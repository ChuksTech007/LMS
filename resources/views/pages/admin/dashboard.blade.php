@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-12 bg-gray-50 px-4 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

        {{-- Welcome and Greeting --}}
        <div class="bg-white rounded-xl shadow-lg p-8 animate-fade-in-down">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-green-900">
                Welcome, Admin!
            </h2>
            <p class="mt-2 text-md text-gray-600">This is a beautiful new summary of the School platform.</p>
        </div>

        {{-- Pending Payments Alert --}}
        @php
            $pendingPaymentsCount = \App\Models\Payment::where('status', 'pending')->count();
        @endphp

        @if($pendingPaymentsCount > 0)
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-lg animate-fade-in-down">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-yellow-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-900">
                                {{ $pendingPaymentsCount }} Payment{{ $pendingPaymentsCount > 1 ? 's' : '' }} Awaiting Verification
                            </h3>
                            <p class="text-yellow-700">Review and verify student payments to enroll them in courses.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}"
                       class="bg-yellow-400 text-green-900 px-6 py-2 rounded-lg font-semibold hover:bg-yellow-500 transition duration-200">
                        Review Now
                    </a>
                </div>
            </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
            {{-- Total Students Card --}}
            <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-1">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-500">Total Students</h3>
                        <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-extrabold text-green-900">{{ $stats['total_students'] }}</div>
                </div>
            </div>

            {{-- Total Instructors Card --}}
            <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-500">Total Instructors</h3>
                        <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-extrabold text-green-900">{{ $stats['total_instructors'] }}</div>
                </div>
            </div>

            {{-- Total Courses Card --}}
            <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-3">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-500">Total Courses</h3>
                        <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-extrabold text-green-900">{{ $stats['total_courses'] }}</div>
                </div>
            </div>

            {{-- Total Enrollments Card --}}
            <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-4">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-500">Total Enrollments</h3>
                        <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-extrabold text-green-900">{{ $stats['total_enrollments'] }}</div>
                </div>
            </div>
        </div>

        {{-- Second Row Stats - Payments --}}
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Pending Payments Card --}}
            <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-1">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-500">Pending Payments</h3>
                        <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-extrabold text-green-900">{{ $pendingPaymentsCount }}</div>
                </div>
            </div>

            {{-- Verified Payments Card --}}
            <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-2">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-500">Verified Payments</h3>
                        <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-extrabold text-green-900">{{ \App\Models\Payment::where('status', 'verified')->count() }}</div>
                </div>
            </div>

            {{-- Total Revenue Card --}}
            <div class="bg-white rounded-xl shadow-xl border-b-4 border-yellow-400 overflow-hidden transition-all duration-300 transform hover:scale-[1.02] hover:shadow-2xl animate-fade-in-left-delay-3">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-500">Total Revenue</h3>
                        <div class="flex-shrink-0 p-2 rounded-full bg-yellow-400 text-green-900">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="text-4xl font-extrabold text-green-900">
                        ₦{{ number_format(\App\Models\Payment::where('status', 'verified')->sum('amount'), 2) }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-xl p-8 animate-fade-in-up">
            <h3 class="text-2xl font-bold text-green-900">Quick Actions</h3>
            <p class="mt-1 text-sm text-gray-600">Easily manage your courses, users, and payments with these quick links.</p>
            <div class="mt-6 flex flex-wrap gap-4">
                <a href="{{ route('admin.users.index') }}"
                   class="rounded-md bg-green-900 px-6 py-3 text-sm font-semibold text-white shadow-md
                          hover:bg-green-800 hover:scale-[1.05] transition-all duration-200 ease-in-out">
                    Manage Users & Roles
                </a>
                <a href="{{ route('admin.courses.index') }}"
                   class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300
                          hover:bg-gray-50 hover:scale-[1.05] transition-all duration-200 ease-in-out">
                    Manage All Courses
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="rounded-md bg-white px-6 py-3 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300
                          hover:bg-gray-50 hover:scale-[1.05] transition-all duration-200 ease-in-out">
                    Manage Course Categories
                </a>
                <a href="{{ route('admin.payments.index') }}"
                   class="rounded-md bg-yellow-400 px-6 py-3 text-sm font-semibold text-green-900 shadow-md
                          hover:bg-yellow-500 hover:scale-[1.05] transition-all duration-200 ease-in-out">
                    Manage Payments
                    @if($pendingPaymentsCount > 0)
                        <span class="ml-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs">{{ $pendingPaymentsCount }}</span>
                    @endif
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.8s ease-out forwards;
    }
    .animate-fade-in-left-delay-1 { animation: fadeInLeft 0.8s ease-out 0.2s forwards; opacity: 0; }
    .animate-fade-in-left-delay-2 { animation: fadeInLeft 0.8s ease-out 0.4s forwards; opacity: 0; }
    .animate-fade-in-left-delay-3 { animation: fadeInLeft 0.8s ease-out 0.6s forwards; opacity: 0; }
    .animate-fade-in-left-delay-4 { animation: fadeInLeft 0.8s ease-out 0.8s forwards; opacity: 0; }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out 1s forwards; opacity: 0;
    }
</style>
@endsection