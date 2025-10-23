@extends('layouts.app')

@section('content')

{{-- Determine the time to display in the datetime-local input --}}
@php
    $displayTime = '';
    if (isset($liveSession)) {
        // TIMEZONE CORRECTION REMOVED: Since APP_TIMEZONE is correctly configured (e.g., Europe/Amsterdam)
        // and the controller saves UTC, accessing $liveSession->start_time automatically converts
        // the UTC time to the correct local application timezone. No manual offset is needed here.
        $displayTime = $liveSession->start_time->format('Y-m-d\TH:i');
    }
@endphp

<div class="py-12 bg-gray-50 px-4">
    <div class="max-w-4xl mx-auto space-y-8">
        <h1 class="text-3xl font-bold">
            Schedule Live Session for {{ $course->title }}
        </h1>

        @if (session('error'))
            <div class="bg-red-100 border border-red-500 text-red-700 p-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white shadow-lg rounded-xl p-8">
            {{-- ACTION: Use update route if $liveSession exists, store route otherwise --}}
            <form
                action="{{ isset($liveSession) ? route('instructor.live-sessions.update', $liveSession) : route('instructor.live-sessions.store') }}"
                method="POST">
                @csrf
                
                {{-- METHOD: Use PUT for updates --}}
                @if (isset($liveSession))
                    @method('PUT')
                @endif
                
                {{-- Hidden Course ID for creation --}}
                <input type="hidden" name="course_id" value="{{ $course->id }}">

                <div class="space-y-6">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Session
                            Title</label>
                        <input type="text" name="title" id="title" required
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                            value="{{ old('title', $liveSession->title ?? '') }}"
                            placeholder="Live Q&A on Project Setup">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Start Time --}}
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700">Scheduled Start
                            Time</label>
                        <input type="datetime-local" name="start_time" id="start_time" required
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                            {{-- $displayTime is now the correctly localized time --}}
                            value="{{ old('start_time', $displayTime) }}">
                        @error('start_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Duration --}}
                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Duration
                            (Minutes)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" required
                            min="10" max="180"
                            class="mt-1 block w-full border border-gray-300 rounded-md p-2"
                            value="{{ old('duration_minutes', $liveSession->duration_minutes ?? 60) }}">
                        @error('duration_minutes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-green-700 text-white font-medium rounded-md hover:bg-green-600 transition">
                        {{ isset($liveSession) ? 'Update Session' : 'Schedule Session' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
