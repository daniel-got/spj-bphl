<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head', ['title' => $title ?? null, 'description' => $description ?? null])
</head>
<body class="bg-gray-50 text-gray-900 font-sans antialiased flex flex-col min-h-screen">

    {{ $slot }}

    @include('partials.scripts')
</body>
</html>
