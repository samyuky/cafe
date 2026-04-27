@extends('layouts.cafe')

@section('title', 'Kelola Menu')

@section('content')
<div class="cafe-card p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-amber-900">📝 Kelola Menu Cafe</h2>
        <button onclick="openAddModal()" class="cafe-button">
            ➕ Tambah Menu
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Filter Kategori -->
    <div class="flex space-x-3 mb-6">
        <button onclick="filterMenu('all')" class="px-4 py-2 rounded-xl bg-amber-600 text-white">Semua</button>
        <button onclick="filterMenu('makanan')" class="px-4 py-2 rounded-xl bg-amber-100 text-amber-700 hover:bg-amber-200">🍽️ Makanan</button>
        <button onclick="filterMenu('minuman')" class="px-4 py-2 rounded-xl bg-amber-100 text-amber-700 hover:bg-amber-200">🥤 Minuman</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($menus as $menu)
        <div class="menu-card border border-amber-200 rounded-xl p-4 hover:shadow-lg transition"
             data-category="{{ $menu->category }}">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <span class="text-3xl">{{ $menu->category == 'makanan' ? '🍽️' : '🥤' }}</span>
                    <span class="ml-2 px-2 py-1 bg-amber-100 text-amber-700 text-xs rounded-full">
                        {{ ucfirst($menu->category) }}
                    </span>
                </div>
                @if($menu->is_available)
                    <span class="text-green-600 text-sm">✅ Tersedia</span>
                @else
                    <span class="text-red-600 text-sm">❌ Tidak Tersedia</span>
                @endif
            </div>
            
            <h3 class="font-bold text-amber-900 text-lg">{{ $menu->name }}</h3>
            <p class="text-gray-500 text-sm mt-1">{{ $menu->description ?? 'Tidak ada deskripsi' }}</p>
            <p class="text-xl font-bold text-amber-700 mt-3">Rp{{ number_format($menu->price) }}</p>
            
            <button onclick="openEditModal({{ $menu->id }}, '{{ $menu->name }}', '{{ $menu->category }}', {{ $menu->price }}, '{{ $menu->description }}', {{ $menu->is_available }})" 
                    class="mt-3 w-full bg-amber-100 text-amber-700 py-2 rounded-xl hover:bg-amber-200 transition">
                ✏️ Edit Menu
            </button>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Tambah Menu -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold text-amber-900 mb-4">➕ Tambah Menu Baru</h3>
        <form action="{{ route('manager.menu.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-amber-900 font-medium mb-1">Nama Menu</label>
                    <input type="text" name="name" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-1">Kategori</label>
                    <select name="category" required class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                        <option value="makanan">🍽️ Makanan</option>
                        <option value="minuman">🥤 Minuman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-1">Harga</label>
                    <input type="number" name="price" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" 
                              class="w-full border-2 border-amber-200 rounded-xl px-4 py-2"></textarea>
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 cafe-button">💾 Simpan</button>
                    <button type="button" onclick="closeAddModal()" 
                            class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-xl hover:bg-gray-300">
                        ❌ Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Menu -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4">
        <h3 class="text-2xl font-bold text-amber-900 mb-4">✏️ Edit Menu</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-amber-900 font-medium mb-1">Nama Menu</label>
                    <input type="text" name="name" id="editName" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-1">Kategori</label>
                    <select name="category" id="editCategory" required 
                            class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                        <option value="makanan">🍽️ Makanan</option>
                        <option value="minuman">🥤 Minuman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-1">Harga</label>
                    <input type="number" name="price" id="editPrice" required 
                           class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                </div>
                <div>
                    <label class="block text-amber-900 font-medium mb-1">Deskripsi</label>
                    <textarea name="description" id="editDescription" rows="3" 
                              class="w-full border-2 border-amber-200 rounded-xl px-4 py-2"></textarea>
                </div>
                <div>
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="is_available" id="editAvailable" value="1" 
                               class="border-amber-300 text-amber-600 rounded">
                        <span class="text-amber-900">Menu tersedia</span>
                    </label>
                </div>
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 cafe-button">💾 Update</button>
                    <button type="button" onclick="closeEditModal()" 
                            class="flex-1 bg-gray-200 text-gray-700 py-2 rounded-xl hover:bg-gray-300">
                        ❌ Batal
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
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
    document.getElementById('editDescription').value = description || '';
    document.getElementById('editAvailable').checked = isAvailable;
    
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}

function filterMenu(category) {
    const cards = document.querySelectorAll('.menu-card');
    cards.forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection
