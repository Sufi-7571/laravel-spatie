<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight">
            {{ __('Write a Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800">Write a Review</h2>
                    <p class="text-gray-600 mt-1">for {{ $product->name }}</p>
                </div>
            </div>

            <!-- Review Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('reviews.store', $product) }}" id="reviewForm">
                        @csrf

                        <!-- Rating -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Rating <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center space-x-2" id="starRating">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer star-label">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden rating-input" {{ old('rating') == $i ? 'checked' : '' }} required>
                                        <svg class="w-10 h-10 fill-current star-icon transition-colors duration-200" viewBox="0 0 20 20" data-rating="{{ $i }}">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            <p class="mt-2 text-sm text-gray-500" id="ratingText">Click on a star to rate</p>
                            @error('rating')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Review Title (Optional)
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title') }}"
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                   placeholder="Sum up your experience">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Review <span class="text-red-500">*</span>
                            </label>
                            <textarea id="comment" 
                                      name="comment" 
                                      rows="6" 
                                      required
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                      placeholder="Share your experience with this product (minimum 10 characters)">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Minimum 10 characters</p>
                        </div>

                        <!-- Buttons -->
                        <div class="flex items-center justify-between">
                            <a href="{{ route('reviews.index', $product) }}" 
                               class="text-gray-600 hover:text-gray-800">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold transition hover:opacity-90">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-icon');
            const ratingInputs = document.querySelectorAll('.rating-input');
            const ratingText = document.getElementById('ratingText');
            let selectedRating = {{ old('rating', 0) }};

            // Initialize stars based on old value or default
            updateStars(selectedRating);

            stars.forEach((star, index) => {
                const rating = parseInt(star.getAttribute('data-rating'));
                
                // Click event
                star.addEventListener('click', function() {
                    selectedRating = rating;
                    ratingInputs[index].checked = true;
                    updateStars(rating);
                    updateRatingText(rating);
                });

                // Hover event
                star.addEventListener('mouseenter', function() {
                    updateStars(rating, true);
                });
            });

            // Reset to selected rating on mouse leave
            document.getElementById('starRating').addEventListener('mouseleave', function() {
                updateStars(selectedRating);
            });

            function updateStars(rating, isHover = false) {
                stars.forEach((star, index) => {
                    const starRating = parseInt(star.getAttribute('data-rating'));
                    if (starRating <= rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            }

            function updateRatingText(rating) {
                const messages = {
                    1: '⭐ Poor',
                    2: '⭐⭐ Fair',
                    3: '⭐⭐⭐ Good',
                    4: '⭐⭐⭐⭐ Very Good',
                    5: '⭐⭐⭐⭐⭐ Excellent'
                };
                ratingText.textContent = messages[rating] || 'Click on a star to rate';
            }

            // Set initial text if rating is already selected
            if (selectedRating > 0) {
                updateRatingText(selectedRating);
            }
        });
    </script>
    @endpush
</x-app-layout>