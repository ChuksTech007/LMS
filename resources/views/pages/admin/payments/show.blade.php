@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-6">
            <a href="{{ route(auth()->user()->role->value === 'admin' ? 'admin.payments.index' : 'instructor.payments.index') }}"
               class="text-green-600 hover:text-green-800 font-medium">
                ← Back to Payments
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- Payment Details --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Status Card --}}
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold text-gray-900">Payment Details</h2>
                        @if($payment->status === 'pending')
                            <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-800 font-semibold">
                                Pending Verification
                            </span>
                        @elseif($payment->status === 'verified')
                            <span class="px-4 py-2 rounded-full bg-green-100 text-green-800 font-semibold">
                                Verified
                            </span>
                        @else
                            <span class="px-4 py-2 rounded-full bg-red-100 text-red-800 font-semibold">
                                Rejected
                            </span>
                        @endif
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Student</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $payment->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $payment->user->email }}</p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Course</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $payment->course->title }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Amount</label>
                                <p class="mt-1 text-2xl font-bold text-green-700">₦{{ number_format($payment->amount, 2) }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Payment Reference</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $payment->payment_reference ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-500">Submitted On</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $payment->created_at->format('F d, Y h:i A') }}</p>
                        </div>

                        @if($payment->verified_at)
                            <div>
                                <label class="text-sm font-medium text-gray-500">Verified By</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $payment->verifier->name ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-500">{{ $payment->verified_at->format('F d, Y h:i A') }}</p>
                            </div>
                        @endif

                        @if($payment->admin_notes)
                            <div>
                                <label class="text-sm font-medium text-gray-500">Admin Notes</label>
                                <p class="mt-1 text-gray-900">{{ $payment->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Payment Proof --}}
                @if($payment->proof_image)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Payment Proof</h3>
                        <div class="border border-gray-300 rounded-lg overflow-hidden">
                            <img src="{{ asset('/' . $payment->proof_image) }}" 
                                 alt="Payment Proof"
                                 class="w-full h-auto cursor-pointer hover:opacity-90 transition"
                                 onclick="window.open('{{ asset('/' . $payment->proof_image) }}', '_blank')">
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Click image to view full size</p>
                    </div>
                @endif

            </div>

            {{-- Actions Sidebar --}}
            <div class="lg:col-span-1">
                @if($payment->status === 'pending')
                    <div class="bg-white rounded-xl shadow-lg p-6 space-y-4">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Actions</h3>
                        
                        {{-- Verify Form --}}
                        <form action="{{ route(auth()->user()->role->value === 'admin' ? 'admin.payments.verify' : 'instructor.payments.verify', $payment) }}" 
                              method="POST" 
                              onsubmit="return confirm('Are you sure you want to verify this payment? The student will be enrolled in the course.')">
                            @csrf
                            <div class="mb-4">
                                <label for="verify_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Notes (Optional)
                                </label>
                                <textarea name="admin_notes" id="verify_notes" rows="3"
                                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                          placeholder="Add any notes..."></textarea>
                            </div>
                            <button type="submit"
                                    class="w-full bg-green-700 text-white px-4 py-3 rounded-lg font-semibold hover:bg-green-800 transition duration-200">
                                ✓ Verify & Enroll Student
                            </button>
                        </form>

                        <div class="border-t border-gray-200 pt-4">
                            {{-- Reject Form --}}
                            <form action="{{ route(auth()->user()->role->value === 'admin' ? 'admin.payments.reject' : 'instructor.payments.reject', $payment) }}" 
                                  method="POST"
                                  onsubmit="return confirm('Are you sure you want to reject this payment?')">
                                @csrf
                                <div class="mb-4">
                                    <label for="reject_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                        Rejection Reason <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="admin_notes" id="reject_notes" rows="3" required
                                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500"
                                              placeholder="Explain why this payment is rejected..."></textarea>
                                </div>
                                <button type="submit"
                                        class="w-full bg-red-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-red-700 transition duration-200">
                                    ✗ Reject Payment
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Status</h3>
                        <p class="text-gray-600">
                            This payment has already been 
                            <span class="font-semibold">{{ $payment->status }}</span>.
                            No further action is required.
                        </p>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection