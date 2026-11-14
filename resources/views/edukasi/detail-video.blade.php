@extends('layouts.edukasi-detail')

@section('title', $edukasi->judul . ' - JambiBersih')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- Tombol Kembali -->
    <a href="{{ route('edukasi.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-[#1F3D2E] hover:text-[#6B7F4E] mb-6">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke Edukasi & Media
    </a>

    <article class="bg-white rounded-3xl border border-[#5A4A3A]/15 shadow-md overflow-hidden">

        <div class="p-5 sm:p-8">

            <!-- Informasi Video -->
            <div class="flex flex-wrap items-center gap-3 mb-4">

                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-md">
                    {{ $edukasi->kategori }}
                </span>

                <span class="text-xs text-[#5A4A3A]/70">
                    <i class="fa-regular fa-calendar mr-1"></i>
                    {{ ($edukasi->published_at ?? $edukasi->created_at)?->translatedFormat('d F Y, H:i') }}
                </span>

            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#1F3D2E] leading-tight mb-3">
                {{ $edukasi->judul }}
            </h1>

            @if ($edukasi->ringkasan)
                <p class="text-sm text-[#5A4A3A]/80 leading-relaxed mb-6">
                    {{ $edukasi->ringkasan }}
                </p>
            @endif

            <!-- Pemutar Video -->
            <div class="rounded-xl overflow-hidden bg-black aspect-video">

                @if ($videoEmbedUrl)
                    <iframe
                        src="{{ $videoEmbedUrl }}"
                        title="{{ $edukasi->judul }}"
                        class="w-full h-full"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin"
                        allowfullscreen>
                    </iframe>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-white p-6 text-center">
                        <i class="fa-solid fa-circle-exclamation text-3xl mb-3"></i>
                        <p class="text-sm">Video belum dapat ditampilkan.</p>
                        <p class="text-xs text-white/60 mt-1">
                            URL video YouTube belum tersedia atau tidak valid.
                        </p>
                    </div>
                @endif

            </div>

        </div>

    </article>

</div>

@endsection