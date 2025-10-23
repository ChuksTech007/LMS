@php
$userTime = $liveSession->start_time;

$isAvailable = $userTime->copy()->subMinutes(10)->isPast() && 
               $userTime->copy()->addMinutes($liveSession->duration_minutes)->isFuture();

$courseTitle = $liveSession->course->title;

@endphp

<div class="bg-indigo-100 border-l-4 border-indigo-500 text-indigo-700 p-4 rounded-lg shadow-md flex flex-col sm:flex-row justify-between items-start sm:items-center my-2 transition duration-300 hover:shadow-lg hover:bg-indigo-50">
<div class="mb-3 sm:mb-0">
<h3 class="text-xl font-bold flex items-center">
<svg class="w-6 h-6 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.552-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.448.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
{{ $liveSession->title }}
</h3>
<p class="text-sm font-semibold text-indigo-500 mt-1">Course: {{ $courseTitle }}</p>
<p class="mt-1">
Scheduled for
<span class="font-semibold">{{ $userTime->format('F j, Y \a\t h:i A') }}</span> ({{ $liveSession->duration_minutes }} min).
</p>

    @if ($userTime->isFuture())
        <p class="text-sm mt-2 font-medium">Starts in **{{ $userTime->diffForHumans() }}**.</p>
    @endif
</div>

<div class="flex-shrink-0 w-full sm:w-auto mt-4 sm:mt-0">
    @if ($isAvailable)
        <a href="{{ route('student.live-sessions.join', $liveSession) }}" target="_blank"
            class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-white bg-red-600 font-bold rounded-full shadow-xl hover:bg-red-700 transition transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.872v4.256a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Join Live Class NOW!
        </a>
    @else
           <button disabled class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 text-gray-500 bg-gray-200 rounded-full cursor-not-allowed font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Not Yet Active
        </button>
    @endif
</div>

</div>