<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ $title ?? config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @fluxAppearance

    <style>
        button,
        input[type="radio"],
        label {
            cursor: pointer !important;
        }

        .fake-disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
</head>

<html class="h-full">

<body class="h-full bg-gray-100 bg-white dark:bg-gray-800">
    <main class="h-full bg-white dark:bg-gray-800">
        {{ $mainSlot }}
    </main>
    {{ $script }}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    @fluxScripts
    @livewireScripts
</body>

</html>
