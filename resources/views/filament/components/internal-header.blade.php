<div
    id="jambibersih-topbar-brand"
    class="hidden items-center"
>
    <a href="{{ url('/') }}" class="flex items-center gap-1 group">
        <!-- Logo simbol -->
        <img
            src="{{ asset('images/logo-angsa.png') }}"
            alt="Logo JambiBersih"
            class="w-10 h-10 object-contain">

        <!-- Tulisan JambiBersih -->
        <img
            src="{{ asset('images/font-angsa.png') }}"
            alt="JambiBersih"
            class="h-11 w-auto object-contain"
        >
    </a>
</div>

<script>
    (() => {
        const moveBrand = () => {
            const brand = document.getElementById('jambibersih-topbar-brand');
            const hamburger = document.querySelector('.fi-topbar-open-sidebar-btn');

            if (!brand || !hamburger) return;

            hamburger.insertAdjacentElement('afterend', brand);

            brand.classList.remove('hidden');
            brand.classList.add('flex');
        };

        moveBrand();

        document.addEventListener('livewire:navigated', moveBrand);
    })();
</script>