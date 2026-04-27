@extends('layouts.cafe')

@section('title', 'Hasil Laporan')

@section('content')
<div class="bg-white rounded-2xl p-6 shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-amber-900">📈 Hasil Laporan</h2>
        <a href="{{ route('manager.reports') }}" 
           class="text-amber-600 hover:text-amber-800 font-medium flex items-center">
            <span class="mr-2">🔙</span> Filter Ulang
        </a>
    </div>
    
    <!-- Ringkasan -->
    <div class="bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-white p-8 rounded-2xl mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-amber-100 text-sm">Total Pendapatan</p>
                <p class="text-4xl font-bold mt-2">Rp{{ number_format($totalIncome) }}</p>
            </div>
            <div>
                <p class="text-amber-100 text-sm">Jumlah Transaksi</p>
                <p class="text-4xl font-bold mt-2">{{ $transactions->count() }} Transaksi</p>
            </div>
        </div>
    </div>
    
    @if($transactions->isEmpty())
        <div class="text-center py-12">
            <div class="text-6xl mb-4">📭</div>
            <p class="text-gray-500 text-lg">Tidak ada transaksi untuk filter yang dipilih</p>
            <a href="{{ route('manager.reports') }}" class="text-amber-600 hover:text-amber-800 font-medium mt-2 inline-block">
                Coba filter lain
            </a>
        </div>
    @else
        <!-- Tabel Transaksi -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-amber-50">
                        <th class="text-left py-4 px-4 text-amber-900">No.</th>
                        <th class="text-left py-4 px-4 text-amber-900">Tanggal</th>
                        <th class="text-left py-4 px-4 text-amber-900">Kasir</th>
                        <th class="text-left py-4 px-4 text-amber-900">No. Meja</th>
                        <th class="text-right py-4 px-4 text-amber-900">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $index => $transaction)
                    <tr class="border-b border-gray-100 hover:bg-amber-50 transition">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 text-sm">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-3 px-4 font-medium">{{ $transaction->user->full_name }}</td>
                        <td class="py-3 px-4">
                            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm">
                                Meja {{ $transaction->table_number }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right font-bold text-amber-700">
                            Rp{{ number_format($transaction->total_amount) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="bg-amber-100 font-bold text-lg">
                        <td colspan="4" class="py-4 px-4 text-right">TOTAL</td>
                        <td class="py-4 px-4 text-right text-amber-900">Rp{{ number_format($totalIncome) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>
@endsection