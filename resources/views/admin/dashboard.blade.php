@extends('layouts.admin')

@section('title', 'Kelola User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Form Tambah User -->
    <div class="lg:col-span-1">
        <div class="card-admin p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <i class="ph ph-user-plus text-purple-600"></i>
                Tambah User Baru
            </h3>
            
            <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <i class="ph ph-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required 
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition"
                               placeholder="Masukkan nama lengkap">
                    </div>
                    @error('full_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <i class="ph ph-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition"
                               placeholder="email@example.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <i class="ph ph-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" required 
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition"
                               placeholder="Minimal 8 karakter">
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role" required 
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none transition">
                        <option value="kasir">💁 Kasir</option>
                        <option value="manager">👔 Manager</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1">Admin hanya bisa dibuat oleh Super Admin</p>
                    @error('role')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <button type="submit" class="btn-purple w-full py-2.5 flex items-center justify-center gap-2">
                    <i class="ph ph-plus-circle"></i>
                    Tambah User
                </button>
            </form>
        </div>
        
        <!-- Info Admin -->
        <div class="card-admin p-5 mt-4 bg-purple-50 border-purple-200">
            <div class="flex items-center gap-3">
                <i class="ph ph-shield-check text-purple-600 text-2xl"></i>
                <div>
                    <p class="text-sm font-semibold text-purple-900">Admin Utama</p>
                    <p class="text-xs text-purple-600">{{ auth()->user()->full_name }}</p>
                    <p class="text-xs text-purple-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Daftar User (Hanya Kasir & Manager) -->
    <div class="lg:col-span-2">
        <div class="card-admin p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-2 flex items-center gap-2">
                <i class="ph ph-users text-purple-600"></i>
                Daftar User
            </h3>
            <p class="text-sm text-gray-500 mb-6">
                Menampilkan {{ $users->count() }} user (Kasir & Manager)
            </p>
            
            @if($users->isEmpty())
                <div class="text-center py-12">
                    <i class="ph ph-users text-5xl text-gray-300 block mb-3"></i>
                    <p class="text-gray-500">Belum ada user terdaftar</p>
                    <p class="text-sm text-gray-400 mt-1">Tambahkan kasir atau manager baru</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($users as $user)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition gap-3">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg flex-shrink-0
                                @if($user->role == 'manager') bg-blue-100 text-blue-600
                                @else bg-green-100 text-green-600
                                @endif">
                                {{ strtoupper(substr($user->full_name, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="font-semibold text-gray-900 truncate">{{ $user->full_name }}</p>
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium flex-shrink-0
                                        @if($user->role == 'manager') bg-blue-100 text-blue-700
                                        @else bg-green-100 text-green-700
                                        @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Dibuat: {{ $user->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <form action="{{ route('admin.user.role', $user->id) }}" method="POST" 
                              class="flex items-center gap-2 flex-shrink-0">
                            @csrf
                            @method('PUT')
                            <select name="role" 
                                    class="px-3 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-purple-500 outline-none
                                    @if($user->role == 'manager') bg-blue-50 border-blue-200
                                    @else bg-green-50 border-green-200
                                    @endif">
                                <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                            </select>
                            <button type="submit" 
                                    class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition text-sm font-medium">
                                Update
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection