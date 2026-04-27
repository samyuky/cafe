@extends('layouts.cafe')

@section('title', 'Kelola Menu')

@section('content')
<div class="bg-white rounded-2xl p-6 shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-amber-900">📝 Kelola Menu Cafe</h2>
        <button onclick="openAddModal()" 
                class="bg-gradient-to-r from-amber-700 to-amber-500 text-white px-6 py-3 rounded-xl font-bold hover:shadow-lg transition">
            ➕ Tambah Menu Baru
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 flex items-center">
            <span class="text-2xl mr-3">✅</span>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center">
            <span class="text-2xl mr-3">❌</span>
            {{ session('error') }}
        </div>
    @endif

    <!-- Filter Kategori -->
    <div class="flex flex-wrap gap-2 mb-6">
        <button onclick="filterMenu('all')" 
                class="px-4 py-2 rounded-xl bg-amber-600 text-white font-medium filter-btn active">Semua</button>
        <button onclick="filterMenu('makanan')" 
                class="px-4 py-2 rounded-xl bg-amber-100 text-amber-700 font-medium filter-btn hover:bg-amber-200">
            🍽️ Makanan
        </button>
        <button onclick="filterMenu('minuman')" 
                class="px-4 py-2 rounded-xl bg-amber-100 text-amber-700 font-medium filter-btn hover:bg-amber-200">
            🥤 Minuman
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($menus as $menu)
        <div class="menu-card border-2 border-amber-100 rounded-2xl p-5 hover:shadow-xl transition-all duration-300 hover:border-amber-300"
             data-category="{{ $menu->category }}">
            <div class="flex justify-between items-start mb-3">
                <div class="flex items-center space-x-2">
                    <span class="text-3xl">{{ $menu->category == 'makanan' ? '🍽️' : '🥤' }}</span>
                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-xs rounded-full font-medium">
                        {{ ucfirst($menu->category) }}
                    </span>
                </div>
                <span class="text-sm {{ $menu->is_available ? 'text-green-600' : 'text-red-600' }}">
                    {{ $menu->is_available ? '✅ Aktif' : '❌ Nonaktif' }}
                </span>
            </div>
            
            <h3 class="font-bold text-amber-900 text-lg mb-2">{{ $menu->name }}</h3>
            <p class="text-gray-500 text-sm mb-3">{{ $menu->description ?? 'Tidak ada deskripsi' }}</p>
            
            <div class="flex justify-between items-center">
                <p class="text-2xl font-bold text-amber-700">Rp{{ number_format($menu->price) }}</p>
                <button onclick="openEditModal({{ $menu->id }}, '{{ addslashes($menu->name) }}', '{{ $menu->category }}', {{ $menu->price }}, '{{ addslashes($menu->description ?? '') }}', {{ $menu->is_available ? 'true' : 'false' }})" 
                        class="bg-amber-100 text-amber-700 px-4 py-2 rounded-xl hover:bg-amber-200 transition font-medium">
                    ✏️ Edit
                </button>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Tambah Menu -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full">
        <h3 class="text-2xl font-bold text-amber-900 mb-6">➕ Tambah Menu Baru</h3>
        <form action="{{ route('manager.menu.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Nama Menu *</label>
                    <input type="text" name="name" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none"
                           placeholder="Contoh: Kopi Latte">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Kategori *</label>
                    <select name="category" required 
                            class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none">
                        <option value="makanan">🍽️ Makanan</option>
                        <option value="minuman">🥤 Minuman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Harga *</label>
                    <input type="number" name="price" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none"
                           placeholder="Contoh: 25000">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" 
                              class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none"
                              placeholder="Deskripsi menu (opsional)"></textarea>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-amber-700 to-amber-500 text-white py-3 rounded-xl font-bold hover:shadow-lg transition">
                        💾 Simpan Menu
                    </button>
                    <button type="button" onclick="closeAddModal()" 
                            class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition">
                        ❌ Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Menu -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full">
        <h3 class="text-2xl font-bold text-amber-900 mb-6">✏️ Edit Menu</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Nama Menu *</label>
                    <input type="text" name="name" id="editName" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Kategori *</label>
                    <select name="category" id="editCategory" required 
                            class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none">
                        <option value="makanan">🍽️ Makanan</option>
                        <option value="minuman">🥤 Minuman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Harga *</label>
                    <input type="number" name="price" id="editPrice" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-2">Deskripsi</label>
                    <textarea name="description" id="editDescription" rows="3" 
                              class="w-full border-2 border-amber-200 rounded-xl px-4 py-3 focus:border-amber-500 focus:outline-none"></textarea>
                </div>
                <div>
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="is_available" id="editAvailable" value="1" 
                               class="w-5 h-5 border-2 border-amber-300 text-amber-600 rounded focus:ring-amber-500">
                        <span class="text-amber-900 font-medium">Menu tersedia (aktif)</span>
                    </label>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-amber-700 to-amber-500 text-white py-3 rounded-xl font-bold hover:shadow-lg transition">
                        💾 Update Menu
                    </button>
                    <button type="button" onclick="closeEditModal()" 
                            class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-300 transition">
                        ❌ Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .filter-btn.active {
        background: linear-gradient(135deg, #6F4E37 0%, #A67B5B 100%);
        color: white;
    }
</style>
@endsection

@section('scripts')
<script>
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    document.getElementById('addModal').classList.add('flex');
}

function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('addModal').classList.remove('flex');
}

function openEditModal(id, name, category, price, description, isAvailable) {
    document.getElementById('editForm').action = '/manager/menu/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editCategory').value = category;
    document.getElementById('editPrice').value = price;
    document.getElementById('editDescription').value = description;
    document.getElementById('editAvailable').checked = isAvailable;
    
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

function filterMenu(category) {
    // Update active button
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
        btn.classList.add('bg-amber-100', 'text-amber-700');
    });
    event.target.classList.add('active');
    event.target.classList.remove('bg-amber-100', 'text-amber-700');
    
    // Filter cards
    const cards = document.querySelectorAll('.menu-card');
    cards.forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Close modal when clicking outside
document.getElementById('addModal').addEventListener('click', function(e) {
    if (e.target === this) closeAddModal();
});

document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>
@endsection