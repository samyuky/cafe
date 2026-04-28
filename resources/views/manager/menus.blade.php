@extends('layouts.manager')

@section('title', 'Kelola Menu')
@section('page-title', 'Manajemen Menu Cafe')

@section('content')
<div class="card-manager p-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                <i class="ph ph-list-dashes text-blue-600"></i>
                Daftar Menu
            </h3>
            <p class="text-sm text-gray-500 mt-1">Total: {{ $menus->count() }} menu</p>
        </div>
        <button onclick="openAddModal()" 
                class="btn-blue flex items-center gap-2 px-5 py-3">
            <i class="ph ph-plus-circle text-lg"></i>
            Tambah Menu Baru
        </button>
    </div>

    <!-- Notifikasi Error -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6 animate-fade-in">
            <div class="flex items-start gap-3">
                <i class="ph ph-warning-circle text-red-600 text-xl flex-shrink-0 mt-0.5"></i>
                <div>
                    <h4 class="text-red-800 font-semibold text-sm">Validasi Gagal!</h4>
                    <ul class="mt-2 space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="text-red-600 text-sm flex items-center gap-2">
                                <i class="ph ph-dot text-xs"></i>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-red-400 hover:text-red-600 flex-shrink-0">
                    <i class="ph ph-x"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 mb-6 animate-fade-in flex items-start gap-3" id="successAlert">
            <i class="ph ph-check-circle text-emerald-600 text-xl flex-shrink-0 mt-0.5"></i>
            <div class="flex-1">
                <p class="text-emerald-800 font-semibold text-sm">{{ session('success') }}</p>
            </div>
            <button onclick="document.getElementById('successAlert').remove()" class="text-emerald-400 hover:text-emerald-600 flex-shrink-0">
                <i class="ph ph-x"></i>
            </button>
        </div>
    @endif

    <!-- Notifikasi Error Session -->
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6 animate-fade-in flex items-start gap-3" id="errorAlert">
            <i class="ph ph-warning-circle text-red-600 text-xl flex-shrink-0 mt-0.5"></i>
            <div class="flex-1">
                <p class="text-red-800 font-semibold text-sm">{{ session('error') }}</p>
            </div>
            <button onclick="document.getElementById('errorAlert').remove()" class="text-red-400 hover:text-red-600 flex-shrink-0">
                <i class="ph ph-x"></i>
            </button>
        </div>
    @endif

    <!-- Filter & Search -->
    <div class="flex flex-wrap items-center gap-2 mb-6">
        <button onclick="filterMenu('all')" 
                class="px-4 py-2 rounded-xl text-sm font-medium transition bg-blue-600 text-white filter-btn">
            Semua Menu
        </button>
        <button onclick="filterMenu('makanan')" 
                class="px-4 py-2 rounded-xl text-sm font-medium transition bg-gray-100 text-gray-600 hover:bg-gray-200 filter-btn">
            <i class="ph ph-hamburger mr-1"></i> Makanan
        </button>
        <button onclick="filterMenu('minuman')" 
                class="px-4 py-2 rounded-xl text-sm font-medium transition bg-gray-100 text-gray-600 hover:bg-gray-200 filter-btn">
            <i class="ph ph-coffee mr-1"></i> Minuman
        </button>
        <div class="relative ml-auto">
            <i class="ph ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" id="searchMenu" placeholder="Cari menu..." 
                   class="pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none w-48">
        </div>
    </div>

    <!-- Menu Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($menus as $menu)
        <div class="menu-card border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 group"
             data-category="{{ $menu->category }}">
            <div class="relative h-40 bg-gray-100 overflow-hidden">
                @if($menu->image)
                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <div class="text-center">
                            <i class="ph {{ $menu->category == 'makanan' ? 'ph-hamburger' : 'ph-coffee' }} text-5xl 
                                {{ $menu->category == 'makanan' ? 'text-orange-300' : 'text-blue-300' }}"></i>
                            <p class="text-xs text-gray-400 mt-1">No Image</p>
                        </div>
                    </div>
                @endif
                <div class="absolute top-3 left-3">
                    <span class="px-2 py-1 rounded-lg text-xs font-medium backdrop-blur-sm
                        {{ $menu->category == 'makanan' ? 'bg-orange-500/90 text-white' : 'bg-blue-500/90 text-white' }}">
                        {{ ucfirst($menu->category) }}
                    </span>
                </div>
                <div class="absolute top-3 right-3">
                    <span class="px-2 py-1 rounded-lg text-xs font-medium backdrop-blur-sm
                        {{ $menu->is_available ? 'bg-green-500/90 text-white' : 'bg-red-500/90 text-white' }}">
                        {{ $menu->is_available ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
            </div>
            <div class="p-4">
                <h4 class="font-bold text-gray-900 text-lg mb-1">{{ $menu->name }}</h4>
                <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $menu->description ?? 'Tidak ada deskripsi' }}</p>
                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    <p class="text-xl font-bold text-blue-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                    <button onclick="openEditModal({{ $menu->id }}, '{{ addslashes($menu->name) }}', '{{ $menu->category }}', {{ $menu->price }}, '{{ addslashes($menu->description ?? '') }}', {{ $menu->is_available ? 'true' : 'false' }}, '{{ $menu->image }}')" 
                            class="flex items-center gap-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition text-sm font-medium">
                        <i class="ph ph-pencil"></i>
                        Edit
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Tambah Menu -->
<div id="addModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4 overflow-y-auto" onclick="if(event.target === this) closeAddModal()">
    <div class="bg-white rounded-2xl p-6 max-w-lg w-full my-8 shadow-2xl" onclick="event.stopPropagation()">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="ph ph-plus-circle text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Tambah Menu Baru</h3>
                <p class="text-sm text-gray-500">Lengkapi detail menu cafe</p>
            </div>
        </div>
        
        <form action="{{ route('manager.menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4" id="addMenuForm">
            @csrf
            
            <!-- Upload Gambar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Menu</label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 transition cursor-pointer" 
                     id="addImageContainer">
                    <input type="file" name="image" id="addImage" accept="image/*" 
                           class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewAddImage(event)">
                    <div id="addImagePreview">
                        <i class="ph ph-image text-4xl text-gray-300 block mb-2"></i>
                        <p class="text-sm text-gray-500">Klik untuk upload gambar</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP (Max. 2MB)</p>
                    </div>
                    <img id="addImagePreviewImg" src="" class="hidden max-h-40 mx-auto rounded-lg">
                </div>
                <p id="addImageError" class="text-red-500 text-xs mt-1 hidden"></p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Menu <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="addName" required 
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                       placeholder="Contoh: Kopi Latte"
                       oninput="validateAddForm()">
                <p id="addNameError" class="text-red-500 text-xs mt-1 hidden"></p>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="addCategory" required 
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="addPrice" required 
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                           placeholder="25000"
                           oninput="validateAddForm()">
                    <p id="addPriceError" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" id="addDescription" rows="3" 
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none"
                          placeholder="Deskripsi menu (opsional)"
                          oninput="validateAddForm()"></textarea>
                <p id="addDescError" class="text-red-500 text-xs mt-1 hidden"></p>
            </div>
            
            <!-- Error Summary -->
            <div id="addFormError" class="bg-red-50 border border-red-200 rounded-xl p-3 hidden">
                <p class="text-red-700 text-sm font-medium">Mohon perbaiki error berikut:</p>
                <ul id="addFormErrorList" class="mt-2 space-y-1 text-sm text-red-600"></ul>
            </div>
            
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeAddModal()" 
                        class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
                    Batal
                </button>
                <button type="submit" id="addSubmitBtn"
                        class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition text-sm font-medium flex items-center justify-center gap-2">
                    <i class="ph ph-check"></i>
                    Simpan Menu
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Menu -->
<div id="editModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 p-4 overflow-y-auto" onclick="if(event.target === this) closeEditModal()">
    <div class="bg-white rounded-2xl p-6 max-w-lg w-full my-8 shadow-2xl" onclick="event.stopPropagation()">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="ph ph-pencil text-blue-600 text-xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Edit Menu</h3>
                <p class="text-sm text-gray-500">Perbarui detail menu</p>
            </div>
        </div>
        
        <form id="editForm" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Menu</label>
                <div class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-400 transition cursor-pointer">
                    <input type="file" name="image" id="editImageInput" accept="image/*" 
                           class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewEditImage(event)">
                    <div id="editImagePreview">
                        <i class="ph ph-image text-4xl text-gray-300 block mb-2"></i>
                        <p class="text-sm text-gray-500">Klik untuk ganti gambar</p>
                        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti</p>
                    </div>
                    <img id="editImagePreviewImg" src="" class="hidden max-h-40 mx-auto rounded-lg">
                </div>
                <p id="editCurrentImage" class="text-xs text-blue-500 mt-2 hidden"></p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Menu <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="editName" required 
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                    <select name="category" id="editCategory" required 
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="price" id="editPrice" required 
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" id="editDescription" rows="3" 
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-none"></textarea>
            </div>
            
            <div>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_available" id="editAvailable" value="1" 
                           class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">Menu tersedia (aktif)</span>
                </label>
            </div>
            
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeEditModal()" 
                        class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition text-sm font-medium">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition text-sm font-medium flex items-center justify-center gap-2">
                    <i class="ph ph-check"></i>
                    Update Menu
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .filter-btn.active { background-color: #2563eb; color: white; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .animate-fade-in { animation: fadeIn 0.4s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    .input-error { border-color: #ef4444 !important; }
</style>
@endsection

@section('scripts')
<script>
// Filter
function filterMenu(category) {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('bg-gray-100', 'text-gray-600');
    });
    event.target.classList.add('bg-blue-600', 'text-white');
    event.target.classList.remove('bg-gray-100', 'text-gray-600');
    document.querySelectorAll('.menu-card').forEach(card => {
        card.style.display = (category === 'all' || card.dataset.category === category) ? 'block' : 'none';
    });
}

// Search
document.getElementById('searchMenu').addEventListener('input', function() {
    const s = this.value.toLowerCase();
    document.querySelectorAll('.menu-card').forEach(card => {
        card.style.display = card.querySelector('h4').textContent.toLowerCase().includes(s) ? 'block' : 'none';
    });
});

// Real-time Add Form Validation
function validateAddForm() {
    const name = document.getElementById('addName').value.trim();
    const price = document.getElementById('addPrice').value;
    const desc = document.getElementById('addDescription').value;
    let errors = [];
    
    // Reset
    document.getElementById('addName').classList.remove('input-error');
    document.getElementById('addPrice').classList.remove('input-error');
    document.getElementById('addDescription').classList.remove('input-error');
    document.getElementById('addNameError').classList.add('hidden');
    document.getElementById('addPriceError').classList.add('hidden');
    document.getElementById('addDescError').classList.add('hidden');
    
    // Validasi nama
    if (name && name.length < 3) {
        document.getElementById('addName').classList.add('input-error');
        document.getElementById('addNameError').textContent = 'Nama minimal 3 karakter';
        document.getElementById('addNameError').classList.remove('hidden');
        errors.push('Nama menu minimal 3 karakter');
    }
    
    // Validasi harga
    if (price && (parseInt(price) < 500 || parseInt(price) > 999999)) {
        document.getElementById('addPrice').classList.add('input-error');
        document.getElementById('addPriceError').textContent = 'Harga harus antara Rp 500 - Rp 999.999';
        document.getElementById('addPriceError').classList.remove('hidden');
        errors.push('Harga tidak valid');
    }
    
    // Validasi deskripsi
    if (desc && desc.length > 500) {
        document.getElementById('addDescription').classList.add('input-error');
        document.getElementById('addDescError').textContent = 'Deskripsi maksimal 500 karakter';
        document.getElementById('addDescError').classList.remove('hidden');
        errors.push('Deskripsi terlalu panjang');
    }
    
    // Tampilkan error summary
    const errorDiv = document.getElementById('addFormError');
    const errorList = document.getElementById('addFormErrorList');
    if (errors.length > 0) {
        errorDiv.classList.remove('hidden');
        errorList.innerHTML = errors.map(e => `<li>• ${e}</li>`).join('');
    } else {
        errorDiv.classList.add('hidden');
    }
}

// Preview Add Image
function previewAddImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Validasi tipe file
        const allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!allowed.includes(file.type)) {
            document.getElementById('addImageError').textContent = 'Format harus JPG, PNG, atau WebP!';
            document.getElementById('addImageError').classList.remove('hidden');
            event.target.value = '';
            return;
        }
        // Validasi ukuran
        if (file.size > 2 * 1024 * 1024) {
            document.getElementById('addImageError').textContent = 'Ukuran maksimal 2MB!';
            document.getElementById('addImageError').classList.remove('hidden');
            event.target.value = '';
            return;
        }
        document.getElementById('addImageError').classList.add('hidden');
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('addImagePreview').classList.add('hidden');
            const img = document.getElementById('addImagePreviewImg');
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Preview Edit Image
function previewEditImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('editImagePreview').classList.add('hidden');
            const img = document.getElementById('editImagePreviewImg');
            img.src = e.target.result;
            img.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Modal Add
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    document.getElementById('addModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeAddModal() {
    document.getElementById('addModal').classList.add('hidden');
    document.getElementById('addModal').classList.remove('flex');
    document.body.style.overflow = '';
    resetAddForm();
}
function resetAddForm() {
    document.getElementById('addImagePreview').classList.remove('hidden');
    document.getElementById('addImagePreviewImg').classList.add('hidden');
    document.getElementById('addImage').value = '';
    document.getElementById('addName').value = '';
    document.getElementById('addPrice').value = '';
    document.getElementById('addDescription').value = '';
    document.getElementById('addFormError').classList.add('hidden');
    document.querySelectorAll('#addMenuForm .input-error').forEach(el => el.classList.remove('input-error'));
    document.querySelectorAll('#addMenuForm .text-red-500.text-xs').forEach(el => el.classList.add('hidden'));
}

// Modal Edit
function openEditModal(id, name, category, price, description, isAvailable, image) {
    document.getElementById('editForm').action = '/manager/menu/' + id;
    document.getElementById('editName').value = name;
    document.getElementById('editCategory').value = category;
    document.getElementById('editPrice').value = price;
    document.getElementById('editDescription').value = description;
    document.getElementById('editAvailable').checked = isAvailable;
    document.getElementById('editImagePreview').classList.remove('hidden');
    document.getElementById('editImagePreviewImg').classList.add('hidden');
    document.getElementById('editImageInput').value = '';
    
    const currentImageText = document.getElementById('editCurrentImage');
    if (image && image !== '') {
        currentImageText.textContent = '📸 Menu ini memiliki gambar. Upload baru untuk mengganti.';
        currentImageText.classList.remove('hidden');
    } else {
        currentImageText.classList.add('hidden');
    }
    
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
    document.body.style.overflow = '';
}

// Auto-hide alerts
setTimeout(() => {
    document.querySelectorAll('.animate-fade-in').forEach(el => {
        el.style.transition = 'all 0.5s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 500);
    });
}, 5000);
</script>
@endsection