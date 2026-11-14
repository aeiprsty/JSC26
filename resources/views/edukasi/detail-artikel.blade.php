@extends('layouts.edukasi-detail')

@section('title', $edukasi->judul . ' - JambiBersih')

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- Tombol Kembali -->
    <a href="{{ route('edukasi.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-[#1F3D2E] hover:text-[#6B7F4E] mb-6">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Edukasi & Media
    </a>

    <article class="bg-white rounded-3xl border border-[#5A4A3A]/15 shadow-md overflow-hidden">
        
        <div class="p-6 sm:p-10">

            <!-- Informasi Artikel -->
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-md">
                    {{ $edukasi->kategori }}
                </span>

                <span class="text-xs text-[#5A4A3A]/70">
                    <i class="fa-regular fa-calendar mr-1"></i>
                    {{ ($edukasi->published_at ?? $edukasi->created_at)->translatedFormat('d F Y, H:i') }}
                </span>

                @if ($edukasi->penulis)
                    <span class="text-xs text-[#5A4A3A]/70">
                        <i class="fa-regular fa-user mr-1"></i>
                        {{ $edukasi->penulis }}
                    </span>
                @endif
            </div>

            <!-- Judul -->
            <h1 class="text-2xl sm:text-4xl font-extrabold text-[#1F3D2E] leading-tight mb-6">
                {{ $edukasi->judul }}
            </h1>

            <!-- Gambar Cover -->
            @if ($edukasi->gambar)
                <img
                    src="{{ Storage::disk('supabase')->url($edukasi->gambar) }}"
                    alt="{{ $edukasi->judul }}"
                    class="w-full max-h-[420px] object-cover rounded-2xl mb-8"
                >
            @endif

            <!-- Ringkasan -->
            @if ($edukasi->ringkasan)
                <p class="text-base text-[#5A4A3A]/80 leading-relaxed border-l-4 border-[#6B7F4E] pl-4 mb-8">
                    {{ $edukasi->ringkasan }}
                </p>
            @endif

            <!-- Isi Artikel -->
            <div class="text-sm sm:text-base text-[#5A4A3A] leading-8
                        [&_h1]:text-2xl [&_h1]:font-bold [&_h1]:text-[#1F3D2E] [&_h1]:mt-8 [&_h1]:mb-4
                        [&_h2]:text-xl [&_h2]:font-bold [&_h2]:text-[#1F3D2E] [&_h2]:mt-7 [&_h2]:mb-3
                        [&_h3]:text-lg [&_h3]:font-bold [&_h3]:text-[#1F3D2E] [&_h3]:mt-6 [&_h3]:mb-2
                        [&_p]:mb-4 [&_ul]:list-disc [&_ul]:pl-6 [&_ol]:list-decimal [&_ol]:pl-6
                        [&_li]:mb-2 [&_a]:text-[#4C6A73] [&_a]:underline
                        [&_strong]:font-bold">

                @if ($edukasi->isi)
                    {!! $edukasi->isi !!}
                @else
                    <p class="text-[#5A4A3A]/60 italic">
                        Isi artikel belum tersedia.
                    </p>
                @endif
            </div>

        </div>

    </article>

</div>

@endsection