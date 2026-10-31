<div class="flex justify-center">
    @if ($record->foto)
        <img
            src="{{ Storage::disk('public')->url($record->foto) }}"
            alt="Foto Bukti Laporan"
            class="max-h-[75vh] w-auto max-w-full rounded-xl object-contain"
        >
    @else
        <p class="text-gray-500">
            Foto laporan tidak tersedia.
        </p>
    @endif
</div>