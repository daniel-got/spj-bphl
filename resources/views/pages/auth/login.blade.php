{{-- resources/views/pages/auth/login.blade.php --}}
<x-layout.app title="Login">

    <style>
        /* Menggunakan latar belakang kabut hutan hijau terang yang sama dengan Beranda */
        .main-portal-bg {
            background-image: url('https://images.unsplash.com/photo-1542273917363-3b1817f69a2d?q=80&w=1920&auto=format&fit=crop') !important;
            background-position: center !important;
            background-size: cover !important;
            background-attachment: fixed !important;
        }

        /* Lapisan putih transparan pelindung kontras teks */
        .light-overlay {
            background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.92)) !important;
        }
    </style>

    <div class="main-portal-bg min-h-screen flex items-center justify-center p-4 relative">
        <div class="absolute inset-0 light-overlay pointer-events-none z-0"></div>

        <div class="relative z-10 w-full max-w-[420px] mx-auto">
            
            <x-layout.card class="w-full flex flex-col gap-2 bg-white/95 border border-emerald-100 rounded-2xl shadow-xl p-6 backdrop-blur-sm" title="">
                
                <div class="flex flex-col items-center text-center my-2">
                    <div class="flex justify-center items-center mb-3">
                        <img class="h-16 w-auto" src="{{ asset('favicon.png') }}" alt="Logo BPHL">
                    </div>
                    <h2 class="text-xl font-extrabold text-emerald-950 tracking-tight">BPHL Wil IV Jambi</h2>
                    <p class="text-[11px] text-emerald-800/70 font-bold mt-1 uppercase tracking-wider">Sistem Informasi Perjalanan Dinas</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="w-full space-y-4 text-left px-2 pb-2">
                    @csrf

                    <x-form.input name="email" label="Email" type="email" placeholder="contoh@email.com"
                        :value="old('email')" :required="true" :error="$errors->first('email')" hint="Gunakan email kantor" />

                    <x-form.input name="password" label="Password" type="password" placeholder="********"
                        :required="true" :error="$errors->first('password')" />
                    
                    <div class="flex items-center pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none"> 
                            <input type="checkbox" name="remember" class="rounded border-emerald-300 text-emerald-700 focus:ring-emerald-600 bg-gray-50"> 
                            <span class="text-xs font-semibold text-emerald-950/80">Ingat Saya</span>
                        </label>
                    </div>

                    <div class="pt-3">
                        <x-action.button-primary type="submit" class="w-full bg-emerald-800 hover:bg-emerald-900 text-white font-bold py-2.5 rounded-xl transition-all duration-150 shadow-md">
                            Masuk
                        </x-action.button-primary>
                    </div>

                    <div class="pt-4 border-t border-gray-100 text-center">
                        <a href="/" class="inline-flex items-center text-xs font-bold text-emerald-800 hover:text-emerald-900 transition-colors duration-150">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </x-layout.card>
        </div>
    </div>

</x-layout.app>