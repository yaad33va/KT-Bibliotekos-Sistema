<x-layouts.app :title="__('Borrowed Books')">
    <div class="space-y-6">
        <div>
            <h1 class="text-3xl font-bold">{{ __('Currently Borrowed Books') }}</h1>
        </div>

        @if(session('success'))
            <div class="rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 p-4">
                <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
            </div>
        @endif

        @if($borrowed->isEmpty())
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-8 text-center">
                <p class="text-gray-600 dark:text-gray-400">{{ __('No books currently borrowed.') }}</p>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('User') }}</th>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('Book') }}</th>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('Borrowed Date') }}</th>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('Return Due') }}</th>
                        <th class="px-4 py-2 text-left font-semibold">{{ __('Action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($borrowed as $reservation)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <td class="px-4 py-3">{{ $reservation->user->name }}</td>
                            <td class="px-4 py-3">{{ $reservation->book->title }}</td>
                            <td class="px-4 py-3">{{ $reservation->reservation_date->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">{{ $reservation->return_date->format('Y-m-d') }}</td>
                            <td class="px-4 py-3">
                                <x-form method="post" :action="route('librarian.returns.mark-returned', $reservation)" class="inline">
                                    <x-button type="submit" class="text-green-600 hover:text-green-700">{{ __('Mark Returned') }}</x-button>
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
