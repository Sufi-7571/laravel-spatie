<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight">
                {{ __('Products') }}
            </h2>

            <div class="flex items-center gap-3">
                @role('admin')
                    <a href="{{ route('admin.reviews.index') }}"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        Manage Reviews
                    </a>
                @endrole

                @can('create products')
                    <a href="{{ route('products.create') }}"
                        class="gradient-bg text-white font-bold py-2 px-4 rounded-lg shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Product
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border-t-4 border-purple-600">
                <div class="p-6 text-gray-900">
                    <!-- Search, Filter & Role Section -->
                    <div class="mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <!-- Search & Filter Form -->
                        <form action="{{ route('products.index') }}" method="GET"
                            class="flex flex-col sm:flex-row gap-3 flex-1">
                            <!-- Search Bar -->
                            <div class="relative flex-1 max-w-md">
                                <input type="text" name="search" value="{{ $search ?? '' }}"
                                    placeholder="Search products..."
                                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Rating Filter -->
                            <div class="relative">
                                <select name="rating" onchange="this.form.submit()"
                                    class="appearance-none pl-10 pr-8 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition bg-white cursor-pointer">
                                    <option value="">All Ratings</option>
                                    <option value="5" {{ ($rating ?? '') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Stars
                                    </option>
                                    <option value="4" {{ ($rating ?? '') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4+ Stars
                                    </option>
                                    <option value="3" {{ ($rating ?? '') == '3' ? 'selected' : '' }}>⭐⭐⭐ 3+ Stars
                                    </option>
                                    <option value="2" {{ ($rating ?? '') == '2' ? 'selected' : '' }}>⭐⭐ 2+ Stars
                                    </option>
                                    <option value="1" {{ ($rating ?? '') == '1' ? 'selected' : '' }}>⭐ 1+ Stars
                                    </option>
                                </select>
                                
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Search Button -->
                            <button type="submit"
                                class="gradient-bg text-white px-6 py-2 rounded-lg font-semibold hover:opacity-90 transition flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                Search
                            </button>

                            <!-- Clear Filters -->
                            @if ($search || $rating)
                                <a href="{{ route('products.index') }}"
                                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100 transition flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Clear
                                </a>
                            @endif
                        </form>

                        <!-- User Role Badge -->
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-purple-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                    clip-rule="evenodd" />
                            </svg>
                            <p class="text-sm text-gray-600">
                                Your Role:
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-purple-600 to-indigo-600 text-white ml-2">
                                    {{ auth()->user()->roles->pluck('name')->first() ?? 'No Role' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Search Results Info -->
                    @if ($search || $rating)
                        <div class="mb-4 flex items-center justify-between bg-purple-50 rounded-lg px-4 py-2">
                            <p class="text-sm text-purple-700">
                                <span class="font-semibold">{{ $products->total() }}</span> results found
                                @if ($search)
                                    for "<span class="font-semibold">{{ $search }}</span>"
                                @endif
                                @if ($rating)
                                    with <span class="font-semibold">{{ $rating }}+ stars</span>
                                @endif
                            </p>
                            <a href="{{ route('products.index') }}"
                                class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                Clear all filters
                            </a>
                        </div>
                    @endif

                    <div class="overflow-x-auto rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-purple-600 to-indigo-600">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Product</th>
                                   <th
                                        class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Category</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Price</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Stock</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Rating</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($products as $product)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <!-- Product with Image -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-12 w-12">
                                                    <img class="h-12 w-12 rounded-lg object-cover shadow"
                                                        src="{{ $product->getImageUrl() }}"
                                                        alt="{{ $product->name }}">
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        {{ $product->name }}</div>
                                                    <div class="text-xs text-gray-500">#{{ $product->id }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Category -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                        </td>

                                        <!-- Price -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="text-sm text-green-600 font-bold">${{ number_format($product->price, 2) }}</span>
                                        </td>

                                        <!-- Stock -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $product->stock }} units
                                            </span>
                                        </td>

                                        <!-- Rating -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex text-yellow-400">
                                                    @php $avgRating = $product->averageRating(); @endphp
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($avgRating))
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
                                                <span
                                                    class="ml-2 text-xs text-gray-600">({{ $product->reviewsCount() }})</span>
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center gap-3">
                                                <a href="{{ route('products.show', $product) }}"
                                                    class="text-blue-600 hover:text-blue-900 transition-colors duration-200"
                                                    title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                <a href="{{ route('reviews.index', $product) }}"
                                                    class="text-yellow-600 hover:text-yellow-900 transition-colors duration-200"
                                                    title="Reviews">
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path
                                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </a>

                                                @can('download product pdf')
                                                    <a href="{{ route('products.downloadPdf', $product) }}"
                                                        class="text-green-600 hover:text-green-900 transition-colors duration-200"
                                                        title="PDF">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                        </svg>
                                                    </a>
                                                @endcan

                                                @can('edit products')
                                                    <a href="{{ route('products.edit', $product) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200"
                                                        title="Edit">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>
                                                @endcan

                                                @can('delete products')
                                                    <form action="{{ route('products.destroy', $product) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDelete(this)"
                                                            class="text-red-600 hover:text-red-900 transition-colors duration-200"
                                                            title="Delete">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="mt-4 text-gray-500 font-medium">No products found.</p>
                                            @can('create products')
                                                <a href="{{ route('products.create') }}"
                                                    class="mt-2 inline-block text-purple-600 hover:text-purple-800 font-semibold">
                                                    Create your first product →
                                                </a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $products->links() }}
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
