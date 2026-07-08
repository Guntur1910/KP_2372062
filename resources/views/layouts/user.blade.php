<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kain Tenun Sumba')</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    @stack('styles')
    <style>
        html { scroll-behavior: smooth; }

        #backToTop {
            position: fixed;
            bottom: 36px;
            right: 36px;
            width: 44px;
            height: 44px;
            background: var(--cream-dark);
            color: var(--text-dark);
            border: none;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s, visibility 0.3s, transform 0.3s;
            z-index: 999;
        }

        #backToTop.visible {
            opacity: 1;
            visibility: visible;
        }

        #backToTop:hover {
            transform: translateY(-3px);
            background: var(--cream);
        }
    </style>
</head>
<body>

    <nav class="navbar-custom">
        <ul class="nav-links">
            <li><a href="{{ route('user.home') }}">Home</a></li>
            <li><a href="{{ route('user.home') }}#tentang">Tentang</a></li>
            <li><a href="{{ route('user.home') }}#koleksi">Koleksi</a></li>
            <li><a href="{{ route('user.home') }}#galeri">Galeri</a></li>
        </ul>
        <a href="{{ route('admin.login') }}" class="btn-logout" style="position: absolute; right: 40px;">Login</a>
    </nav>
    @yield('content')

    <button id="backToTop" onclick="window.scrollTo({top:0, behavior:'smooth'})">↑</button>

    <footer class="footer">
        <div class="footer-brand"><span>Kain</span> Tenun Sumba</div>
        <div class="footer-tagline">
            Digitalisasi Motif Kain Tenun Sumba<br>
            untuk Inovasi Desain Aksesoris Interior
        </div>
    </footer>

    <script>
        const btn = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 400) {
                btn.classList.add('visible');
            } else {
                btn.classList.remove('visible');
            }
        });
    </script>
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                } else {
                    entry.target.classList.remove('visible');
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.section-split, .section-full, .section-split-alt, .section-cards')
            .forEach(section => observer.observe(section));
    </script>
    <script>
        function startSlideshow(containerId, interval) {
            const container = document.getElementById(containerId);
            if (!container) return;
            const slides = container.querySelectorAll('.slide-img');
            if (slides.length === 0) return;
            let current = 0;
            slides[0].classList.add('active');
            setInterval(() => {
                slides[current].classList.remove('active');
                current = (current + 1) % slides.length;
                slides[current].classList.add('active');
            }, interval);
        }

        startSlideshow('slideshow-1', 3000);
        startSlideshow('slideshow-2', 4000);
    </script>

    @stack('scripts')

</body>
</html>