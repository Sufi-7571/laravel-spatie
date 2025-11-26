<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <span class="text-sm text-gray-500">
                {{ now()->format('l, F j, Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="gradient-bg rounded-2xl shadow-xl p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
                        <p class="text-purple-100">Here's what's happening with your store today.</p>
                    </div>
                    <div class="hidden md:block">
                        <svg class="w-24 h-24 text-white opacity-20" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Products -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-full">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Products</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalProducts) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-50 px-6 py-2">
                        <a href="{{ route('products.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">View all →</a>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-full">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Users</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalUsers) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-50 px-6 py-2">
                        @can('manage users')
                            <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Manage users →</a>
                        @else
                            <span class="text-sm text-gray-400">User management</span>
                        @endcan
                    </div>
                </div>

                <!-- Total Reviews -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 bg-yellow-100 rounded-full">
                                <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Reviews</p>
                                <p class="text-2xl font-bold text-gray-800">{{ number_format($totalReviews) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-yellow-50 px-6 py-2">
                        @if($pendingReviews > 0)
                            <span class="text-sm text-yellow-600 font-medium">{{ $pendingReviews }} pending approval</span>
                        @else
                            <span class="text-sm text-green-600 font-medium">All reviews approved ✓</span>
                        @endif
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 {{ $lowStockCount > 0 ? 'bg-red-100' : 'bg-green-100' }} rounded-full">
                                <svg class="w-8 h-8 {{ $lowStockCount > 0 ? 'text-red-600' : 'text-green-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Low Stock Items</p>
                                <p class="text-2xl font-bold {{ $lowStockCount > 0 ? 'text-red-600' : 'text-green-600' }}">{{ number_format($lowStockCount) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="{{ $lowStockCount > 0 ? 'bg-red-50' : 'bg-green-50' }} px-6 py-2">
                        @if($lowStockCount > 0)
                            <span class="text-sm text-red-600 font-medium">Needs attention!</span>
                        @else
                            <span class="text-sm text-green-600 font-medium">Stock levels OK ✓</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stock Overview & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Stock Overview -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Stock Overview</h3>
                    <div class="space-y-4">
                        <!-- In Stock -->
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-600">In Stock</span>
                                <span class="text-sm font-bold text-green-600">{{ $inStock }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $totalProducts > 0 ? ($inStock / $totalProducts) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <!-- Low Stock -->
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-600">Low Stock</span>
                                <span class="text-sm font-bold text-yellow-600">{{ $lowStock }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $totalProducts > 0 ? ($lowStock / $totalProducts) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                        <!-- Out of Stock -->
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-600">Out of Stock</span>
                                <span class="text-sm font-bold text-red-600">{{ $outOfStock }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: {{ $totalProducts > 0 ? ($outOfStock / $totalProducts) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @can('create products')
                        <a href="{{ route('products.create') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition">
                            <svg class="w-8 h-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            <span class="text-sm font-medium text-purple-700">Add Product</span>
                        </a>
                        @endcan

                        @role('admin')
                        <a href="{{ route('users.create') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                            <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            <span class="text-sm font-medium text-blue-700">Add User</span>
                        </a>

                        <a href="{{ route('admin.reviews.index') }}" class="flex flex-col items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition">
                            <svg class="w-8 h-8 text-yellow-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-sm font-medium text-yellow-700">Reviews</span>
                        </a>
                        @endrole

                        <a href="{{ route('products.index') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                            <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            <span class="text-sm font-medium text-green-700">All Products</span>
                        </a>
                    </div>
                </div>

                <!-- Your Info -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Your Profile</h3>
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-4">
                            <p class="font-bold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Role</span>
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                                {{ auth()->user()->roles->pluck('name')->first() ?? 'No Role' }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Member Since</span>
                            <span class="text-gray-800 font-medium">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="mt-4 block text-center text-sm text-purple-600 hover:text-purple-800 font-medium">
                        Edit Profile →
                    </a>
                </div>
            </div>

            <!-- Recent Products & Recent Reviews -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Recent Products -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Recent Products</h3>
                        <a href="{{ route('products.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">View all →</a>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($recentProducts as $product)
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500">Added {{ $product->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-green-600">${{ number_format($product->price, 2) }}</p>
                                        <p class="text-sm {{ $product->stock > 10 ? 'text-green-500' : ($product->stock > 0 ? 'text-yellow-500' : 'text-red-500') }}">
                                            {{ $product->stock }} in stock
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">
                                No products yet
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Reviews -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Recent Reviews</h3>
                        @role('admin')
                            <a href="{{ route('admin.reviews.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">Manage →</a>
                        @endrole
                    </div>
                    <div class="divide-y divide-gray-200">
                        @forelse($recentReviews as $review)
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="flex items-center mb-1">
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= $review->rating)
                                                        ⭐
                                                    @endif
                                                @endfor
                                            </div>
                                            @if(!$review->is_approved)
                                                <span class="ml-2 px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs rounded-full">Pending</span>
                                            @endif
                                        </div>
                                        <p class="font-medium text-gray-800">{{ $review->product->name ?? 'Unknown Product' }}</p>
                                        <p class="text-sm text-gray-500">by {{ $review->user->name ?? 'Unknown User' }}</p>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center text-gray-500">
                                No reviews yet
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Users (Admin Only) -->
            @role('admin')
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Recent Users</h3>
                    <a href="{{ route('users.index') }}" class="text-sm text-purple-600 hover:text-purple-800 font-medium">View all →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentUsers as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $user->roles->first()?->name === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $user->roles->first()?->name ?? 'No Role' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endrole

        </div>
    </div>
</x-app-layout>