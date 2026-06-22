<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Розробка ігор | ФІОТ КПІ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script>
</head>
<body class="bg-fiot-black text-fiot-white antialiased overflow-x-hidden selection:bg-fiot-accent selection:text-fiot-black flex flex-col min-h-screen">


    <!-- Background Effects -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <!-- <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-fiot-dark/40 via-transparent to-transparent"></div> -->
        <div class="absolute top-[-10%] left-[-10%] w-[80%] h-[80%] bg-fiot-primary/15 rounded-full blur-[180px]"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-fiot-accent/10 rounded-full blur-[150px]"></div>
        <!-- <div class="absolute inset-0 bg-[linear-gradient(to_right,#14161C_1px,transparent_1px),linear-gradient(to_bottom,#14161C_1px,transparent_1px)] bg-[size:40px_40px] md:bg-[size:80px_80px] opacity-30"></div> -->
    </div>

    @include('components.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('components.footer')
    
    @yield('scripts')
</body>
</html>