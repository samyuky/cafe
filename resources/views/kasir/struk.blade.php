@extends('layouts.kasir')

@section('title', 'Struk Pembayaran')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="card p-8" id="printArea">
        <!-- Header -->
        <div class="text-center border-b-2 border-dashed border-coffee-200 pb-6 mb-6">
            <div class="w-16 h-16 bg-gradient-to-br from-coffee-700 to-coffee-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                <i class="ph ph-coffee text-white text-2xl"></i>
            </div>
            <h2 class="text-2xl font-display font-bold text-coffee-900">CUMA Cafe</h2>
            <p class="text-coffee-500 text-sm mt-1">Jl. Kopi Nikmat No. 123</p>
            
            <!-- Nomor Antrian -->
            <div class="mt-4 inline-flex flex-col items-center">
                <span class="text-xs text-coffee-400">Nomor Antrian</span>
                <span class="text-3xl font-bold text-coffee-900 bg-coffee-50 px-6 py-2 rounded-xl mt-1">
                    {{ $transaction->queue_number }}
                </span>
            </div>
            
            <!-- Barcode -->
            <div class="mt-4 flex justify-center">
                <svg id="barcode"></svg>
            </div>
            
            <div class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-emerald-50 text-emerald-700 rounded-full">
                <i class="ph ph-check-circle text-emerald-600"></i>
                <span class="text-sm font-semibold">LUNAS</span>
            </div>
        </div>

        <!-- Info Transaksi -->
        <div class="bg-coffee-50 rounded-2xl p-4 mb-6">
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <p class="text-coffee-400 text-xs">No. Transaksi</p>
                    <p class="font-bold text-coffee-900">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-coffee-400 text-xs">Kasir</p>
                    <p class="font-medium text-coffee-700">{{ $transaction->user->full_name }}</p>
                </div>
                <div>
                    <p class="text-coffee-400 text-xs">Tanggal</p>
                    <p class="font-medium text-coffee-700">{{ $transaction->created_at->format('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-coffee-400 text-xs">Jam</p>
                    <p class="font-medium text-coffee-700">{{ $transaction->created_at->format('H:i') }}</p>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-coffee-200 space-y-2">
                <div class="flex justify-between">
                    <span class="text-coffee-500 text-sm">Nama Pembeli</span>
                    <span class="font-semibold text-coffee-900">{{ $transaction->customer_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-coffee-500 text-sm">Metode Bayar</span>
                    <span class="font-semibold text-coffee-900 uppercase">
                        @php
                            $methods = [
                                'tunai' => '💵 Tunai',
                                'qris' => '📱 QRIS',
                            ];
                        @endphp
                        {{ $methods[$transaction->payment_method] ?? $transaction->payment_method }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Detail Pesanan -->
        <div class="mb-6">
            <h4 class="font-semibold text-coffee-900 mb-3">Detail Pesanan</h4>
            <div class="space-y-2">
                @foreach($transaction->transactionDetails as $detail)
                <div class="flex items-center justify-between py-3 border-b border-coffee-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center
                            {{ $detail->menu->category == 'makanan' ? 'bg-orange-50' : 'bg-blue-50' }}">
                            <i class="ph {{ $detail->menu->category == 'makanan' ? 'ph-hamburger' : 'ph-coffee' }} text-lg
                                {{ $detail->menu->category == 'makanan' ? 'text-orange-600' : 'text-blue-600' }}"></i>
                        </div>
                        <div>
                            <p class="font-medium text-coffee-900 text-sm">{{ $detail->menu->name }}</p>
                            <p class="text-xs text-coffee-400">
                                {{ $detail->quantity }} × Rp {{ number_format($detail->price, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                    <span class="font-semibold text-coffee-700">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Total & Pembayaran -->
        <div class="border-t-2 border-dashed border-coffee-200 pt-4 space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-coffee-500">Subtotal</span>
                <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-coffee-500">PPN (11%)</span>
                <span>Rp {{ number_format($transaction->tax_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center pt-2 border-t border-coffee-100">
                <span class="text-coffee-700 font-semibold">Total</span>
                <span class="text-xl font-bold text-coffee-900">
                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                </span>
            </div>
            
            @if($transaction->payment_method == 'tunai')
                <div class="flex justify-between text-sm">
                    <span class="text-coffee-500">Pembayaran</span>
                    <span>Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center pt-2 border-t border-coffee-100">
                    <span class="text-coffee-700 font-semibold">Kembalian</span>
                    <span class="text-xl font-bold text-emerald-700">
                        Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                    </span>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 pt-6 border-t-2 border-dashed border-coffee-200">
            <p class="text-coffee-400 text-sm">Terima kasih telah berkunjung!</p>
            <p class="text-coffee-300 text-xs mt-1">Simpan struk ini sebagai bukti pembayaran</p>
            <p class="text-coffee-500 font-medium mt-3">Selamat menikmati ☕</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex gap-3 mt-6 no-print">
        <button onclick="printStruk()" 
                class="flex-1 btn-coffee flex items-center justify-center gap-2 py-3">
            <i class="ph ph-printer text-lg"></i>
            Cetak Struk
        </button>
        <a href="{{ route('kasir.dashboard') }}" 
           class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition shadow-lg">
            <i class="ph ph-plus-circle text-lg"></i>
            Transaksi Baru
        </a>
    </div>
</div>

<style>
    @media print {
        body * { visibility: hidden; }
        #printArea, #printArea * { visibility: visible; }
        #printArea {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            max-width: 400px;
            box-shadow: none !important;
            border: none !important;
        }
        .no-print { display: none !important; }
    }
</style>
@endsection

@section('scripts')
<script>
// Generate Barcode
document.addEventListener('DOMContentLoaded', function() {
    const transactionId = "{{ $transaction->queue_number }}";
    
    try {
        JsBarcode("#barcode", transactionId, {
            format: "CODE128",
            width: 2,
            height: 60,
            displayValue: true,
            fontSize: 14,
            font: "Inter",
            textMargin: 5,
            margin: 10,
            background: "#ffffff",
            lineColor: "#000000",
            text: transactionId
        });
    } catch (error) {
        console.error('Barcode error:', error);
        document.getElementById('barcode').innerHTML = 
            '<text x="50%" y="50%" text-anchor="middle" fill="#999">' + transactionId + '</text>';
    }
});

function printStruk() {
    window.print();
}
</script>
@endsection