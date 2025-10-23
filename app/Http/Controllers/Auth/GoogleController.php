<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirect (): mixed{
        return Socialite::driver('google')->redirect();
    }

    public function callback (Request $request): mixed{
        try {
            $user = Socialite::driver('google')->user();;
        } catch (Throwable $e) {
            // Handle the error, such as logging it or redirecting with an error message
            return redirect('/')->with('error', 'Failed to authenticate with Google.');
        }

        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            // User exists, log them in
            Auth::login(user: $existingUser);
        } else {
            // User does not exist, create a new user
            $newUser = User::updateOrCreate([
                'email' => $user->email,
            ], [
                'name' => $user->name,
                'password' => bcrypt(value: Str::random(length: 16)), // Generate a random password
                'email_verified_at' => now(), // Mark email as verified
            ]);
            Auth::login(user: $newUser);
        }

        return redirect('/');
        
    }
}