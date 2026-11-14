@props([
    'icon' => '',
    'label' => '',
])

<div class="flex items-center gap-3">
    <i class="{{ $icon }} text-base w-5 text-center"></i>
    <span>{{ $label }}</span>
</div>