<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header Info -->
        <!-- <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">
                        Msegat SMS Integration
                    </h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                        <p>Configure your Msegat SMS service to enable:</p>
                        <ul class="list-disc list-inside mt-2 space-y-1">
                            <li>OTP authentication for customers</li>
                            <li>Booking confirmation SMS notifications</li>
                            <li>Booking cancellation SMS notifications</li>
                        </ul>
                        <p class="mt-3">
                            <strong>Your Credentials:</strong><br>
                            Username: <code class="bg-blue-100 dark:bg-blue-800 px-2 py-1 rounded">techflipp</code><br>
                            API Key: <code class="bg-blue-100 dark:bg-blue-800 px-2 py-1 rounded">4563eb312a38125a5b63acb0d57bd57a</code>
                        </p>
                    </div>
                </div>
            </div>
        </div> -->

        <!-- Form -->
        <form wire:submit="save">
            {{ $this->form }}

            <div class="flex gap-3 mt-6">
                @foreach ($this->getFormActions() as $action)
                    {{ $action }}
                @endforeach
            </div>
        </form>

        <!-- API Documentation -->
        <!-- <div class="bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-lg p-4 mt-6">
            <h3 class="text-sm font-medium text-gray-800 dark:text-gray-300 mb-3">
                📚 API Documentation
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                For more information about Msegat API, visit: 
                <a href="https://msegat.docs.apiary.io/" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline">
                    https://msegat.docs.apiary.io/
                </a>
            </p>
        </div> -->

        <!-- Current Status -->
        <!-- <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">OTP Status</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ config('services.msegat.username') ? 'Configured' : 'Not Configured' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">SMS Notifications</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">Active</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sender Name</p>
                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            {{ config('services.msegat.sender', 'Not Set') }}
                        </p>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
</x-filament-panels::page>
