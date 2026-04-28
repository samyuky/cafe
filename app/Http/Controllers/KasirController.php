<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function dashboard()
    {
        $menus = Menu::where('is_available', true)->get();
        return view('kasir.dashboard', compact('menus'));
    }
    
    public function storeTransaction(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1|max:99',
            'payment_method' => 'required|in:tunai,qris',
            'payment_amount' => 'nullable|numeric|min:0',
        ], [
            'customer_name.required' => 'Nama pembeli harus diisi',
            'items.required' => 'Pilih minimal 1 menu',
            'payment_method.required' => 'Pilih metode pembayaran',
        ]);
        
        // Hitung subtotal
        $subtotal = 0;
        $details = [];
        
        foreach($request->items as $item) {
            $menu = Menu::findOrFail($item['menu_id']);
            
            if (!$menu->is_available) {
                return back()->with('error', 'Menu ' . $menu->name . ' tidak tersedia!');
            }
            
            $itemSubtotal = $menu->price * $item['quantity'];
            $subtotal += $itemSubtotal;
            
            $details[] = new TransactionDetail([
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $menu->price,
                'subtotal' => $itemSubtotal,
            ]);
        }
        
        // Hitung pajak (PPN 11%)
        $taxRate = 0.11;
        $taxAmount = $subtotal * $taxRate;
        $totalAmount = $subtotal + $taxAmount;
        
        // Tentukan pembayaran berdasarkan metode
        if ($request->payment_method == 'qris') {
            // QRIS: pembayaran pas dengan total
            $paymentAmount = $totalAmount;
            $changeAmount = 0;
        } else {
            // Tunai: validasi pembayaran
            $paymentAmount = $request->payment_amount ?? 0;
            
            if ($paymentAmount < $totalAmount) {
                return back()->with('error', 
                    'Pembayaran kurang! Total: Rp ' . number_format($totalAmount, 0, ',', '.') . 
                    ' | Dibayar: Rp ' . number_format($paymentAmount, 0, ',', '.')
                );
            }
            
            $changeAmount = $paymentAmount - $totalAmount;
        }
        
        // Generate nomor antrian
        $queueNumber = Transaction::generateQueueNumber();
        
        try {
            DB::beginTransaction();
            
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'customer_name' => $request->customer_name,
                'queue_number' => $queueNumber,
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'payment_amount' => $paymentAmount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'transaction_date' => now(),
            ]);
            
            $transaction->transactionDetails()->saveMany($details);
            
            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Transaksi Baru',
                'description' => $queueNumber . ' | ' . $request->customer_name . 
                            ' | ' . strtoupper($request->payment_method) . 
                            ' | Total: Rp ' . number_format($totalAmount, 0, ',', '.')
            ]);
            
            DB::commit();
            
            return redirect()->route('kasir.struk', $transaction->id);
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal memproses transaksi! Silakan coba lagi.');
        }
    }
    
    public function transactions()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('kasir.transactions', compact('transactions'));
    }
    
    public function struk($id)
    {
        $transaction = Transaction::with('transactionDetails.menu')->findOrFail($id);
        return view('kasir.struk', compact('transaction'));
    }
}