@extends('layouts.admin')

@section('title', 'Data Dewan')
@section('page_title', 'Master Data Dewan')

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
        <h2 class="card-title" style="margin: 0;">Daftar Anggota Dewan</h2>
        <button class="btn btn-primary" onclick="document.getElementById('modalTambah').style.display='flex'">
            <i class="fa-solid fa-plus"></i> Tambah Dewan
        </button>
    </div>
    
    <div class="table-responsive" style="margin-top: 16px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-color); text-align: left;">
                    <th style="padding: 12px; color: var(--color-text-muted);">No</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Nama</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Komisi</th>
                    <th style="padding: 12px; color: var(--color-text-muted);">Fraksi</th>
                    <th style="padding: 12px; color: var(--color-text-muted); text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dewans as $index => $dewan)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 12px;">{{ $index + 1 }}</td>
                    <td style="padding: 12px; font-weight: 600; color: var(--color-text-dark);">{{ $dewan->nama }}</td>
                    <td style="padding: 12px;">
                        @if($dewan->komisi)
                            <span class="badge" style="background: rgba(36, 177, 177, 0.1); color: var(--color-teal); padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">{{ $dewan->komisi }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        @if($dewan->fraksi)
                            <span class="badge" style="background: rgba(227, 116, 52, 0.1); color: var(--color-orange); padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">{{ $dewan->fraksi }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <button class="btn-icon edit" onclick="openEditModal({{ $dewan->id }}, '{{ addslashes($dewan->nama) }}', '{{ addslashes($dewan->komisi ?? '') }}', '{{ addslashes($dewan->fraksi ?? '') }}')" title="Edit"><i class="fa-solid fa-pen"></i></button>
                        <form action="{{ route('dewan.destroy', $dewan->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data anggota dewan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon delete" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 24px; text-align: center; color: var(--color-text-muted);">Belum ada data anggota dewan.</td>
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
            <h3 style="margin: 0; color: var(--color-text-dark);">Tambah Data Dewan</h3>
            <button type="button" onclick="document.getElementById('modalTambah').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--color-text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form action="{{ route('dewan.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" name="nama" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;" onfocus="this.style.borderColor='var(--color-teal)'" onblur="this.style.borderColor='var(--border-color)'">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Komisi</label>
                <input type="text" name="komisi" placeholder="Contoh: Komisi A" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;" onfocus="this.style.borderColor='var(--color-teal)'" onblur="this.style.borderColor='var(--border-color)'">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Fraksi</label>
                <select name="fraksi" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;" onfocus="this.style.borderColor='var(--color-teal)'" onblur="this.style.borderColor='var(--border-color)'">
                    <option value="">-- Pilih Fraksi --</option>
                    <option value="Fraksi PKS">Fraksi PKS</option>
                    <option value="Fraksi PDI Perjuangan">Fraksi PDI Perjuangan</option>
                    <option value="Fraksi Gerindra">Fraksi Gerindra</option>
                    <option value="Fraksi NasDem">Fraksi NasDem</option>
                    <option value="Fraksi Golkar">Fraksi Golkar</option>
                    <option value="Fraksi PKB">Fraksi PKB</option>
                    <option value="Fraksi PAN">Fraksi PAN</option>
                    <option value="Fraksi Demokrat">Fraksi Demokrat</option>
                    <option value="Fraksi PSI">Fraksi PSI</option>
                    <option value="Fraksi PPP">Fraksi PPP</option>
                </select>
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
            <h3 style="margin: 0; color: var(--color-text-dark);">Edit Data Dewan</h3>
            <button type="button" onclick="document.getElementById('modalEdit').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--color-text-muted);"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Nama Lengkap</label>
                <input type="text" id="edit_nama" name="nama" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;" onfocus="this.style.borderColor='var(--color-teal)'" onblur="this.style.borderColor='var(--border-color)'">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Komisi</label>
                <input type="text" id="edit_komisi" name="komisi" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;" onfocus="this.style.borderColor='var(--color-teal)'" onblur="this.style.borderColor='var(--border-color)'">
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--color-text-muted); margin-bottom: 8px;">Fraksi</label>
                <select id="edit_fraksi" name="fraksi" style="width: 100%; padding: 10px 12px; border: 1px solid var(--border-color); border-radius: 6px; font-family: inherit; font-size: 0.95rem; outline: none;" onfocus="this.style.borderColor='var(--color-teal)'" onblur="this.style.borderColor='var(--border-color)'">
                    <option value="">-- Pilih Fraksi --</option>
                    <option value="Fraksi PKS">Fraksi PKS</option>
                    <option value="Fraksi PDI Perjuangan">Fraksi PDI Perjuangan</option>
                    <option value="Fraksi Gerindra">Fraksi Gerindra</option>
                    <option value="Fraksi NasDem">Fraksi NasDem</option>
                    <option value="Fraksi Golkar">Fraksi Golkar</option>
                    <option value="Fraksi PKB">Fraksi PKB</option>
                    <option value="Fraksi PAN">Fraksi PAN</option>
                    <option value="Fraksi Demokrat">Fraksi Demokrat</option>
                    <option value="Fraksi PSI">Fraksi PSI</option>
                    <option value="Fraksi PPP">Fraksi PPP</option>
                </select>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('modalEdit').style.display='none'">Batal</button>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, nama, komisi, fraksi) {
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_komisi').value = komisi;
        document.getElementById('edit_fraksi').value = fraksi;
        document.getElementById('formEdit').action = `/admin/dewan/${id}`;
        document.getElementById('modalEdit').style.display = 'flex';
    }
</script>

@endsection
