<x-layouts.app :title="__('My Borrowed Books')">
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold">{{ __('My Borrowed Books') }}</h1>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4">
                <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4">
                <p class="text-red-700 dark:text-red-400">{{ session('error') }}</p>
            </div>
        @endif

        @if($reservations->isEmpty())
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">{{ __('You have no borrowed books.') }}</p>
            </div>
        @else
            <div class="space-y-2">
                @foreach($reservations as $reservation)
                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold">{{ $reservation->book->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Author') }}: {{ $reservation->book->author }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Return by') }}: {{ $reservation->return_date->format('Y-m-d') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>
