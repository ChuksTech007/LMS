@extends('layouts.app')

@section('title', 'Payment Management')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Payment Management</h1>
            <p class="mt-2 text-gray-600">Review and verify student payments</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="bg-white rounded-xl shadow-lg mb-6">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <a href="{{ route(auth()->user()->role->value === 'admin' ? 'admin.payments.index' : 'instructor.payments.index', ['status' => 'pending']) }}"
                       class="px-6 py-4 text-sm font-medium {{ $status === 'pending' ? 'border-b-2 border-green-700 text-green-700' : 'text-gray-500 hover:text-gray-700' }}">
                        Pending
                        <span class="ml-2 bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">
                            {{ $statusCounts['pending'] ?? 0 }}
                        </span>
                    </a>
                    <a href="{{ route(auth()->user()->role->value === 'admin' ? 'admin.payments.index' : 'instructor.payments.index', ['status' => 'verified']) }}"
                       class="px-6 py-4 text-sm font-medium {{ $status === 'verified' ? 'border-b-2 border-green-700 text-green-700' : 'text-gray-500 hover:text-gray-700' }}">
                        Verified
                        <span class="ml-2 bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                            {{ $statusCounts['verified'] ?? 0 }}
                        </span>
                    </a>
                    <a href="{{ route(auth()->user()->role->value === 'admin' ? 'admin.payments.index' : 'instructor.payments.index', ['status' => 'rejected']) }}"
                       class="px-6 py-4 text-sm font-medium {{ $status === 'rejected' ? 'border-b-2 border-green-700 text-green-700' : 'text-gray-500 hover:text-gray-700' }}">
                        Rejected
                        <span class="ml-2 bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">
                            {{ $statusCounts['rejected'] ?? 0 }}
                        </span>
                    </a>
                    <a href="{{ route(auth()->user()->role->value === 'admin' ? 'admin.payments.index' : 'instructor.payments.index', ['status' => 'all']) }}"
                       class="px-6 py-4 text-sm font-medium {{ $status === 'all' ? 'border-b-2 border-green-700 text-green-700' : 'text-gray-500 hover:text-gray-700' }}">
                        All
                    </a>
                </nav>
            </div>
        </div>

        {{-- Payments Table --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            @if($payments->isEmpty())
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No payments found</h3>
                    <p class="mt-1 text-sm text-gray-500">No payments match the selected filter.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($payments as $payment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $payment->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $payment->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($payment->course->title, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">₦{{ number_format($payment->amount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $payment->payment_reference ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($payment->status === 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @elseif($payment->status === 'verified')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Verified
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $payment->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route(auth()->user()->role->value === 'admin' ? 'admin.payments.show' : 'instructor.payments.show', $payment) }}"
                                           class="text-green-600 hover:text-green-900">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection