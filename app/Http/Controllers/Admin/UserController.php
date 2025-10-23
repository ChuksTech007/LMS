<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class UserController extends Controller
{
    /**
     * Display a list of all users.
     */
    public function index()
    {
        // Get all users except the currently logged-in admin, with pagination
        $users = User::where('id', '!=', auth()->id())
            ->latest()
            ->paginate(15);

        return view('pages.admin.users.index', compact('users'));
    }

    /**
     * Update the user's role.
     */
    public function update(Request $request, User $user)
    {
        // Validate the incoming request
        $request->validate([
            'role' => ['required', new Enum(Role::class)],
        ]);

        // Update the user's role
        $user->role = $request->role;
        $user->save();

        return back()->with('success', "The role for user {$user->name} has been successfully updated.");
    }
}
