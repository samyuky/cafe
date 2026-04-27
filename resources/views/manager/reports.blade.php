@extends('layouts.cafe')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="bg-white rounded-2xl p-6 shadow-lg">
    <h2 class="text-2xl font-bold text-amber-900 mb-6">📊 Filter Laporan Transaksi</h2>
    
    <form action="{{ route('manager.reports.filter') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-amber-900 font-medium mb-2">👤 Pilih Kasir</label>
                <select name="user_id" 
                        class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none">
                    <option value="">Semua Kasir</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-amber-900 font-medium mb-2">📅 Dari Tanggal</label>
                <input type="date" name="date_from" 
                       class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none">
            </div>
            
            <div>
                <label class="block text-amber-900 font-medium mb-2">📅 Sampai Tanggal</label>
                <input type="date" name="date_to" 
                       class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none">
            </div>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-gradient-to-r from-amber-700 to-amber-500 text-white px-8 py-3 rounded-xl font-bold hover:shadow-lg transition">
                🔍 Tampilkan Laporan
            </button>
        </div>
    </form>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
    @php
        $todayTotal = App\Models\Transaction::whereDate('transaction_date', today())->sum('total_amount');
        $weekTotal = App\Models\Transaction::whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_amount');
        $monthTotal = App\Models\Transaction::whereMonth('transaction_date', now()->month)->sum('total_amount');
    @endphp
    
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <p class="text-gray-500 text-sm">Pendapatan Hari Ini</p>
        <p class="text-2xl font-bold text-amber-700 mt-2">Rp{{ number_format($todayTotal) }}</p>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <p class="text-gray-500 text-sm">Pendapatan Minggu Ini</p>
        <p class="text-2xl font-bold text-amber-700 mt-2">Rp{{ number_format($weekTotal) }}</p>
    </div>
    
    <div class="bg-white rounded-2xl p-6 shadow-lg">
        <p class="text-gray-500 text-sm">Pendapatan Bulan Ini</p>
        <p class="text-2xl font-bold text-amber-700 mt-2">Rp{{ number_format($monthTotal) }}</p>
    </div>
</div>
@endsection