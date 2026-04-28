@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-display font-bold text-coffee-900">Riwayat Transaksi</h2>
            <p class="text-coffee-500 mt-1">Semua transaksi yang telah Anda proses</p>
        </div>
        <a href="{{ route('kasir.dashboard') }}" class="btn-coffee inline-flex items-center gap-2">
            <i class="ph ph-plus-circle text-lg"></i> Transaksi Baru
        </a>
    </div>

    <!-- Stats -->
    @php
        $todayTotal = $transactions->where('created_at', '>=', today())->sum('total_amount');
        $todayCount = $transactions->where('created_at', '>=', today())->count();
    @endphp
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-coffee-100 rounded-xl flex items-center justify-center">
                <i class="ph ph-receipt text-coffee-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-coffee-400">Total Transaksi</p>
                <p class="text-2xl font-bold text-coffee-900">{{ $transactions->count() }}</p>
            </div>
        </div>
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <i class="ph ph-calendar-check text-emerald-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-coffee-400">Hari Ini</p>
                <p class="text-2xl font-bold text-coffee-900">{{ $todayCount }}</p>
            </div>
        </div>
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                <i class="ph ph-currency-dollar text-amber-600 text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-coffee-400">Pendapatan Total</p>
                <p class="text-2xl font-bold text-coffee-900">Rp {{ number_format($transactions->sum('total_amount'), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card p-6">
        <div class="flex gap-4 mb-6">
            <div class="relative flex-1">
                <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-coffee-400"></i>
                <input type="text" id="searchTransaction" placeholder="Cari nama pembeli..." 
                       class="input-coffee pl-10 text-sm">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-coffee-100">
                        <th class="text-left py-3 px-3 text-xs font-semibold text-coffee-500">Antrian</th>
                        <th class="text-left py-3 px-3 text-xs font-semibold text-coffee-500">Waktu</th>
                        <th class="text-left py-3 px-3 text-xs font-semibold text-coffee-500">Pembeli</th>
                        <th class="text-left py-3 px-3 text-xs font-semibold text-coffee-500">Metode</th>
                        <th class="text-right py-3 px-3 text-xs font-semibold text-coffee-500">Total</th>
                        <th class="text-center py-3 px-3 text-xs font-semibold text-coffee-500">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr class="border-b border-coffee-50 hover:bg-coffee-50/50 transition transaction-row">
                        <td class="py-3 px-3">
                            <span class="font-mono font-bold text-coffee-700 text-sm">{{ $transaction->queue_number }}</span>
                        </td>
                        <td class="py-3 px-3">
                            <span class="text-sm font-medium">{{ $transaction->created_at->format('d/m/Y') }}</span>
                            <span class="text-xs text-coffee-400 block">{{ $transaction->created_at->format('H:i') }}</span>
                        </td>
                        <td class="py-3 px-3">
                            <span class="text-sm font-medium text-coffee-900">{{ $transaction->customer_name }}</span>
                        </td>
                        <td class="py-3 px-3">
                            <span class="px-2 py-1 bg-coffee-100 text-coffee-700 rounded-full text-xs font-medium uppercase">
                                {{ $transaction->payment_method }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-right">
                            <span class="font-bold text-coffee-900">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                        </td>
                        <td class="py-3 px-3">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('kasir.struk', $transaction->id) }}" 
                                   class="p-2 bg-coffee-100 hover:bg-coffee-200 rounded-lg transition">
                                    <i class="ph ph-eye text-coffee-700"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('searchTransaction').addEventListener('input', function() {
    const search = this.value.toLowerCase();
    document.querySelectorAll('.transaction-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
});
</script>
@endsection