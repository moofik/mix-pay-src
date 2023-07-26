<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SPA Authentication using Laravel 9 Sanctum, Vue 3 and Vite - TechvBlogs</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script> window._asset = '{{ asset('') }}'; </script>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body style="background-color: #eee;">
<div id="app">
    <router-view></router-view>
</div>
</body>
</html>