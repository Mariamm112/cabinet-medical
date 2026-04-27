<header>
    @include('partials.nav')
</header>

<main>
    @yield('content')
    <h1>{{ __('messages.welcome') }}</h1>
</main>

<footer>
    Copyright
</footer>