<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Profile Information Card -->
            <div
                class="bg-white shadow-xl sm:rounded-xl overflow-hidden border-t-4 border-purple-600 transform hover:scale-[1.01] transition-all duration-300">
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Update Password Card -->
            <div
                class="bg-white shadow-xl sm:rounded-xl overflow-hidden border-t-4 border-indigo-600 transform hover:scale-[1.01] transition-all duration-300">
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- Delete Account Card -->
            <div
                class="bg-white shadow-xl sm:rounded-xl overflow-hidden border-t-4 border-red-600 transform hover:scale-[1.01] transition-all duration-300">
                <div class="p-6 sm:p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
