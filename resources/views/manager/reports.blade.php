@extends('layouts.manager')

@section('title', 'Laporan')
@section('page-title', 'Laporan Penjualan')

@section('content')
<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    @php
        $todayTotal = App\Models\Transaction::whereDate('transaction_date', today())->sum('total_amount');
        $weekTotal = App\Models\Transaction::whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount');
        $monthTotal = App\Models\Transaction::whereMonth('transaction_date', now()->month)->sum('total_amount');
    @endphp
    
    <div class="stat-card">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($todayTotal, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="ph ph-calendar text-blue-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="border-left-color: #10b981;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Minggu Ini</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($weekTotal, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="ph ph-chart-line text-emerald-600 text-xl"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card" style="border-left-color: #f59e0b;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Bulan Ini</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($monthTotal, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                <i class="ph ph-trend-up text-amber-600 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="card-manager p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
        <i class="ph ph-funnel text-blue-600"></i>
        Filter Laporan
    </h3>
    
    <form action="{{ route('manager.reports.filter') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Kasir</label>
                <div class="relative">
                    <i class="ph ph-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <select name="user_id" 
                            class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition appearance-none">
                        <option value="">Semua Kasir</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                <div class="relative">
                    <i class="ph ph-calendar absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="date" name="date_from" 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                <div class="relative">
                    <i class="ph ph-calendar absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="date" name="date_to" 
                           class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
            </div>
        </div>
        
        <div class="flex justify-end gap-3">
            <a href="{{ route('manager.reports') }}" 
               class="px-6 py-2.5 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition text-sm font-medium flex items-center gap-2">
                <i class="ph ph-arrow-counter-clockwise"></i>
                Reset
            </a>
            <button type="submit" 
                    class="btn-blue flex items-center gap-2">
                <i class="ph ph-magnifying-glass"></i>
                Tampilkan Laporan
            </button>
        </div>
    </form>
</div>
@endsection