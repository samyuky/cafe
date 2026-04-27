@extends('layouts.cafe')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Tambah User -->
    <div class="cafe-card p-6">
        <h2 class="text-2xl font-bold text-amber-900 mb-6">👥 Tambah User Baru</h2>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('admin.user.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Nama Lengkap</label>
                    <input type="text" name="full_name" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Email</label>
                    <input type="email" name="email" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Password</label>
                    <input type="password" name="password" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Role</label>
                    <select name="role" required class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                        <option value="admin">👑 Admin</option>
                        <option value="manager">👔 Manager</option>
                        <option value="kasir">💁 Kasir</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="cafe-button mt-4">
                ➕ Tambah User
            </button>
        </form>
    </div>
    
    <!-- Daftar User -->
    <div class="cafe-card p-6">
        <h2 class="text-2xl font-bold text-amber-900 mb-6">📋 Daftar User</h2>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-amber-50">
                        <th class="text-left py-3 px-4">Nama</th>
                        <th class="text-left py-3 px-4">Email</th>
                        <th class="text-left py-3 px-4">Role</th>
                        <th class="text-left py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr class="border-b border-gray-100 hover:bg-amber-50">
                        <td class="py-3 px-4 font-medium">{{ $user->full_name }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $user->email }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 rounded-full text-sm 
                                @if($user->role == 'admin') bg-red-100 text-red-700
                                @elseif($user->role == 'manager') bg-blue-100 text-blue-700
                                @else bg-green-100 text-green-700
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <form action="{{ route('admin.user.role', $user->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <select name="role" class="border border-amber-200 rounded-lg px-2 py-1 text-sm">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                </select>
                                <button type="submit" class="text-amber-600 hover:text-amber-800 text-sm">
                                    💾 Update
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection