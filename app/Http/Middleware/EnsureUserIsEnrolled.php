<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsEnrolled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the course from the route parameter
        $course = $request->route('course');

        // Check if the user is authenticated and is enrolled in the course.
        if (!$request->user() || !$request->user()->enrolledCourses->contains($course)) {
            abort(403, 'AKSES DITOLAK.');
        }

        return $next($request);
    }
}
