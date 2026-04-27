<?php

namespace App\Http\Controllers;

use App\Models\User;          // 👈 Tambahkan ini
use App\Models\ActivityLog;   // 👈 Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,manager,kasir',
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
            'description' => 'Menambahkan user: ' . $request->full_name
        ]);
        
        return redirect()->route('admin.dashboard')->with('success', 'User berhasil ditambahkan');
    }
    
    public function updateUserRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Update Role',
            'description' => 'Update role user: ' . $user->full_name . ' menjadi ' . $request->role
        ]);
        
        return redirect()->route('admin.dashboard')->with('success', 'Role user berhasil diupdate');
    }
    
    public function activityLog()
    {
        $logs = ActivityLog::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.activity_log', compact('logs'));
    }
}