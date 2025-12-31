<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Martku - Platform E-Commerce Indonesia' }}</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/logo.webp') }}">
    @vite(['resources/css/app.css','resources/js/app.js'])

    {{-- Fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @livewireStyles

    <style>
        [x-cloak]{ display:none !important; }

        .carousel-scroll {
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
        }
        .carousel-item {
            scroll-snap-align: start;
        }
        .gradient-fashion {
            background: linear-gradient(135deg, #9c27b0 0%, #e91e63 100%);
        }
        .gradient-orange {
            background: linear-gradient(135deg, #ff9800 0%, #ff6f00 100%);
        }
        .gradient-blue {
            background: linear-gradient(135deg, #3f51b5 0%, #2196f3 100%);
        }
        .gradient-pink {
            background: linear-gradient(135deg, #e91e63 0%, #ff1744 100%);
        }
        .product-image {
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
        }
    </style>
</head>

<body class="bg-white" x-data="app()" x-init="init()">

    {{-- HEADER --}}
    <x-landing.header />

    {{-- CONTENT --}}
    <main>
        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <x-landing.footer />

    @livewireScripts

    {{-- Alpine Function --}}
    <script>
        function app() {
            return {
                startX: 0,
                isDragging: false,

                init() {
                    console.log('Landingpage initialized');
                },

                scrollCarousel(direction, refName) {
                    const carousel = this.$refs[refName];
                    const scrollAmount = 320;

                    if (!carousel) return;

                    carousel.scrollBy({
                        left: direction === 'left' ? -scrollAmount : scrollAmount,
                        behavior: 'smooth'
                    });
                },

                handleTouchMove(e) {
                    if (e.touches.length > 0) {
                        const moveX = e.touches[0].clientX;
                        const diff = this.startX - moveX;

                        if (Math.abs(diff) > 50) {
                            this.isDragging = true;
                        }
                    }
                }
            }
        }
    </script>

</body>
</html>
