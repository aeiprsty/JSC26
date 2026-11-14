@php
    $icon = $getState();
@endphp

@if ($icon)
    <i class="{{ $icon }} text-xl" title="{{ $icon }}"></i>
@else
    <span class="text-gray-400">-</span>
@endif