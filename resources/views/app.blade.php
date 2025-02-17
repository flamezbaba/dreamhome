<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/png" href="{{ url('/fav.png') }}">
    <link
        href="https://fonts.bunny.net/css?family=albert-sans:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    <style>
        html,
        body {
            /* font-family: "Albert Sans"; */
            font-family: "Red Hat Display","Nunito";
            font-size: 14px;
            text-rendering: optimizeSpeed;
            line-height: 2px;
        }

        * {
            box-sizing: border-box;
        }

        :not(html):not(body) {
            /* scrollbar-color: hsla(0,0%,100%,.3) transparent; */
            scrollbar-width: none;
        }
    </style>
    <!-- Scripts -->
    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>

<body class="antialiased">
    {{-- <body class="font-sans antialiased"> --}}
    @inertia
</body>

</html>
