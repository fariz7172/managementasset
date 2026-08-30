@extends('layouts.admin')

@section('title', 'Data Pembayaran')
@section('page_title', 'Data Pembayaran')

@section('content')

@if(session('success'))
<div style="background: var(--color-teal); color: white; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; z-index: 9999;">
    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- Header Data Management -->
<div class="animate-fade-in delay-1" style="margin-bottom: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 20px;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--color-text-dark); margin-bottom: 4px;">Arsip Pembayaran</h2>
            <p style="color: var(--color-text-muted); font-size: 0.9rem; margin: 0;">Mengelola data sinkronisasi pembayaran SPP/SPM dari sistem eksternal.</p>
        </div>
        <div>
            <button id="btnFetchApi" class="btn btn-primary" style="padding: 10px 20px; border-radius: 8px;">
                <i class="fa-solid fa-cloud-arrow-down"></i> Sinkronisasi API
            </button>
        </div>
    </div>
    
    <div style="display: flex; justify-content: flex-end; gap: 12px; align-items: center; margin-top: 20px;">
        <div style="position: relative;">
            <select id="perPageSelect" style="padding: 10px 12px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--color-white); outline: none; font-family: inherit; font-size: 0.875rem; cursor: pointer; color: var(--color-text-dark);">
                <option value="5">5 baris</option>
                <option value="10">10 baris</option>
                <option value="50">50 baris</option>
                <option value="100">100 baris</option>
            </select>
        </div>
        <div style="position: relative;">
            <i class="fa-solid fa-search" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--color-text-muted);"></i>
            <input type="text" id="searchInput" placeholder="Cari SPP / vendor / kontrak..." style="padding: 10px 16px 10px 40px; border-radius: 8px; border: 1px solid var(--border-color); background: var(--color-white); outline: none; font-family: inherit; font-size: 0.875rem; width: 250px; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--color-teal)'" onblur="this.style.borderColor='var(--border-color)'">
        </div>
    </div>
</div>

<!-- Kontainer Hasil API dengan Accordion -->
<div id="apiResultContainer" class="animate-fade-in delay-2" style="display: none; flex-direction: column; gap: 16px;">
    <!-- Data akan dimasukkan ke sini melalui JavaScript -->
</div>

<!-- Pagination Container -->
<div id="paginationContainer" class="animate-fade-in delay-3" style="display: none; justify-content: space-between; align-items: center; margin-top: 24px; padding: 16px 24px; background: var(--color-white); border-radius: 12px; box-shadow: var(--shadow-sm); border: 1px solid var(--border-color);">
    <span id="pageInfoText" style="font-size: 0.875rem; color: var(--color-text-muted); font-weight: 500;">Menampilkan data</span>
    <div style="display: flex; gap: 8px;" id="paginationButtons">
        <!-- Tombol pagination -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnFetchApi = document.getElementById('btnFetchApi');
    const resultContainer = document.getElementById('apiResultContainer');
    const paginationContainer = document.getElementById('paginationContainer');
    const paginationButtons = document.getElementById('paginationButtons');
    const pageInfoText = document.getElementById('pageInfoText');
    const searchInput = document.getElementById('searchInput');
    
    let groupedDataArray = [];
    let allRawData = [];
    let currentPage = 1;
    let itemsPerPage = 5; // dinamis
    
    // Inisialisasi data yang sudah ada di database saat load awal
    const existingDbData = @json($dbPayments ?? []);
    if (existingDbData && existingDbData.length > 0) {
        allRawData = existingDbData;
        processAndRenderData(allRawData);
    } else {
        resultContainer.style.display = 'flex';
        resultContainer.innerHTML = `
            <div style="background: var(--color-white); padding: 48px; border-radius: 16px; text-align: center; border: 1px dashed var(--border-color); box-shadow: var(--shadow-sm);">
                <div style="font-size: 3rem; color: var(--color-text-muted); margin-bottom: 16px; opacity: 0.5;"><i class="fa-solid fa-folder-open"></i></div>
                <h3 style="font-size: 1.1rem; color: var(--color-text-dark); margin-bottom: 8px;">Belum ada data pembayaran</h3>
                <p style="color: var(--color-text-muted); font-size: 0.9rem;">Silakan klik tombol "Sinkronisasi API" di atas untuk menarik data terbaru.</p>
            </div>
        `;
    }
    
    function processAndRenderData(rawData) {
        const groupedObj = {};
        rawData.forEach(item => {
            const parsedItem = typeof item === 'string' ? JSON.parse(item) : item;
            const key = parsedItem.no_spp || 'Tanpa SPP';
            if (!groupedObj[key]) {
                groupedObj[key] = [];
            }
            groupedObj[key].push(parsedItem);
        });
        
        groupedDataArray = Object.keys(groupedObj).map(key => {
            return {
                no_spp: key,
                no_spm: groupedObj[key][0].no_spm || '-',
                items: groupedObj[key]
            };
        });
        
        currentPage = 1;
        resultContainer.style.display = 'flex';
        renderPage(currentPage);
    }

    const perPageSelect = document.getElementById('perPageSelect');
    if(perPageSelect) {
        perPageSelect.addEventListener('change', function(e) {
            itemsPerPage = parseInt(e.target.value);
            currentPage = 1; // reset ke halaman 1
            const currentSearch = searchInput.value;
            if (currentSearch) {
                searchInput.dispatchEvent(new Event('input'));
            } else {
                processAndRenderData(allRawData);
            }
        });
    }

    // Fungsi Pencarian
    searchInput.addEventListener('input', function(e) {
        const q = e.target.value.toLowerCase().trim();
        if (!q) {
            processAndRenderData(allRawData);
            return;
        }
        
        const filtered = allRawData.filter(item => {
            const parsed = typeof item === 'string' ? JSON.parse(item) : item;
            const spm = (parsed.no_spm || '').toLowerCase();
            const bast = (parsed.no_bast || '').toLowerCase();
            const spp = (parsed.no_spp || '').toLowerCase();
            const vendor = parsed.vendor && parsed.vendor.nama_perusahaan ? parsed.vendor.nama_perusahaan.toLowerCase() : '';
            const contract = parsed.contract && parsed.contract.nomor_kontrak ? parsed.contract.nomor_kontrak.toLowerCase() : '';
            
            return spm.includes(q) || bast.includes(q) || vendor.includes(q) || contract.includes(q) || spp.includes(q);
        });
        
        if (filtered.length === 0) {
            resultContainer.style.display = 'block';
            paginationContainer.style.display = 'none';
            resultContainer.innerHTML = '<div style="color: var(--color-text-muted); padding: 32px; text-align: center; font-weight: 500; font-size: 1.1rem;"><i class="fa-solid fa-search" style="margin-bottom: 12px; font-size: 2rem; display: block; opacity: 0.3;"></i>Data tidak ditemukan.</div>';
        } else {
            processAndRenderData(filtered);
        }
    });
    
    function renderPage(page) {
        if (!groupedDataArray || groupedDataArray.length === 0) return;
        
        resultContainer.innerHTML = '';
        
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedData = groupedDataArray.slice(startIndex, endIndex);
        
        const processedIds = @json($processedPaymentIds ?? []);

        paginatedData.forEach(group => {
            let itemsHtml = '';
            let groupIsProcessed = false;
            
            group.items.forEach((item, index) => {
                const isProcessed = processedIds.includes(String(item.id)) || processedIds.includes(Number(item.id));
                if (isProcessed) groupIsProcessed = true;
                const badgeHtml = isProcessed 
                    ? `<span style="background: rgba(36, 177, 177, 0.1); color: var(--color-teal); padding: 2px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 600; margin-left: 10px; border: 1px solid rgba(36, 177, 177, 0.2);"><i class="fa-solid fa-check"></i> Asset</span>`
                    : '';
                const btnHtml = isProcessed
                    ? `<button class="btn" style="padding: 8px 16px; border-radius: 8px; background: #f3f4f6; color: #9ca3af; border: 1px solid #e5e7eb; cursor: not-allowed;" disabled><i class="fa-solid fa-check-circle"></i> Sudah Diproses</button>`
                    : `<button class="btn btn-primary" style="padding: 8px 16px; border-radius: 8px;" onclick="openAssetModal('${item.id}', '${item.jumlah}')"><i class="fa-solid fa-share-from-square"></i> Proses ke Asset</button>`;
                
                const formatRupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(item.jumlah);
                const vendor = item.vendor || {};
                const contract = item.contract || {};
                
                const borderTop = index > 0 ? 'border-top: 1px dashed var(--border-color); padding-top: 24px; margin-top: 24px;' : '';
                
                itemsHtml += `
                    <div style="${borderTop}">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
                            <div style="background: var(--color-bg); padding: 12px 16px; border-radius: 8px; border-left: 3px solid var(--color-teal);">
                                <small style="color: var(--color-text-muted); text-transform: uppercase; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">No SPD</small>
                                <div style="font-size: 0.9rem; font-weight: 600; color: var(--color-text-dark); margin-top: 4px; display: flex; align-items: center;">
                                    ${item.no_spd || '-'} ${badgeHtml}
                                </div>
                            </div>
                            <div style="background: var(--color-bg); padding: 12px 16px; border-radius: 8px; border-left: 3px solid var(--color-orange);">
                                <small style="color: var(--color-text-muted); text-transform: uppercase; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">Kode Rekening</small>
                                <div style="font-size: 0.9rem; font-weight: 600; color: var(--color-text-dark); margin-top: 4px;">${item.kode_rek || '-'}</div>
                            </div>
                            <div style="background: var(--color-bg); padding: 12px 16px; border-radius: 8px; border-left: 3px solid var(--color-teal);">
                                <small style="color: var(--color-text-muted); text-transform: uppercase; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">No BAST</small>
                                <div style="font-size: 0.9rem; font-weight: 600; color: var(--color-text-dark); margin-top: 4px;">${item.no_bast || '-'}</div>
                            </div>
                            <div style="background: rgba(36, 177, 177, 0.05); padding: 12px 16px; border-radius: 8px; border: 1px solid rgba(36, 177, 177, 0.2);">
                                <small style="color: var(--color-teal); text-transform: uppercase; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">Nilai Pembayaran</small>
                                <div style="color: var(--color-teal); font-size: 1.25rem; font-weight: 700; margin-top: 4px;">${formatRupiah}</div>
                                <div style="font-size: 0.7rem; font-style: italic; color: var(--color-text-muted); margin-top: 4px;">${item.terbilang || '-'}</div>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 24px;">
                            <small style="color: var(--color-text-muted); text-transform: uppercase; font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px; display: block; margin-bottom: 8px;">Uraian / Keperluan</small>
                            <p style="font-size: 0.95rem; font-weight: 500; color: var(--color-text-dark); line-height: 1.6; margin: 0;">${item.keperluan || '-'}</p>
                        </div>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px;">
                            <div style="background: var(--color-white); padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(227, 116, 52, 0.1); color: var(--color-orange); display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-building"></i></div>
                                    <h4 style="font-size: 1rem; font-weight: 600; color: var(--color-text-dark); margin: 0;">Informasi Rekanan / Vendor</h4>
                                </div>
                                <div style="display: grid; grid-template-columns: 100px 1fr; gap: 8px; font-size: 0.85rem; color: var(--color-text-dark);">
                                    <span style="color: var(--color-text-muted);">Nama</span> <strong style="font-weight: 600;">${vendor.nama_perusahaan || '-'}</strong>
                                    <span style="color: var(--color-text-muted);">Direktur</span> <strong>${vendor.direktur || '-'}</strong>
                                    <span style="color: var(--color-text-muted);">NPWP</span> <strong>${vendor.npwp || '-'}</strong>
                                    <span style="color: var(--color-text-muted);">Akte</span> <strong>${vendor.akte || '-'} (${vendor.tgl_akte || '-'})</strong>
                                    <span style="color: var(--color-text-muted);">TDP</span> <strong>${vendor.tdp || '-'} (${vendor.tgl_tdp || '-'})</strong>
                                </div>
                            </div>
                            
                            <div style="background: var(--color-white); padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 1px solid var(--border-color);">
                                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(36, 177, 177, 0.1); color: var(--color-teal); display: flex; align-items: center; justify-content: center;"><i class="fa-solid fa-file-signature"></i></div>
                                    <h4 style="font-size: 1rem; font-weight: 600; color: var(--color-text-dark); margin: 0;">Informasi Kontrak</h4>
                                </div>
                                <div style="display: grid; grid-template-columns: 100px 1fr; gap: 8px; font-size: 0.85rem; color: var(--color-text-dark);">
                                    <span style="color: var(--color-text-muted);">Nomor Kontrak</span> <strong style="font-weight: 600;">${contract.nomor_kontrak || '-'}</strong>
                                    <span style="color: var(--color-text-muted);">Tgl Kontrak</span> <strong>${contract.tgl_kontrak ? new Date(contract.tgl_kontrak).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-'}</strong>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 20px; text-align: right;">
                            ${btnHtml}
                        </div>
                    </div>
                `;
            });
            
            // Accordion modern style
            const headerBadge = groupIsProcessed 
                ? `<span style="background: rgba(36, 177, 177, 0.1); color: var(--color-teal); padding: 2px 8px; border-radius: 12px; font-size: 0.7rem; font-weight: 600; margin-left: 10px; border: 1px solid rgba(36, 177, 177, 0.2);"><i class="fa-solid fa-check"></i> Asset</span>`
                : '';

            const accordionHtml = `
                <div class="accordion-item" style="border: 1px solid var(--border-color); border-radius: 12px; background: var(--color-white); overflow: hidden; transition: box-shadow 0.3s;" onmouseover="this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.boxShadow='none'">
                    <div class="accordion-header" style="padding: 20px 24px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; background: var(--color-white); border-bottom: 1px solid transparent;" onclick="const body = this.nextElementSibling; const icon = this.querySelector('.fa-chevron-down'); const header = this; if (body.style.display === 'none') { body.style.display = 'block'; icon.style.transform = 'rotate(180deg)'; header.style.borderBottom = '1px solid var(--border-color)'; header.style.background = 'rgba(248,249,250,0.5)'; } else { body.style.display = 'none'; icon.style.transform = 'rotate(0deg)'; header.style.borderBottom = '1px solid transparent'; header.style.background = 'var(--color-white)'; }">
                        <div style="display: flex; gap: 16px; align-items: center;">
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: rgba(36, 177, 177, 0.1); color: var(--color-teal); display: flex; align-items: center; justify-content: center; font-size: 1.25rem;">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <div>
                                <h4 style="margin: 0; color: var(--color-text-dark); font-size: 1.1rem; font-weight: 600; margin-bottom: 4px; display: flex; align-items: center;">${group.no_spp} ${headerBadge}</h4>
                                <div style="display: flex; gap: 12px; align-items: center; font-size: 0.8rem;">
                                    <span style="color: var(--color-text-muted);">SPM: <span style="color: var(--color-text-dark); font-weight: 500;">${group.no_spm}</span></span>
                                    <span style="display: inline-block; width: 4px; height: 4px; border-radius: 50%; background: var(--border-color);"></span>
                                    <span style="background: rgba(227, 116, 52, 0.1); color: var(--color-orange); padding: 2px 8px; border-radius: 12px; font-weight: 600; font-size: 0.7rem;">${group.items.length} Data</span>
                                </div>
                            </div>
                        </div>
                        <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--color-bg); display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-chevron-down" style="transition: transform 0.3s; color: var(--color-text-muted); font-size: 0.9rem;"></i>
                        </div>
                    </div>
                    <div class="accordion-body" style="display: none; padding: 24px; background: rgba(248,249,250,0.3);">
                        ${itemsHtml}
                    </div>
                </div>
            `;
            
            resultContainer.insertAdjacentHTML('beforeend', accordionHtml);
        });
        
        renderPagination();
    }

    const allKelurahans = @json($kelurahans ?? []);
    
    window.updateKelurahan = function() {
        const kecId = document.getElementById('select_kecamatan').value;
        const kelSelect = document.getElementById('select_kelurahan');
        kelSelect.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
        if (kecId) {
            const filtered = allKelurahans.filter(k => k.kecamatan_id == kecId);
            filtered.forEach(k => {
                kelSelect.innerHTML += `<option value="${k.id}">${k.nama_kelurahan}</option>`;
            });
        }
    };
    
    window.openAssetModal = function(paymentId, biaya) {
        document.getElementById('asset_api_payment_id').value = paymentId || '';
        document.getElementById('asset_biaya').value = biaya || 0;
        
        // Cari data item berdasarkan ID
        const item = allRawData.find(x => {
            const parsed = typeof x === 'string' ? JSON.parse(x) : x;
            return String(parsed.id) === String(paymentId);
        });
        
        if (item) {
            const parsedItem = typeof item === 'string' ? JSON.parse(item) : item;
            
            // Isi field permintaan
            document.querySelector('textarea[name="permintaan"]').value = parsedItem.keperluan || '';
            
            // Isi field tanggal_reses
            let tgl = '';
            if (parsedItem.contract && parsedItem.contract.tgl_kontrak) {
                tgl = parsedItem.contract.tgl_kontrak.split('T')[0];
            } else if (parsedItem.contract_tgl) {
                tgl = parsedItem.contract_tgl.split(' ')[0];
            }
            document.querySelector('input[name="tanggal_reses"]').value = tgl;
            
            // Isi field lokasi (karena parsedItem adalah raw_data itu sendiri)
            let lokasiStr = '';
            if (parsedItem.vendor && parsedItem.vendor.alamat) {
                lokasiStr = parsedItem.vendor.alamat;
            } else if (parsedItem.alamat) {
                lokasiStr = parsedItem.alamat;
            }
            document.querySelector('textarea[name="lokasi"]').value = lokasiStr;
        }

        document.getElementById('modalProsesAsset').style.display = 'flex';
    };
    
    function renderPagination() {
        paginationButtons.innerHTML = '';
        const totalPages = Math.ceil(groupedDataArray.length / itemsPerPage);
        
        paginationContainer.style.display = 'flex';
        
        if (totalPages < 1) {
            paginationContainer.style.display = 'none';
            return;
        }
        
        const startIndex = (currentPage - 1) * itemsPerPage + 1;
        const endIndex = Math.min(currentPage * itemsPerPage, groupedDataArray.length);
        pageInfoText.innerHTML = `Menampilkan <strong style="color: var(--color-text-dark);">${startIndex}-${endIndex}</strong> dari <strong style="color: var(--color-text-dark);">${groupedDataArray.length}</strong> Arsip SPP`;
        
        // Prev button
        const prevBtn = document.createElement('button');
        prevBtn.className = 'btn btn-outline';
        prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left"></i>';
        prevBtn.disabled = currentPage === 1;
        prevBtn.style.padding = '8px 12px';
        prevBtn.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                renderPage(currentPage);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        };
        paginationButtons.appendChild(prevBtn);
        
        // Page numbers
        let startPage = Math.max(1, currentPage - 1);
        let endPage = Math.min(totalPages, startPage + 2);
        if (endPage - startPage < 2) {
            startPage = Math.max(1, endPage - 2);
        }
        
        for (let i = startPage; i <= endPage; i++) {
            const numBtn = document.createElement('button');
            if (i === currentPage) {
                numBtn.className = 'btn btn-primary';
            } else {
                numBtn.className = 'btn btn-outline';
            }
            numBtn.textContent = i;
            numBtn.style.padding = '8px 14px';
            numBtn.style.minWidth = '40px';
            numBtn.onclick = () => {
                if (currentPage !== i) {
                    currentPage = i;
                    renderPage(currentPage);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            };
            paginationButtons.appendChild(numBtn);
        }
        
        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.className = 'btn btn-outline';
        nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.style.padding = '8px 12px';
        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                renderPage(currentPage);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        };
        paginationButtons.appendChild(nextBtn);
    }
    
    btnFetchApi.addEventListener('click', async function() {
        btnFetchApi.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
        btnFetchApi.disabled = true;
        
        try {
            const response = await fetch('https://aplikasimailingsudin.farizahmad.com/api/payments?target_kode_rek=true');
            const result = await response.json();
            
            if (result.status === 'success' && result.data && result.data.length > 0) {
                
                // Simpan ke database lokal via AJAX
                try {
                    const syncResponse = await fetch('/admin/api-payments/sync', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ payments: result.data })
                    });
                    const syncResult = await syncResponse.json();
                    if (syncResponse.ok) {
                        const toast = document.createElement('div');
                        toast.innerHTML = `<div style="position: fixed; bottom: 30px; right: 30px; background: var(--color-teal); color: white; padding: 16px 24px; border-radius: 12px; box-shadow: var(--shadow-lg); z-index: 1000; font-weight: 600; display: flex; align-items: center; gap: 12px; font-size: 0.95rem; animation: fadeIn 0.3s ease-out;"><i class="fa-solid fa-check-circle" style="font-size: 1.2rem;"></i> ${syncResult.message}</div>`;
                        document.body.appendChild(toast);
                        setTimeout(() => {
                            toast.style.opacity = '0';
                            toast.style.transition = 'opacity 0.4s';
                            setTimeout(() => toast.remove(), 400);
                        }, 4000);
                    }
                } catch (syncErr) {
                    console.error('Gagal sinkronisasi data ke database lokal:', syncErr);
                }

                // Gabungkan data API baru dengan data DB lokal agar pagination tidak hilang (karena API mungkin hanya mengembalikan data baru/sebagian)
                const allMap = new Map();
                allRawData.forEach(item => {
                   const parsed = typeof item === 'string' ? JSON.parse(item) : item;
                   allMap.set(parsed.id, parsed);
                });
                result.data.forEach(item => {
                   allMap.set(item.id, item);
                });
                allRawData = Array.from(allMap.values());
                
                // Jika sedang mencari sesuatu, jangan hapus pencariannya
                const currentSearch = searchInput.value;
                if (currentSearch) {
                    searchInput.dispatchEvent(new Event('input'));
                } else {
                    processAndRenderData(allRawData);
                }
                
            } else {
                resultContainer.style.display = 'block';
                paginationContainer.style.display = 'none';
                resultContainer.innerHTML = '<div style="color: var(--color-orange); padding: 16px; text-align: center; font-weight: 500;">Gagal mengambil data atau data kosong.</div>';
            }
        } catch (error) {
            resultContainer.style.display = 'block';
            paginationContainer.style.display = 'none';
            resultContainer.innerHTML = '<div style="color: red; padding: 16px; text-align: center; font-weight: 500;">Terjadi kesalahan koneksi API.</div>';
            console.error(error);
        } finally {
            btnFetchApi.innerHTML = '<i class="fa-solid fa-cloud-arrow-down"></i> Sinkronisasi API';
            btnFetchApi.disabled = false;
        }
    });
});
</script>

<!-- Modal Proses Asset -->
<div id="modalProsesAsset" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: var(--color-white); width: 650px; max-height: 90vh; overflow-y: auto; border-radius: 12px; padding: 24px; box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; position: sticky; top: -24px; background: var(--color-white); z-index: 10; padding-top: 24px; padding-bottom: 10px; border-bottom: 1px solid var(--border-color); margin-top: -24px;">
            <h3 style="margin: 0; color: var(--color-text-dark);">Proses Data ke Asset</h3>
            <button onclick="document.getElementById('modalProsesAsset').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--color-text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="api_payment_id" id="asset_api_payment_id">
            <input type="hidden" name="biaya" id="asset_biaya">
            
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Tanggal Reses</label>
                <input type="date" name="tanggal_reses" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Kecamatan</label>
                    <select id="select_kecamatan" name="kecamatan_id" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;" onchange="updateKelurahan()">
                        <option value="">-- Pilih Kecamatan --</option>
                        @foreach($kecamatans as $kec)
                            <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Kelurahan</label>
                    <select id="select_kelurahan" name="kelurahan_id" required style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
                        <option value="">-- Pilih Kelurahan --</option>
                        <!-- Diisi via JS -->
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Lokasi</label>
                <textarea name="lokasi" rows="2" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Latitude</label>
                    <input type="text" name="latitude" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Longitude</label>
                    <input type="text" name="longtitude" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Permintaan / Usulan</label>
                <textarea name="permintaan" rows="2" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 10px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Panjang (m)</label>
                    <input type="number" step="0.01" name="panjang" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Lebar (m)</label>
                    <input type="number" step="0.01" name="lebar" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Tinggi (m)</label>
                    <input type="number" step="0.01" name="tinggi" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Volume</label>
                    <input type="number" step="0.01" name="volume" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Status</label>
                    <select name="status" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
                        <option value="Selesai">Selesai</option>
                        <option value="Proses">Proses</option>
                        <option value="Tertunda">Tertunda</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Upload Foto (Otomatis WebP)</label>
                    <input type="file" name="foto" accept="image/*" style="width: 100%; padding: 8px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;">
                </div>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Keterangan</label>
                <textarea name="keterangan" rows="2" style="width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; font-family: inherit;"></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('modalProsesAsset').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Simpan ke Asset</button>
            </div>
        </form>
    </div>
</div>

@endsection
