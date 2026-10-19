<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Кафедра ігрових та інтелектуальних систем | ФІОТ КПІ')</title>

    <meta name="description" content="@yield('meta_description', 'Кафедра ігрових та інтелектуальних систем ФІОТ КПІ ім. Ігоря Сікорського. Освітня програма «Розробка комп’ютерних ігор»: ігрові рушії, комп’ютерна графіка, ШІ та системна інженерія.')">
    <meta name="robots" content="index, follow">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Кафедра ігрових та інтелектуальних систем | ФІОТ КПІ">
    <meta property="og:title" content="@yield('title', 'Кафедра ігрових та інтелектуальних систем | ФІОТ КПІ')">
    <meta property="og:description" content="@yield('meta_description', 'Кафедра ігрових та інтелектуальних систем ФІОТ КПІ ім. Ігоря Сікорського. Освітня програма «Розробка комп’ютерних ігор».')">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Pre-FOUC paint: dark canvas before Vite CSS loads --}}
    <style>
        html{background:#080809;color-scheme:dark}
        body{background:#080809;margin:0}
        /* Hide raw (unstyled) HTML until the CSS bundle is applied;
           the timeout guarantees the page never stays hidden. */
        html.js:not(.ready) body{visibility:hidden}
    </style>
    <script>
        document.documentElement.classList.add('js');
        setTimeout(function(){ document.documentElement.classList.add('ready'); }, 1200);
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js" defer></script>
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