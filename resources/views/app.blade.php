<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="application-name" content="{{ config('app.name') }}">
    @viteReactRefresh
    @vite('resources/css/app.css')
    @vite('resources/js/app.tsx')
    @inertiaHead
</head>
<body>
@inertia
</body>
</html>
