@extends('layouts.cafe')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="cafe-card p-6">
    <h2 class="text-2xl font-bold text-amber-900 mb-6">📊 Filter Laporan Transaksi</h2>
    
    <form action="{{ route('manager.reports.filter') }}" method="POST" class="space-y-4">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-amber-900 font-medium mb-2">👤 Kasir</label>
                <select name="user_id" class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
                    <option value="">Semua Kasir</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-amber-900 font-medium mb-2">📅 Dari Tanggal</label>
                <input type="date" name="date_from" 
                       class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
            </div>
            
            <div>
                <label class="block text-amber-900 font-medium mb-2">📅 Sampai Tanggal</label>
                <input type="date" name="date_to" 
                       class="w-full border-2 border-amber-200 rounded-xl px-4 py-2">
            </div>
        </div>
        
        <button type="submit" class="cafe-button w-full md:w-auto">
            🔍 Tampilkan Laporan
        </button>
    </form>
</div>
@endsection