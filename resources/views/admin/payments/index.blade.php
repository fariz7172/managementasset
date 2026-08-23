@extends('layouts.admin')

@section('title', 'Data Pembayaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Data Pembayaran</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar transaksi pembayaran terintegrasi API (Total: {{ $total_data ?? 0 }} Data).</p>
        </div>
        
        <!-- Search -->
        <div class="w-full md:w-72 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </div>
            <input type="text" id="searchInput" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 sm:text-sm transition-colors" placeholder="Cari SPM, Nama Perusahaan...">
        </div>
    </div>

    @if($error)
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-red-600 font-medium">
        {{ $error }}
    </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200" id="paymentsTable">
                <thead class="bg-slate-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">No SPM / SP2D</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Perusahaan</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Kegiatan</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Nilai (Rp)</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Progress</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($payments as $index => $item)
                        @php
                            $spm = $item['no_spm'] ?? '-';
                            $sp2d = $item['no_sp2d'] ?? '-';
                            $vendor = $item['vendor']['nama_perusahaan'] ?? '-';
                            $kegiatan = $item['keperluan'] ?? '-';
                            $nilai = $item['jumlah'] ?? 0;
                            $progress = $item['progres'] ?? '0%';
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors payment-row">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-slate-900">{{ $spm }}</div>
                                <div class="text-xs text-slate-500 mt-1">SP2D: {{ $sp2d }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-slate-900">{{ $vendor }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-slate-600 line-clamp-2 max-w-xs" title="{{ $kegiatan }}">{{ $kegiatan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-emerald-600">Rp {{ number_format($nilai, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $progress == '100%' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $progress }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button type="button" onclick="showDetail({{ $index }})" class="text-primary-600 hover:text-primary-900 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg transition-colors inline-flex items-center gap-1.5 font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    <p class="text-lg font-medium text-slate-900">Belum ada data pembayaran</p>
                                    <p class="text-sm mt-1">Data dari API tidak ditemukan atau kosong.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity" id="modalBackdrop"></div>

    <div class="fixed inset-0 z-10 overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">
                
                <!-- Modal Header -->
                <div class="bg-slate-50 px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-900" id="modal-title">Detail Pembayaran</h3>
                    <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-slate-500 focus:outline-none bg-white hover:bg-slate-100 rounded-lg p-1.5 transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-5">
                    <div id="modalContent" class="space-y-6">
                        <!-- Content injected via JS -->
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end">
                    <button type="button" onclick="closeModal()" class="inline-flex justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.payment-row');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if(text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Pass PHP data to JS
    const paymentsData = @json($payments->items());

    // Modal functionality
    const modal = document.getElementById('detailModal');
    const modalBackdrop = document.getElementById('modalBackdrop');
    
    function showDetail(index) {
        const data = paymentsData[index];
        const content = document.getElementById('modalContent');
        
        // Format rupiah
        const formatRp = (num) => {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);
        };
        
        // Format tanggal (basic)
        const formatTgl = (dateString) => {
            if(!dateString) return '-';
            const d = new Date(dateString);
            if(isNaN(d.getTime())) return dateString;
            return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
        };

        const vendor = data.vendor || {};
        const contract = data.contract || {};
        const pptk = data.pptk || {};
        
        content.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Info Pekerjaan -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 border-b pb-2">Informasi Pekerjaan</h4>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="block text-slate-500">Keperluan:</span>
                                <span class="font-semibold text-slate-900">${data.keperluan || '-'}</span>
                            </div>
                            <div>
                                <span class="block text-slate-500">Program:</span>
                                <span class="font-medium text-slate-800">${data.program || '-'}</span>
                            </div>
                            <div>
                                <span class="block text-slate-500">Progress Pekerjaan:</span>
                                <span class="font-bold text-emerald-600">${data.progres || '-'}</span>
                            </div>
                            <div>
                                <span class="block text-slate-500">Nilai Pembayaran:</span>
                                <span class="font-bold text-lg text-slate-900">${formatRp(data.jumlah)}</span>
                                <p class="text-xs text-slate-500 italic mt-0.5">${data.terbilang || ''}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Info Vendor & Kontrak -->
                <div class="space-y-4">
                    <div>
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 border-b pb-2">Data Vendor & Dokumen</h4>
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="block text-slate-500">Perusahaan:</span>
                                <span class="font-bold text-slate-900">${vendor.nama_perusahaan || '-'}</span>
                            </div>
                            <div>
                                <span class="block text-slate-500">Direktur:</span>
                                <span class="font-medium text-slate-800">${vendor.direktur || '-'}</span>
                            </div>
                            <div>
                                <span class="block text-slate-500">Rekening Bank:</span>
                                <span class="font-medium text-slate-800">${vendor.bank || '-'} - ${vendor.no_rekening || '-'}</span>
                            </div>
                            <div class="pt-2">
                                <span class="block text-slate-500">No. Kontrak (SPK):</span>
                                <span class="font-medium text-slate-800">${contract.nomor_kontrak || '-'}</span>
                            </div>
                            <div>
                                <span class="block text-slate-500">No. BAST:</span>
                                <span class="font-medium text-slate-800">${data.no_bast || '-'} <span class="text-slate-400">(${formatTgl(data.tgl_bast)})</span></span>
                            </div>
                            <div>
                                <span class="block text-slate-500">No. SPM:</span>
                                <span class="font-medium text-slate-800">${data.no_spm || '-'} <span class="text-slate-400">(${formatTgl(data.tgl_spm)})</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-wider mb-0.5">PPTK / Penanggung Jawab</p>
                    <p class="text-sm font-bold text-slate-900">${pptk.nama || data.pptk_id || '-'}</p>
                    <p class="text-xs text-slate-500">${pptk.jabatan || '-'}</p>
                </div>
            </div>
        `;
        
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    // Close modal on backdrop click
    modalBackdrop.addEventListener('click', closeModal);
</script>
@endpush
