<div class="sidebar__menu-group">
    <ul class="sidebar_nav">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ Request::is('dashboard') ? 'active':'' }}">
                <span class="nav-icon fas fa-chart-line" style="font-size: 14px!important;"></span>
                <span class="menu-text">@lang('menu.dashboard')</span>
            </a>
        </li>
        <li class="has-child {{ in_array(request()->route()->getName(), ['categories', 'subcategories', 'colors', 'products', 'products.create', 'products.edit']) ? 'open':'' }}">
            <a href="#" class="{{ in_array(request()->route()->getName(), ['categories', 'subcategories', 'colors', 'products', 'products.create', 'products.edit']) ? 'active':'' }}">
                <span class="nav-icon fas fa-clipboard" style="font-size: 14px!important;"></span>
                <span class="menu-text">@lang('menu.maintenance')</span>
                <span class="toggle-icon"></span>
            </a>
            <ul>
                <li class="{{ Request::is('categories') ? 'active':'' }}"><a href="{{route('categories')}}">@lang('menu.categories')</a></li>
                <li class="{{ Request::is('subcategories') ? 'active':'' }}"><a href="{{route('subcategories')}}">@lang('menu.subcategories')</a></li>
                <li class="{{ Request::is('colors') ? 'active':'' }}"><a href="{{route('colors')}}">@lang('menu.colors')</a></li>
                <li class="{{ in_array(request()->route()->getName(), ['products', 'products.create', 'products.edit']) ? 'active':'' }}"><a href="{{route('products')}}">@lang('menu.products')</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('cash_register') }}" class="{{ Request::is('cash-register') ? 'active':'' }}">
                <span class="nav-icon fa fa-cash-register" style="font-size: 14px!important;"></span>
                <span class="menu-text">@lang('menu.cash_register')</span>
            </a>
        </li>
        <li>
            <a href="{{ route('orders') }}" class="{{ Request::is('orders') ? 'active':'' }}">
                <span class="nav-icon fas fa-shopping-cart" style="font-size: 14px!important;"></span>
                <span class="menu-text">@lang('menu.orders')</span>
            </a>
        </li>
    </ul>
</div>
