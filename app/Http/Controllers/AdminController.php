<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hanya tampilkan user selain admin (kasir & manager)
        $users = User::where('role', '!=', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.dashboard', compact('users'));
    }
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:kasir,manager', // Admin tidak bisa dibuat dari sini
        ], [
            'role.in' => 'Role tidak valid',
        ]);
        
        User::create([
            'full_name' => $request->full_name,
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Tambah User',
            'description' => 'Menambahkan user: ' . $request->full_name . ' sebagai ' . ucfirst($request->role)
        ]);
        
        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan!');
    }
    
    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Cegah mengubah role admin lain
        if ($user->role == 'admin' && $user->id != auth()->id()) {
            return redirect()->route('admin.dashboard')->with('error', 'Tidak dapat mengubah role admin lain!');
        }
        
        $user->update(['role' => $request->role]);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Update Role',
            'description' => 'Update role user: ' . $user->full_name . ' menjadi ' . ucfirst($request->role)
        ]);
        
        return redirect()->route('admin.dashboard')->with('success', 'Role user berhasil diupdate!');
    }
    
    public function activityLog()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.activity_log', compact('logs'));
    }
}