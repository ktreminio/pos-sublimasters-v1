<div class="breadcrumb-main">
    <h4 class="text-capitalize breadcrumb-title">@lang(!isset($title) ? 'Hola' : $title)</h4>
    <div class="breadcrumb-action justify-content-center flex-wrap">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><i class="las la-home"></i>@lang('menu.dashboard')</a></li>
                <li class="breadcrumb-item active"
                    aria-current="page">@lang(!isset($pageActual) ? (!isset($title) ? 'Hola' : $title) : $pageActual)</li>
            </ol>
        </nav>
    </div>
</div>
