<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Product Details') }}
            </h2>
            <a href="{{ route('products.index') }}"
                class="text-white hover:text-purple-200 transition-colors duration-200">
                <svg class="inline-block w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-4 border-blue-600">
                <div class="p-8 text-gray-900">

                    <!-- Product Header with Image -->
                    <div class="mb-8 pb-6 border-b-2 border-gray-100">
                        <div class="flex flex-col md:flex-row gap-8">
                            <!-- Product Image -->
                            <div class="md:w-1/3">
                                <div class="relative rounded-xl overflow-hidden shadow-lg bg-gray-100">
                                    <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}"
                                        class="w-full h-64 md:h-80 object-cover">
                                    @if (!$product->hasImage())
                                        <div class="absolute inset-0 flex items-center justify-center bg-gray-200">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="md:w-2/3">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            #{{ $product->id }}
                                        </span>
                                    </div>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $product->stock > 0 ? ($product->stock > 10 ? 'In Stock' : 'Low Stock') : 'Out of Stock' }}
                                    </span>
                                </div>

                                <h3 class="text-3xl font-bold text-gray-900 mb-3">{{ $product->name }}</h3>

                                <p class="text-gray-600 text-lg mb-4">
                                    {{ $product->description ?? 'No description available' }}
                                </p>


                                <!-- Price -->
                                <div class="mb-4">
                                    <span
                                        class="text-4xl font-bold text-green-600">${{ number_format($product->price, 2) }}</span>
                                </div>

                                <!-- Rating Display -->
                                <div class="flex items-center">
                                    <div class="flex text-yellow-400">
                                        @php
                                            $avgRating = $product->averageRating();
                                            $fullStars = floor($avgRating);
                                            $hasHalfStar = $avgRating - $fullStars >= 0.5;
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $fullStars)
                                                <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                <svg class="w-6 h-6 fill-current text-yellow-400" viewBox="0 0 20 20">
                                                    <defs>
                                                        <linearGradient id="halfGrad">
                                                            <stop offset="50%" stop-color="currentColor" />
                                                            <stop offset="50%" stop-color="#D1D5DB" />
                                                        </linearGradient>
                                                    </defs>
                                                    <path fill="url(#halfGrad)"
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @else
                                                <svg class="w-6 h-6 fill-current text-gray-300" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span
                                        class="ml-2 text-lg font-semibold text-gray-700">{{ number_format($avgRating, 1) }}</span>
                                    <span class="ml-2 text-gray-500">({{ $product->reviewsCount() }}
                                        {{ Str::plural('review', $product->reviewsCount()) }})</span>
                                </div>

                                <div class="flex items-center mt-5">
                                    <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 7h18M3 12h18M3 17h18" />
                                    </svg>
                                    <span class="text-gray-600 font-semibold">Category:</span>
                                    <span class="ml-1 text-gray-800">
                                        {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>
                    

                    <!-- Product Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div
                            class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm font-medium text-green-700">Price</p>
                            </div>
                            <p class="text-3xl font-bold text-green-600">${{ number_format($product->price, 2) }}</p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <p class="text-sm font-medium text-purple-700">Stock</p>
                            </div>
                            <p class="text-3xl font-bold text-purple-600">{{ $product->stock }}
                                <span class="text-lg font-normal text-purple-500">units</span>
                            </p>
                        </div>

                        <div
                            class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-xl border border-yellow-200">
                            <div class="flex items-center mb-2">
                                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <p class="text-sm font-medium text-yellow-700">Rating</p>
                            </div>
                            <p class="text-3xl font-bold text-yellow-600">{{ number_format($avgRating, 1) }}
                                <span class="text-lg font-normal text-yellow-500">/ 5</span>
                            </p>
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="bg-gray-50 p-6 rounded-xl mb-8">
                        <h4 class="text-sm font-bold text-gray-700 uppercase mb-4">Product Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-gray-600">Created: </span>
                                <span
                                    class="ml-1 font-semibold text-gray-800">{{ $product->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-600">Updated: </span>
                                <span
                                    class="ml-1 font-semibold text-gray-800">{{ $product->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews Section -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-bold text-gray-800">Customer Reviews</h4>
                            <a href="{{ route('reviews.create', $product) }}"
                                class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                                Write a Review →
                            </a>
                        </div>

                        @php
                            $reviews = $product->approvedReviews()->with('user')->latest()->take(5)->get();
                        @endphp

                        @if ($reviews->count() > 0)
                            <div class="space-y-4">
                                @foreach ($reviews as $review)
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div class="ml-3">
                                                    <p class="font-semibold text-gray-800">
                                                        {{ $review->user->name ?? 'Unknown User' }}</p>
                                                    <div class="flex text-yellow-400">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                                </svg>
                                                            @else
                                                                <svg class="w-4 h-4 fill-current text-gray-300"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>
                                            <span
                                                class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if ($review->title)
                                            <p class="font-semibold text-gray-800 mb-1">{{ $review->title }}</p>
                                        @endif
                                        <p class="text-gray-600">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>

                            @if ($product->reviewsCount() > 5)
                                <div class="mt-4 text-center">
                                    <a href="{{ route('reviews.index', $product) }}"
                                        class="text-purple-600 hover:text-purple-800 font-medium">
                                        View all {{ $product->reviewsCount() }} reviews →
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="bg-gray-50 rounded-xl p-8 text-center">
                                <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                <p class="text-gray-500 mb-3">No reviews yet. Be the first to review this product!</p>
                                <a href="{{ route('reviews.create', $product) }}"
                                    class="inline-block gradient-bg text-white px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition">
                                    Write a Review
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center justify-end gap-3 pt-6 border-t border-gray-200">
                        <a href="{{ route('products.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </a>

                        <a href="{{ route('reviews.index', $product) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Reviews ({{ $product->reviewsCount() }})
                        </a>

                        @can('download product pdf')
                            <a href="{{ route('products.downloadPdf', $product) }}"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                PDF
                            </a>
                        @endcan

                        @can('edit products')
                            <a href="{{ route('products.edit', $product) }}"
                                class="gradient-bg text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                        @endcan

                        @can('delete products')
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                    <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(button) {
                Swal.fire({
                    title: 'Delete Product?',
                    text: "This product will be moved to trash.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#667eea',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    }
                });
            }
        </script>
    @endpush
</x-app-layout>
