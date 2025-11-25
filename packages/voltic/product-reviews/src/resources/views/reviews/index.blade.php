<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Product Reviews') }}
        </h2>
    </x-slot>

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Product Info Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h2>
                            <p class="text-gray-600 mt-1">Customer Reviews</p>
                        </div>
                        <a href="{{ route('reviews.create', $product) }}" 
                           class="gradient-bg text-white px-6 py-2 rounded-lg transition hover:opacity-90">
                            Write a Review
                        </a>
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($reviews->count() > 0)
                        <div class="space-y-6">
                            @foreach($reviews as $review)
                                <div class="border-b border-gray-200 pb-6 last:border-0">
                                    <!-- Review Header -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <div class="flex items-center mb-1">
                                                <!-- Star Rating -->
                                                <div class="flex text-yellow-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                            </svg>
                                                        @else
                                                            <svg class="w-5 h-5 fill-current text-gray-300" viewBox="0 0 20 20">
                                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                            </svg>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <span class="ml-2 text-sm font-semibold text-gray-700">{{ $review->rating }}/5</span>
                                            </div>
                                            @if($review->title)
                                                <h3 class="text-lg font-semibold text-gray-800">{{ $review->title }}</h3>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $review->created_at->diffForHumans() }}
                                        </div>
                                    </div>

                                    <!-- Review Content -->
                                    <p class="text-gray-700 mb-3">{{ $review->comment }}</p>

                                    <!-- Reviewer Info -->
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>{{ $review->user->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $reviews->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No reviews yet</h3>
                            <p class="text-gray-600 mb-4">Be the first to review this product!</p>
                            <a href="{{ route('reviews.create', $product) }}" 
                               class="inline-block gradient-bg text-white px-6 py-2 rounded-lg transition hover:opacity-90">
                                Write a Review
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusMessage = @js(session('status'));
        const errorMessage = @js(session('error'));

        if (statusMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: statusMessage,
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#667eea'
            });
        }

        if (errorMessage) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: errorMessage,
                showConfirmButton: true,
                confirmButtonText: 'OK',
                confirmButtonColor: '#667eea'
            });
        }
    });
</script>
</x-app-layout>