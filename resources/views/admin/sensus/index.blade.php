@extends('layouts.admin')

@section('title', 'Data Sensus')
@section('page_title', 'Master Data Sensus')

@section('content')
@if(session('success'))
<div style="background: rgba(36, 177, 177, 0.1); border-left: 4px solid var(--color-teal); padding: 16px; border-radius: 8px; margin-bottom: 24px; color: var(--color-teal);">
    {{ session('success') }}
</div>
@endif


<div class="glass-card animate-fade-in delay-1" style="max-width: 100%; overflow-x: hidden;">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 class="card-title" style="margin: 0;">Daftar Sensus</h2>
            <p style="font-size: 0.875rem; color: var(--color-text-muted); margin: 4px 0 0 0;">Arsip hasil pendataan sensus.</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('sensus.export-pdf', request()->all()) }}" class="btn btn-outline" style="color: #e3342f; border-color: #e3342f;">
                <i class="fa-solid fa-file-pdf"></i> Export PDF
            </a>
            <button type="button" class="btn btn-outline" onclick="document.getElementById('importModal').style.display='flex'">
                <i class="fa-solid fa-file-excel" style="color: #217346;"></i> Import Excel
            </button>
            <a href="{{ route('sensus.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Data Sensus
            </a>
        </div>
    </div>


    <div style="margin-top: 16px; padding: 16px; background: rgba(255, 255, 255, 0.03); border-radius: 8px; border: 1px solid var(--border-color);">
        <form action="{{ route('sensus.index') }}" method="GET" style="display: flex; gap: 12px; align-items: flex-end; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 200px;">
                <label for="search" style="display: block; margin-bottom: 8px; font-size: 0.875rem; color: var(--color-text-muted);">Pencarian</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Cari nama barang, kode..." class="form-input" style="width: 100%; padding: 10px; background: var(--color-bg); border: 1px solid var(--border-color); color: var(--color-text); border-radius: 6px;">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="kecamatan" style="display: block; margin-bottom: 8px; font-size: 0.875rem; color: var(--color-text-muted);">Filter Kecamatan</label>
                <select name="kecamatan" id="kecamatan" class="form-input" style="width: 100%; padding: 10px; background: var(--color-bg); border: 1px solid var(--border-color); color: var(--color-text); border-radius: 6px;">
                    <option value="">-- Semua Kecamatan --</option>
                    @foreach($kecamatans as $kec)
                        <option value="{{ $kec }}" {{ request('kecamatan') == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                    @endforeach
                </select>
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label for="status_pelaksanaan" style="display: block; margin-bottom: 8px; font-size: 0.875rem; color: var(--color-text-muted);">Status Pelaksanaan</label>
                <select name="status_pelaksanaan" id="status_pelaksanaan" class="form-input" style="width: 100%; padding: 10px; background: var(--color-bg); border: 1px solid var(--border-color); color: var(--color-text); border-radius: 6px;">
                    <option value="">-- Semua Status --</option>
                    @foreach($statusPelaksanaans as $status)
                        <option value="{{ $status }}" {{ request('status_pelaksanaan') == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="padding: 10px 20px;">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
                @if(request('kecamatan') || request('search'))
                    <a href="{{ route('sensus.index') }}" class="btn btn-outline" style="padding: 10px 20px;">
                        <i class="fa-solid fa-times"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-responsive" style="margin-top: 16px; overflow-x: auto; -webkit-overflow-scrolling: touch; width: 100%;">
        <table style="width: 100%; border-collapse: collapse; min-width: 1000px;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                    <th style="padding: 12px; color: var(--color-text-muted);">Foto</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Nama & Kode Barang</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Wilayah</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Tanggal Perolehan</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Harga</th>
                    <th style="padding: 12px; color: var(--color-text-muted); text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sensuses as $sensus)
                <tr style="border-bottom: 1px solid var(--border-color); transition: all 0.2s;">
                    <td style="padding: 12px; vertical-align: top;">
                        @if($sensus->url_foto_pendataan && is_array($sensus->url_foto_pendataan) && count($sensus->url_foto_pendataan) > 0)
                            <div style="width: 60px; height: 60px; border-radius: 8px; overflow: hidden; border: 1px solid var(--border-color); position: relative; cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" onclick="openImageModal('{{ Str::startsWith($sensus->url_foto_pendataan[0], ['http://', 'https://']) ? $sensus->url_foto_pendataan[0] : asset('storage/' . $sensus->url_foto_pendataan[0]) }}')">
                                <img src="{{ Str::startsWith($sensus->url_foto_pendataan[0], ['http://', 'https://']) ? $sensus->url_foto_pendataan[0] : asset('storage/' . $sensus->url_foto_pendataan[0]) }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                @if(count($sensus->url_foto_pendataan) > 1)
                                    <div style="position: absolute; bottom: 0; right: 0; background: rgba(0,0,0,0.6); color: white; font-size: 0.6rem; padding: 2px 4px; border-top-left-radius: 4px; font-weight: bold;">
                                        +{{ count($sensus->url_foto_pendataan) - 1 }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div style="width: 60px; height: 60px; border-radius: 8px; background: var(--color-bg); display: flex; align-items: center; justify-content: center; color: var(--color-text-muted); border: 1px dashed var(--border-color);">
                                <i class="fa-regular fa-image"></i>
                            </div>
                        @endif
                    </td>
                    <td style="padding: 12px; vertical-align: top;">
                        <div style="font-weight: 600; color: var(--color-text-dark);">{{ $sensus->nama_barang ?? '-' }}</div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted); margin-top: 4px;">
                            <i class="fa-solid fa-barcode" style="width: 16px;"></i> {{ $sensus->kode_barang ?? '-' }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted);">
                            <i class="fa-solid fa-hashtag" style="width: 16px;"></i> Reg: {{ $sensus->nomor_register ?? '-' }}
                        </div>
                    </td>
                    <td style="padding: 12px; vertical-align: top;">
                        <div style="font-weight: 500; color: var(--color-text-dark);">
                            {{ $sensus->kelurahan ?? '-' }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--color-text-muted); margin-top: 4px;">
                            {{ $sensus->kecamatan ?? '-' }}
                        </div>
                    </td>
                    <td style="padding: 12px; vertical-align: top;">
                        {{ $sensus->tanggal_perolehan ? \Carbon\Carbon::parse($sensus->tanggal_perolehan)->format('d M Y') : '-' }}
                    </td>
                    <td style="padding: 12px; vertical-align: top; font-weight: 600;">
                        {{ $sensus->harga ? 'Rp ' . number_format($sensus->harga, 0, ',', '.') : '-' }}
                    </td>
                    <td style="padding: 12px; vertical-align: top; text-align: center; white-space: nowrap;">
                        <button type="button" onclick="openDetailModal('{{ route('sensus.show', $sensus->id) }}')" class="btn-icon" style="background: rgba(36, 177, 177, 0.1); color: var(--color-teal); border: none; cursor: pointer;" title="Detail">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <a href="{{ route('sensus.edit', $sensus->id) }}" class="btn-icon edit" title="Edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        <form action="{{ route('sensus.destroy', $sensus->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon delete" title="Hapus">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 32px; text-align: center; color: var(--color-text-muted);">
                        <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 12px; color: var(--border-color);"></i>
                        <p>Belum ada data sensus.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $sensuses->links('pagination::bootstrap-4') }}
    </div>
</div>

<!-- Modal Import -->
<div id="importModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: var(--color-bg); padding: 24px; border-radius: 12px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px;">
            <h3 style="margin: 0; font-size: 1.1rem;">Import Data Sensus</h3>
            <button type="button" onclick="document.getElementById('importModal').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--color-text-muted);">&times;</button>
        </div>
        
        @if ($errors->any())
            <div style="background: rgba(227, 116, 52, 0.1); border-left: 4px solid var(--color-orange); padding: 12px; border-radius: 6px; margin-bottom: 16px; color: var(--color-orange); font-size: 0.85rem;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('sensus.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="margin-bottom: 16px;">
                <label class="form-label">Pilih File Excel (.xlsx)</label>
                <input type="file" name="file_excel" class="form-control" accept=".xlsx, .xls" required>
                <small style="color: var(--color-text-muted); display: block; margin-top: 6px;">Format yang didukung: XLSX, XLS. Maksimal 50MB.</small>
            </div>
            
            <div style="text-align: right; margin-top: 24px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('importModal').style.display='none'" style="margin-right: 8px;">Batal</button>
                <button type="submit" class="btn btn-primary" onclick="this.innerHTML='<i class=\'fa-solid fa-spinner fa-spin\'></i> Mengimpor...'; this.style.pointerEvents='none'; this.form.submit();">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Upload & Import
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: var(--color-bg); border-radius: 12px; width: 85%; height: 85%; box-shadow: 0 15px 30px rgba(0,0,0,0.3); position: relative; display: flex; flex-direction: column; overflow: hidden; border: 1px solid var(--border-color);">
        <div style="display: flex; justify-content: space-between; align-items: center; background: var(--color-bg); padding: 16px 24px; border-bottom: 1px solid var(--border-color);">
            <h3 style="margin: 0; font-size: 1.1rem; color: var(--color-teal);"><i class="fa-solid fa-circle-info"></i> Rincian Data Sensus</h3>
            <button type="button" onclick="closeDetailModal()" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; color: var(--color-text-muted); transition: 0.2s;">&times;</button>
        </div>
        <div style="flex: 1; position: relative;">
            <div id="detailLoading" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: flex; flex-direction: column; align-items: center; color: var(--color-teal);">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 2rem; margin-bottom: 12px;"></i>
                <span>Memuat Data...</span>
            </div>
            <iframe id="detailIframe" src="" style="width: 100%; height: 100%; border: none; opacity: 0; transition: opacity 0.3s;" onload="this.style.opacity=1; document.getElementById('detailLoading').style.display='none';"></iframe>
        </div>
    </div>
</div>

<!-- Modal Photo -->
<div id="photoModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); z-index: 1050; align-items: center; justify-content: center; backdrop-filter: blur(5px);" onclick="closeImageModal()">
    <button type="button" onclick="closeImageModal()" style="position: absolute; top: 24px; right: 32px; background: none; border: none; font-size: 2rem; color: white; cursor: pointer; transition: 0.2s;">&times;</button>
    <img id="photoModalImg" src="" style="max-width: 90%; max-height: 90%; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); object-fit: contain; cursor: zoom-out;" alt="Preview Foto">
</div>

<script>
    // Tampilkan modal secara otomatis jika ada error validasi import
    @if ($errors->has('file_excel'))
        document.getElementById('importModal').style.display = 'flex';
    @endif

    function openImageModal(url) {
        document.getElementById('photoModalImg').src = url;
        document.getElementById('photoModal').style.display = 'flex';
    }

    function closeImageModal() {
        document.getElementById('photoModal').style.display = 'none';
        document.getElementById('photoModalImg').src = '';
    }

    function openDetailModal(url) {

        const modal = document.getElementById('detailModal');
        const iframe = document.getElementById('detailIframe');
        const loading = document.getElementById('detailLoading');
        
        iframe.style.opacity = 0;
        loading.style.display = 'flex';
        
        // Tambahkan query parameter ?modal=1 agar tidak me-load sidebar
        iframe.src = url + (url.includes('?') ? '&' : '?') + 'modal=1';
        modal.style.display = 'flex';
    }

    function closeDetailModal() {
        document.getElementById('detailModal').style.display = 'none';
        document.getElementById('detailIframe').src = '';
    }
</script>
@endsection
