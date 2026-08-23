<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIDAJU Jakarta Utara</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/logo.ico') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: '#0f172a',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-primary-500 selection:text-white min-h-screen flex">

    <!-- Left Panel: Login Form -->
    <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 sm:p-12 lg:p-24 relative bg-white z-10 shadow-2xl">
        <div class="w-full max-w-md">
            
            <!-- Logo & Back to Home -->
            <div class="flex justify-between items-center mb-16">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-primary-600 to-primary-400 shadow-lg shadow-primary-500/30 group-hover:scale-105 transition-transform overflow-hidden border border-primary-200">
                        <img src="{{ asset('assets/logo.jpeg') }}" alt="Logo SIDAJU" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h1 class="font-display font-bold text-xl leading-none text-slate-800 tracking-wide">SIDAJU JAKUT</h1>
                    </div>
                </a>
                
                <a href="{{ url('/') }}" class="text-sm font-medium text-slate-500 hover:text-primary-600 transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>

            <!-- Header -->
            <div class="mb-10">
                <h2 class="text-4xl font-display font-extrabold text-slate-900 mb-3">Selamat Datang 👋</h2>
                <p class="text-slate-500 text-base">Silakan masuk menggunakan kredensial NIP Anda untuk mengakses sistem pemerintahan.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('login') ?? '#' }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Input NIP / Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">NIP / Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" id="email" name="email" required autofocus
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all placeholder:text-slate-400 font-medium" 
                            placeholder="Masukkan NIP atau Email">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                        <a href="#" class="text-sm font-semibold text-primary-600 hover:text-primary-500 transition-colors">Lupa sandi?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all placeholder:text-slate-400 font-medium" 
                            placeholder="Masukkan kata sandi">
                        
                        <!-- Toggle Password Visibility -->
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-slate-400 hover:text-slate-600 transition-colors" onclick="const p = document.getElementById('password'); if(p.type === 'password') { p.type = 'text'; this.innerHTML = '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21\'></path></svg>'; } else { p.type = 'password'; this.innerHTML = '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 12a3 3 0 11-6 0 3 3 0 016 0z\'></path><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\'></path></svg>'; }">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-primary-600 focus:ring-primary-500 cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm font-medium text-slate-700 cursor-pointer">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-primary-500/30 text-base font-bold text-white bg-primary-600 hover:bg-primary-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all">
                    Masuk ke Sistem
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
            
            <div class="mt-12 pt-8 border-t border-slate-100">
                <p class="text-center text-xs text-slate-500 font-medium">
                    &copy; {{ date('Y') }} Suku Dinas Tata Kelola Air Wilayah Jakarta Utara.<br>Semua Hak Cipta Dilindungi.
                </p>
            </div>
        </div>
    </div>

    <!-- Right Panel: Image / Showcase -->
    <div class="hidden lg:block lg:w-1/2 relative bg-dark">
        <!-- Background Image -->
        <img src="{{ asset('img/slide1.jpg') }}" alt="Command Center SIDAJU" class="absolute inset-0 w-full h-full object-cover">
        
        <!-- Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-r from-dark/90 to-primary-900/40 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-dark/90 via-transparent to-transparent"></div>

        <!-- Glassmorphism Content Box -->
        <div class="absolute bottom-16 left-16 right-16">
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-2xl shadow-2xl">
                <span class="inline-block py-1 px-3 rounded-full bg-primary-500/30 border border-primary-400/30 text-primary-200 text-xs font-bold tracking-wider uppercase mb-4">Command Center Cerdas</span>
                <h3 class="text-3xl font-display font-bold text-white mb-3">Monitoring Terintegrasi SIDAJU</h3>
                <p class="text-primary-100 text-sm leading-relaxed max-w-lg">Sistem pelayanan satu pintu (SSO) untuk seluruh aplikasi pendukung operasional tata kelola sumber daya air di wilayah kota administrasi Jakarta Utara.</p>
                
                <div class="mt-6 flex items-center space-x-6 text-sm text-white/80 font-medium">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Aman & Terenkripsi
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Real-time 24/7
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Decorative Elements -->
        <div class="absolute top-1/4 -left-12 w-32 h-32 bg-primary-500 rounded-full mix-blend-multiply filter blur-[64px] opacity-70"></div>
    </div>
</body>
</html>
