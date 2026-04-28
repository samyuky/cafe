@extends('layouts.manager')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas Pegawai')

@section('content')
<div class="card-manager p-6">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <i class="ph ph-clock-history text-blue-600"></i>
            Aktivitas Pegawai
        </h3>
        <span class="px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-medium">
            {{ $logs->total() }} Aktivitas
        </span>
    </div>
    
    <!-- Timeline Style -->
    <div class="relative">
        @forelse($logs as $log)
        <div class="flex gap-4 pb-6 relative">
            <!-- Timeline Line -->
            @if(!$loop->last)
            <div class="absolute left-4 top-10 bottom-0 w-0.5 bg-gray-200"></div>
            @endif
            
            <!-- Icon -->
            <div class="relative z-10">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center
                    @if(str_contains($log->activity, 'Login')) bg-green-100
                    @elseif(str_contains($log->activity, 'Logout')) bg-red-100
                    @elseif(str_contains($log->activity, 'Tambah')) bg-blue-100
                    @elseif(str_contains($log->activity, 'Edit') || str_contains($log->activity, 'Update')) bg-amber-100
                    @elseif(str_contains($log->activity, 'Transaksi')) bg-purple-100
                    @else bg-gray-100
                    @endif">
                    <i class="ph 
                        @if(str_contains($log->activity, 'Login')) ph-sign-in text-green-600
                        @elseif(str_contains($log->activity, 'Logout')) ph-sign-out text-red-600
                        @elseif(str_contains($log->activity, 'Tambah')) ph-plus-circle text-blue-600
                        @elseif(str_contains($log->activity, 'Edit') || str_contains($log->activity, 'Update')) ph-pencil text-amber-600
                        @elseif(str_contains($log->activity, 'Transaksi')) ph-shopping-cart text-purple-600
                        @else ph-activity text-gray-600
                        @endif text-lg"></i>
                </div>
            </div>
            
            <!-- Content -->
            <div class="flex-1 bg-gray-50 rounded-xl p-4">
                <div class="flex items-start justify-between mb-2">
                    <div>
                        <span class="px-3 py-1 rounded-lg text-xs font-medium
                            @if(str_contains($log->activity, 'Login')) bg-green-100 text-green-700
                            @elseif(str_contains($log->activity, 'Logout')) bg-red-100 text-red-700
                            @elseif(str_contains($log->activity, 'Tambah')) bg-blue-100 text-blue-700
                            @elseif(str_contains($log->activity, 'Edit') || str_contains($log->activity, 'Update')) bg-amber-100 text-amber-700
                            @elseif(str_contains($log->activity, 'Transaksi')) bg-purple-100 text-purple-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            {{ $log->activity }}
                        </span>
                    </div>
                    <span class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-gray-700">{{ $log->description }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <div class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold
                        @if($log->user->role == 'admin') bg-purple-100 text-purple-600
                        @elseif($log->user->role == 'manager') bg-blue-100 text-blue-600
                        @else bg-green-100 text-green-600
                        @endif">
                        {{ strtoupper(substr($log->user->full_name, 0, 2)) }}
                    </div>
                    <span class="text-xs text-gray-500">{{ $log->user->full_name }}</span>
                    <span class="text-xs text-gray-400">•</span>
                    <span class="text-xs text-gray-400">{{ ucfirst($log->user->role) }}</span>
                    <span class="text-xs text-gray-400">•</span>
                    <span class="text-xs text-gray-400">{{ $log->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16">
            <i class="ph ph-clock-history text-6xl text-gray-300 block mb-4"></i>
            <h4 class="text-xl font-semibold text-gray-500">Belum ada aktivitas</h4>
            <p class="text-gray-400 mt-2">Aktivitas pegawai akan muncul disini</p>
        </div>
        @endforelse
    </div>
    
    <!-- Pagination -->
    @if($logs->hasPages())
    <div class="mt-8 pt-6 border-t border-gray-200">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection