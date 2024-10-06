<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <a href="{{ route('products.create') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                            Add New Product
                        </a>

                        <table class="min-w-full bg-white dark:bg-gray-700 mt-4">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4">Image</th>
                                    <th class="py-2 px-4">Name</th>
                                    <th class="py-2 px-4">Price</th>
                                    <th class="py-2 px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <td>
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}">
                                        </td>
                                        <td class="py-2 px-4">{{ $product->name }}</td>
                                        <td class="py-2 px-4">${{ number_format($product->price, 2) }}</td>
                                        <td class="py-2 px-4">
                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:underline">Edit</a>
                                            <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                class="inline-block ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 dark:text-red-400 hover:underline">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $products->links() }} <!-- Pagination Links -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main>
            {{-- {{ $slot }} --}}
        </main>
    </div>
</body>

</html>
