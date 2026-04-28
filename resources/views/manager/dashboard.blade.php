@extends('layouts.manager')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Manager')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="stat-card p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Pendapatan Hari Ini</p>
                <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($todayIncome, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ now()->format('d M Y') }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="ph ph-currency-dollar text-blue-600 text-lg"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card p-5" style="border-left-color: #10b981;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Pendapatan Bulanan</p>
                <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ now()->format('F Y') }}</p>
            </div>
            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="ph ph-chart-line-up text-emerald-600 text-lg"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card p-5" style="border-left-color: #f59e0b;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Transaksi Hari Ini</p>
                <p class="text-xl font-bold text-gray-900 mt-1">{{ $totalTransactions }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Transaksi</p>
            </div>
            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="ph ph-shopping-cart text-amber-600 text-lg"></i>
            </div>
        </div>
    </div>
    
    <div class="stat-card p-5" style="border-left-color: #8b5cf6;">
        @php
            $avgTransaction = $totalTransactions > 0 ? $todayIncome / $totalTransactions : 0;
        @endphp
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-500 font-medium uppercase tracking-wider">Rata-rata</p>
                <p class="text-xl font-bold text-gray-900 mt-1">Rp {{ number_format($avgTransaction, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-0.5">Per transaksi</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class="ph ph-calculator text-purple-600 text-lg"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <div class="card-manager p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <i class="ph ph-chart-line text-blue-600"></i>
                Pendapatan 7 Hari Terakhir
            </h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">Mingguan</span>
        </div>
        <div style="height: 220px;">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>
    
    <div class="card-manager p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <i class="ph ph-chart-pie text-purple-600"></i>
                Penjualan per Kategori
            </h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">Bulan Ini</span>
        </div>
        <div style="height: 220px;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

<!-- Second Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="lg:col-span-2 card-manager p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <i class="ph ph-star text-amber-600"></i>
                Menu Terlaris Bulan Ini
            </h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">Top 5</span>
        </div>
        <div style="height: 200px;">
            <canvas id="topMenuChart"></canvas>
        </div>
    </div>
    
    <div class="card-manager p-5">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                <i class="ph ph-clock text-orange-600"></i>
                Jam Sibuk
            </h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">Hari Ini</span>
        </div>
        <div style="height: 200px;">
            <canvas id="hourlyChart"></canvas>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('manager.menus') }}" class="card-manager p-4 hover:shadow-md transition cursor-pointer group flex items-center gap-3">
        <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-blue-100 transition">
            <i class="ph ph-list-dashes text-blue-600 text-lg"></i>
        </div>
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Kelola Menu</h3>
            <p class="text-xs text-gray-500">Tambah & edit menu</p>
        </div>
    </a>
    
    <a href="{{ route('manager.reports') }}" class="card-manager p-4 hover:shadow-md transition cursor-pointer group flex items-center gap-3">
        <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-100 transition">
            <i class="ph ph-chart-bar text-emerald-600 text-lg"></i>
        </div>
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Laporan Detail</h3>
            <p class="text-xs text-gray-500">Filter transaksi</p>
        </div>
    </a>
    
    <a href="{{ route('manager.activity-log') }}" class="card-manager p-4 hover:shadow-md transition cursor-pointer group flex items-center gap-3">
        <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-amber-100 transition">
            <i class="ph ph-clock-history text-amber-600 text-lg"></i>
        </div>
        <div>
            <h3 class="text-sm font-semibold text-gray-900">Log Aktivitas</h3>
            <p class="text-xs text-gray-500">Pantau pegawai</p>
        </div>
    </a>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Data dari server
const weeklyData = {
    labels: {!! json_encode($weeklyData['labels'] ?? ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']) !!},
    data: {!! json_encode($weeklyData['data'] ?? [0, 0, 0, 0, 0, 0, 0]) !!}
};

const categoryData = {
    labels: {!! json_encode($categoryData['labels'] ?? ['Makanan', 'Minuman']) !!},
    data: {!! json_encode($categoryData['data'] ?? [0, 0]) !!}
};

const topMenuData = {
    labels: {!! json_encode($topMenuData['labels'] ?? ['Belum ada data']) !!},
    data: {!! json_encode($topMenuData['data'] ?? [0]) !!}
};

const hourlyData = {
    labels: {!! json_encode($hourlyData['labels'] ?? ['06', '08', '10', '12', '14', '16', '18', '20']) !!},
    data: {!! json_encode($hourlyData['data'] ?? [0, 0, 0, 0, 0, 0, 0, 0]) !!}
};

Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.font.size = 11;

// Weekly Chart
new Chart(document.getElementById('weeklyChart'), {
    type: 'bar',
    data: {
        labels: weeklyData.labels,
        datasets: [{
            label: 'Pendapatan',
            data: weeklyData.data,
            backgroundColor: 'rgba(59, 130, 246, 0.85)',
            borderRadius: 6,
            borderSkipped: false,
            barPercentage: 0.7,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: {
                beginAtZero: true,
                grid: { color: '#f1f5f9' },
                ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') }
            }
        }
    }
});

// Category Chart
new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: categoryData.labels,
        datasets: [{
            data: categoryData.data,
            backgroundColor: ['rgba(249, 115, 22, 0.85)', 'rgba(59, 130, 246, 0.85)'],
            borderWidth: 3,
            borderColor: '#ffffff',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 15, usePointStyle: true, pointStyleWidth: 8 }
            }
        }
    }
});

// Top Menu Chart
new Chart(document.getElementById('topMenuChart'), {
    type: 'bar',
    data: {
        labels: topMenuData.labels,
        datasets: [{
            label: 'Terjual',
            data: topMenuData.data,
            backgroundColor: 'rgba(245, 158, 11, 0.85)',
            borderRadius: 6,
            borderSkipped: false,
            barPercentage: 0.6,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
            y: { grid: { display: false } }
        }
    }
});

// Hourly Chart
new Chart(document.getElementById('hourlyChart'), {
    type: 'line',
    data: {
        labels: hourlyData.labels,
        datasets: [{
            data: hourlyData.data,
            borderColor: 'rgba(249, 115, 22, 1)',
            backgroundColor: 'rgba(249, 115, 22, 0.08)',
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            pointBackgroundColor: 'white',
            pointBorderColor: 'rgba(249, 115, 22, 1)',
            pointBorderWidth: 2,
            pointHoverRadius: 5,
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } }
        }
    }
});
</script>
@endsection