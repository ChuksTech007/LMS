@extends('layouts.app')

@section('title', 'Make Payment')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Course Info Card --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-start space-x-4">
                <img src="{{ asset('/' . $course->thumbnail) }}" alt="{{ $course->title }}" 
                     class="w-32 h-32 object-cover rounded-lg">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $course->title }}</h1>
                    <p class="mt-2 text-gray-600">By {{ $course->instructor->name }}</p>
                    <div class="mt-4 inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full">
                        <span class="text-2xl font-bold">₦{{ number_format($course->price, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($existingPayment)
            {{-- Existing Payment Status --}}
            <div class="bg-blue-50 border-l-4 border-blue-400 p-6 rounded-lg">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-blue-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-900">Payment Status: 
                            <span class="uppercase">{{ $existingPayment->status }}</span>
                        </h3>
                        <p class="mt-1 text-blue-700">
                            @if($existingPayment->status === 'pending')
                                Your payment is being verified. Please wait for confirmation.
                            @elseif($existingPayment->status === 'verified')
                                Your payment has been verified! You can now access the course.
                            @endif
                        </p>
                        @if($existingPayment->proof_image)
                            <a href="{{ asset('/' . $existingPayment->proof_image) }}" target="_blank"
                               class="mt-2 inline-block text-blue-600 hover:underline">
                                View your payment proof
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @else
            {{-- Payment Form --}}
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Complete Your Payment</h2>
                
                {{-- Bank Details --}}
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bank Transfer Details</h3>
                    <div class="space-y-2 text-gray-700">
                        <p><span class="font-semibold">Bank Name:</span> Example Bank</p>
                        <p><span class="font-semibold">Account Name:</span> LMS Platform</p>
                        <p><span class="font-semibold">Account Number:</span> 1234567890</p>
                        <p><span class="font-semibold">Amount:</span> ₦{{ number_format($course->price, 2) }}</p>
                    </div>
                    <p class="mt-4 text-sm text-gray-600">
                        Please make the transfer and upload proof of payment below.
                    </p>
                </div>

                {{-- Upload Form --}}
                <form action="{{ route('courses.payment.store', $course) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="payment_reference" class="block text-sm font-medium text-gray-700 mb-2">
                            Payment Reference (Optional)
                        </label>
                        <input type="text" name="payment_reference" id="payment_reference"
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                               placeholder="Enter transaction reference">
                        @error('payment_reference')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="proof_image" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Payment Proof <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="proof_image" id="proof_image" accept="image/*" required
                               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        <p class="mt-1 text-sm text-gray-500">Accepted formats: JPG, PNG (Max: 2MB)</p>
                        @error('proof_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit"
                                class="flex-1 bg-green-700 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-800 transition duration-200">
                            Submit Payment Proof
                        </button>
                        <a href="{{ route('courses.show', $course) }}"
                           class="px-6 py-3 border border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition duration-200">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        @endif

    </div>
</div>
@endsection