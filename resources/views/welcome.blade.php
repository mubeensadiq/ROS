<!DOCTYPE html>
<html lang="en" class="theme-3 dark">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ env('APP_NAME', 'Pizza Xpress') }}</title>
    @vite(['resources/js/app.js'])
</head>
<body>
<div id="app"></div>
</body>
</html>
