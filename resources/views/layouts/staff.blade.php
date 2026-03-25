<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Staff') | {{ $clinicName }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/fonts/hugeicons/hgi-stroke-rounded.css" />
    @yield('styles')
</head>

<body class="bg-slate-100 font-sans antialiased text-slate-900 overflow-hidden">
    <div class="flex h-screen h-[100dvh] overflow-hidden" x-data="{ sidebarOpen: false }">

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-30 lg:hidden"></div>

        <!-- Dark Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-slate-900 flex-shrink-0 flex flex-col
                      transform transition-transform duration-300 ease-in-out
                      lg:static lg:translate-x-0 lg:z-auto"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            <div class="h-16 flex items-center px-5 border-b border-slate-800 flex-shrink-0">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-9 h-9 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-900/50 flex-shrink-0">
                        <i class="hgi-stroke hgi-manager text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white leading-none tracking-tight">{{ $clinicName }}</p>
                        <p class="text-[9px] font-semibold text-indigo-400 uppercase tracking-widest mt-0.5">Staff
                            Portal</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3 py-4 overflow-y-auto">
                @php
                $navItems = config('layout.navigation.staff');
                $groups = collect($navItems)->groupBy('group');
                @endphp

                @foreach($groups as $groupName => $items)
                <div class="mb-4">
                    <p class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-1.5 px-3">{{ $groupName
                        }}</p>
                    <div class="space-y-0.5">
                        @foreach($items as $item)
                        @php
                        $active = Route::has($item['route']) && request()->routeIs($item['route']);
                        $isSubItem = in_array($item['route'], ['staff.patients.create', 'staff.appointments.create',
                        'staff.checkin']);
                        @endphp
                        <a href="{{ Route::has($item['route']) ? route($item['route']) : '#' }}" class="flex items-center space-x-3 rounded-xl transition-all duration-150 group
                                          {{ $isSubItem ? 'pl-7 pr-3 py-2' : 'px-3 py-2.5' }}
                                          {{ $active
                                              ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/40'
                                              : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            @if($isSubItem && !$active)
                            <span class="w-1 h-1 rounded-full bg-slate-600 flex-shrink-0"></span>
                            @endif
                            <i
                                class="hgi-stroke {{ $item['icon'] }} text-sm flex-shrink-0
                                               {{ $active ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"></i>
                            <span class="text-xs font-semibold tracking-tight">{{ $item['name'] }}</span>
                            @if($active)
                            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/50 flex-shrink-0"></span>
                            @endif
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </nav>

        </aside>

        <!-- Main Area -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <header
                class="h-16 bg-white border-b border-slate-200 px-4 lg:px-6 flex items-center justify-between flex-shrink-0 z-20">
                <div class="flex items-center space-x-3">
                    <!-- Mobile menu toggle -->
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-all active:scale-95">
                        <i class="hgi-stroke hgi-menu-01 text-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-sm font-bold text-slate-900 leading-none">@yield('page_title', 'Dashboard')</h1>
                        <p class="text-[10px] text-slate-400 font-medium mt-0.5 hidden sm:block">{{
                            \Carbon\Carbon::now()->format('l, d F Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open"
                            class="relative w-9 h-9 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-all active:scale-95">
                            <i class="hgi-stroke hgi-notification-03 text-base"></i>
                            @if($unreadCount > 0)
                            <span
                                class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
                            @endif
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden origin-top-right">
                            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                                <div class="flex items-center space-x-2">
                                    <p class="text-xs font-bold text-slate-900">Notifications</p>
                                    @if($unreadCount > 0)<span
                                        class="px-1.5 py-0.5 bg-indigo-600 text-white rounded-full text-[9px] font-bold">{{
                                        $unreadCount }}</span>@endif
                                </div>
                                @if($unreadCount > 0)
                                <form action="{{ route('notifications.readAll') }}" method="POST">
                                    @csrf
                                    <button class="text-[10px] font-semibold text-indigo-600 hover:text-indigo-800">Mark
                                        all read</button>
                                </form>
                                @endif
                            </div>
                            <div class="max-h-72 overflow-y-auto divide-y divide-slate-50">
                                @forelse(Auth::user()->notifications()->latest()->take(8)->get() as $notif)
                                <div class="flex items-start space-x-3 px-4 py-3 {{ $notif->read_at ? '' : 'bg-indigo-50/60' }} hover:bg-slate-50 transition-colors cursor-pointer"
                                    data-notif="{{ json_encode(['id' => $notif->id, 'title' => $notif->data['title'], 'message' => $notif->data['message'], 'icon' => $notif->data['icon'] ?? 'hgi-notification-03', 'time' => $notif->created_at->diffForHumans(), 'isRead' => (bool)$notif->read_at, 'readUrl' => route('notifications.read', $notif->id)]) }}"
                                    @click="$dispatch('open-notification', JSON.parse($el.dataset.notif)); open = false">
                                    <div
                                        class="w-8 h-8 rounded-xl {{ $notif->read_at ? 'bg-slate-100 text-slate-400' : 'bg-indigo-100 text-indigo-600' }} flex items-center justify-center shrink-0 mt-0.5">
                                        <i
                                            class="hgi-stroke {{ $notif->data['icon'] ?? 'hgi-notification-03' }} text-sm"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-slate-900">{{ $notif->data['title'] }}</p>
                                        <p class="text-[10px] text-slate-500 mt-0.5 leading-relaxed">{{
                                            $notif->data['message'] }}</p>
                                        <p class="text-[9px] text-slate-400 mt-1">{{ $notif->created_at->diffForHumans()
                                            }}</p>
                                    </div>
                                    @if(!$notif->read_at)
                                    <span class="w-2 h-2 bg-indigo-500 rounded-full mt-2 block shrink-0"></span>
                                    @endif
                                </div>
                                @empty
                                <div class="py-10 text-center">
                                    <i
                                        class="hgi-stroke hgi-notification-off-01 text-3xl text-slate-200 block mb-2"></i>
                                    <p class="text-xs text-slate-400 font-medium">You're all caught up!</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="w-px h-6 bg-slate-200"></div>

                    <div class="relative" x-data="{ open: false }">
                        <button type="button" @click="open = !open"
                            class="flex items-center space-x-2.5 px-3 py-2 rounded-xl hover:bg-slate-100 transition-all active:scale-95">
                            <div
                                class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-xs font-semibold text-slate-900 leading-none">{{ Auth::user()->name }}
                                </p>
                                <p class="text-[9px] text-indigo-600 font-semibold uppercase tracking-widest mt-0.5">
                                    Staff</p>
                            </div>
                            <i class="hgi-stroke hgi-arrow-down-01 text-[10px] text-slate-400 hidden sm:block"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50 origin-top-right">
                            <a href="{{ route('staff.profile') }}"
                                class="flex items-center space-x-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                                <i class="hgi-stroke hgi-user-edit-01 text-base"></i>
                                <span class="font-medium">Edit Profile</span>
                            </a>
                            <div class="my-1.5 border-t border-slate-100"></div>
                            <form id="staff-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf</form>
                            <button type="button"
                                @click="$dispatch('open-confirm', {type: 'signout', title: 'Sign Out', message: 'Are you sure you want to sign out of the Staff Portal?', formId: 'staff-logout-form'})"
                                class="w-full flex items-center space-x-2.5 px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                <i class="hgi-stroke hgi-logout-01 text-base"></i>
                                <span class="font-medium">Sign Out</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto bg-slate-100">
                @if(session('success'))
                <div
                    class="mx-6 mt-4 flex items-center space-x-3 px-4 py-3 bg-green-50 border border-green-200 rounded-xl text-green-700 animate__animated animate__fadeInDown animate__faster">
                    <i class="hgi-stroke hgi-checkmark-circle-02 text-lg flex-shrink-0"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                @endif
                @if(session('error'))
                <div
                    class="mx-6 mt-4 flex items-center space-x-3 px-4 py-3 bg-red-50 border border-red-200 rounded-xl text-red-700 animate__animated animate__fadeInDown animate__faster">
                    <i class="hgi-stroke hgi-alert-circle text-lg flex-shrink-0"></i>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                @endif
                <div class="p-6 animate__animated animate__fadeInUp animate__faster">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    @yield('scripts')
    @stack('scripts')

    <!-- Notification Detail Modal -->
    <div x-data="notificationModal()" @open-notification.window="openModal($event.detail)" x-cloak>
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] flex items-center justify-center p-4"
            @click.self="close()">
            <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-2xl shadow-slate-900/20 w-full max-w-sm overflow-hidden">
                <div class="px-6 pt-6 pb-4 text-center">
                    <div class="mx-auto mb-4 w-14 h-14 rounded-2xl flex items-center justify-center"
                        :class="isRead ? 'bg-slate-100' : 'bg-indigo-50'">
                        <i class="text-2xl hgi-stroke"
                            :class="`${icon} ${isRead ? 'text-slate-400' : 'text-indigo-600'}`"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900" x-text="title"></h3>
                    <p class="text-sm text-slate-500 mt-2 leading-relaxed" x-text="message"></p>
                    <p class="text-[10px] text-slate-400 mt-3" x-text="time"></p>
                </div>
                <div class="border-t border-slate-100"></div>
                <div class="flex">
                    <button @click="close()"
                        class="flex-1 px-4 py-3.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors"
                        :class="!isRead ? 'border-r border-slate-100' : ''">
                        Close
                    </button>
                    <form x-show="!isRead" :action="readUrl" method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-3.5 text-sm font-bold text-indigo-600 hover:bg-indigo-50 transition-colors">
                            Mark as Read
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Confirmation Modal -->
    <div x-data="confirmModal()" @open-confirm.window="openModal($event.detail)" x-cloak>
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[200] flex items-center justify-center p-4"
            @click.self="cancel()">
            <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-2xl shadow-slate-900/20 w-full max-w-sm overflow-hidden">
                <div class="px-6 pt-6 pb-4 text-center">
                    <div class="mx-auto mb-4 flex items-center justify-center w-14 h-14 rounded-2xl"
                        :class="type === 'delete' ? 'bg-red-50' : 'bg-amber-50'">
                        <i class="text-2xl hgi-stroke"
                            :class="type === 'delete' ? 'hgi-delete-02 text-red-500' : 'hgi-logout-01 text-amber-500'"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900" x-text="title"></h3>
                    <p class="text-sm text-slate-500 mt-1.5 leading-relaxed" x-text="message"></p>
                </div>
                <div class="border-t border-slate-100"></div>
                <div class="flex">
                    <button @click="cancel()"
                        class="flex-1 px-4 py-3.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors border-r border-slate-100">
                        Cancel
                    </button>
                    <button @click="confirm()" class="flex-1 px-4 py-3.5 text-sm font-bold transition-colors"
                        :class="type === 'delete' ? 'text-red-600 hover:bg-red-50' : 'text-amber-600 hover:bg-amber-50'">
                        <span x-text="type === 'delete' ? 'Delete' : 'Sign Out'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ╔══════════════════════════════════════════╗ -->
    <!-- ║  Force Password Change Modal             ║ -->
    <!-- ╚══════════════════════════════════════════╝ -->
    @auth
    @if(auth()->user()->must_change_password || auth()->user()->isPasswordExpired())
    <style>
        header,
        aside,
        [x-data*="open"] button,
        [x-data*="notif"] {
            pointer-events: none !important;
        }
    </style>
    <div x-data="{ showError: false, errorMsg: '', showSuccess: false }"
        class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-4"
        style="z-index: 9999; pointer-events: all;">

        <div x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="bg-white rounded-2xl shadow-2xl shadow-slate-900/20 w-full max-w-sm overflow-hidden">

            <div class="px-6 pt-6 pb-4 text-center">
                <div class="mx-auto mb-4 flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-50">
                    <i class="text-2xl hgi-stroke hgi-lock-password text-indigo-600"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Change Your Password</h3>
                <p class="text-sm text-slate-500 mt-1.5 leading-relaxed">
                    @if(auth()->user()->must_change_password)
                    Your account is using a default or admin-reset password. Please set a new password to continue.
                    @else
                    Your password has expired (last changed {{ auth()->user()->password_changed_at->diffForHumans() }}).
                    Please set a new password to continue.
                    @endif
                </p>
            </div>

            <div class="border-t border-slate-100"></div>

            <form method="POST" action="{{ route('password.change') }}" @submit.prevent="
                    showError = false;
                    const fd = new FormData($el);
                    fetch($el.action, { method:'POST', body: fd, headers:{'X-Requested-With':'XMLHttpRequest'} })
                      .then(r => r.json())
                      .then(d => {
                        if (d.success) { showSuccess = true; setTimeout(() => window.location.reload(), 1200); }
                        else { showError = true; errorMsg = d.message || 'Please check your input.'; }
                      })
                      .catch(() => { showError = true; errorMsg = 'Something went wrong. Please try again.'; })
                  ">
                @csrf
                <div class="px-6 py-4 space-y-4">
                    <div x-show="showSuccess"
                        class="flex items-center space-x-2 bg-green-50 border border-green-100 rounded-xl px-4 py-3">
                        <i class="hgi-stroke hgi-checkmark-circle-02 text-green-500 text-sm"></i>
                        <p class="text-xs font-semibold text-green-700">Password changed successfully! Reloading…</p>
                    </div>
                    <div x-show="showError"
                        class="flex items-center space-x-2 bg-red-50 border border-red-100 rounded-xl px-4 py-3">
                        <i class="hgi-stroke hgi-alert-02 text-red-500 text-sm"></i>
                        <p class="text-xs font-semibold text-red-700" x-text="errorMsg"></p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">New
                            Password</label>
                        <input type="password" name="password" required minlength="8"
                            class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            placeholder="Min. 8 characters">
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Confirm
                            Password</label>
                        <input type="password" name="password_confirmation" required minlength="8"
                            class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all"
                            placeholder="Repeat new password">
                    </div>
                </div>
                <div class="border-t border-slate-100"></div>
                <div class="flex">
                    <button type="submit"
                        class="flex-1 px-4 py-3.5 text-sm font-bold text-indigo-600 hover:bg-indigo-50 transition-colors">
                        Set New Password
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
    @endauth

    <script>
        window.openConfirmModal = function (type, title, message, formId) {
            window.dispatchEvent(new CustomEvent('open-confirm', {
                detail: { type, title, message, formId }
            }));
        };

        function notificationModal() {
            return {
                isOpen: false,
                id: '',
                title: '',
                message: '',
                icon: '',
                time: '',
                isRead: false,
                readUrl: '',
                openModal(detail) {
                    this.id = detail.id || '';
                    this.title = detail.title || '';
                    this.message = detail.message || '';
                    this.icon = detail.icon || 'hgi-notification-03';
                    this.time = detail.time || '';
                    this.isRead = detail.isRead || false;
                    this.readUrl = detail.readUrl || '';
                    this.isOpen = true;
                },
                close() {
                    this.isOpen = false;
                }
            }
        }

        function confirmModal() {
            return {
                isOpen: false,
                type: 'delete',
                title: '',
                message: '',
                formId: '',
                openModal(detail) {
                    this.type = detail.type || 'delete';
                    this.title = detail.title || 'Are you sure?';
                    this.message = detail.message || 'This action cannot be undone.';
                    this.formId = detail.formId || '';
                    this.isOpen = true;
                },
                confirm() {
                    if (this.formId) {
                        document.getElementById(this.formId).submit();
                    }
                    this.isOpen = false;
                },
                cancel() {
                    this.isOpen = false;
                }
            }
        }
    </script>
</body>

</html>