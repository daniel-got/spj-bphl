{{-- resources/views/pages/auth/login.blade.php --}}
<x-layout.app title="Login">

    <x-layout.navbar />

    <div class="flex">

        <main class="grow flex flex-col justify-center items-center px-6 py-16 md:py-24 text-center">
            <x-layout.page-header title="Login" description="Silahkan masukkan email dan password!" />

            {{-- Dengan semua opsi --}}
            <x-feedback.skeleton type="card">

                <x-form.input name="email" label="Email" type="email" placeholder="contoh@email.com" :value="old('email', $user->email ?? null)"
                    :required="true" :error="$errors->first('email')" hint="Gunakan email kantor" />

                <x-form.input name="password" label="Password" type="password" placeholder="********" :required="true"
                    :error="$errors->first('password')" />

            </x-feedback.skeleton>
        </main>
    </div>

</x-layout.app>
