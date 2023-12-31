<!DOCTYPE html>
{{-- Headerの追加以外は,layout/gust/blade.phpと同じ内容 --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        {{-- Laravel10.0 tailwidcss追加 --}}
        @vite(['resources/css/app.css', 'resources/js/app.js']);

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        {{-- headerの追加 --}}
        <header>
            {{ $header }}
        </header>
        {{-----------------}}
        <div class="font-sans text-gray-900 antialiased">
            {{-- view/test/component-test1・2.blade.php→components/tests/app.blade.php --}}
            {{ $slot }}
        </div>
    </body>
</html>
