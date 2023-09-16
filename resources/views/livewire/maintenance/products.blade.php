<div>
    @section('styles')
        <style>
            .space-initial {
                white-space: initial !important;
            }
        </style>
    @endsection
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-breadcrumb">
                    <x-breadcrumb title="pages.products.title"/>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="userDatatable orderDatatable global-shadow py-30 px-sm-30 px-20 radius-xl w-100 mb-30">
                    <div class="project-top-wrapper d-flex justify-content-between flex-wrap mb-25 mt-n10">
                        <div class="d-flex align-items-center flex-wrap justify-content-center">
                            <div class="project-search order-search  global-shadow mt-10">
                                <form action="/" class="order-search__form">
                                    <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                    <input wire:model="search" class="form-control me-sm-2 border-0 box-shadow-none" type="search"
                                           placeholder="@lang('pages.fields.search')" aria-label="Search">
                                </form>
                            </div><!-- End: .project-search -->
                        </div><!-- End: .d-flex -->
                        <div class="content-center mt-10">
                            <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                                <a href="{{route('products.create')}}" class="btn btn-sm btn-primary btn-squared">
                                    <i class="la la-plus fs-16"></i>
                                    @lang('pages.products.new')
                                </a>
                            </div>
                        </div><!-- End: .content-center -->
                    </div><!-- End: .project-top-wrapper -->

                    <div class="table-responsive">
                        <table class="table mb-0 border-0 table-borderless">
                            <thead>
                            <tr class="userDatatable-header">
                                <th wire:click="sortBy('products.name')" class="text-center cursor-true">
                                    <span class="userDatatable-title">@lang('pages.fields.name')</span>
                                    <x-sort-icon class="float-end mx-3" field="products.name" :sort-field="$sortField" :direction="$direction"/>
                                </th>
                                <th wire:click="sortBy('products.price')" class="text-center cursor-true">
                                    <span class="userDatatable-title">@lang('pages.fields.price')</span>
                                    <x-sort-icon class="float-end mx-3" field="products.price" :sort-field="$sortField" :direction="$direction"/>
                                </th>
                                <th wire:click="sortBy('categories.name')" class="text-center cursor-true">
                                    <span class="userDatatable-title">@lang('pages.fields.category')</span>
                                    <x-sort-icon class="float-end mx-3" field="categories.name" :sort-field="$sortField" :direction="$direction"/>
                                </th>
                                <th wire:click="sortBy('sub_categories.name')" class="text-center cursor-true">
                                    <span class="userDatatable-title">@lang('pages.fields.subcategory')</span>
                                    <x-sort-icon class="float-end mx-3" field="sub_categories.name" :sort-field="$sortField" :direction="$direction"/>
                                </th>
                                <th wire:click="sortBy('products.pasive')" class="text-center cursor-true">
                                    <span class="userDatatable-title">@lang('pages.fields.status')</span>
                                    <x-sort-icon class="float-end mx-3" field="products.pasive" :sort-field="$sortField" :direction="$direction"/>
                                </th>
                                <th class="text-center">
                                    <span class="userDatatable-title float-end">@lang('pages.fields.actions')</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($products) == 0 && $search != '')
                                <tr>
                                    <td colspan="6">
                                        <div class="d-flex justify-content-center align-items-center flex-column">
                                            <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_results')</p>
                                        </div>
                                    </td>
                                </tr>
                            @elseif(count($products) == 0)
                                <tr>
                                    <td colspan="6">
                                        <div class="d-flex justify-content-center align-items-center flex-column">
                                            <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_records')</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @foreach($products as $product)
                                <tr>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center">
                                            <div class="userDatatable__imgWrapper d-flex align-items-center">
                                                <span class="profile-image d-block m-0 wh-38 img-thumbnail"
                                                   style="background-image:url({{'storage/'.$product->url_image_principal}}); background-size: cover;"></span>
                                            </div>
                                            <div class="userDatatable-inline-title">
                                                <h6 class="space-initial overflow-hidden text-start" style="width: 300px">{{$product->name}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="userDatatable-content">
                                            C$ {{ number_format($product->price, 2) }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="userDatatable-content">
                                            {{$product->subcategory->category->name}}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="userDatatable-content">
                                            {{$product->subcategory->name}}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="userDatatable-content d-inline-block">
                                            @if($product->pasive)
                                                <span class="bg-opacity-danger  color-danger userDatatable-content-status active">@lang('pages.fields.inactive')</span>
                                            @else
                                                <span class="bg-opacity-success color-success rounded-pill userDatatable-content-status active">@lang('pages.fields.active')</span>
                                            @endif

                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                            <li>
                                                <a class="edit cursor-true" href="{{route('products.edit', $product->id)}}">
                                                    <i class="uil uil-edit"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="cursor-true {{$product->pasive ? 'view' : 'remove'}}">
                                                    <i class="uil {{$product->pasive ? 'uil-thumbs-up' : 'uil-thumbs-down'}}"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($products->hasPages())
                        <div class="d-flex border-top justify-content-end pt-20">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
