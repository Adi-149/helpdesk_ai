<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifikasi') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 rounded bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/50 dark:border-green-800 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <!-- Tabs & Actions Header -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-gray-200 dark:border-gray-700 px-6 py-4 gap-4 bg-gray-50 dark:bg-gray-900/50">
                <div class="flex space-x-4">
                    <a href="{{ route('notifications.index', ['tab' => 'all']) }}" 
                       class="text-sm font-semibold pb-1 border-b-2 transition duration-150 {{ $tab === 'all' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                        Semua
                    </a>
                    <a href="{{ route('notifications.index', ['tab' => 'unread']) }}" 
                       class="text-sm font-semibold pb-1 border-b-2 transition duration-150 relative {{ $tab === 'unread' ? 'text-indigo-600 border-indigo-600 dark:text-indigo-400 dark:border-indigo-400' : 'text-gray-500 border-transparent hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                        Belum Dibaca
                        @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
                        @if($unreadCount > 0)
                            <span class="absolute -top-2 -right-6 inline-flex items-center justify-center px-1.5 py-0.5 text-[10px] font-bold leading-none text-white bg-red-600 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>

                @if($unreadCount > 0)
                    <form method="POST" action="{{ route('notifications.mark-all-read') }}" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-xs font-semibold rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                            Tandai Semua Dibaca
                        </button>
                    </form>
                @endif
            </div>

            <!-- List Content -->
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($notifications as $notif)
                    @php $isUnread = is_null($notif->read_at); @endphp
                    <div class="p-6 transition duration-150 flex items-start justify-between gap-4 {{ $isUnread ? 'bg-indigo-50/40 dark:bg-indigo-950/20' : 'hover:bg-gray-50/50 dark:hover:bg-gray-700/30' }}">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <!-- Blue dot indicator for unread -->
                            @if($isUnread)
                                <span class="w-2.5 h-2.5 rounded-full bg-indigo-600 dark:bg-indigo-400 mt-1.5 flex-shrink-0" title="Belum dibaca"></span>
                            @else
                                <span class="w-2.5 h-2.5 rounded-full bg-transparent mt-1.5 flex-shrink-0"></span>
                            @endif

                            <div class="flex-1 min-w-0">
                                <a href="{{ route('notifications.click', $notif->id) }}" class="block group">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-150">
                                        {{ $notif->data['message'] ?? 'Notifikasi baru' }}
                                    </p>
                                    @if(isset($notif->data['subject']))
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                            Tiket: {{ $notif->data['subject'] }}
                                        </p>
                                    @endif
                                </a>
                                <span class="text-xs text-gray-400 dark:text-gray-500 mt-2 block">
                                    {{ $notif->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        @if($isUnread)
                            <form method="POST" action="{{ route('notifications.mark-read', $notif->id) }}" class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="p-1.5 rounded-full text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-150" title="Tandai telah dibaca">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="py-12 px-6 text-center">
                        <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada notifikasi untuk ditampilkan.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Footer -->
            @if($notifications->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
