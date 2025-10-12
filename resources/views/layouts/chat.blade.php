<!DOCTYPE html>
<html lang="en" data-theme="fantasy">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title ?? 'Artisan Talk' }}</title>


        {{-- Vite Assets --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- DaisyUI and Tailwind CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
				
        {{-- Livewire Styles --}}
        @livewireStyles
    </head>

    <body class="h-screen overflow-hidden">
        {{ $slot }}

        {{-- Livewire Scripts --}}
        @livewireScripts
    </body>

</html>
