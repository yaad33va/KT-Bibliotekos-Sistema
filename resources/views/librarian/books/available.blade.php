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
    <div class="max-w-7xl mx-auto px-6 py-4 lg:px-8">
        <div class="flex items-center justify-between">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-teal-600 to-cyan-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 015.5 14c1.669 0 3.218-.584 4.5-1.548V4.804z"></path>
                        <path d="M15 9.304A7.968 7.968 0 0111.5 9c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 0111.5 19c1.669 0 3.218-.584 4.5-1.548V9.304z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">LibraryHub</h1>
                </div>
            </div>

            <!-- Right Menu -->
            <div class="flex items-center gap-4">
                <x-link href="{{ route('books.available') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 font-medium">
                    Browse
                </x-link>

                @guest
                    <x-link href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 font-medium">
                        Sign In
                    </x-link>
                    <x-link href="{{ route('register') }}" class="text-sm px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-semibold">
                        Register
                    </x-link>
                @else
                    <x-link href="{{ route('dashboard') }}" class="text-sm px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-semibold">
                        Dashboard
                    </x-link>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="pt-32 pb-20 px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-950">
    <div class="max-w-6xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Left Content -->
            <div class="space-y-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-teal-50 dark:bg-teal-900/20 rounded-full border border-teal-200 dark:border-teal-800">
                        <span class="w-2 h-2 bg-teal-600 rounded-full"></span>
                        <span class="text-sm font-semibold text-teal-700 dark:text-teal-400">Welcome to LibraryHub</span>
                    </div>

                    <h1 class="text-5xl lg:text-6xl font-black text-gray-900 dark:text-white leading-tight">
                        Discover &amp;
                        <span class="bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">
                                    Borrow Books
                                </span>
                    </h1>

                    <p class="text-xl text-gray-600 dark:text-gray-400">
                        Access thousands of books instantly. Browse our collection, borrow what you love, and build your personal library.
                    </p>
                </div>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    @guest
                        <x-link href="{{ route('books.available') }}" class="px-8 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-semibold text-center transition-colors">
                            Browse Books
                        </x-link>
                        <x-link href="{{ route('register') }}" class="px-8 py-3 border-2 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 font-semibold text-center transition-colors">
                            Create Account
                        </x-link>
                    @else
                        <x-link href="{{ route('books.available') }}" class="px-8 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 font-semibold text-center transition-colors">
                            Browse Now
                        </x-link>
                        <x-link href="{{ route('borrowing.index') }}" class="px-8 py-3 border-2 border-gray-300 dark:border-gray-700 text-gray-900 dark:text-white rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 font-semibold text-center transition-colors">
                            My Books
                        </x-link>
                    @endauth
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 pt-8">
                    <div>
                        <div class="text-3xl font-bold text-teal-600">{{ \App\Models\Book::count() ?? '500+' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Books</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-teal-600">{{ \App\Models\User::role('registered')->count() ?? '100+' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Readers</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-teal-600">{{ \App\Models\Reservation::where('book_status', 'returned')->count() ?? '1000+' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">Borrowed</div>
                    </div>
                </div>
            </div>

            <!-- Right Side - Illustration -->
            <div class="hidden lg:block">
                <div class="relative">
                    <!-- Gradient background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-teal-100 to-cyan-100 dark:from-teal-900/20 dark:to-cyan-900/20 rounded-2xl"></div>

                    <!-- Book Cards -->
                    <div class="relative p-8 space-y-4">
                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md hover:shadow-lg transition-shadow border border-gray-200 dark:border-gray-700">
                            <div class="flex gap-4">
                                <div class="w-16 h-24 bg-gradient-to-br from-teal-400 to-cyan-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 015.5 14c1.669 0 3.218-.584 4.5-1.548V4.804z"></path>
                                        <path d="M15 9.304A7.968 7.968 0 0111.5 9c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 0111.5 19c1.669 0 3.218-.584 4.5-1.548V9.304z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">The Great Gatsby</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">F. Scott Fitzgerald</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-teal-100 dark:bg-teal-900/40 text-teal-700 dark:text-teal-400 text-xs font-semibold rounded">Available</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md hover:shadow-lg transition-shadow border border-gray-200 dark:border-gray-700">
                            <div class="flex gap-4">
                                <div class="w-16 h-24 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 015.5 14c1.669 0 3.218-.584 4.5-1.548V4.804z"></path>
                                        <path d="M15 9.304A7.968 7.968 0 0111.5 9c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 0111.5 19c1.669 0 3.218-.584 4.5-1.548V9.304z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">1984</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">George Orwell</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-400 text-xs font-semibold rounded">Borrowed</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md hover:shadow-lg transition-shadow border border-gray-200 dark:border-gray-700">
                            <div class="flex gap-4">
                                <div class="w-16 h-24 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 015.5 14c1.669 0 3.218-.584 4.5-1.548V4.804z"></path>
                                        <path d="M15 9.304A7.968 7.968 0 0111.5 9c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 0111.5 19c1.669 0 3.218-.584 4.5-1.548V9.304z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">To Kill a Mockingbird</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Harper Lee</p>
                                    <span class="inline-block mt-2 px-2 py-1 bg-teal-100 dark:bg-teal-900/40 text-teal-700 dark:text-teal-400 text-xs font-semibold rounded">Available</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-20 px-6 lg:px-8 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Why Choose LibraryHub</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400">Everything you need for a seamless reading experience</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900/30 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C6.5 6.253 3 9.756 3 15.5s3.5 9.247 9 9.247m0-13c5.5 0 9-2.756 9-9.247m-9 9.247C6.5 24.247 3 20.744 3 15.5m9 9.247c5.5 0 9-2.756 9-9.247" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Vast Collection</h3>
                <p class="text-gray-600 dark:text-gray-400">Browse thousands of books across multiple genres and find your next favorite read.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Instant Access</h3>
                <p class="text-gray-600 dark:text-gray-400">See real-time availability and manage your borrowings with our intuitive dashboard.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-8 border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-shadow">
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Easy Borrowing</h3>
                <p class="text-gray-600 dark:text-gray-400">Borrow with a single click and manage your reading list all in one place.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
@guest
    <section class="py-20 px-6 lg:px-8 bg-gradient-to-r from-teal-600 to-cyan-600">
        <div class="max-w-3xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-white mb-4">Ready to start reading?</h2>
            <p class="text-xl text-teal-100 mb-8">Join our community and access thousands of books today.</p>
            <x-link href="{{ route('register') }}" class="inline-block px-8 py-3 bg-white text-teal-600 rounded-lg hover:bg-gray-100 font-semibold transition-colors">
                Get Started for Free
            </x-link>
        </div>
    </section>
@endguest

<!-- Footer -->
<footer class="bg-gray-900 text-gray-100 px-6 lg:px-8 py-16">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-4 gap-12 mb-12">
            <div>
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-600 flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 015.5 14c1.669 0 3.218-.584 4.5-1.548V4.804z"></path>
                            <path d="M15 9.304A7.968 7.968 0 0111.5 9c-1.255 0-2.443.29-3.5.804v10.99A7.97 7.97 0 0111.5 19c1.669 0 3.218-.584 4.5-1.548V9.304z"></path>
                        </svg>
                    </div>
                    LibraryHub
                </h3>
                <p class="text-sm text-gray-400">Your gateway to unlimited knowledge and reading adventures.</p>
            </div>

            <div>
                <h4 class="font-semibold mb-4">Browse</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><x-link href="{{ route('books.available') }}" class="hover:text-teal-400">Available Books</x-link></li>
                    <li><x-link href="{{ route('books.index') }}" class="hover:text-teal-400">All Books</x-link></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-4">Support</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><x-link href="#" class="hover:text-teal-400">Help Center</x-link></li>
                    <li><x-link href="#" class="hover:text-teal-400">Contact</x-link></li>
                </ul>
            </div>

            <div>
                <h4 class="font-semibold mb-4">Account</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    @auth
                        <li><x-link href="{{ route('dashboard') }}" class="hover:text-teal-400">Dashboard</x-link></li>
                    @else
                        <li><x-link href="{{ route('login') }}" class="hover:text-teal-400">Sign In</x-link></li>
                        <li><x-link href="{{ route('register') }}" class="hover:text-teal-400">Register</x-link></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8">
            <p class="text-sm text-gray-400 text-center">
                &copy; {{ date('Y') }} LibraryHub. All rights reserved.
            </p>
        </div>
    </div>
</footer>
</body>
</html>
