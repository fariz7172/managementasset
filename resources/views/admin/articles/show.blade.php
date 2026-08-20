@extends('layouts.admin')

@section('title', 'Detail Artikel Kegiatan')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <a href="{{ route('admin.articles.index') }}" class="text-sm font-semibold text-slate-500 hover:text-primary-600 transition-colors flex items-center mb-2">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
        <h2 class="text-3xl font-display font-bold text-slate-900">Detail Kegiatan</h2>
        <p class="text-slate-500 mt-1 font-medium">Informasi lengkap kegiatan dan galeri terkait.</p>
    </div>
    <div class="space-x-3">
        <a href="{{ route('admin.articles.edit', $article) }}" class="inline-flex items-center px-4 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Artikel
        </a>
        <a href="{{ route('articles.show', $article) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-bold text-white bg-primary-600 hover:bg-primary-500 transition-colors shadow-sm shadow-primary-500/30">
            Lihat Tampilan Publik
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="p-8">
        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-slate-100">
            <div>
                <h3 class="text-2xl font-display font-bold text-slate-900 mb-2">{{ $article->title }}</h3>
                <div class="flex items-center text-sm font-medium text-slate-500 space-x-4">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $article->activity_date ? $article->activity_date->format('d F Y') : '-' }}
                    </span>
                    <span class="flex items-center">
                        @if($article->status == 'published')
                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span> Published
                        @else
                            <span class="w-2 h-2 rounded-full bg-slate-400 mr-2"></span> Draft
                        @endif
                    </span>
                </div>
            </div>
        </div>
        
        <div class="prose prose-slate max-w-none">
            {!! $article->content !!}
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
    <h3 class="text-xl font-display font-bold text-slate-900 mb-4 border-b border-slate-100 pb-4">Galeri Dokumentasi ({{ $article->images->count() }})</h3>
    
    @if($article->images->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($article->images as $image)
        <div class="rounded-xl overflow-hidden border border-slate-200 aspect-[4/3] bg-slate-50 cursor-pointer hover:opacity-90 transition-opacity" onclick="openImageModal('{{ Storage::url($image->image_path) }}')">
            <img src="{{ Storage::url($image->image_path) }}" class="w-full h-full object-cover">
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-8 text-slate-500">
        Belum ada foto galeri untuk kegiatan ini.
    </div>
    @endif
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-slate-900/90 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="relative max-w-5xl w-full max-h-[90vh] flex items-center justify-center">
        <button type="button" onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-slate-300 transition-colors bg-slate-800/50 rounded-full p-2">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <img id="modalImage" src="" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">
    </div>
</div>

@endsection

@push('scripts')
<script>
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');

    function openImageModal(src) {
        modalImage.src = src;
        modal.classList.remove('hidden');
        // trigger reflow for transition
        void modal.offsetWidth; 
        modal.classList.remove('opacity-0');
        modal.classList.add('opacity-100');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modalImage.src = '';
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Close on click outside
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeImageModal();
        }
    });

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeImageModal();
        }
    });
</script>
@endpush
