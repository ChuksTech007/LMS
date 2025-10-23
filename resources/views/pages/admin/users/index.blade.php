@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<!-- A consistent background gradient for a premium feel -->
<div class="py-12 bg-gray-50 min-h-screen px-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

        {{-- Page Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 animate-fade-in-down">
            <div class="mb-4 sm:mb-0">
                <h2 class="text-3xl font-extrabold text-green-900">User & Role Management</h2>
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors duration-200 mt-1">
                   &larr; Back to Dashboard
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 rounded-2xl bg-green-50 p-4 animate-fade-in-up">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- User Table --}}
        <div class="bg-white overflow-hidden shadow-xl rounded-2xl p-6 animate-fade-in-up">
            <div class="text-gray-900">
                <div class="flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th scope="col"
                                            class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">
                                            Name</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                        <th scope="col"
                                            class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Joined At
                                        </th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-3"><span
                                                class="sr-only">Change Role</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($users as $user)
                                        <tr class="even:bg-gray-50">
                                            <td
                                                class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">
                                                {{ $user->name }}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium
                                                    {{ $user->role === App\Enums\Role::ADMIN ? 'bg-red-50 text-red-700 ring-red-600/20' : '' }}
                                                    {{ $user->role === App\Enums\Role::INSTRUCTOR ? 'bg-yellow-50 text-yellow-700 ring-yellow-600/20' : '' }}
                                                    {{ $user->role === App\Enums\Role::STUDENT ? 'bg-green-50 text-green-700 ring-green-600/20' : '' }}
                                                    ">
                                                    {{ $user->role->name }}
                                                </span>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                {{ $user->created_at->format('d M Y') }}</td>
                                            <td
                                                class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-3">
                                                <form action="{{ route('admin.users.update', $user) }}" method="POST"
                                                    class="flex items-center gap-x-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="role"
                                                        class="block w-full rounded-md border-0 py-1 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-green-600 sm:text-sm">
                                                        @foreach(App\Enums\Role::cases() as $role)
                                                            <option value="{{ $role->value }}" @selected($user->role === $role)>
                                                                {{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button type="submit"
                                                        class="rounded-md bg-green-900 px-3 py-1.5 text-xs font-semibold text-white shadow-sm ring-1 ring-inset ring-green-900 hover:bg-green-800 transition-colors duration-200">
                                                        Save
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-gray-500">No other users.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 animate-fade-in-up">{{ $users->links() }}</div>
    </div>
</div>

<!-- Custom CSS for animations -->
<style>
    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.8s ease-out forwards;
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out 0.8s forwards; opacity: 0;
    }
</style>
@endsection
