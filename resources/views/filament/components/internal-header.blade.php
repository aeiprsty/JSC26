<div
    id="jambibersih-topbar-brand"
    class="hidden items-center"
>
    <a href="{{ url('/') }}" class="flex flex-col group">
        <span class="font-extrabold text-lg tracking-tight leading-none text-gray-900 dark:text-white group-hover:text-[#6B7F4E] transition-colors">
            JambiBersih
        </span>

        <span class="text-[10px] text-gray-500 dark:text-gray-400 font-medium tracking-wider uppercase">
            Dinas Lingkungan Hidup Kota Jambi
        </span>
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