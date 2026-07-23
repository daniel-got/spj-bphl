<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.head', ['title' => $title ?? null, 'description' => $description ?? null])
</head>
<body class="bg-background text-text-main font-sans antialiased flex flex-col min-h-screen" x-data="{ sidebarCollapsed: window.innerWidth < 1024 }" @resize.window="if(window.innerWidth < 1024) sidebarCollapsed = true">

    {{ $slot }}

    @include('partials.scripts')
</body>
</html>
