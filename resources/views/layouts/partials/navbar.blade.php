<nav class="bg-white shadow-lg z-50 sticky top-0" x-data="{ open: false, notificationOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between items-center">
            <!-- Logo / Brand -->
            <div class="flex items-center space-x-3 transition-transform duration-300 transform hover:scale-105">
                <a href="/" class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-yellow-400 flex items-center justify-center text-green-900 font-extrabold text-lg">F</div>
                    <span class="text-xl font-bold tracking-wide text-green-900">FUTO-SkillUP</span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden sm:flex items-center space-x-6 text-green-900 font-semibold">
                @guest
                    <a href="{{ route('login') }}"
                       class="hover:text-yellow-400 transition-colors duration-300">Login</a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 bg-yellow-400 text-green-900 rounded-lg shadow-md hover:bg-yellow-300 hover:shadow-lg transition-all duration-300">
                        Register
                    </a>
                @endguest

                @auth
                    @if (auth()->user()->role === \App\Enums\Role::ADMIN)
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-400 transition-colors duration-300">Admin Dashboard</a>
                    @elseif (auth()->user()->role === \App\Enums\Role::INSTRUCTOR)
                        <a href="{{ route('instructor.dashboard') }}" class="hover:text-yellow-400 transition-colors duration-300">Instructor Dashboard</a>
                    @else
                        <a href="{{ route('student.dashboard') }}" class="hover:text-yellow-400 transition-colors duration-300">My Courses</a>
                    @endif

                    <!-- Notification Bell -->
                    @if (auth()->user()->role->value === 'instructor')
                        <div class="relative">
                            <button @click="notificationOpen = !notificationOpen" class="relative focus:outline-none p-2 rounded-full hover:bg-gray-100 transition-colors duration-300">
                                <svg class="h-6 w-6 text-green-900 hover:text-yellow-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                                @if($unreadNotifications->isNotEmpty())
                                    <span class="absolute top-0 right-0 block h-2 w-2 rounded-full ring-2 ring-white bg-yellow-400 animate-ping-once"></span>
                                @endif
                            </button>

                            <div x-show="notificationOpen" @click.away="notificationOpen = false"
                                 class="absolute right-0 mt-3 w-72 max-h-80 overflow-y-auto bg-white text-green-900 rounded-xl shadow-2xl border border-gray-100 transform origin-top-right transition-all duration-300"
                                 x-transition:enter="ease-out"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="ease-in"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 style="display: none;">
                                <div class="px-4 py-3 font-bold border-b border-gray-200 sticky top-0 bg-white">Notifications</div>
                                @forelse ($unreadNotifications as $notification)
                                    <a href="{{ route('notifications.read', $notification) }}"
                                       class="block px-4 py-3 text-sm hover:bg-green-50 transition-colors duration-200">
                                        <p class="font-medium leading-snug">{{ $notification->data['message'] }}</p>
                                        <p class="mt-1 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                    </a>
                                @empty
                                    <p class="px-4 py-4 text-sm text-center text-gray-500">No new notifications.</p>
                                @endforelse
                            </div>
                        </div>
                    @endif

                    <!-- Profile -->
                    <div class="ml-4 flex items-center space-x-4">
                        <a href="{{ route('profile.edit') }}" class="hover:text-yellow-400 transition-colors duration-300">Hi, {{ auth()->user()->name }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:text-yellow-400 transition-colors duration-300">Logout</button>
                        </form>
                    </div>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-green-900 hover:bg-green-100 focus:outline-none transition-colors duration-300">
                    <svg :class="{ 'hidden': open, 'block': !open }" class="block h-6 w-6" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg :class="{ 'block': open, 'hidden': !open }" class="hidden h-6 w-6" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open"
         class="sm:hidden bg-green-900 text-white shadow-inner"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         style="display: none;">
        <div class="space-y-2 px-4 py-4 font-semibold">
            @guest
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">Login</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">Register</a>
            @endguest
            @auth
                @if (auth()->user()->role === \App\Enums\Role::ADMIN)
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">Admin Dashboard</a>
                @elseif (auth()->user()->role === \App\Enums\Role::INSTRUCTOR)
                    <a href="{{ route('instructor.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">Instructor Dashboard</a>
                @else
                    <a href="{{ route('student.dashboard') }}" class="block px-3 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">My Courses</a>
                @endif
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">Hi, {{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md hover:bg-green-700 transition-colors duration-200">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<style>
/* Custom animations for a more polished look */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn { animation: fadeIn 0.3s ease-in-out; }

/* The original ping is a bit aggressive. This one runs once. */
@keyframes ping-once {
    0% { transform: scale(0.9); opacity: 0; }
    50% { transform: scale(1.1); opacity: 1; }
    100% { transform: scale(1); opacity: 0; }
}
.animate-ping-once { animation: ping-once 1.2s cubic-bezier(0, 0, 0.2, 1) forwards; }
</style>
