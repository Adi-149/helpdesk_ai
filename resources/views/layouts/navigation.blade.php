<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-white border-b border-gray-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2">
                    <div>
                        <a href="{{ route('dashboard') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        </a>
                    </div>
                    <div class="hidden sm:block">
                        <a href="{{ route('dashboard') }}" class="text-lg font-bold text-gray-800 hover:text-blue-600 transition duration-150">
                            HelpDesk
                        </a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Kelola Pengguna') }}
                        </x-nav-link>
                        <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index', 'tickets.create', 'tickets.show')">
                            {{ __('Tiket') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                            {{ __('Laporan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.knowledge-base.index')" :active="request()->routeIs('admin.knowledge-base.*')">
                            {{ __('Knowledge Base') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dasbor') }}
                        </x-nav-link>
                        
                        @if(auth()->user()->role === 'support')
                            <x-nav-link :href="route('support.tickets')" :active="request()->routeIs('support.tickets')">
                                {{ __('Tiket') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index', 'tickets.create', 'tickets.show')">
                                {{ __('Tiket') }}
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Notifications Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-3">
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false" id="notification-dropdown-container">
                    <button @click="open = ! open" class="relative p-2 rounded-full text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <!-- Unread Count Badge -->
                        <span id="nav-notification-badge" class="absolute top-1.5 right-1.5 hidden min-w-[18px] h-[18px] px-1 bg-red-600 border border-white rounded-full text-[10px] font-bold text-white flex items-center justify-center">0</span>
                    </button>

                    <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-80 rounded-md shadow-lg ltr:origin-top-right rtl:origin-top-left z-50 bg-white border border-gray-200 overflow-hidden"
                            style="display: none;">
                        <div class="px-4 py-2 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                            <span class="text-xs font-semibold text-gray-800">Notifikasi</span>
                            <button onclick="markAllNotificationsAsRead(event)" class="text-[10px] text-blue-600 hover:text-blue-800 font-medium bg-transparent border-0 cursor-pointer">Tandai semua dibaca</button>
                        </div>
                        
                        <!-- Notification List (AJAX Filled) -->
                        <div id="nav-notification-list" class="max-h-64 overflow-y-auto divide-y divide-gray-100">
                            <div class="p-4 text-center text-xs text-gray-500">Memuat notifikasi...</div>
                        </div>

                        <a href="{{ route('notifications.index') }}" class="block py-2 text-center text-xs font-semibold text-blue-600 hover:text-blue-800 border-t border-gray-200 bg-gray-50 transition duration-150">
                            Lihat Semua Notifikasi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Kelola Pengguna') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index', 'tickets.create', 'tickets.show')">
                    {{ __('Tiket') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.reports')" :active="request()->routeIs('admin.reports')">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.knowledge-base.index')" :active="request()->routeIs('admin.knowledge-base.*')">
                    {{ __('Knowledge Base') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dasbor') }}
                </x-responsive-nav-link>
                
                @if(auth()->user()->role === 'support')
                    <x-responsive-nav-link :href="route('support.tickets')" :active="request()->routeIs('support.tickets')">
                        {{ __('Tiket') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index', 'tickets.create', 'tickets.show')">
                        {{ __('Tiket') }}
                    </x-responsive-nav-link>
                @endif
            @endif

            <!-- Mobile Notification Link -->
            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')">
                <span class="flex items-center justify-between">
                    <span>{{ __('Notifikasi') }}</span>
                    <span id="mobile-notification-badge" class="hidden min-w-[18px] h-[18px] px-1 bg-red-600 rounded-full text-[10px] font-bold text-white flex items-center justify-center">0</span>
                </span>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    // AJAX Polling for Notifications
    document.addEventListener('DOMContentLoaded', function() {
        const desktopBadge = document.getElementById('nav-notification-badge');
        const mobileBadge = document.getElementById('mobile-notification-badge');
        const notificationList = document.getElementById('nav-notification-list');
        // Request Notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }

        async function fetchNotifications() {
            try {
                const response = await fetch('{{ route('notifications.unread') }}', {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!response.ok) return;

                const data = await response.json();

                // Native Browser Notifications
                if ('Notification' in window && Notification.permission === 'granted') {
                    let storedNotifiedIds = [];
                    const isFirstRun = localStorage.getItem('notified_ids') === null;
                    try {
                        storedNotifiedIds = JSON.parse(localStorage.getItem('notified_ids') || '[]');
                    } catch(e) {}

                    let currentIds = [];
                    data.notifications.forEach(notif => {
                        currentIds.push(notif.id);
                        if (!isFirstRun && !storedNotifiedIds.includes(notif.id)) {
                            const message = notif.data.message || 'Ada notifikasi baru';
                            const browserNotification = new Notification('Helpdesk AI', {
                                body: message,
                                tag: notif.id
                            });
                            browserNotification.onclick = function() {
                                window.focus();
                                window.location.href = `/notifications/${notif.id}/click`;
                            };
                        }
                    });
                    localStorage.setItem('notified_ids', JSON.stringify(currentIds));
                }

                updateNotificationBadge(data.unread_count);
                updateNotificationList(data.notifications);
            } catch (error) {
                console.error('Error fetching notifications:', error);
            }
        }

        function updateNotificationBadge(count) {
            if (count > 0) {
                if (desktopBadge) {
                    desktopBadge.textContent = count;
                    desktopBadge.classList.remove('hidden');
                    desktopBadge.classList.add('flex');
                }
                if (mobileBadge) {
                    mobileBadge.textContent = count;
                    mobileBadge.classList.remove('hidden');
                    mobileBadge.classList.add('flex');
                }
            } else {
                if (desktopBadge) {
                    desktopBadge.classList.add('hidden');
                    desktopBadge.classList.remove('flex');
                }
                if (mobileBadge) {
                    mobileBadge.classList.add('hidden');
                    mobileBadge.classList.remove('flex');
                }
            }
        }

        function updateNotificationList(notifications) {
            if (!notificationList) return;

            if (notifications.length === 0) {
                notificationList.innerHTML = `
                    <div class="p-4 text-center text-xs text-gray-500">
                        Tidak ada notifikasi baru
                    </div>
                `;
                return;
            }

            notificationList.innerHTML = '';
            notifications.forEach(notif => {
                const clickUrl = `/notifications/${notif.id}/click`;
                
                const item = document.createElement('div');
                item.className = 'relative hover:bg-gray-50 transition duration-150';
                
                item.innerHTML = `
                    <div class="flex items-start p-3 gap-3">
                        <div class="flex-1 min-w-0">
                            <a href="${clickUrl}" class="block text-[11px] text-gray-700 leading-tight">
                                <span class="font-medium text-gray-900">${notif.data.message || ''}</span>
                            </a>
                            <span class="text-[9px] text-gray-400 mt-1 block">${notif.created_at}</span>
                        </div>
                        <button onclick="markAsRead(event, '${notif.id}')" class="text-gray-400 hover:text-gray-600 focus:outline-none self-center" title="Tandai telah dibaca">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>
                    </div>
                `;
                notificationList.appendChild(item);
            });
        }

        window.markAsRead = async function(event, notifId) {
            event.preventDefault();
            event.stopPropagation();
            try {
                const response = await fetch(`/notifications/${notifId}/read`, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (response.ok) {
                    fetchNotifications();
                }
            } catch (error) {
                console.error('Error marking notification as read:', error);
            }
        };

        window.markAllNotificationsAsRead = async function(event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            try {
                const response = await fetch('{{ route('notifications.mark-all-read') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (response.ok) {
                    fetchNotifications();
                }
            } catch (error) {
                console.error('Error marking all notifications as read:', error);
            }
        };

        // Run immediately on page load
        fetchNotifications();

        // Poll every 10 seconds
        pollingInterval = setInterval(fetchNotifications, 10000);
    });
</script>
