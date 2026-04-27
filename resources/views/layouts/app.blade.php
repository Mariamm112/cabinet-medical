<header>
    @include('partials.nav')
</header>
<body>
<main>
    @yield('content')
    <h1>{{ __('messages.welcome') }}</h1>
</main>

<footer>
    Copyright
</footer>
<script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
</body>