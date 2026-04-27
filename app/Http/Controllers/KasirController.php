<?php

namespace App\Http\Controllers;

use App\Models\Menu;              // 👈 Tambahkan ini
use App\Models\Transaction;      // 👈 Tambahkan ini
use App\Models\TransactionDetail; // 👈 Tambahkan ini
use App\Models\ActivityLog;      // 👈 Tambahkan ini
use Illuminate\Http\Request;

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
            'table_number' => 'required|integer|min:1',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_amount' => 'required|numeric|min:0',
        ]);
        
        // Hitung total
        $total = 0;
        $details = [];
        
        foreach($request->items as $item) {
            $menu = Menu::find($item['menu_id']);
            $subtotal = $menu->price * $item['quantity'];
            $total += $subtotal;
            
            $details[] = new TransactionDetail([
                'menu_id' => $menu->id,
                'quantity' => $item['quantity'],
                'price' => $menu->price,
                'subtotal' => $subtotal,
            ]);
        }
        
        // Validasi pembayaran
        if($request->payment_amount < $total) {
            return back()->with('error', 'Pembayaran kurang! Total: Rp' . number_format($total));
        }
        
        // Simpan transaksi
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'table_number' => $request->table_number,
            'total_amount' => $total,
            'payment_amount' => $request->payment_amount,
            'change_amount' => $request->payment_amount - $total,
            'transaction_date' => now(),
        ]);
        
        $transaction->transactionDetails()->saveMany($details);
        
        // Log activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Transaksi',
            'description' => 'Transaksi meja ' . $request->table_number . ' sebesar Rp' . number_format($total)
        ]);
        
        return redirect()->route('kasir.struk', $transaction->id);
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