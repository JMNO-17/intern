<style>
    .loader {
        width: 60px;
        aspect-ratio: 4;
        background: radial-gradient(circle closest-side, #011B54 90%, #0000) 0/calc(100%/3) 100% space;
        clip-path: inset(0 100% 0 0);
        animation: l1 1s steps(4) infinite;
    }

    @keyframes l1 {
        to {
            clip-path: inset(0 -34% 0 0)
        }
    }
</style>
<div id="loader"
    class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-1000 opacity-100">
    <div class="loader"></div>
</div>
<script>
    window.addEventListener('load', function() {
        const loader = document.getElementById('loader');
        if (loader) {
            loader.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                loader.style.display = 'none';
            }, 100);
        }
    });
</script>
