{{-- resources/views/pages/auth/login.blade.php --}}
<x-layout.app title="Login">


    <div class="flex">

        <main class="grow flex flex-col justify-center items-center px-6 py-16 md:py-24 text-center">
            <x-layout.page-header title="Login" description="Silahkan masukkan email dan password!" />

            {{-- Dengan semua opsi --}}
            <x-layout.card class="flex flex-col gap-4" title="BPHL Wil IV Jambi">

                <div class="flex justify-center items-center">
                    <img class="h-30 w-auto" src="{{ asset('favicon.png') }}" alt="Logo">
                </div>

                <form method="POST" action="{{ route('login') }}" class="w-full max-w-md mx-auto px-6 py-8 space-y-6 text-left">
                    @csrf
                    
                    <x-form.input name="email" label="Email" type="email" placeholder="contoh@email.com"
                        :value="old('email')" :required="true" :error="$errors->first('email')" hint="Gunakan email kantor" />
                        
                    <x-form.input name="password" label="Password" type="password" placeholder="********"
                        :required="true" :error="$errors->first('password')" />
                        
                    <x-action.button-primary type="submit" class="w-full">
                        Masuk
                    </x-action.button-primary>
                    
                    <a href="/"
                        class="block w-full text-center text-xs font-semibold tracking-wider text-text-main hover:text-primary transition-colors">
                        Kembali ke Beranda
                    </a>
                </form>
            </x-layout.card>
        </main>
    </div>

</x-layout.app>
