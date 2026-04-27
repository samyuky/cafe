<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Catat log
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'Login',
                'description' => $user->full_name . ' telah login'
            ]);

            // Redirect berdasarkan role
            return match($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'manager' => redirect()->route('manager.dashboard'),
                'kasir' => redirect()->route('kasir.dashboard'),
                default => redirect()->route('dashboard')
            };
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session (LOGOUT).
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();
        
        // Catat log logout
        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'Logout',
                'description' => $user->full_name . ' telah logout'
            ]);
        }

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}