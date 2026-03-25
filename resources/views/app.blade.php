<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="dark" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="bg-pixl-dark text-pixl-light font-pixl antialiased">
    @inertia
</body>
</html>
