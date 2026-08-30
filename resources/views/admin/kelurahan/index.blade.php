@extends('layouts.admin')

@section('title', 'Data Kelurahan')
@section('page_title', 'Master Data Kelurahan')

@section('content')

@if(session('success'))
<div style="background: var(--color-teal); color: white; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="background: var(--color-orange); color: white; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
    <ul style="margin: 0; padding-left: 20px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="glass-card animate-fade-in delay-1">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="card-title" style="margin: 0;">Daftar Kelurahan</h2>
        <button class="btn btn-primary" onclick="document.getElementById('modalTambah').style.display='flex'">
            <i class="fa-solid fa-plus"></i> Tambah Kelurahan
        </button>
    </div>
    
    <div class="table-responsive" style="margin-top: 16px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                    <th style="padding: 12px; color: var(--color-text-muted);">No</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Nama Kelurahan</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Kecamatan</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Kode Pos</th>
                    <th style="padding: 12px; color: var(--color-text-muted); text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelurahans as $index => $kel)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px;">{{ $index + 1 }}</td>
                    <td style="padding: 12px; font-weight: 500;">{{ $kel->nama_kelurahan }}</td>
                    <td style="padding: 12px;">{{ $kel->kecamatan->nama_kecamatan ?? '-' }}</td>
                    <td style="padding: 12px;">{{ $kel->kode_pos ?? '-' }}</td>
                    <td style="padding: 12px; text-align: center;">
                        <button class="btn-icon edit" onclick="openEditModal({{ $kel->id }}, '{{ addslashes($kel->nama_kelurahan) }}', {{ $kel->kecamatan_id }}, '{{ addslashes($kel->kode_pos) }}')" title="Edit"><i class="fa-solid fa-pen"></i></button>
                        <form action="{{ route('kelurahan.destroy', $kel->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus kelurahan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon delete" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 24px; text-align: center; color: var(--color-text-muted);">Belum ada data kelurahan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: var(--color-white); width: 450px; border-radius: 12px; padding: 24px; box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; color: var(--color-text-dark);">Tambah Kelurahan</h3>
            <button onclick="document.getElementById('modalTambah').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--color-text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('kelurahan.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Kecamatan</label>
                <select name="kecamatan_id" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;">
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach($kecamatans as $kec)
                        <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Nama Kelurahan</label>
                <input type="text" name="nama_kelurahan" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Kode Pos (Opsional)</label>
                <input type="text" name="kode_pos" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('modalTambah').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: var(--color-white); width: 450px; border-radius: 12px; padding: 24px; box-shadow: var(--shadow-lg);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; color: var(--color-text-dark);">Edit Kelurahan</h3>
            <button onclick="document.getElementById('modalEdit').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--color-text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Kecamatan</label>
                <select id="edit_kecamatan_id" name="kecamatan_id" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;">
                    <option value="">-- Pilih Kecamatan --</option>
                    @foreach($kecamatans as $kec)
                        <option value="{{ $kec->id }}">{{ $kec->nama_kecamatan }}</option>
                    @endforeach
                </select>
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Nama Kelurahan</label>
                <input type="text" id="edit_nama_kelurahan" name="nama_kelurahan" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Kode Pos</label>
                <input type="text" id="edit_kode_pos" name="kode_pos" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;">
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('modalEdit').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nama, kecamatanId, kodePos) {
        document.getElementById('edit_nama_kelurahan').value = nama;
        document.getElementById('edit_kecamatan_id').value = kecamatanId;
        document.getElementById('edit_kode_pos').value = kodePos;
        document.getElementById('formEdit').action = `/admin/kelurahan/${id}`;
        document.getElementById('modalEdit').style.display = 'flex';
    }
</script>

@endsection
