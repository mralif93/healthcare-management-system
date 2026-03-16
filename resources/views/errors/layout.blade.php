<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ config('app.name') }}</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-900 h-screen flex items-center justify-center p-6">
    <div class="max-w-xl w-full text-center">
        <div class="mb-8">
            <i class="@yield('icon') text-8xl text-red-500 opacity-20"></i>
        </div>
        
        <h1 class="text-9xl font-black text-gray-200 mb-4">@yield('code')</h1>
        <h2 class="text-3xl font-bold text-gray-800 mb-4">@yield('message')</h2>
        <p class="text-gray-500 mb-8 text-lg">@yield('description')</p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ url('/') }}" class="w-full sm:w-auto px-8 py-3 bg-gray-900 text-white rounded-xl font-bold hover:bg-gray-800 transition">
                Go to Homepage
            </a>
            <button onclick="window.history.back()" class="w-full sm:w-auto px-8 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition">
                Go Back
            </button>
        </div>

        @if(config('app.debug'))
            <div class="mt-12 p-6 bg-red-50 border border-red-100 rounded-2xl text-left">
                <h3 class="text-xs font-black uppercase tracking-widest text-red-400 mb-2">Debug Information</h3>
                <div class="font-mono text-sm text-red-700 break-all overflow-x-auto">
                    <strong>Message:</strong> {{ $exception->getMessage() ?: 'No message provided.' }}<br>
                    <strong>File:</strong> {{ $exception->getFile() }}:{{ $exception->getLine() }}
                </div>
            </div>
        @endif
    </div>
</body>
</html>
