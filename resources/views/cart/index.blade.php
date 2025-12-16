<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Shopping Cart') }}
            </h2>
            <a href="{{ route('products.index') }}"
                class="gradient-bg text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Continue Shopping
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-4 border-purple-600">
                <div class="p-6">
                    @if ($cartItems->count() > 0)
                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-purple-600 to-indigo-600">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Product</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Price</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Quantity</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Subtotal</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($cartItems as $item)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    <img class="h-16 w-16 rounded-lg object-cover shadow"
                                                        src="{{ $item->product->getImageUrl() }}"
                                                        alt="{{ $item->product->name }}">
                                                    <div class="ml-4">
                                                        <div class="text-sm font-semibold text-gray-900">
                                                            {{ $item->product->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="text-sm text-green-600 font-bold">${{ number_format($item->product->price, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <form action="{{ route('cart.update', $item) }}" method="POST"
                                                    class="flex items-center gap-2">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                        min="1"
                                                        class="w-20 px-3 py-1 rounded border border-gray-300 focus:ring-2 focus:ring-purple-500">
                                                    <button type="submit"
                                                        class="text-purple-600 hover:text-purple-800 font-semibold text-sm">
                                                        Update
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="text-sm font-bold text-gray-900">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <div class="bg-gray-50 rounded-lg p-6 w-full md:w-96">
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-lg font-semibold text-gray-700">Total:</span>
                                    <span
                                        class="text-2xl font-bold text-purple-600">${{ number_format($total, 2) }}</span>
                                </div>
                                <form action="{{ route('payment.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="amount" value="{{ $total }}">
                                    <input type="hidden" name="product_name" value="Cart Items">
                                    <button type="submit"
                                        class="w-full gradient-bg text-white font-bold py-3 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Proceed to Payment
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <p class="mt-4 text-gray-500 font-medium">Your cart is empty.</p>
                            <a href="{{ route('products.index') }}"
                                class="mt-4 inline-block gradient-bg text-white font-bold py-2 px-6 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                                Start Shopping
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
