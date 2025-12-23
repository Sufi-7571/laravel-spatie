<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Payment Successful') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-4 border-green-600">
                <div class="p-8 text-center">
                    <div class="mb-6">
                        <svg class="w-20 h-20 text-green-600 mx-auto" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>

                    <h3 class="text-3xl font-bold text-gray-900 mb-4">Payment Successful!</h3>
                    <p class="text-gray-600 mb-2">Your payment has been processed successfully.</p>

                    @if (isset($payment))
                        <p class="text-lg font-semibold text-green-600 mb-8">Amount Paid:
                            ${{ number_format($payment->amount, 2) }}</p>
                    @endif

                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('payment.index') }}"
                            class="inline-flex items-center gap-2 gradient-bg text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            View All Payments
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
