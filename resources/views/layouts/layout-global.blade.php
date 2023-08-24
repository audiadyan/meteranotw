<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @yield('script_head')

    {{-- daisyUI --}}
    <link href="https://cdn.jsdelivr.net/npm/daisyui@3.5.0/dist/full.css" rel="stylesheet" type="text/css" />

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Page Title --}}
    <title>PLN Pintar OnTheWay</title>
</head>

<body class="flex flex-col min-h-screen bg-slate-100">
    @yield('global_layout')

    @yield('script')

    {{-- FlowBite --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

    {{-- <script type="text/javascript" src="/js/app.js"></script> --}}
</body>

</html>
