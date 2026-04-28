<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $todayIncome = Transaction::whereDate('transaction_date', today())->sum('total_amount');
        $monthlyIncome = Transaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('total_amount');
        $totalTransactions = Transaction::whereDate('transaction_date', today())->count();
        
        $weeklyData = $this->getWeeklyData();
        $categoryData = $this->getCategoryData();
        $topMenuData = $this->getTopMenuData();
        $hourlyData = $this->getHourlyData();
        
        return view('manager.dashboard', compact(
            'todayIncome', 
            'monthlyIncome', 
            'totalTransactions',
            'weeklyData',
            'categoryData',
            'topMenuData',
            'hourlyData'
        ));
    }
    
    private function getWeeklyData()
    {
        $labels = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->translatedFormat('D');
            $data[] = Transaction::whereDate('transaction_date', $date)->sum('total_amount');
        }
        
        return ['labels' => $labels, 'data' => $data];
    }
    
    private function getCategoryData()
    {
        $monthlyTransactions = TransactionDetail::whereHas('transaction', function($query) {
            $query->whereMonth('transaction_date', now()->month)
                  ->whereYear('transaction_date', now()->year);
        })->with('menu')->get();
        
        $makanan = 0;
        $minuman = 0;
        
        foreach ($monthlyTransactions as $detail) {
            if ($detail->menu && $detail->menu->category == 'makanan') {
                $makanan += $detail->subtotal;
            } elseif ($detail->menu) {
                $minuman += $detail->subtotal;
            }
        }
        
        return [
            'labels' => ['Makanan', 'Minuman'],
            'data' => [$makanan, $minuman]
        ];
    }
    
    private function getTopMenuData()
    {
        $topMenus = TransactionDetail::whereHas('transaction', function($query) {
            $query->whereMonth('transaction_date', now()->month)
                  ->whereYear('transaction_date', now()->year);
        })
        ->select('menu_id', DB::raw('SUM(quantity) as total_qty'))
        ->groupBy('menu_id')
        ->orderByDesc('total_qty')
        ->limit(5)
        ->with('menu')
        ->get();
        
        $labels = [];
        $data = [];
        
        foreach ($topMenus as $item) {
            if ($item->menu) {
                $labels[] = $item->menu->name;
                $data[] = $item->total_qty;
            }
        }
        
        if (empty($labels)) {
            $labels = ['Belum ada data'];
            $data = [0];
        }
        
        return ['labels' => $labels, 'data' => $data];
    }
    
    private function getHourlyData()
    {
        $hours = ['06:00', '08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00'];
        $labels = ['06', '08', '10', '12', '14', '16', '18', '20'];
        $data = [];
        
        foreach ($hours as $hour) {
            $count = Transaction::whereDate('transaction_date', today())
                ->whereTime('transaction_date', '>=', $hour)
                ->whereTime('transaction_date', '<', Carbon::parse($hour)->addHours(2)->format('H:i'))
                ->count();
            $data[] = $count;
        }
        
        return ['labels' => $labels, 'data' => $data];
    }
    
    // KELOLA MENU
    public function menus()
    {
        $menus = Menu::orderBy('created_at', 'desc')->get();
        return view('manager.menus', compact('menus'));
    }
    
    public function storeMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, PNG, atau WebP',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }
        
        $menu = Menu::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
            'is_available' => true,
        ]);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Tambah Menu',
            'description' => 'Menambahkan menu baru: ' . $request->name . ' (Rp ' . number_format($request->price) . ')'
        ]);
        
        return redirect()->route('manager.menus')->with('success', 'Menu berhasil ditambahkan!');
    }
    
    public function updateMenu(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        
        $menu = Menu::findOrFail($id);
        
        $imagePath = $menu->image;
        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $imagePath = $request->file('image')->store('menus', 'public');
        }
        
        $menu->update([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
            'is_available' => $request->has('is_available'),
        ]);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Edit Menu',
            'description' => 'Mengedit menu: ' . $menu->name
        ]);
        
        return redirect()->route('manager.menus')->with('success', 'Menu berhasil diupdate!');
    }
    
    // LAPORAN
    public function reports()
    {
        $users = User::where('role', 'kasir')->get();
        return view('manager.reports', compact('users'));
    }
    
    public function filterReports(Request $request)
    {
        $query = Transaction::with(['user', 'transactionDetails.menu']);
        
        if($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        if($request->filled('date_from')) {
            $query->whereDate('transaction_date', '>=', $request->date_from);
        }
        
        if($request->filled('date_to')) {
            $query->whereDate('transaction_date', '<=', $request->date_to);
        }
        
        $transactions = $query->orderBy('transaction_date', 'desc')->get();
        $totalIncome = $transactions->sum('total_amount');
        
        return view('manager.report_result', compact('transactions', 'totalIncome'));
    }
    
    // LOG AKTIVITAS
    public function activityLog()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('manager.activity_log', compact('logs'));
    }
}