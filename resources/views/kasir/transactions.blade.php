@extends('layouts.kasir')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-display font-bold" style="color: #3c2415;">Riwayat Transaksi</h2>
            <p style="color: #a45225; margin-top: 4px;">Semua transaksi yang telah Anda proses</p>
        </div>
        <a href="{{ route('kasir.dashboard') }}" class="btn-primary">
            <i class="ph ph-plus-circle text-lg"></i> Transaksi Baru
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        @php
            $todayTransactions = $transactions->filter(function($t) {
                return $t->created_at->isToday();
            });
            $todayCount = $todayTransactions->count();
            $todayTotal = $todayTransactions->sum('total_amount');
            $totalAll = $transactions->sum('total_amount');
        @endphp
        
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: #f9eddb;">
                <i class="ph ph-receipt text-xl" style="color: #6b3820;"></i>
            </div>
            <div>
                <p style="color: #a45225; font-size: 13px;">Total Transaksi</p>
                <p class="text-2xl font-bold" style="color: #3c2415;">{{ $transactions->count() }}</p>
            </div>
        </div>
        
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: #ecfdf5;">
                <i class="ph ph-calendar-check text-xl" style="color: #065f46;"></i>
            </div>
            <div>
                <p style="color: #a45225; font-size: 13px;">Hari Ini</p>
                <p class="text-2xl font-bold" style="color: #3c2415;">{{ $todayCount }}</p>
            </div>
        </div>
        
        <div class="card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background: #fff7ed;">
                <i class="ph ph-currency-dollar text-xl" style="color: #c2410c;"></i>
            </div>
            <div>
                <p style="color: #a45225; font-size: 13px;">Pendapatan Total</p>
                <p class="text-2xl font-bold" style="color: #3c2415;">Rp {{ number_format($totalAll, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card p-6">
        @if($transactions->isEmpty())
            <div class="text-center py-16">
                <i class="ph ph-receipt-x text-6xl block mb-4" style="color: #e9bb87;"></i>
                <h3 class="text-xl font-semibold" style="color: #a45225;">Belum ada transaksi</h3>
                <p style="color: #c5a582; margin-top: 8px;">Mulai transaksi pertama Anda sekarang</p>
                <a href="{{ route('kasir.dashboard') }}" class="btn-primary inline-flex mt-6">
                    <i class="ph ph-plus-circle"></i> Buat Transaksi
                </a>
            </div>
        @else
            <div class="flex gap-4 mb-6">
                <div class="relative flex-1">
                    <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2" style="color: #c5a582;"></i>
                    <input type="text" id="searchTransaction" placeholder="Cari nama pembeli atau nomor antrian..." 
                           class="input-premium pl-10">
                </div>
                <select id="filterDate" onchange="filterByDate(this.value)" class="input-premium w-auto">
                    <option value="all">Semua Waktu</option>
                    <option value="today">Hari Ini</option>
                    <option value="yesterday">Kemarin</option>
                    <option value="week">Minggu Ini</option>
                    <option value="month">Bulan Ini</option>
                </select>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr style="border-bottom: 2px solid #f2d7b6;">
                            <th class="text-left py-4 px-3 text-xs font-semibold" style="color: #a45225;">NO. ANTRIAN</th>
                            <th class="text-left py-4 px-3 text-xs font-semibold" style="color: #a45225;">WAKTU</th>
                            <th class="text-left py-4 px-3 text-xs font-semibold" style="color: #a45225;">PEMBELI</th>
                            <th class="text-left py-4 px-3 text-xs font-semibold" style="color: #a45225;">METODE</th>
                            <th class="text-right py-4 px-3 text-xs font-semibold" style="color: #a45225;">TOTAL</th>
                            <th class="text-center py-4 px-3 text-xs font-semibold" style="color: #a45225;">STRUK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr class="transaction-row" 
                            style="border-bottom: 1px solid #f9eddb;"
                            data-date="{{ $transaction->created_at->format('Y-m-d') }}"
                            onmouseover="this.style.background='#fdf8f0'" 
                            onmouseout="this.style.background='transparent'">
                            
                            <td class="py-4 px-3">
                                <span class="font-mono font-bold text-sm" style="color: #6b3820;">
                                    #{{ $transaction->queue_number }}
                                </span>
                            </td>
                            
                            <td class="py-4 px-3">
                                <span class="text-sm font-medium" style="color: #3c2415;">
                                    {{ $transaction->created_at->format('d M Y') }}
                                </span>
                                <span class="text-xs block" style="color: #c5a582;">
                                    {{ $transaction->created_at->format('H:i') }} WIB
                                </span>
                            </td>
                            
                            <td class="py-4 px-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold" 
                                         style="background: #f9eddb; color: #6b3820;">
                                        {{ strtoupper(substr($transaction->customer_name, 0, 2)) }}
                                    </div>
                                    <span class="text-sm font-medium" style="color: #3c2415;">
                                        {{ $transaction->customer_name }}
                                    </span>
                                </div>
                            </td>
                            
                            <td class="py-4 px-3">
                                <span class="badge {{ $transaction->payment_method == 'tunai' ? 'badge-food' : 'badge-drink' }}">
                                    {{ $transaction->payment_method == 'tunai' ? '💵 Tunai' : '📱 QRIS' }}
                                </span>
                            </td>
                            
                            <td class="py-4 px-3 text-right">
                                <span class="font-bold" style="color: #3c2415;">
                                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                </span>
                            </td>
                            
                            <td class="py-4 px-3">
                                <div class="flex justify-center">
                                    <a href="{{ route('kasir.struk', $transaction->id) }}" 
                                       class="btn-secondary" style="padding: 8px 16px; font-size: 13px;">
                                        <i class="ph ph-eye"></i> Lihat
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Search functionality
document.getElementById('searchTransaction').addEventListener('input', function() {
    const search = this.value.toLowerCase();
    document.querySelectorAll('.transaction-row').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(search) ? '' : 'none';
    });
});

// Date filter
function filterByDate(filter) {
    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];
    
    const yesterday = new Date(today);
    yesterday.setDate(yesterday.getDate() - 1);
    const yesterdayStr = yesterday.toISOString().split('T')[0];
    
    const weekStart = new Date(today);
    weekStart.setDate(today.getDate() - today.getDay());
    const weekStartStr = weekStart.toISOString().split('T')[0];
    
    const monthStart = new Date(today.getFullYear(), today.getMonth(), 1);
    const monthStartStr = monthStart.toISOString().split('T')[0];
    
    document.querySelectorAll('.transaction-row').forEach(row => {
        const date = row.dataset.date;
        
        switch(filter) {
            case 'today':
                row.style.display = date === todayStr ? '' : 'none';
                break;
            case 'yesterday':
                row.style.display = date === yesterdayStr ? '' : 'none';
                break;
            case 'week':
                row.style.display = date >= weekStartStr ? '' : 'none';
                break;
            case 'month':
                row.style.display = date >= monthStartStr ? '' : 'none';
                break;
            default:
                row.style.display = '';
        }
    });
}
</script>
@endsection