@extends('layouts.admin')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas Sistem')

@section('content')
<div class="card-admin p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <i class="ph ph-clock-history text-purple-600"></i>
            Aktivitas Terbaru
        </h3>
        <span class="text-sm text-gray-500">Total: {{ $logs->total() }} aktivitas</span>
    </div>
    
    <!-- Filter Info -->
    @if(request()->has('user_id') || request()->has('date'))
    <div class="mb-4 p-3 bg-purple-50 rounded-xl flex items-center justify-between">
        <p class="text-sm text-purple-700">Menampilkan hasil filter</p>
        <a href="{{ route('admin.activity-log') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">
            Reset Filter
        </a>
    </div>
    @endif
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Waktu</th>
                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">User</th>
                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Role</th>
                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Aktivitas</th>
                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="py-3 px-4">
                        <div class="text-sm font-medium text-gray-900">{{ $log->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold
                                @if($log->user->role == 'admin') bg-purple-100 text-purple-600
                                @elseif($log->user->role == 'manager') bg-blue-100 text-blue-600
                                @else bg-green-100 text-green-600
                                @endif">
                                {{ strtoupper(substr($log->user->full_name, 0, 2)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $log->user->full_name }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-lg text-xs font-medium
                            @if($log->user->role == 'admin') bg-purple-100 text-purple-700
                            @elseif($log->user->role == 'manager') bg-blue-100 text-blue-700
                            @else bg-green-100 text-green-700
                            @endif">
                            {{ ucfirst($log->user->role) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                            {{ $log->activity }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $log->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12">
                        <div class="text-gray-400">
                            <i class="ph ph-clock-history text-5xl block mb-3"></i>
                            <p class="text-lg font-medium">Belum ada aktivitas</p>
                            <p class="text-sm mt-1">Aktivitas akan muncul saat user melakukan aksi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="mt-6 border-t border-gray-200 pt-4">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection