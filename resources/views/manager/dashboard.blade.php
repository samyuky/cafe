@extends('layouts.cafe')

@section('title', 'Dashboard Manager')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Hari Ini -->
    <div class="bg-white rounded-2xl p-6 shadow-lg bg-gradient-to-br from-amber-400 to-amber-600 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm">Pendapatan Hari Ini</p>
                <p class="text-3xl font-bold mt-2">Rp{{ number_format($todayIncome) }}</p>
            </div>
            <div class="text-5xl opacity-50">📊</div>
        </div>
    </div>
    
    <!-- Total Bulanan -->
    <div class="bg-white rounded-2xl p-6 shadow-lg bg-gradient-to-br from-amber-600 to-amber-800 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm">Pendapatan Bulan Ini</p>
                <p class="text-3xl font-bold mt-2">Rp{{ number_format($monthlyIncome) }}</p>
            </div>
            <div class="text-5xl opacity-50">💰</div>
        </div>
    </div>
    
    <!-- Total Transaksi -->
    <div class="bg-white rounded-2xl p-6 shadow-lg bg-gradient-to-br from-amber-500 to-amber-700 text-white transform hover:scale-105 transition">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm">Transaksi Hari Ini</p>
                <p class="text-3xl font-bold mt-2">{{ $totalTransactions }}</p>
            </div>
            <div class="text-5xl opacity-50">🛍️</div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('manager.menus') }}" 
       class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition text-center group cursor-pointer">
        <div class="text-6xl mb-4 group-hover:scale-110 transition">📝</div>
        <h3 class="text-xl font-bold text-amber-900">Kelola Menu</h3>
        <p class="text-gray-500 mt-2">Tambah & edit menu cafe</p>
    </a>
    
    <a href="{{ route('manager.reports') }}" 
       class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition text-center group cursor-pointer">
        <div class="text-6xl mb-4 group-hover:scale-110 transition">📈</div>
        <h3 class="text-xl font-bold text-amber-900">Laporan Penjualan</h3>
        <p class="text-gray-500 mt-2">Filter & lihat laporan</p>
    </a>
    
    <a href="{{ route('manager.activity-log') }}" 
       class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition text-center group cursor-pointer">
        <div class="text-6xl mb-4 group-hover:scale-110 transition">📜</div>
        <h3 class="text-xl font-bold text-amber-900">Log Aktivitas</h3>
        <p class="text-gray-500 mt-2">Pantau aktivitas pegawai</p>
    </a>
</div>

<!-- Recent Transactions -->
<div class="bg-white rounded-2xl p-6 shadow-lg mt-8">
    <h3 class="text-xl font-bold text-amber-900 mb-4">📋 Transaksi Terbaru</h3>
    
    @php
        $recentTransactions = App\Models\Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    @endphp
    
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-amber-50">
                    <th class="text-left py-3 px-4 text-amber-900">No.</th>
                    <th class="text-left py-3 px-4 text-amber-900">Waktu</th>
                    <th class="text-left py-3 px-4 text-amber-900">Kasir</th>
                    <th class="text-left py-3 px-4 text-amber-900">Meja</th>
                    <th class="text-right py-3 px-4 text-amber-900">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $index => $trans)
                <tr class="border-b border-gray-100 hover:bg-amber-50 transition">
                    <td class="py-3 px-4">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 text-sm">{{ $trans->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-3 px-4">{{ $trans->user->full_name }}</td>
                    <td class="py-3 px-4">
                        <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm">
                            Meja {{ $trans->table_number }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-right font-bold text-amber-700">
                        Rp{{ number_format($trans->total_amount) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">
                        <div class="text-4xl mb-2">📭</div>
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection