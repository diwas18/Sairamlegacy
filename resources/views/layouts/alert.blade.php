@if (Session::has('success'))
    <div id="message" class="fixed top-4 left-1/2 transform -translate-x-1/2 z-50 bg-[#D4AF37] text-[#800020] px-6 py-3 rounded-lg shadow-lg font-semibold text-sm md:text-base transition-opacity duration-500">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            const message = document.getElementById('message');
            if (message) {
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 500);
            }
        }, 2000);
    </script>
@endif
