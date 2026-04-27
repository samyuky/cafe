@extends('layouts.cafe')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="cafe-card p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-amber-900">📋 Riwayat Transaksi Saya</h2>
        <a href="{{ route('kasir.dashboard') }}" class="cafe-button">
            ➕ Transaksi Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-amber-50">
                    <th class="text-left py-3 px-4 text-amber-900">No. Transaksi</th>
                    <th class="text-left py-3 px-4 text-amber-900">Tanggal</th>
                    <th class="text-left py-3 px-4 text-amber-900">No. Meja</th>
                    <th class="text-left py-3 px-4 text-amber-900">Total</th>
                    <th class="text-left py-3 px-4 text-amber-900">Pembayaran</th>
                    <th class="text-left py-3 px-4 text-amber-900">Kembalian</th>
                    <th class="text-left py-3 px-4 text-amber-900">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr class="border-b border-gray-100 hover:bg-amber-50 transition">
                    <td class="py-3 px-4 font-semibold">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="py-3 px-4">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td class="py-3 px-4">
                        <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-sm font-semibold">
                            Meja {{ $transaction->table_number }}
                        </span>
                    </td>
                    <td class="py-3 px-4 font-semibold">Rp{{ number_format($transaction->total_amount) }}</td>
                    <td class="py-3 px-4">Rp{{ number_format($transaction->payment_amount) }}</td>
                    <td class="py-3 px-4 text-green-600">Rp{{ number_format($transaction->change_amount) }}</td>
                    <td class="py-3 px-4">
                        <a href="{{ route('kasir.struk', $transaction->id) }}" 
                           class="text-amber-600 hover:text-amber-800 font-semibold">
                            👁️ Lihat
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        <div class="text-4xl mb-3">📭</div>
                        <p>Belum ada transaksi</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection