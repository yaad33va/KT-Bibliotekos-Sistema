<x-layouts.app :title="__('Manage Books')">
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold">{{ __('Manage Books') }}</h1>
            <x-link :href="route('librarian.books.create')" class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">
                {{ __('Add New Book') }}
            </x-link>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4">
                <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        @if($books->isEmpty())
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">{{ __('No books in library.') }}</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('Title') }}</th>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('Author') }}</th>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('Genre') }}</th>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('Copies') }}</th>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($books as $book)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-3">{{ $book->title }}</td>
                            <td class="px-4 py-3">{{ $book->author }}</td>
                            <td class="px-4 py-3">{{ $book->genre }}</td>
                            <td class="px-4 py-3">{{ $book->book_count }}</td>
                            <td class="px-4 py-3 space-x-2">
                                <x-link :href="route('librarian.books.edit', $book)" class="text-teal-600 hover:text-teal-700">
                                    {{ __('Edit') }}
                                </x-link>
                                <x-form method="delete" :action="route('librarian.books.destroy', $book)" class="inline">
                                    <x-button type="submit" class="text-red-600 hover:text-red-700">{{ __('Delete') }}</x-button>
                                </x-form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layouts.app>
