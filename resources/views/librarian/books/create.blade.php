<x-layouts.app :title="__('Add New Book')">
    <div class="max-w-2xl">
        <h1 class="text-3xl font-bold mb-6">{{ __('Add New Book') }}</h1>

        <x-form method="post" :action="route('librarian.books.store')" class="space-y-6">
            <x-input
                type="text"
                :label="__('Title')"
                name="title"
                required
            />

            <x-input
                type="text"
                :label="__('Author')"
                name="author"
                required
            />

            <x-input
                type="text"
                :label="__('Genre')"
                name="genre"
                required
            />

            <x-input
                type="date"
                :label="__('Release Date')"
                name="release_date"
                required
            />

            <x-field>
                <x-label for="book_description" :value="__('Description')" />
                <textarea name="book_description" id="book_description" class="w-full rounded-lg border border-gray-200 dark:border-white/10 p-3" rows="5" required></textarea>
            </x-field>

            <x-input
                type="number"
                :label="__('Page Count')"
                name="page_count"
                min="1"
                required
            />

            <x-input
                type="number"
                :label="__('Number of Copies')"
                name="book_count"
                min="1"
                required
            />

            <div class="flex gap-3">
                <x-button type="submit">{{ __('Add Book') }}</x-button>
                <x-link :href="route('librarian.books.index')">{{ __('Cancel') }}</x-link>
            </div>
        </x-form>
    </div>
</x-layouts.app>
