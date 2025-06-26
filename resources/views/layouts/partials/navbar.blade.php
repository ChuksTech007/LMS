<nav class="bg-white shadow-sm" x-data="{ open: false, notificationOpen: false }">
	<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="flex h-16 justify-between">
			<div class="flex">
				<div class="flex flex-shrink-0 items-center">
					<a href="/" class="text-xl font-bold text-indigo-600">Skoolio</a>
				</div>
			</div>
			<div class="hidden sm:ml-6 sm:flex sm:items-center">
				@guest
					<a href="{{ route('login') }}"
						class="rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
						{{ __('auth.login_button') }}
					</a>
					<a href="{{ route('register') }}"
						class="ml-4 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
						{{ __('auth.register_button') }}
					</a>
				@endguest

				@auth
					@if (auth()->user()->role === \App\Enums\Role::ADMIN)
						<a href="{{ route('admin.dashboard') }}"
							class="rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Admin
							Dashboard</a>
					@elseif (auth()->user()->role === \App\Enums\Role::INSTRUCTOR)
						<a href="{{ route('instructor.dashboard') }}"
							class="rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Instructor
							Dashboard</a>
					@else
						<a href="{{ route('student.dashboard') }}"
							class="rounded-md px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">Kursus Saya</a>
					@endif

					{{-- Notification Bell --}}
					@if (auth()->user()->role->value === 'instructor')
						<div class="relative ml-3">
							<div>
								<button @click="notificationOpen = !notificationOpen" type="button"
									class="relative rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
									<span class="sr-only">View notifications</span>
									<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
										stroke="currentColor">
										<path stroke-linecap="round" stroke-linejoin="round"
											d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
									</svg>
									@if($unreadNotifications->isNotEmpty())
										<span class="absolute -top-1 -right-1 flex h-3 w-3"><span
												class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span
												class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span></span>
									@endif
								</button>
							</div>
							<div x-show="notificationOpen" @click.away="notificationOpen = false"
								class="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
								role="menu" style="display: none;">
								<div class="p-2 border-b text-sm font-semibold">Notifikasi</div>
								@forelse ($unreadNotifications as $notification)
									<a href="{{ route('notifications.read', $notification) }}"
										class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100">
										<p>{{ $notification->data['message'] }}</p>
										<p class="mt-1 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
									</a>
								@empty
									<p class="px-4 py-3 text-sm text-center text-gray-500">Tidak ada notifikasi baru.</p>
								@endforelse
							</div>
						</div>
					@endif

					<div class="ml-4">
						<span class="text-sm text-gray-700">Halo, {{ auth()->user()->name }}</span>
						<form method="POST" action="{{ route('logout') }}" class="inline-block ml-4">@csrf<button
								type="submit" class="text-sm text-gray-900 hover:text-gray-500">Logout</button></form>
					</div>
				@endauth
			</div>
			<div class="-mr-2 flex items-center sm:hidden">
				<button @click="open = !open" type="button"
					class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
					aria-controls="mobile-menu" aria-expanded="false">
					<span class="sr-only">Open main menu</span>
					<svg :class="{ 'hidden': open, 'block': !open }" class="block h-6 w-6" fill="none"
						viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
					</svg>
					<svg :class="{ 'block': open, 'hidden': !open }" class="hidden h-6 w-6" fill="none"
						viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
		</div>
	</div>

	<div x-show="open" class="sm:hidden" id="mobile-menu">
		<div class="space-y-1 pb-3 pt-2">
			@guest
				<a href="{{ route('login') }}"
					class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Login</a>
				<a href="{{ route('register') }}"
					class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Register</a>
			@endguest
			@auth
				<div class="border-t border-gray-200 pb-3 pt-4">
					<div class="flex items-center px-4">
						<div class="ml-3">
							<div class="text-base font-medium text-gray-800">{{ auth()->user()->name }}</div>
							<div class="text-sm font-medium text-gray-500">{{ auth()->user()->email }}</div>
						</div>
					</div>
					<div class="mt-3 space-y-1">
						<form method="POST" action="{{ route('logout') }}">
							@csrf
							<button type="submit"
								class="block w-full text-left border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Logout</button>
						</form>
					</div>
				</div>
			@endauth
		</div>
	</div>
</nav>