@extends('layouts.kasir')

@section('title', 'Transaksi Baru')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-3xl font-display font-bold text-coffee-900">Menu Cafe</h2>
            <p class="text-coffee-500 mt-1 text-sm">Pilih menu untuk memulai transaksi</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Menu Selection -->
        <div class="lg:col-span-2">
            <div class="card p-5">
                <div class="flex flex-col sm:flex-row gap-3 mb-5">
                    <div class="relative flex-1">
                        <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-coffee-400"></i>
                        <input type="text" id="searchMenu" placeholder="Cari menu..." 
                               class="input-coffee pl-10 text-sm">
                    </div>
                    <div class="flex gap-2">
                        <button onclick="filterCategory('all')" 
                                class="px-4 py-2 rounded-xl bg-coffee-800 text-white text-sm font-medium filter-btn">Semua</button>
                        <button onclick="filterCategory('makanan')" 
                                class="px-4 py-2 rounded-xl bg-coffee-50 text-coffee-700 text-sm font-medium filter-btn hover:bg-coffee-100">
                            <i class="ph ph-hamburger mr-1"></i> Makanan
                        </button>
                        <button onclick="filterCategory('minuman')" 
                                class="px-4 py-2 rounded-xl bg-coffee-50 text-coffee-700 text-sm font-medium filter-btn hover:bg-coffee-100">
                            <i class="ph ph-coffee mr-1"></i> Minuman
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4" id="menuGrid">
                    @foreach($menus as $menu)
                    <div class="menu-item border-2 border-coffee-200 rounded-2xl overflow-hidden cursor-pointer hover:border-coffee-500 hover:shadow-lg transition-all duration-300 group bg-white"
                         data-id="{{ $menu->id }}"
                         data-name="{{ $menu->name }}"
                         data-price="{{ $menu->price }}"
                         data-category="{{ $menu->category }}">
                        <div class="relative h-36 bg-coffee-50 overflow-hidden">
                            @if($menu->image)
                                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="ph {{ $menu->category == 'makanan' ? 'ph-hamburger' : 'ph-coffee' }} text-5xl 
                                        {{ $menu->category == 'makanan' ? 'text-orange-300' : 'text-blue-300' }}"></i>
                                </div>
                            @endif
                            <div class="absolute top-2 left-2">
                                <span class="px-2 py-1 rounded-lg text-xs font-medium
                                    {{ $menu->category == 'makanan' ? 'bg-orange-500 text-white' : 'bg-blue-500 text-white' }}">
                                    {{ $menu->category }}
                                </span>
                            </div>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center">
                                <span class="text-white font-bold opacity-0 group-hover:opacity-100 transition text-lg">+ Pesan</span>
                            </div>
                        </div>
                        <div class="p-3">
                            <h4 class="font-semibold text-coffee-900 text-sm">{{ $menu->name }}</h4>
                            <p class="text-base font-bold text-coffee-700 mt-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="card p-5 sticky top-24">
                <h3 class="text-lg font-bold text-coffee-900 mb-4 flex items-center gap-2">
                    <i class="ph ph-shopping-cart text-coffee-600"></i>
                    Pesanan Aktif
                </h3>
                
                <form id="transactionForm" action="{{ route('kasir.transaction.store') }}" method="POST">
                    @csrf
                    
                    <!-- Nama Pembeli -->
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-coffee-700 mb-2">Nama Pembeli</label>
                        <div class="relative">
                            <i class="ph ph-user absolute left-3 top-1/2 -translate-y-1/2 text-coffee-400"></i>
                            <input type="text" name="customer_name" required 
                                   class="input-coffee pl-10" placeholder="Masukkan nama pembeli">
                        </div>
                    </div>
                    
                    <!-- Metode Pembayaran -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-coffee-700 mb-2">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="tunai" checked 
                                    class="peer absolute opacity-0" onchange="updatePaymentMethod()">
                                <div class="border-2 border-coffee-200 rounded-xl p-3 text-center peer-checked:border-coffee-600 peer-checked:bg-coffee-50 transition hover:border-coffee-400">
                                    <i class="ph ph-money text-2xl text-coffee-600 block mb-1"></i>
                                    <span class="text-sm font-medium text-coffee-700">Tunai</span>
                                </div>
                            </label>
                            
                            <label class="relative cursor-pointer">
                                <input type="radio" name="payment_method" value="qris" 
                                    class="peer absolute opacity-0" onchange="updatePaymentMethod()">
                                <div class="border-2 border-coffee-200 rounded-xl p-3 text-center peer-checked:border-coffee-600 peer-checked:bg-coffee-50 transition hover:border-coffee-400">
                                    <i class="ph ph-qr-code text-2xl text-coffee-600 block mb-1"></i>
                                    <span class="text-sm font-medium text-coffee-700">QRIS</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Daftar Pesanan -->
                    <div id="orderItems" class="space-y-3 mb-4 max-h-56 overflow-y-auto pr-1">
                        <div class="text-center py-8 text-coffee-300">
                            <i class="ph ph-hand-tap text-5xl block mb-3"></i>
                            <p class="text-sm">Klik menu untuk menambah</p>
                        </div>
                    </div>
                    
                    <!-- Ringkasan -->
                    <div class="border-t-2 border-coffee-100 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-coffee-500">Subtotal</span>
                            <span id="subtotalAmount" class="font-medium text-coffee-700">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-coffee-500">PPN (11%)</span>
                            <span id="taxAmount" class="font-medium text-coffee-700">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-coffee-100">
                            <span class="text-coffee-700 font-semibold">Total</span>
                            <span id="totalAmount" class="text-xl font-bold text-coffee-900">Rp 0</span>
                        </div>
                        
                        <div id="paymentInputContainer">
                            <label class="block text-sm font-medium text-coffee-700 mb-2 mt-3">Pembayaran</label>
                            <div class="relative">
                                <i class="ph ph-money absolute left-3 top-1/2 -translate-y-1/2 text-coffee-400"></i>
                                <input type="number" name="payment_amount" id="paymentAmount" 
                                       class="input-coffee pl-10" placeholder="Jumlah uang">
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center bg-coffee-50 p-3 rounded-xl">
                            <span class="text-coffee-600 text-sm">Kembalian</span>
                            <span id="changeAmount" class="text-lg font-bold text-emerald-700">Rp 0</span>
                        </div>
                        
                        <button type="submit" 
                                class="btn-coffee w-full py-3 flex items-center justify-center gap-2 text-base">
                            <i class="ph ph-check-circle text-lg"></i>
                            Proses Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const TAX_RATE = 0.11;
let orderItems = [];
let subtotalAmount = 0;

// Search
document.getElementById('searchMenu').addEventListener('input', function() {
    const search = this.value.toLowerCase();
    document.querySelectorAll('.menu-item').forEach(item => {
        item.style.display = item.dataset.name.toLowerCase().includes(search) ? '' : 'none';
    });
});

// Filter
function filterCategory(category) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-coffee-800', 'text-white');
        btn.classList.add('bg-coffee-50', 'text-coffee-700');
    });
    event.target.classList.add('bg-coffee-800', 'text-white');
    event.target.classList.remove('bg-coffee-50', 'text-coffee-700');
    
    document.querySelectorAll('.menu-item').forEach(item => {
        item.style.display = (category === 'all' || item.dataset.category === category) ? '' : 'none';
    });
}

// Switch payment method
function switchPaymentMethod() {
    const method = document.querySelector('input[name="payment_method"]:checked').value;
    const paymentInput = document.getElementById('paymentInputContainer');
    const paymentAmount = document.getElementById('paymentAmount');
    const qrisInfo = document.getElementById('qrisInfo');
    const paymentHint = document.getElementById('paymentHint');
    const submitText = document.getElementById('submitText');
    const submitButton = document.getElementById('submitButton');
    const changeEl = document.getElementById('changeAmount');
    
    if (method === 'qris') {
        // Sembunyikan input pembayaran
        paymentInput.style.display = 'none';
        paymentAmount.required = false;
        paymentAmount.value = '';
        
        // Tampilkan info QRIS
        qrisInfo.classList.remove('hidden');
        
        // Update teks tombol
        submitText.textContent = 'Bayar dengan QRIS';
        submitButton.disabled = false;
        
        // Update kembalian
        changeEl.textContent = 'Rp 0 (QRIS)';
        changeEl.className = 'text-sm font-medium text-blue-600';
    } else {
        // Tampilkan input pembayaran
        paymentInput.style.display = 'block';
        paymentAmount.required = true;
        
        // Sembunyikan info QRIS
        qrisInfo.classList.add('hidden');
        
        // Update teks
        paymentHint.textContent = 'Masukkan jumlah uang dari pembeli';
        submitText.textContent = 'Proses Pembayaran';
        
        calculateChange();
    }
}

// Add item to cart
document.querySelectorAll('.menu-item').forEach(item => {
    item.addEventListener('click', function() {
        const id = this.dataset.id;
        const name = this.dataset.name;
        const price = parseFloat(this.dataset.price);
        
        const existing = orderItems.find(i => i.id === id);
        if (existing) {
            existing.quantity++;
        } else {
            orderItems.push({ id, name, price, quantity: 1 });
        }
        
        updateOrderDisplay();
        
        // Animation
        this.style.transform = 'scale(0.95)';
        setTimeout(() => this.style.transform = '', 100);
    });
});

function updateOrderDisplay() {
    const container = document.getElementById('orderItems');
    subtotalAmount = 0;
    
    if (orderItems.length === 0) {
        container.innerHTML = `
            <div class="text-center py-8 text-coffee-300">
                <i class="ph ph-hand-tap text-5xl block mb-3"></i>
                <p class="text-sm">Klik menu untuk menambah</p>
            </div>`;
        document.getElementById('submitButton').disabled = true;
    } else {
        container.innerHTML = orderItems.map((item, index) => {
            const itemSubtotal = item.price * item.quantity;
            subtotalAmount += itemSubtotal;
            return `
                <div class="bg-coffee-50 rounded-xl p-3 animate-fade-in">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1 mr-2">
                            <p class="font-medium text-coffee-900 text-sm">${item.name}</p>
                            <p class="text-xs text-coffee-400">Rp ${item.price.toLocaleString()} × ${item.quantity}</p>
                        </div>
                        <span class="font-semibold text-coffee-700 text-sm">Rp ${itemSubtotal.toLocaleString()}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="changeQty(${index}, -1)" 
                                class="w-7 h-7 bg-white rounded-lg border border-coffee-200 hover:border-coffee-400 flex items-center justify-center text-sm">−</button>
                        <span class="font-medium text-sm w-8 text-center">${item.quantity}</span>
                        <button type="button" onclick="changeQty(${index}, 1)" 
                                class="w-7 h-7 bg-white rounded-lg border border-coffee-200 hover:border-coffee-400 flex items-center justify-center text-sm">+</button>
                        <button type="button" onclick="removeItem(${index})" class="ml-auto text-red-400 hover:text-red-600">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                    <input type="hidden" name="items[${index}][menu_id]" value="${item.id}">
                    <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                </div>`;
        }).join('');
        
        document.getElementById('submitButton').disabled = false;
    }
    
    // Update amounts
    const taxAmount = subtotalAmount * TAX_RATE;
    const totalAmount = subtotalAmount + taxAmount;
    
    document.getElementById('subtotalAmount').textContent = 'Rp ' + subtotalAmount.toLocaleString();
    document.getElementById('taxAmount').textContent = 'Rp ' + Math.round(taxAmount).toLocaleString();
    document.getElementById('totalAmount').textContent = 'Rp ' + Math.round(totalAmount).toLocaleString();
    
    calculateChange();
}

function changeQty(index, delta) {
    orderItems[index].quantity += delta;
    if (orderItems[index].quantity <= 0) orderItems.splice(index, 1);
    updateOrderDisplay();
}

function removeItem(index) {
    orderItems.splice(index, 1);
    updateOrderDisplay();
}

document.getElementById('paymentAmount').addEventListener('input', calculateChange);

function calculateChange() {
    const taxAmount = subtotalAmount * TAX_RATE;
    const totalAmount = subtotalAmount + taxAmount;
    const method = document.querySelector('input[name="payment_method"]:checked').value;
    const submitButton = document.getElementById('submitButton');
    const paymentHint = document.getElementById('paymentHint');
    
    if (method === 'qris') {
        document.getElementById('changeAmount').textContent = 'Rp 0 (QRIS)';
        document.getElementById('changeAmount').className = 'text-sm font-medium text-blue-600';
        submitButton.disabled = false;
        return;
    }
    
    const payment = parseFloat(document.getElementById('paymentAmount').value) || 0;
    const change = payment - totalAmount;
    const el = document.getElementById('changeAmount');
    
    if (payment === 0) {
        el.textContent = 'Rp 0';
        el.className = 'text-lg font-bold text-coffee-400';
        submitButton.disabled = true;
        paymentHint.textContent = 'Masukkan jumlah uang dari pembeli';
        paymentHint.className = 'text-xs text-coffee-400 mt-1';
    } else if (change >= 0) {
        el.textContent = 'Rp ' + Math.round(change).toLocaleString();
        el.className = 'text-lg font-bold text-emerald-700';
        submitButton.disabled = false;
        paymentHint.textContent = '✅ Pembayaran cukup';
        paymentHint.className = 'text-xs text-emerald-600 mt-1';
    } else {
        el.textContent = 'Kurang Rp ' + Math.abs(Math.round(change)).toLocaleString();
        el.className = 'text-lg font-bold text-red-600';
        submitButton.disabled = true;
        paymentHint.textContent = '❌ Pembayaran kurang Rp ' + Math.abs(Math.round(change)).toLocaleString();
        paymentHint.className = 'text-xs text-red-500 mt-1';
    }
}

// Validasi sebelum submit
document.getElementById('transactionForm').addEventListener('submit', function(e) {
    const customerName = document.getElementById('customerName').value.trim();
    const method = document.querySelector('input[name="payment_method"]:checked').value;
    const taxAmount = subtotalAmount * TAX_RATE;
    const totalAmount = subtotalAmount + taxAmount;
    
    if (!customerName) {
        e.preventDefault();
        alert('Nama pembeli harus diisi!');
        return;
    }
    
    if (orderItems.length === 0) {
        e.preventDefault();
        alert('Pilih minimal 1 menu!');
        return;
    }
    
    if (method === 'tunai') {
        const payment = parseFloat(document.getElementById('paymentAmount').value) || 0;
        if (payment < totalAmount) {
            e.preventDefault();
            alert('Pembayaran kurang! Total: Rp ' + Math.round(totalAmount).toLocaleString());
            return;
        }
    }
});

// Inisialisasi
updateOrderDisplay();
switchPaymentMethod();
</script>
@endsection