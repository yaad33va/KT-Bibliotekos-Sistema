<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library Management System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100">
<!-- Fixed Navigation -->
<nav class="fixed top-0 left-0 right-0 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 z-50">
    <div class="px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-teal-600 to-cyan-600 flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 015.5 14c1.669 0 3.218-.584 4.5-1.548V4.804z"></path>
                        <path d="M15 9.304A7.968 7.968 0 0111.5 9c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 0111.5 19c1.669 0 3.218-.584 4.5-1.548V9.304z"></path>
                    </svg>
                </div>
                <h1 class="text-lg font-bold text-gray-900 dark:text-white">LibraryHub</h1>
            </div>

            <!-- Right Menu -->
            <div class="flex items-center gap-3">
                <x-link href="{{ route('books.available') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 font-medium">
                    Browse
                </x-link>

                @auth
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->username }}</span>
                    <x-link href="{{ route('dashboard') }}" class="text-sm px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-semibold">
                        Dashboard
                    </x-link>
                @else
                    <x-link href="{{ route('login') }}" class="text-sm px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 font-medium">
                        Login
                    </x-link>
                    <x-link href="{{ route('register') }}" class="text-sm px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-semibold">
                        Register
                    </x-link>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Main Content -->
<section class="pt-24 pb-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Available Books Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Available Books</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Author</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Genre</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Pages</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Available</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse(\App\Models\Book::all()->filter(function($book) { return $book->available_copies > 0; }) as $book)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">{{ $book->title }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $book->author }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $book->genre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $book->page_count }}</td>
                            <td class="px-6 py-4 text-sm">
                                            <span class="inline-block px-3 py-1 bg-teal-100 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 rounded-full font-semibold text-xs">
                                                {{ $book->available_copies }}/{{ $book->book_count }}
                                            </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @auth
                                    @if(auth()->user()->hasRole('registered'))
                                        <x-form method="post" :action="route('borrowing.borrow', $book)" class="inline">
                                            <x-button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-xs py-1 px-3">Borrow</x-button>
                                        </x-form>
                                    @else
                                        <button disabled class="bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-300 text-xs py-1 px-3 rounded cursor-not-allowed">Borrow</button>
                                    @endif
                                @else
                                    <x-link href="{{ route('login') }}" class="bg-teal-600 hover:bg-teal-700 text-white text-xs py-1 px-3 rounded inline-block">Login</x-link>
                                @endauth
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                No books available
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Borrowed Books Table (if authenticated) -->
        @auth
            @if(auth()->user()->hasRole('registered'))
                <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">My Borrowed Books</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Title</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Author</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Borrowed Date</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Return Due</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse(auth()->user()->reservations()->where('book_status', 'taken')->get() as $reservation)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">{{ $reservation->book->title }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $reservation->book->author }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $reservation->reservation_date->format('Y-m-d') }}</td>
                                    <td class="px-6 py-4 text-sm">
                                                    <span class="inline-block px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 rounded-full font-semibold text-xs">
                                                        {{ $reservation->return_date->format('Y-m-d') }}
                                                    </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
                                        No borrowed books
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endauth
    </div>
</section>
</body>
</html>
