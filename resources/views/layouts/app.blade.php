<x-layouts.base>
    @auth
        <div class="mobile-search">
            <form action="/" class="search-form">
                <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                <input class="form-control me-sm-2 box-shadow-none" type="search" placeholder="Search..." aria-label="Search">
            </form>
        </div>
        <div class="mobile-author-actions"></div>
        <header class="header-top">
            @include('partials._top_nav')
        </header>
        <main class="main-content">
            <div class="sidebar-wrapper">
                <aside class="sidebar sidebar-collapse" id="sidebar">
                    @include('partials._menu')
                </aside>
            </div>
            <div class="contents">
                {{ $slot }}
            </div>
            <footer class="footer-wrapper">
                @include('partials._footer')
            </footer>
        </main>
        @include('partials._loader')
        <div class="overlay-dark-sidebar"></div>
        <div class="customizer-overlay"></div>
        <div class="customizer-wrapper">
            @include('partials._customizer')
        </div>
    @endauth

    @guest
        @if(in_array(request()->route()->getName(), ['login']))
            {{$slot}}
        @endif
    @endguest
</x-layouts.base>
