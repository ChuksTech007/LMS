@extends('layouts.app')

@section('title', 'Live Sessions Management')

@section('content')
    <div class="py-12 bg-gray-50 px-4 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <h1 class="text-3xl font-extrabold text-green-900">
                📺 My Live Sessions Schedule
            </h1>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md" role="alert">
                    <p>{{ session('error') }}</p>
                </div>
            @endif


            @forelse ($courses as $course)
                <div class="bg-white shadow-xl rounded-xl p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-3">
                        <h2 class="text-xl font-bold text-gray-800">{{ $course->title }}</h2>
                        <a href="{{ route('instructor.live-sessions.create', $course) }}"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-800 hover:bg-green-700 transition">
                            + Schedule New Session
                        </a>
                    </div>

                    {{-- CHECK FOR EXISTING SESSIONS AND DISPLAY THEM --}}
                    @if ($course->liveSessions->isNotEmpty())
                        <div class="space-y-4">
                            @foreach ($course->liveSessions->sortBy('start_time') as $session)
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg border">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-lg font-semibold text-gray-900 truncate">{{ $session->title }}</p>

                                        @php
                                            // TIMEZONE CORRECTION REMOVED: Since APP_TIMEZONE is set, accessing
                                            // $session->start_time automatically converts the UTC time from the database
                                            // into the local time (Europe/Amsterdam). No manual offset needed!
                                            $userTime = $session->start_time;
                                            $endTime = $userTime->copy()->addMinutes($session->duration_minutes);
                                            // Carbon::now() also uses the configured APP_TIMEZONE
                                            $now = \Carbon\Carbon::now();

                                            // 2. Define the active window (60 minutes before start up to end time)
                                            $startTimeWithBuffer = $userTime->copy()->subMinutes(60);

                                            if ($now->lessThan($startTimeWithBuffer)) {
                                                // Before the 60 minute buffer starts
                                                $status = 'Not Time Yet';
                                                $isJoinable = false;
                                            } elseif (
                                                $now->greaterThanOrEqualTo($startTimeWithBuffer) &&
                                                $now->lessThan($endTime)
                                            ) {
                                                // Within the active window
                                                $status = 'Launch Jitsi Meet';
                                                $isJoinable = true;
                                            } else {
                                                // After the session ends
                                                $status = 'Session Ended';
                                                $isJoinable = false;
                                            }
                                        @endphp

                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium">Starts:</span>
                                            {{ $userTime->format('M d, Y @ h:i A') }}
                                            ({{ $userTime->diffForHumans() }})
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            Duration: {{ $session->duration_minutes }} minutes
                                        </p>
                                    </div>
                                    <div class="ml-4 flex space-x-2">

                                        <a href="{{ route('instructor.live-sessions.join', $session) }}" target="_blank"
                                            class="px-4 py-2 text-sm font-medium rounded-md transition 
    {{ $isJoinable ? 'bg-red-600 text-white hover:bg-red-700' : ($status === 'Session Ended' ? 'bg-gray-500 text-white' : 'bg-gray-400 text-gray-700') }}
    cursor-not-allowed pointer-events-none {{ $isJoinable ? '!cursor-pointer !pointer-events-auto' : '' }}">
                                            {{ $status }}
                                        </a>

                                        <a href="{{ route('instructor.live-sessions.edit', $session) }}"
                                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-yellow-400 rounded-md hover:bg-yellow-500 transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('instructor.live-sessions.destroy', $session) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to cancel this session?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md hover:bg-red-600 transition">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- MESSAGE FOR COURSES WITH NO SESSIONS --}}
                        <div class="p-4 text-center text-gray-500 bg-gray-50 rounded-lg">
                            No live sessions scheduled for this course yet.
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-6 bg-white rounded-xl shadow-lg text-center text-gray-600">
                    You do not have any courses assigned to you.
                </div>
            @endforelse
        </div>
    </div>

@endsection
