<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Eventy') }} | Management Console</title>
        <meta name="description" content="Manage your event services and bookings with Eventy's premium management console.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            primary: {
                                DEFAULT: '#0A3A7A',
                                50: '#f0f4f9', 100: '#e1e9f3', 200: '#c3d3e7', 300: '#a5bddb',
                                400: '#6991c3', 500: '#0A3A7A', 600: '#09346e', 700: '#082b5c',
                                800: '#062349', 900: '#051b3b', 950: '#030f21',
                            },
                            secondary: {
                                DEFAULT: '#ED1C24',
                                50: '#fef3f3', 100: '#fee7e7', 200: '#fcc3c5', 300: '#fa9fa3',
                                400: '#f6575e', 500: '#ED1C24', 600: '#d51920', 700: '#b2151b',
                                800: '#8e1115', 900: '#750e11', 950: '#4a090b',
                            },
                        },
                    },
                },
            };
        </script>

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            html { font-size: 92%; }
            body { font-family: 'Inter', sans-serif; letter-spacing: -0.01em; }
            [x-cloak] { display: none !important; }
        </style>
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50">
        @include('partials.toast')
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-100 sticky top-[64px] z-40">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <x-back-to-top />
        @stack('scripts')
    </body>
</html>


