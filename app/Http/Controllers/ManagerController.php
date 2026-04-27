<?php

namespace App\Http\Controllers;

use App\Models\Menu;           // 👈 Tambahkan ini
use App\Models\Transaction;    // 👈 Tambahkan ini
use App\Models\User;           // 👈 Tambahkan ini
use App\Models\ActivityLog;    // 👈 Tambahkan ini
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $todayIncome = Transaction::whereDate('transaction_date', today())->sum('total_amount');
        $monthlyIncome = Transaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('total_amount');
        $totalTransactions = Transaction::whereDate('transaction_date', today())->count();
        
        return view('manager.dashboard', compact('todayIncome', 'monthlyIncome', 'totalTransactions'));
    }
    
    public function menus()
    {
        $menus = Menu::all();
        return view('manager.menus', compact('menus'));
    }
    
    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);
        
        $menu = Menu::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'is_available' => true,
        ]);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Tambah Menu',
            'description' => 'Menambahkan menu: ' . $request->name
        ]);
        
        return redirect()->route('manager.menus')->with('success', 'Menu berhasil ditambahkan');
    }
    
    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        
        $menu->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'is_available' => $request->has('is_available'),
        ]);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Edit Menu',
            'description' => 'Mengedit menu: ' . $menu->name
        ]);
        
        return redirect()->route('manager.menus')->with('success', 'Menu berhasil diupdate');
    }
    
    public function reports()
    {
        $users = User::where('role', 'kasir')->get();
        return view('manager.reports', compact('users'));
    }
    
    public function filterReports(Request $request)
    {
        $query = Transaction::with('user');
        
        if($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        if($request->date_from) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        
        if($request->date_to) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }
        
        $transactions = $query->orderBy('transaction_date', 'desc')->get();
        $totalIncome = $transactions->sum('total_amount');
        $users = User::where('role', 'kasir')->get();
        
        return view('manager.report_result', compact('transactions', 'totalIncome', 'users'));
    }
    
    public function activityLog()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('manager.activity_log', compact('logs'));
    }
}