@extends('layouts.admin')

@section('title', isset($article) ? 'Edit Artikel Kegiatan' : 'Tambah Artikel Kegiatan')

@push('styles')
<style>
    .ck-editor__editable_inline {
        min-height: 300px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
</style>
@endpush

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <a href="{{ route('admin.articles.index') }}" class="text-sm font-semibold text-slate-500 hover:text-primary-600 transition-colors flex items-center mb-2">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-3xl font-display font-bold text-slate-900">{{ isset($article) ? 'Edit Artikel Kegiatan' : 'Tulis Artikel Kegiatan Baru' }}</h2>
        <p class="text-slate-500 mt-1 font-medium">Lengkapi detail kegiatan dan unggah foto-foto dokumentasi.</p>
    </div>
</div>

<form action="{{ isset($article) ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if(isset($article))
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Form Data -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Informasi Utama</h3>
                
                <div class="space-y-5">
                    <div>
                        <label for="title" class="block text-sm font-bold text-slate-700 mb-2">Judul Kegiatan</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $article->title ?? '') }}" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all font-medium placeholder:text-slate-400"
                            placeholder="Contoh: Gerebek Lumpur Kali Sunter Bulan Agustus">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="activity_date" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Pelaksanaan</label>
                            <input type="date" id="activity_date" name="activity_date" value="{{ old('activity_date', isset($article) && $article->activity_date ? $article->activity_date->format('Y-m-d') : '') }}" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all font-medium">
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-bold text-slate-700 mb-2">Status Publikasi</label>
                            <select id="status" name="status" required
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all font-medium">
                                <option value="draft" {{ old('status', $article->status ?? '') == 'draft' ? 'selected' : '' }}>Draft (Sembunyikan)</option>
                                <option value="published" {{ old('status', $article->status ?? '') == 'published' ? 'selected' : '' }}>Published (Tampilkan Publik)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-bold text-slate-700 mb-2">Isi Artikel / Laporan</label>
                        <textarea id="content" name="content" rows="10"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all font-medium placeholder:text-slate-400"
                            placeholder="Tuliskan deskripsi lengkap dari kegiatan ini...">{{ old('content', $article->content ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Galeri Foto -->
        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-24">
                <h3 class="text-lg font-bold text-slate-800 mb-2">Galeri Foto</h3>
                <p class="text-sm text-slate-500 mb-6">Unggah foto dokumentasi kegiatan. Anda dapat memilih lebih dari satu foto sekaligus.</p>
                
                <div class="mb-6">
                    <label for="images" class="block text-sm font-bold text-slate-700 mb-2">Unggah Foto Baru</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-xl hover:bg-slate-50 hover:border-primary-400 transition-colors cursor-pointer" onclick="document.getElementById('images').click()">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-slate-600 justify-center">
                                <span class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>Pilih File</span>
                                    <input id="images" name="images[]" type="file" multiple class="sr-only" accept="image/*" onchange="updateFileList(this)">
                                </span>
                            </div>
                            <p class="text-xs text-slate-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    <!-- Preview List of files to upload -->
                    <div id="file-list" class="mt-3 text-sm text-slate-600 font-medium space-y-1"></div>
                </div>

                @if(isset($article) && $article->images->count() > 0)
                <div class="mt-6 border-t border-slate-100 pt-6">
                    <h4 class="text-sm font-bold text-slate-700 mb-3">Foto Tersimpan ({{ $article->images->count() }})</h4>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($article->images as $image)
                        <div class="relative group rounded-lg overflow-hidden border border-slate-200" id="img-{{ $image->id }}">
                            <img src="{{ Storage::url($image->image_path) }}" alt="" class="w-full h-24 object-cover">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" onclick="deleteImage({{ $image->id }})" class="p-1.5 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mt-8 pt-6 border-t border-slate-100">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm shadow-primary-500/30 text-base font-bold text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all">
                        {{ isset($article) ? 'Simpan Perubahan' : 'Terbitkan Artikel' }}
                    </button>
                </div>
            </div>
            
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }
        upload() {
            return this.loader.file
                .then(file => new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    
                    fetch('{{ route('admin.articles.uploadImage') }}', {
                        method: 'POST',
                        body: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.error) {
                            reject(response.error);
                        } else {
                            resolve({
                                default: response.url
                            });
                        }
                    })
                    .catch(error => {
                        reject('Upload failed');
                    });
                }));
        }
        abort() {}
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    ClassicEditor
        .create(document.querySelector('#content'), {
            extraPlugins: [MyCustomUploadAdapterPlugin],
        })
        .catch(error => {
            console.error(error);
        });

    function updateFileList(input) {
        const fileList = document.getElementById('file-list');
        fileList.innerHTML = '';
        if (input.files.length > 0) {
            fileList.innerHTML = `<p class="text-primary-600">${input.files.length} file dipilih siap diunggah.</p>`;
            for (let i = 0; i < input.files.length; i++) {
                fileList.innerHTML += `<div class="text-xs truncate bg-slate-100 px-2 py-1 rounded">📄 ${input.files[i].name}</div>`;
            }
        }
    }

    function deleteImage(id) {
        if(confirm('Hapus foto ini secara permanen?')) {
            fetch(`/admin/articles/image/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(response => response.json())
              .then(data => {
                  if(data.success) {
                      document.getElementById('img-' + id).remove();
                  }
              });
        }
    }
</script>
@endpush
