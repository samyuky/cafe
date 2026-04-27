@extends('layouts.cafe')

@section('title', 'Log Aktivitas')

@section('content')
<div class="bg-white rounded-2xl p-6 shadow-lg">
    <h2 class="text-2xl font-bold text-amber-900 mb-6">📜 Log Aktivitas Pegawai</h2>
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-amber-50">
                    <th class="text-left py-4 px-4 text-amber-900">Waktu</th>
                    <th class="text-left py-4 px-4 text-amber-900">User</th>
                    <th class="text-left py-4 px-4 text-amber-900">Aktivitas</th>
                    <th class="text-left py-4 px-4 text-amber-900">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="border-b border-gray-100 hover:bg-amber-50 transition">
                    <td class="py-3 px-4 text-sm">
                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                    </td>
                    <td class="py-3 px-4">
                        <div class="font-medium">{{ $log->user->full_name }}</div>
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($log->user->role == 'admin') bg-red-100 text-red-700
                            @elseif($log->user->role == 'manager') bg-blue-100 text-blue-700
                            @else bg-green-100 text-green-700
                            @endif">
                            {{ ucfirst($log->user->role) }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $log->activity }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-gray-600">{{ $log->description }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-12">
                        <div class="text-6xl mb-4">📭</div>
                        <p class="text-gray-500 text-lg">Belum ada aktivitas tercatat</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="mt-6">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection