@extends('layouts.cafe')

@section('title', 'Dashboard Kasir')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Menu Selection -->
    <div class="lg:col-span-2 cafe-card p-6">
        <h2 class="text-2xl font-bold text-amber-900 mb-6">📋 Menu Cafe</h2>
        
        <div class="grid grid-cols-2 gap-4">
            @foreach($menus as $menu)
            <div class="border border-amber-200 rounded-xl p-4 hover:shadow-lg transition cursor-pointer menu-item"
                 data-id="{{ $menu->id }}"
                 data-name="{{ $menu->name }}"
                 data-price="{{ $menu->price }}">
                <div class="text-4xl mb-2">{{ $menu->category == 'makanan' ? '🍽️' : '🥤' }}</div>
                <h3 class="font-semibold text-amber-900">{{ $menu->name }}</h3>
                <p class="text-sm text-gray-500">{{ $menu->description }}</p>
                <p class="text-lg font-bold text-amber-700 mt-2">Rp{{ number_format($menu->price) }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Order Summary -->
    <div class="cafe-card p-6">
        <h2 class="text-2xl font-bold text-amber-900 mb-6">🛒 Pesanan</h2>
        
        <form id="transactionForm" action="{{ route('kasir.transaction.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-amber-900 font-semibold mb-2">No Meja</label>
                <input type="number" name="table_number" class="w-full border-2 border-amber-300 rounded-xl px-4 py-2" required min="1">
            </div>
            
            <div id="orderItems" class="space-y-3 mb-4 max-h-96 overflow-y-auto">
                <!-- Items akan ditambahkan disini -->
            </div>
            
            <div class="border-t-2 border-amber-200 pt-4">
                <div class="flex justify-between text-lg mb-2">
                    <span>Total:</span>
                    <span id="totalAmount" class="font-bold">Rp0</span>
                </div>
                
                <div class="mb-4">
                    <label class="block text-amber-900 font-semibold mb-2">Pembayaran</label>
                    <input type="number" name="payment_amount" id="paymentAmount" 
                           class="w-full border-2 border-amber-300 rounded-xl px-4 py-2" required>
                </div>
                
                <div class="flex justify-between text-lg mb-4">
                    <span>Kembalian:</span>
                    <span id="changeAmount" class="font-bold text-green-600">Rp0</span>
                </div>
                
                <button type="submit" class="cafe-button w-full">
                    💰 Proses Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
let orderItems = [];
let totalAmount = 0;

document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const price = parseFloat(this.dataset.price);
        
        const existingItem = orderItems.find(item => item.id === id);
        
        if (existingItem) {
            existingItem.quantity++;
        } else {
            orderItems.push({
                id: id,
                name: name,
                price: price,
                quantity: 1
            });
        }
        
        updateOrderDisplay();
    });
});

function updateOrderDisplay() {
    const orderDiv = document.getElementById('orderItems');
    totalAmount = 0;
    
    orderDiv.innerHTML = orderItems.map((item, index) => {
        const subtotal = item.price * item.quantity;
        totalAmount += subtotal;
        
        return `
            <div class="flex items-center justify-between bg-amber-50 p-3 rounded-xl">
                <div>
                    <span class="font-semibold text-amber-900">${item.name}</span>
                    <div class="flex items-center space-x-2 mt-1">
                        <button type="button" onclick="changeQuantity(${index}, -1)" class="text-amber-600 hover:text-amber-800">➖</button>
                        <span class="font-bold">${item.quantity}</span>
                        <button type="button" onclick="changeQuantity(${index}, 1)" class="text-amber-600 hover:text-amber-800">➕</button>
                    </div>
                </div>
                <div class="text-right">
                    <span class="font-bold text-amber-700">Rp${subtotal.toLocaleString()}</span>
                    <button type="button" onclick="removeItem(${index})" class="block text-red-500 text-sm">Hapus</button>
                </div>
                <input type="hidden" name="items[${index}][menu_id]" value="${item.id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
            </div>
        `;
    }).join('');
    
    document.getElementById('totalAmount').textContent = 'Rp' + totalAmount.toLocaleString();
    calculateChange();
}

function changeQuantity(index, delta) {
    orderItems[index].quantity += delta;
    if (orderItems[index].quantity <= 0) {
        orderItems.splice(index, 1);
    }
    updateOrderDisplay();
}

function removeItem(index) {
    orderItems.splice(index, 1);
    updateOrderDisplay();
}

document.getElementById('paymentAmount').addEventListener('input', calculateChange);

function calculateChange() {
    const payment = parseFloat(document.getElementById('paymentAmount').value) || 0;
    const change = payment - totalAmount;
    const changeElement = document.getElementById('changeAmount');
    
    if (change >= 0) {
        changeElement.textContent = 'Rp' + change.toLocaleString();
        changeElement.className = 'font-bold text-green-600';
    } else {
        changeElement.textContent = 'Pembayaran kurang Rp' + Math.abs(change).toLocaleString();
        changeElement.className = 'font-bold text-red-600';
    }
}
</script>
@endsection
