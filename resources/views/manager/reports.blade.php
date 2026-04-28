@extends('layouts.manager')

@section('title', 'Laporan Penjualan')
@section('page-title', 'Laporan Penjualan')

@section('content')
<div class="space-y-6">
    <!-- Filter Card -->
    <div class="card-manager p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
            <i class="ph ph-funnel text-blue-600"></i>
            Filter Laporan
        </h3>
        
        <form action="{{ route('manager.reports') }}" method="GET" id="filterForm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kasir</label>
                    <select name="user_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value="">Semua Kasir</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Metode Bayar</label>
                    <select name="payment_method" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value="">Semua Metode</option>
                        <option value="tunai" {{ request('payment_method') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                        <option value="qris" {{ request('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>
            </div>
            
            <div class="flex justify-end gap-3">
                <a href="{{ route('manager.reports') }}" 
                   class="px-6 py-2.5 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition text-sm font-medium flex items-center gap-2">
                    <i class="ph ph-arrow-counter-clockwise"></i>
                    Reset Filter
                </a>
                <button type="submit" 
                        class="btn-blue flex items-center gap-2">
                    <i class="ph ph-magnifying-glass"></i>
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    <!-- Active Filters Info -->
    @if(request()->hasAny(['user_id', 'date_from', 'date_to', 'payment_method']))
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 flex flex-wrap items-center gap-3">
            <span class="text-sm font-medium text-blue-700">Filter Aktif:</span>
            
            @if(request('user_id'))
                @php $filterUser = $users->find(request('user_id')); @endphp
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium flex items-center gap-2">
                    Kasir: {{ $filterUser->full_name ?? 'Unknown' }}
                    <a href="{{ route('manager.reports', array_merge(request()->except('user_id'), ['user_id' => ''])) }}" class="text-blue-500 hover:text-blue-700">×</a>
                </span>
            @endif
            
            @if(request('date_from'))
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium flex items-center gap-2">
                    Dari: {{ \Carbon\Carbon::parse(request('date_from'))->format('d M Y') }}
                    <a href="{{ route('manager.reports', array_merge(request()->except('date_from'), ['date_from' => ''])) }}" class="text-blue-500 hover:text-blue-700">×</a>
                </span>
            @endif
            
            @if(request('date_to'))
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium flex items-center gap-2">
                    Sampai: {{ \Carbon\Carbon::parse(request('date_to'))->format('d M Y') }}
                    <a href="{{ route('manager.reports', array_merge(request()->except('date_to'), ['date_to' => ''])) }}" class="text-blue-500 hover:text-blue-700">×</a>
                </span>
            @endif
            
            @if(request('payment_method'))
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium flex items-center gap-2">
                    {{ ucfirst(request('payment_method')) }}
                    <a href="{{ route('manager.reports', array_merge(request()->except('payment_method'), ['payment_method' => ''])) }}" class="text-blue-500 hover:text-blue-700">×</a>
                </span>
            @endif
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="card-manager p-5 bg-gradient-to-br from-blue-50 to-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="ph ph-currency-dollar text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card-manager p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalTransactions }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="ph ph-receipt text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card-manager p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Rata-rata Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($avgTransaction, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <i class="ph ph-calculator text-emerald-600 text-2xl"></i>
                </div>
            </div>
        </div>
        
        <div class="card-manager p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Metode Favorit</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $tunaiTotal >= $qrisTotal ? 'Tunai' : 'QRIS' }}</p>
                </div>
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                    <i class="ph ph-trend-up text-amber-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="card-manager p-5">
            <h4 class="text-sm font-semibold text-gray-700 mb-4">Penjualan per Kategori</h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">🍽️ Makanan</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($foodTotal, 0, ',', '.') }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-orange-500 h-2 rounded-full" style="width: {{ ($totalIncome > 0) ? ($foodTotal / $totalIncome * 100) : 0 }}%"></div>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">🥤 Minuman</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($drinkTotal, 0, ',', '.') }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ ($totalIncome > 0) ? ($drinkTotal / $totalIncome * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="card-manager p-5">
            <h4 class="text-sm font-semibold text-gray-700 mb-4">Penjualan per Metode Bayar</h4>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">💵 Tunai</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($tunaiTotal, 0, ',', '.') }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($totalIncome > 0) ? ($tunaiTotal / $totalIncome * 100) : 0 }}%"></div>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">📱 QRIS</span>
                    <span class="font-semibold text-gray-900">Rp {{ number_format($qrisTotal, 0, ',', '.') }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" style="width: {{ ($totalIncome > 0) ? ($qrisTotal / $totalIncome * 100) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="card-manager p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="ph ph-list-bullets text-blue-600"></i>
                Daftar Transaksi
            </h3>
            <span class="text-sm text-gray-500">{{ $transactions->count() }} transaksi ditemukan</span>
        </div>
        
        @if($transactions->isEmpty())
            <div class="text-center py-12">
                <i class="ph ph-receipt-x text-5xl text-gray-300 block mb-4"></i>
                <p class="text-gray-500 text-lg">Tidak ada transaksi</p>
                <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau rentang tanggal</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left py-4 px-4 text-xs font-semibold text-gray-500 uppercase">No</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold text-gray-500 uppercase">Antrian</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold text-gray-500 uppercase">Kasir</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold text-gray-500 uppercase">Pembeli</th>
                            <th class="text-left py-4 px-4 text-xs font-semibold text-gray-500 uppercase">Metode</th>
                            <th class="text-right py-4 px-4 text-xs font-semibold text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $transaction)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-3 px-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="py-3 px-4">
                                <span class="font-mono font-semibold text-blue-700 text-sm">#{{ $transaction->queue_number }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-sm text-gray-900">{{ $transaction->created_at->format('d M Y') }}</span>
                                <span class="text-xs text-gray-400 block">{{ $transaction->created_at->format('H:i') }}</span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-700">{{ $transaction->user->full_name }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-blue-100 rounded-lg flex items-center justify-center text-xs font-bold text-blue-700">
                                        {{ strtoupper(substr($transaction->customer_name, 0, 2)) }}
                                    </div>
                                    <span class="text-sm text-gray-900">{{ $transaction->customer_name }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ $transaction->payment_method == 'tunai' ? 'bg-green-100 text-green-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $transaction->payment_method == 'tunai' ? '💵 Tunai' : '📱 QRIS' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right text-sm font-bold text-gray-900">
                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="bg-blue-50 font-bold">
                            <td colspan="6" class="py-4 px-4 text-right text-blue-900">TOTAL</td>
                            <td class="py-4 px-4 text-right text-blue-900 text-lg">
                                Rp {{ number_format($totalIncome, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
// Auto-submit form when date changes
document.querySelectorAll('input[type="date"]').forEach(input => {
    input.addEventListener('change', function() {
        // Optional: auto-submit
        // document.getElementById('filterForm').submit();
    });
});

// Remove filter tag
function removeFilter(param) {
    const url = new URL(window.location.href);
    url.searchParams.delete(param);
    window.location.href = url.toString();
}
</script>
@endsection