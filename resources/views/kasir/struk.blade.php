@extends('layouts.cafe')

@section('title', 'Struk Pembayaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="cafe-card p-8">
        <!-- Header Struk -->
        <div class="text-center border-b-2 border-dashed border-amber-300 pb-6 mb-6">
            <div class="text-5xl mb-3">☕</div>
            <h1 class="text-2xl font-bold text-amber-900">CUMA Cafe</h1>
            <p class="text-gray-500">Jl. Kopi Nikmat No. 123</p>
            <p class="text-gray-500">Telp: (021) 1234-5678</p>
            <div class="mt-3">
                <span class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-semibold">
                    ✅ LUNAS
                </span>
            </div>
        </div>

        <!-- Info Transaksi -->
        <div class="grid grid-cols-2 gap-3 mb-6 text-sm">
            <div>
                <span class="text-gray-500">No. Transaksi:</span>
                <span class="font-semibold">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div>
                <span class="text-gray-500">Tanggal:</span>
                <span class="font-semibold">{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </div>
            <div>
                <span class="text-gray-500">Kasir:</span>
                <span class="font-semibold">{{ $transaction->user->full_name }}</span>
            </div>
            <div>
                <span class="text-gray-500">No. Meja:</span>
                <span class="font-semibold text-lg text-amber-700">{{ $transaction->table_number }}</span>
            </div>
        </div>

        <!-- Detail Pesanan -->
        <table class="w-full mb-6">
            <thead>
                <tr class="border-b-2 border-amber-200">
                    <th class="text-left py-2 text-amber-900">Item</th>
                    <th class="text-center py-2 text-amber-900">Qty</th>
                    <th class="text-right py-2 text-amber-900">Harga</th>
                    <th class="text-right py-2 text-amber-900">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->transactionDetails as $detail)
                <tr class="border-b border-gray-100">
                    <td class="py-3">
                        <div class="flex items-center space-x-2">
                            <span class="text-xl">{{ $detail->menu->category == 'makanan' ? '🍽️' : '🥤' }}</span>
                            <span>{{ $detail->menu->name }}</span>
                        </div>
                    </td>
                    <td class="text-center py-3">{{ $detail->quantity }}</td>
                    <td class="text-right py-3">Rp{{ number_format($detail->price) }}</td>
                    <td class="text-right py-3 font-semibold">Rp{{ number_format($detail->subtotal) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total & Pembayaran -->
        <div class="border-t-2 border-dashed border-amber-300 pt-4">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Total</span>
                <span class="text-xl font-bold text-amber-900">Rp{{ number_format($transaction->total_amount) }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Pembayaran</span>
                <span class="font-semibold">Rp{{ number_format($transaction->payment_amount) }}</span>
            </div>
            <div class="flex justify-between items-center text-lg">
                <span class="text-gray-600">Kembalian</span>
                <span class="font-bold text-green-600">Rp{{ number_format($transaction->change_amount) }}</span>
            </div>
        </div>

        <!-- Footer Struk -->
        <div class="text-center mt-8 pt-6 border-t-2 border-dashed border-amber-300">
            <p class="text-gray-500 text-sm">Terima kasih telah berkunjung!</p>
            <p class="text-gray-500 text-sm">Simpan struk ini sebagai bukti pembayaran</p>
            <p class="text-amber-700 font-semibold mt-2">😊 Selamat menikmati! 😊</p>
        </div>

        <!-- Tombol Aksi -->
        <div class="mt-6 flex space-x-3">
            <button onclick="window.print()" class="flex-1 bg-amber-600 text-white py-2 rounded-xl hover:bg-amber-700 transition">
                🖨️ Cetak Struk
            </button>
            <a href="{{ route('kasir.dashboard') }}" class="flex-1 bg-green-600 text-white py-2 rounded-xl hover:bg-green-700 transition text-center">
                ➕ Transaksi Baru
            </a>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .cafe-card, .cafe-card * {
            visibility: visible;
        }
        .cafe-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            box-shadow: none !important;
        }
        button, a {
            display: none !important;
        }
    }
</style>
@endsection