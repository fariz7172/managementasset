@extends('layouts.admin')

@section('title', 'Data Pompa')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-display font-bold text-slate-900">Data Pompa</h1>
            <p class="text-slate-500 mt-1">Kelola data pompa, merk, dan lokasi operasional</p>
        </div>
        <div class="flex gap-3">
            <button type="button" onclick="document.getElementById('importModal').classList.remove('hidden')" class="inline-flex items-center justify-center px-4 py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-500/20 transition-all shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Import Excel
            </button>
            <a href="{{ route('admin.pompas.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 text-white rounded-xl font-medium hover:bg-primary-700 focus:ring-4 focus:ring-primary-500/20 transition-all shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Pompa
            </a>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-sm font-semibold text-slate-600 uppercase tracking-wider">
                        <th class="px-6 py-4">Nama Pompa</th>
                        <th class="px-6 py-4">Merk / Jenis</th>
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($pompas as $pompa)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-lg bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                                    @if(is_array($pompa->photo) && count($pompa->photo) > 0)
                                        <img src="{{ asset('storage/' . $pompa->photo[0]) }}" class="w-full h-full object-cover" alt="Pompa">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 group-hover:text-primary-600 transition-colors">{{ $pompa->nama ?: '-' }}</h3>
                                    <p class="text-xs text-slate-500 line-clamp-1" title="{{ $pompa->alamat }}">{{ Str::limit($pompa->alamat ?: 'Tidak ada alamat', 30) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-700">{{ $pompa->merk_pompa ?: '-' }}</div>
                            <div class="text-xs text-slate-500">{{ $pompa->jenis_pompa ?: '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-800">
                                {{ $pompa->tahun ?: '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($pompa->status == '1' || strtolower($pompa->status) == 'aktif')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                    Aktif
                                </span>
                            @elseif($pompa->status == '0' || strtolower($pompa->status) == 'rusak' || strtolower($pompa->status) == 'dalam perbaikan')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                    Perbaikan
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $pompa->status ?: 'Tidak diketahui' }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.pompas.edit', $pompa) }}" class="p-2 text-slate-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                
                                <form action="{{ route('admin.pompas.destroy', $pompa) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pompa ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <p class="text-base font-medium text-slate-900">Belum ada data Pompa</p>
                                <p class="mt-1 text-sm">Klik tombol "Tambah Pompa" untuk mulai menambahkan data.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($pompas->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $pompas->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" onclick="document.getElementById('importModal').classList.add('hidden')"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        <form action="{{ route('admin.pompas.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-6 border-b border-slate-100">
                <h3 class="text-xl font-bold text-slate-900">Import Data Pompa (Excel)</h3>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-sm text-slate-500">Unggah file Excel (.xlsx) dengan kolom yang sesuai untuk mengimport data secara otomatis.</p>
                
                <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 transition-colors">
                    <input type="file" name="file" id="excel_file" class="hidden" accept=".xlsx,.xls,.csv" required onchange="document.getElementById('file-name').textContent = this.files[0].name">
                    <label for="excel_file" class="cursor-pointer flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 mb-3">
                            <i class="fa-solid fa-file-excel text-xl"></i>
                        </div>
                        <span class="text-sm font-bold text-slate-700">Pilih File Excel</span>
                        <span id="file-name" class="text-xs font-medium text-slate-500 mt-1">.xlsx, .xls maksimal 5MB</span>
                    </label>
                </div>
            </div>
            <div class="p-6 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-5 py-2.5 rounded-xl text-slate-600 font-bold hover:bg-slate-200 transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl font-bold shadow-sm shadow-emerald-500/30 hover:bg-emerald-700 transition-all">
                    Mulai Import
                </button>
            </div>
        </form>
    </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('globalSearchInput');
    const tableRows = document.querySelectorAll('tbody tr');

    if (searchInput && tableRows.length > 0) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            
            tableRows.forEach(row => {
                // Skip the "empty data" row if it exists
                if (row.querySelector('td[colspan]')) return;
                
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endpush
