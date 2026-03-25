<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $clinicName)</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/fonts/hugeicons/hgi-stroke-rounded.css" />
    <!-- Override brand color palette for public pages -->
    <style>
        :root {
            --color-brand-50:  #f0f7ff;
            --color-brand-100: #e0effe;
            --color-brand-200: #bae0fd;
            --color-brand-300: #7cc8fb;
            --color-brand-400: #38acf8;
            --color-brand-500: #0e91e9;
            --color-brand-600: #0274c7;
            --color-brand-700: #035ca1;
            --color-brand-800: #074f85;
            --color-brand-900: #0c426e;
            --color-brand-950: #082a4a;
        }
    </style>

    @yield('styles')
</head>
<body class="font-sans antialiased text-slate-900 selection:bg-brand-100 selection:text-brand-900">
    @yield('content')
    @yield('scripts')
</body>
</html>
