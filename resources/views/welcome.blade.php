<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CBA - CutiApp</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-100 relative">
    <div class="min-h-screen flex flex-col items-center justify-center relative z-10">
        <!-- Logo -->
        <div class="text-center mb-4 pt-8">
            <img src="{{ asset('images/cba-logo.png') }}" alt="Logo" width="200" height="200">
        </div>

        <!-- Header -->
        <header class="mb-6 text-center px-4">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 leading-tight">
                Welcome to CBA Form CutiApp
            </h1>
            <p class="mt-2 text-base md:text-lg text-gray-600 leading-relaxed">
                Ini adalah langkah awal Anda untuk membangun pengalaman yang lebih baik dalam pengelolaan cuti. 
                Ajukan permohonan cuti Anda dengan mudah, cepat, dan efisien melalui platform ini. Mari kita mulai!
            </p>
        </header>

        <!-- Buttons -->
        <div class="mb-8 flex gap-4">
            <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 transition">
                Login here
            </a>
            {{-- <a href="{{ route('register') }}" class="px-6 py-2 bg-green-500 text-white rounded-lg shadow-md hover:bg-green-600 transition">
                Register
            </a> --}}
        </div>

        <!-- Fitur Web Form Pengajuan Cuti -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 px-4">
            <!-- Card 1 -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Pengajuan Cuti Online</h3>
                <p class="text-gray-600">Ajukan cuti kapan saja dan di mana saja dengan proses yang cepat dan mudah.</p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Riwayat Pengajuan</h3>
                <p class="text-gray-600">Lacak dan kelola riwayat pengajuan cuti Anda secara transparan.</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Validasi Otomatis</h3>
                <p class="text-gray-600">Sistem akan menghitung jumlah hari cuti yang diambil dan memastikan sisa cuti Anda akurat.</p>
            </div>

            <!-- Card 4 -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Notifikasi Langsung</h3>
                <p class="text-gray-600">Dapatkan notifikasi langsung terkait status pengajuan cuti Anda.</p>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 pt-6">
                <footer class="bg-white p-4 pt-6 text-center">
                    &copy; {{ date('Y') }} CutiApp - IT CBA. All rights reserved.
                    <br>
                    Version {{ config('app.version') }}
                </footer>
            </div>
        </div>
    </div>

</body>
</html>

