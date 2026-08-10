{{-- resources/views/pages/auth/change-password.blade.php --}}
<x-layout.app title="Ganti Password">

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
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-800">
                            <x-utility.icon name="lock-closed" class="w-8 h-8" />
                        </div>
                    </div>
                    <h2 class="text-xl font-extrabold text-emerald-950 tracking-tight">Wajib Ganti Password</h2>
                    <p class="text-xs text-emerald-800/80 font-medium mt-2 leading-relaxed">
                        Demi keamanan, silakan ganti password default Anda terlebih dahulu sebelum melanjutkan ke dalam sistem.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.change.update') }}" class="w-full space-y-4 text-left px-2 pb-2 mt-4">
                    @csrf

                    <x-form.input name="password" label="Password Baru" type="password" placeholder="Minimal 8 karakter"
                        :required="true" :error="$errors->first('password')" />

                    <x-form.input name="password_confirmation" label="Konfirmasi Password Baru" type="password" placeholder="Masukkan ulang password baru"
                        :required="true" :error="$errors->first('password_confirmation')" />

                    <div class="pt-4">
                        <x-action.button-primary type="submit" class="w-full bg-emerald-800 hover:bg-emerald-900 text-white font-bold py-2.5 rounded-xl transition-all duration-150 shadow-md">
                            Simpan Password & Lanjutkan
                        </x-action.button-primary>
                    </div>
                </form>

                <div class="pt-4 border-t border-gray-100 text-center pb-2">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center text-xs font-bold text-red-600 hover:text-red-800 transition-colors duration-150">
                            <x-utility.icon name="arrow-left-on-rectangle" class="w-4 h-4 mr-1.5" />
                            Logout
                        </button>
                    </form>
                </div>
            </x-layout.card>
        </div>
    </div>

</x-layout.app>
