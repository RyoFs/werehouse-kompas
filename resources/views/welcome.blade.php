<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Warehouse Peminjaman Alat</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- LOTTIE ANIMATION --}}
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 1.1s ease-out forwards;
        }
        @keyframes fadeIn {
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-up {
            opacity: 0;
            transform: translateY(40px);
            animation: slideUp 1.3s ease-out forwards;
        }
        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">

    {{-- BACKGROUND BARU (lebih gelap & industrial) --}}
    <div class="fixed inset-0 bg-[url('https://images.unsplash.com/photo-1605902711622-cfb43c44367f?auto=format&fit=crop&w=1400&q=80')] 
         bg-cover bg-center opacity-25"></div>

    {{-- LAYER UTAMA --}}
    <div class="relative z-10 w-full max-w-5xl px-6">

        {{-- NAV --}}
        <header class="flex justify-end w-full mb-8 fade-in">
            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-4 py-2 bg-white/20 border border-gray-400 rounded-md backdrop-blur-lg hover:bg-white/30 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700 transition">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-4 py-2 bg-gray-800 text-white rounded-md shadow hover:bg-black transition">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        {{-- HERO SECTION --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10 items-center fade-in">

            {{-- BAGIAN TEKS --}}
            <div class="text-center lg:text-left">
                <h1 class="text-4xl lg:text-5xl font-bold tracking-tight mb-4">
                    Warehouse <span class="text-blue-400">Peminjaman Alat</span>
                </h1>

                <p class="text-lg text-gray-200 max-w-xl slide-up">
                    Sistem modern untuk mengelola, menyimpan, dan meminjam alat dengan cepat, aman, dan efisien.
                    Dibangun untuk mempermudah administrasi dan monitoring peminjaman alat.
                </p>

                <div class="flex mt-8 gap-4 justify-center lg:justify-start slide-up">
                    <a href="{{ route('login') }}"
                       class="px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        Masuk Sekarang
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-black transition">
                            Daftar
                        </a>
                    @endif
                </div>
            </div>

            {{-- BAGIAN ANIMASI --}}
            <div class="flex flex-col items-center gap-6 slide-up">

                {{-- ANIMASI KOMPUTER --}}
                <lottie-player 
                    src="https://assets10.lottiefiles.com/packages/lf20_cC7GBO.json" 
                    background="transparent"  
                    speed="1"  
                    style="width: 280px; height: 280px;"  
                    loop  autoplay>
                </lottie-player>

                {{-- ANIMASI ORANG DALAM GUDANG --}}
                <lottie-player 
                    src="https://assets2.lottiefiles.com/packages/lf20_9lpqimzv.json" 
                    background="transparent"
                    speed="1"  
                    style="width: 320px; height: 320px;"  
                    loop  autoplay>
                </lottie-player>

            </div>
        </div>

        {{-- FOOTER --}}
        <footer class="text-center mt-16 text-sm text-gray-300">
            © {{ date('Y') }} Sistem Warehouse Peminjaman Alat
        </footer>

    </div>
</body>
</html>
