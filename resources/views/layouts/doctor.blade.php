<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Doctor') | {{ config('app.name', 'Clinic OS') }}</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.hugeicons.com/font/hgi-stroke-rounded.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Poppins', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac',
                            400: '#4ade80', 500: '#22c55e', 600: '#16a34a', 700: '#15803d',
                            800: '#166534', 900: '#14532d',
                        },
                    }
                }
            }
        }
    </script>

    @yield('styles')
</head>
<body class="bg-emerald-50/20 font-sans antialiased text-slate-900 overflow-hidden">
    <div class="flex h-screen overflow-hidden text-sm">
        
        <!-- Compact Sidebar -->
        <aside class="w-64 bg-white border-r border-emerald-100 flex-shrink-0 flex flex-col z-30">
            <div class="h-16 flex items-center px-6 border-b border-emerald-50 flex-shrink-0">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center text-white shadow-md shadow-emerald-100">
                        <i class="hgi-stroke hgi-doctor-01 text-xl"></i>
                    </div>
                    <span class="text-base font-bold text-slate-900 tracking-tight italic uppercase">Clinical</span>
                </div>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto">
                <div>
                    <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-3 px-2">Clinical Menu</p>
                    <div class="space-y-1">
                        @foreach(config('layout.navigation.doctor') as $item)
                            <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}" 
                               class="flex items-center space-x-3 px-3 py-2 rounded-lg transition-all group {{ request()->routeIs($item['route']) ? 'bg-brand-50 text-brand-600 shadow-sm font-semibold' : 'text-slate-500 hover:bg-emerald-50/50' }}">
                                <i class="hgi-stroke {{ $item['icon'] }} text-lg {{ request()->routeIs($item['route']) ? 'text-brand-600' : 'group-hover:text-brand-600' }}"></i>
                                <span class="tracking-tight">{{ $item['name'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </nav>

            <div class="p-4 border-t border-emerald-50 text-center">
                <p class="text-[9px] font-bold text-emerald-300 uppercase tracking-widest">Medical OS v2.0</p>
            </div>
        </aside>

        <!-- Main Workspace -->
        <main class="flex-1 flex flex-col overflow-hidden relative">
            <header class="h-16 bg-white/80 backdrop-blur-xl border-b border-emerald-100 px-8 flex items-center justify-between z-20">
                <div class="flex items-center space-x-6">
                    <h2 class="text-base font-bold text-slate-900 tracking-tight">@yield('page_title', 'Clinical Console')</h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Notification Bell -->
                    @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative w-9 h-9 rounded-lg border border-emerald-100 text-slate-500 flex items-center justify-center hover:bg-emerald-50 transition-all active:scale-95">
                            <i class="hgi-stroke hgi-notification-03 text-lg"></i>
                            @if($unreadCount > 0)
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white animate-pulse"></span>
                            @endif
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak [x-cloak]:hidden
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-emerald-50 z-50 overflow-hidden">

                            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100 bg-slate-50/50">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-[10px] font-black text-slate-900 uppercase tracking-widest">Notifications</h3>
                                    @if($unreadCount > 0)
                                        <span class="px-1.5 py-0.5 bg-emerald-500 text-white rounded-md text-[8px] font-black">{{ $unreadCount }}</span>
                                    @endif
                                </div>
                                @if($unreadCount > 0)
                                    <form action="{{ route('notifications.readAll') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[9px] font-black text-emerald-600 uppercase tracking-widest hover:text-emerald-800 transition-colors">Mark all read</button>
                                    </form>
                                @endif
                            </div>

                            <div class="max-h-72 overflow-y-auto divide-y divide-slate-50">
                                @forelse(Auth::user()->notifications()->latest()->take(8)->get() as $notif)
                                    <div class="flex items-start space-x-3 px-4 py-3 {{ $notif->read_at ? '' : 'bg-emerald-50/40' }} hover:bg-slate-50 transition-colors">
                                        <div class="w-8 h-8 rounded-lg {{ $notif->read_at ? 'bg-slate-100 text-slate-400' : 'bg-emerald-100 text-emerald-600' }} flex items-center justify-center shrink-0 mt-0.5">
                                            <i class="hgi-stroke {{ $notif->data['icon'] ?? 'hgi-notification-03' }} text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-slate-900 leading-snug">{{ $notif->data['title'] }}</p>
                                            <p class="text-[10px] text-slate-500 mt-0.5 leading-relaxed">{{ $notif->data['message'] }}</p>
                                            <p class="text-[9px] text-slate-400 mt-1 font-semibold">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                        @if(!$notif->read_at)
                                            <form action="{{ route('notifications.read', $notif->id) }}" method="POST" class="shrink-0">
                                                @csrf
                                                <button type="submit" title="Mark as read" class="w-2 h-2 bg-emerald-500 rounded-full mt-2 hover:bg-emerald-700 transition-colors block"></button>
                                            </form>
                                        @endif
                                    </div>
                                @empty
                                    <div class="py-10 text-center">
                                        <i class="hgi-stroke hgi-notification-03 text-3xl text-slate-200 mb-2 block"></i>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">All caught up!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="h-6 w-[1px] bg-emerald-100"></div>

                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-3 group active:scale-95 transition-transform">
                            <div class="w-9 h-9 rounded-lg bg-brand-600 flex items-center justify-center text-white shadow-sm overflow-hidden">
                                <i class="hgi-stroke hgi-user-circle text-2xl"></i>
                            </div>
                            <div class="text-left leading-none hidden sm:block">
                                <p class="text-xs font-bold text-slate-900 leading-none">Dr. {{ Auth::user()->name }}</p>
                                <p class="text-[9px] font-bold text-emerald-600 uppercase tracking-widest mt-1">Medical Doctor</p>
                            </div>
                            <i class="hgi-stroke hgi-arrow-down-01 text-[10px] text-slate-400 group-hover:text-emerald-600 transition-colors"></i>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak [x-cloak]:hidden
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-emerald-50 py-2 z-50">
                            
                            <a href="{{ route('doctor.profile') }}" class="flex items-center space-x-2 px-4 py-2 hover:bg-slate-50 text-slate-600 hover:text-brand-600 transition-colors">
                                <i class="hgi-stroke hgi-user-edit-01 text-base"></i>
                                <span class="text-xs font-bold tracking-tight">Edit Profile</span>
                            </a>

                            <div class="my-1 border-t border-slate-50"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-red-500 hover:bg-red-50 transition-colors">
                                    <i class="hgi-stroke hgi-logout-01 text-base"></i>
                                    <span class="text-xs font-bold tracking-tight">Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="flex-1 overflow-y-auto p-6 lg:p-8">
                <nav class="flex mb-6 items-center space-x-2 text-[10px] font-bold uppercase tracking-widest" aria-label="Breadcrumb">
                    <a href="{{ route('doctor.dashboard') }}" class="flex items-center p-1.5 bg-white border border-emerald-100 rounded-lg text-slate-400 hover:text-emerald-600 hover:border-emerald-200 hover:shadow-sm transition-all group">
                        <i class="hgi-stroke hgi-home-01 text-sm group-hover:scale-110 transition-transform"></i>
                    </a>
                    <i class="hgi-stroke hgi-arrow-right-01 text-slate-300 text-[8px]"></i>
                    <div class="px-3 py-1.5 bg-emerald-50/50 rounded-lg border border-emerald-100/50">
                        <span class="text-emerald-900 font-black tracking-widest">@yield('page_title', 'Clinical Console')</span>
                    </div>
                </nav>

                <div class="animate__animated animate__fadeInUp animate__faster">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    @yield('scripts')
</body>
</html>
