@extends('layouts.manager')

@section('title', 'Hasil Laporan')
@section('page-title', 'Hasil Filter Laporan')

@section('content')
<div class="card-manager p-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <i class="ph ph-chart-bar text-blue-600"></i>
            Hasil Laporan
        </h3>
        <a href="{{ route('manager.reports') }}" 
           class="flex items-center gap-2 px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-xl transition font-medium">
            <i class="ph ph-funnel"></i>
            Filter Ulang
        </a>
    </div>
    
    <!-- Summary Card -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-8 rounded-2xl mb-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-blue-200 text-sm">Total Pendapatan</p>
                <p class="text-4xl font-bold mt-2">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-blue-200 text-sm">Jumlah Transaksi</p>
                <p class="text-4xl font-bold mt-2">{{ $transactions->count() }}</p>
            </div>
            <div>
                <p class="text-blue-200 text-sm">Rata-rata Transaksi</p>
                <p class="text-4xl font-bold mt-2">
                    Rp {{ $transactions->count() > 0 ? number_format($totalIncome / $transactions->count(), 0, ',', '.') : 0 }}
                </p>
            </div>
        </div>
    </div>
    
    @if($transactions->isEmpty())
        <div class="text-center py-16">
            <i class="ph ph-receipt text-6xl text-gray-300 block mb-4"></i>
            <h4 class="text-xl font-semibold text-gray-500">Tidak ada data transaksi</h4>
            <p class="text-gray-400 mt-2">Coba ubah filter atau rentang tanggal</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">No</th>
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Kasir</th>
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Meja</th>
                        <th class="text-right py-4 px-4 text-sm font-semibold text-gray-600">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $index => $transaction)
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                        <td class="py-3 px-4">
                            <span class="text-sm font-medium text-gray-900">{{ $transaction->created_at->format('d M Y') }}</span>
                            <span class="text-xs text-gray-400 block">{{ $transaction->created_at->format('H:i') }}</span>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-700">{{ $transaction->user->full_name }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium">
                                Meja {{ $transaction->table_number }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right text-sm font-semibold text-gray-900">
                            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-blue-50 font-bold">
                        <td colspan="4" class="py-4 px-4 text-right text-blue-900">TOTAL</td>
                        <td class="py-4 px-4 text-right text-blue-900 text-lg">
                            Rp {{ number_format($totalIncome, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>
@endsection