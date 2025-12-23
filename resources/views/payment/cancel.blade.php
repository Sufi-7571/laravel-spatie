<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Payment Cancelled') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-4 border-red-600">
                <div class="p-8 text-center">
                    <div class="mb-6">
                        <svg class="w-20 h-20 text-red-600 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <h3 class="text-3xl font-bold text-gray-900 mb-4">
                        @if (session('error'))
                            {{ session('error') }}
                        @else
                            Payment Cancelled
                        @endif
                    </h3>
                    <p class="text-gray-600 mb-8">
                        @if (session('error'))
                            Please try again or contact support if the issue persists.
                        @else
                            Your payment has been cancelled. No charges were made.
                        @endif
                    </p>

                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('cart.index') }}"
                            class="inline-flex items-center gap-2 gradient-bg text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Try Again
                        </a>

                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
