<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('login');
});

// LOGIN ROUTES
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        
        return match(Auth::user()->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'manager' => redirect()->route('manager.dashboard'),
            'kasir' => redirect()->route('kasir.dashboard'),
            default => redirect('/')
        };
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
});

// LOGOUT ROUTE
Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Dashboard redirect
Route::get('/dashboard', function () {
    return match(Auth::user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'manager' => redirect()->route('manager.dashboard'),
        'kasir' => redirect()->route('kasir.dashboard'),
        default => redirect('/')
    };
})->middleware('auth')->name('dashboard');

// Kasir Routes
Route::middleware(['auth'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');
    Route::post('/transaction', [KasirController::class, 'storeTransaction'])->name('transaction.store');
    Route::get('/transactions', [KasirController::class, 'transactions'])->name('transactions');
    Route::get('/struk/{id}', [KasirController::class, 'struk'])->name('struk');
});

// Manager Routes
Route::middleware(['auth'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'dashboard'])->name('dashboard');
    Route::get('/menus', [ManagerController::class, 'menus'])->name('menus');
    Route::post('/menu', [ManagerController::class, 'storeMenu'])->name('menu.store');
    Route::put('/menu/{id}', [ManagerController::class, 'updateMenu'])->name('menu.update');
    Route::get('/reports', [ManagerController::class, 'reports'])->name('reports');
    Route::post('/reports/filter', [ManagerController::class, 'filterReports'])->name('reports.filter');
    Route::get('/activity-log', [ManagerController::class, 'activityLog'])->name('activity-log');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/user', [AdminController::class, 'storeUser'])->name('user.store');
    Route::put('/user/{id}/role', [AdminController::class, 'updateUserRole'])->name('user.role');
    Route::get('/activity-log', [AdminController::class, 'activityLog'])->name('activity-log');
});

// QRIS Route - Generate data pembayaran
Route::post('/qris/generate', function (\Illuminate\Http\Request $request) {
    $total = $request->total ?? 0;
    $customerName = $request->customer_name ?? 'Customer';
    $timestamp = now()->timestamp;
    
    // Data QRIS (bisa diganti dengan format NMID/QRIS asli dari bank)
    $merchantId = '9360000100123456'; // ID Merchant simulasi
    $transactionId = $timestamp;
    
    // Format QRIS standar (00-01-02-...)
    $qrisString = '000201';
    $qrisString .= '010211';
    $qrisString .= '26' . str_pad(strlen('01' . $merchantId), 2, '0', STR_PAD_LEFT) . '01' . $merchantId;
    $qrisString .= '52045999'; // Kategori
    $qrisString .= '5303360'; // Mata uang IDR
    $qrisString .= '54' . str_pad(strlen($total), 2, '0', STR_PAD_LEFT) . $total;
    $qrisString .= '5802ID'; // Negara
    $qrisString .= '59' . str_pad(strlen('CUMA Cafe'), 2, '0', STR_PAD_LEFT) . 'CUMA Cafe';
    $qrisString .= '60' . str_pad(strlen('Jakarta'), 2, '0', STR_PAD_LEFT) . 'Jakarta';
    $qrisString .= '61' . str_pad(strlen($transactionId), 2, '0', STR_PAD_LEFT) . $transactionId;
    $qrisString .= '62' . str_pad(strlen($customerName), 2, '0', STR_PAD_LEFT) . $customerName;
    
    return response()->json([
        'success' => true,
        'qris_data' => $qrisString,
        'total' => $total,
        'transaction_id' => $transactionId,
        'customer_name' => $customerName,
        'merchant_name' => 'CUMA Cafe',
    ]);
})->name('qris.generate');