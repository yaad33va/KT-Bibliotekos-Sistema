<x-layouts.app :title="__('All Books')">
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold">{{ __('All Books') }}</h1>
        </div>

        @if($books->isEmpty())
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">{{ __('No books available.') }}</p>
            </div>
        @else
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach($books as $book)
                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4 space-y-2">
                        <h2 class="font-semibold text-lg">{{ $book->title }}</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Author') }}: {{ $book->author }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Genre') }}: {{ $book->genre }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Pages') }}: {{ $book->page_count }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Available') }}: {{ $book->available_copies }}/{{ $book->book_count }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>
