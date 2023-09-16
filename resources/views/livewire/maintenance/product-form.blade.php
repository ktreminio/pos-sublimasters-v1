<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-breadcrumb">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">@lang('pages.products.'.$action)</h4>
                        <div class="breadcrumb-action justify-content-center flex-wrap">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('products')}}"><i class="las la-home"></i>@lang('menu.products')</a>
                                    </li>
                                    <li class="breadcrumb-item active"
                                        aria-current="page">@lang('pages.products.'.$action)</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="product-add global-shadow px-sm-30 py-sm-50 px-0 py-20 bg-white radius-xl w-100 mb-40">
                    <div class="row justify-content-center">
                        <div class="col-xxl-7 col-lg-10">
                            <div class="mx-sm-30 mx-20 ">
                                <div class="card add-product p-sm-30 p-20 mb-30" wire:key="detail-product">
                                    <div class="card-body p-0">
                                        <div class="card-header">
                                            <h6 class="fw-500">@lang('pages.products.about')</h6>
                                        </div>
                                        <div class="add-product__body px-sm-40 px-20">
                                            <form>
                                                <div class="form-group">
                                                    <label for="name">@lang('pages.fields.product_name')</label>
                                                    <input wire:model.defer="name"
                                                           type="text"
                                                           name="name"
                                                           autofocus
                                                           class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                                           id="name" placeholder="@lang('pages.fields.product_name')"
                                                    />
                                                    @error('name')
                                                    <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>@lang('pages.fields.category')</label>
                                                        <div class="select-style2">
                                                            <div class="dm-select " wire:key="select-category">
                                                                <select wire:model="category_id" name="category" id="category_id" class="form-control" @if(!$open) disabled @endif>
                                                                    <option value=""></option>
                                                                    @foreach($categories as $category)
                                                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @error('category_id')
                                                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>@lang('pages.fields.subcategory')</label>
                                                        <div class="select-style2">
                                                            <div class="dm-select " wire:key="select-subcategory">
                                                                <select wire:model="subcategory_id" name="subcategory" id="subcategory_id" class="form-control" @if(!$open) disabled @endif>
                                                                    <option value=""></option>
                                                                    @foreach($subcategories as $subcategory)
                                                                        <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        @error('subcategory_id')
                                                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                @if($subcategory_id)
                                                    @if(!$this->subcategory->color && !$this->subcategory->size)
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="quantity">@lang('pages.fields.quantity')</label>
                                                                <input wire:model.defer="quantity"
                                                                       type="number"
                                                                       name="quantity"
                                                                       class="form-control"
                                                                       min="1"
                                                                       step="1"
                                                                       data-inc="1" />
                                                                @error('quantity')
                                                                <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="stock_min">@lang('pages.fields.stock_min')</label>
                                                                <input wire:model.defer="stock_min"
                                                                       type="number"
                                                                       name="stock_min"
                                                                       class="form-control"
                                                                       min="1"
                                                                       step="1"
                                                                       data-inc="1">
                                                                @error('stock_min')
                                                                <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif
                                                <div class="row">
                                                    <div class="form-group quantity-appearance col-md-6">
                                                        <label for="price">@lang('pages.fields.price')</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon1">C$</span>
                                                            </div>
                                                            <div class="pt_Quantity">
                                                                <input wire:model.defer="price"
                                                                       type="number"
                                                                       name="price"
                                                                       class="form-control"
                                                                       pattern="^\d*(\.\d{0,2})?$"
                                                                       min="1"
                                                                       step=".01"
                                                                       data-inc="1"/>
                                                            </div>
                                                        </div>
                                                        @error('price')
                                                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">@lang('pages.fields.description')</label>
                                                    <textarea wire:model.defer="description"
                                                              class="form-control"
                                                              id="description"
                                                              name="description"
                                                              rows="3"
                                                              placeholder="@lang('pages.fields.description')"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>@lang('pages.products.image')</label>
                                                    <div class="add-product__body-img p-0">
                                                        <label for="image" class="file-upload__label">
                                                            <span class="upload-product-img py-4 d-block">
                                                                <span class="file-upload">
                                                                    <img class="svg" src="{{ asset('assets/img/svg/upload.svg') }}" alt="">
                                                                    <input wire:model="image"
                                                                           wire:loading.attr="disabled"
                                                                           wire:target="image"
                                                                           id="image"
                                                                           class="file-upload__input"
                                                                           type="file"
                                                                           name="file-upload">
                                                                </span>
                                                                <span class="pera">@lang('pages.products.select_image')</span>
                                                            </span>
                                                        </label>
                                                        @error('image')
                                                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                        @enderror
                                                        <div class="upload-product-media d-flex justify-content-between align-items-center mt-25">
                                                            <div class="upload-media-area d-flex">
                                                                <div wire:loading wire:target="image"
                                                                     wire:key="image-loading"
                                                                     class="w-100"
                                                                >
                                                                    <p class="color-primary fw-500 mb-0 text-center align-middle">
                                                                        <i class="fa fa-spin fa-spinner fs-20"></i> @lang('pages.actions.loading')
                                                                    </p>
                                                                </div>
                                                                @if($image && ($image->getClientOriginalExtension() === 'png' || $image->getClientOriginalExtension() === 'jpg') && $image->getSize() <= 5242880)
                                                                    <x-img-upload wire:click="deleteImage"
                                                                                  target="deleteImage"
                                                                                  :url="$image->temporaryUrl()"
                                                                                  :name="$image->getClientOriginalName()"
                                                                                  :size="$image->getSize()"/>
                                                                @elseif($image_actual && !$pasive_image_actual)
                                                                    <x-img-upload wire:click="deleteImage"
                                                                                  target="deleteImage"
                                                                                  url="/storage/{{$image_actual}}" />
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @if($subcategory_id)
                                    @if($this->subcategory->color && !$this->subcategory->size)
                                        <div class="card add-product p-sm-30 p-20" wire:key="detail-color">
                                            <div class="card-body p-0">
                                                <div class="card-header">
                                                    <h6 class="fw-500">@lang('pages.colors.about')</h6>
                                                </div>
                                                <div class="add-product__body px-sm-40 px-20">
                                                    <div class="row">
                                                        <div class="form-group quantity-appearance col-md-4 mb-0">
                                                            <label for="color">@lang('pages.fields.color')</label>
                                                            <div class="select-style2">
                                                                <div class="dm-select" wire:key="select-color">
                                                                    <select wire:model="color_id" name="color" id="color_id" class="form-control">
                                                                        <option value=""></option>
                                                                        @foreach($colors as $color)
                                                                            <option value="{{$color->id}}">{{$color->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            @error('color_id')
                                                            <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-4 mb-0">
                                                            <label for="quantity_color">@lang('pages.fields.quantity')</label>
                                                            <input wire:model.defer="quantity_color"
                                                                   type="number"
                                                                   name="quantity_color"
                                                                   class="form-control"
                                                                   min="1"
                                                                   step="1"
                                                                   data-inc="1">
                                                            @error('quantity_color')
                                                            <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group col-md-4 mb-0">
                                                            <label for="stock_min_color">@lang('pages.fields.stock_min')</label>
                                                            <input wire:model.defer="stock_min_color"
                                                                   type="number"
                                                                   name="stock_min_color"
                                                                   class="form-control"
                                                                   min="0"
                                                                   value="0"
                                                                   step="1"
                                                                   data-inc="1">
                                                            @error("stock_min_color")
                                                            <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-sm-end justify-content-center mt-10">
                                                        <button type="button" class="btn btn-primary btn-default btn-squared text-capitalize" wire:loading.remove wire:click="addColor">@lang('pages.actions.add')</button>
                                                        <span class="btn btn-primary btn-default btn-squared text-capitalize" wire:loading wire:target="addColor"><i class="fa fa-spin fa-spinner"></i></span>
                                                    </div>
                                                    @if(count($color_products))
                                                        <div class="userDatatable global-shadow p-0 radius-xl w-100 mt-30 mb-10">
                                                            <div class="table-responsive">
                                                                <table class="table table-borderless">
                                                                    <thead>
                                                                    <tr class="userDatatable-header">
                                                                        <th class="text-center">
                                                                            <span class="userDatatable-title">@lang('pages.fields.color')</span>
                                                                        </th>
                                                                        <th class="text-center">
                                                                            <span class="userDatatable-title">@lang('pages.fields.quantity')</span>
                                                                        </th>
                                                                        <th class="text-center">
                                                                            <span class="userDatatable-title">@lang('pages.fields.stock_min')</span>
                                                                        </th>
                                                                        <th class="text-center">
                                                                            <span class="userDatatable-title">@lang('pages.fields.actions')</span>
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @if(count($color_products) == count(array_filter(array_column($color_products, 'pasive'))))
                                                                        <tr>
                                                                            <td colspan="4">
                                                                                <div class="d-flex justify-content-center align-items-center flex-column">
                                                                                    <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_records')</p>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                    @foreach($color_products as $key => $color_product)
                                                                        @if(!$color_product['pasive'])
                                                                            <tr wire:key="{{$key}}">
                                                                                <td class="text-center">
                                                                                    <div class="userDatatable-content">
                                                                                        {{$color_product['name']}}
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="userDatatable-content">
                                                                                        {{$color_product['quantity']}}
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <div class="userDatatable-content">
                                                                                        {{$color_product['stock_min']}}
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <ul class="orderDatatable_actions mb-0 d-flex justify-content-center">
                                                                                        <li>
                                                                                            <a class="edit cursor-true"
                                                                                               wire:click="editColor({{$key}})">
                                                                                                <i class="uil uil-edit"></i>
                                                                                            </a>
                                                                                        </li>
                                                                                        <li wire:target="removeColor({{$key}})"
                                                                                            wire:loading.remove
                                                                                        >
                                                                                            <a class="cursor-true remove"
                                                                                               wire:click="removeColor({{$key}})">
                                                                                                <i class="uil uil-trash-alt"></i>
                                                                                            </a>
                                                                                        </li>
                                                                                        <li wire:target="removeColor({{$key}})"
                                                                                            wire:loading
                                                                                        >
                                                                                            <a class="cursor-true remove">
                                                                                                <i class="fa fa-spin fa-spinner"></i>
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    @error('color_products')
                                                    <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($this->subcategory->size)
                                        <div class="card order-summery p-sm-30 p-20 " wire:key="detail-size" id="detail_size">
                                            <div class="card-body p-0">
                                                <div class="card-header">
                                                    <h6 class="fw-500">@lang('pages.sizes.about')</h6>
                                                </div>
                                                <div class="add-product__body px-sm-40 px-20">
                                                    <div class="form-group">
                                                        <label for="name_size">@lang('pages.fields.size')</label>
                                                        <input wire:model.defer="name_size"
                                                               type="text"
                                                               name="name_size"
                                                               class="form-control ih-medium ip-gray radius-xs b-light px-15"
                                                               id="name_size" placeholder="@lang('pages.fields.size')"
                                                        />
                                                        @error('name_size')
                                                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="d-flex justify-content-end mt-10">
                                                        <button type="button" class="btn btn-primary btn-default btn-squared text-capitalize" wire:loading.remove wire:click="addSize">@lang('pages.sizes.add')</button>
                                                        <span class="btn btn-primary btn-default btn-squared text-capitalize" wire:loading wire:target="addSize"><i class="fa fa-spin fa-spinner"></i></span>
                                                    </div>
                                                    @error('sizes')
                                                    <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                    @enderror

                                                    @if(count($sizes))
                                                        <div class="row mt-30">
                                                            @foreach($sizes as $key => $size)
                                                                @if(!$size['pasive'])
                                                                    <div class="col-12" wire:key="card-size-{{$key}}">
                                                                        <div class="card rounded p-0 mb-4">
                                                                            <div class="card-header d-flex flex-row justify-content-between align-items-center p-20">
                                                                                <h6 class="overflow-visible">{{  $size['name'] }}</h6>
                                                                                <ul class="orderDatatable_actions mb-0 d-flex justify-content-end">
                                                                                    <li>
                                                                                        <a class="edit cursor-true"
                                                                                           wire:click="editSize({{$key}})">
                                                                                            <i class="uil uil-edit"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li wire:target="removeSize({{$key}})"
                                                                                        wire:loading.remove
                                                                                    >
                                                                                        <a class="cursor-true remove"
                                                                                           wire:click="removeSize({{$key}})">
                                                                                            <i class="uil uil-trash-alt"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                    <li wire:target="removeSize({{$key}})"
                                                                                        wire:loading
                                                                                    >
                                                                                        <a class="cursor-true remove">
                                                                                            <i class="fa fa-spin fa-spinner"></i>
                                                                                        </a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="card-body p-20 rounded-0 rounded-bottom">
                                                                                <div class="add-product__body p-0">
                                                                                    <div class="row">
                                                                                        <div class="form-group quantity-appearance col-md-4 mb-0">
                                                                                            <label for="color_size">@lang('pages.fields.color')</label>
                                                                                            <div class="select-style2" wire:key="select-color-{{$key}}">
                                                                                                <div class="dm-select">
                                                                                                    <select wire:model="color_size_products.{{$key}}.color_size_id"
                                                                                                            wire:key="color-size-{{$key}}"
                                                                                                            data-key="{{$key}}"
                                                                                                            name="color_size"
                                                                                                            id="color_size_id-{{$key}}"
                                                                                                            class="form-control">
                                                                                                        <option value=""></option>
                                                                                                        @foreach($colors as $color)
                                                                                                            <option value="{{$color->id}}">{{$color->name}}</option>
                                                                                                        @endforeach
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            @error("color_size_products.$key.color_size_id")
                                                                                            <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div class="form-group col-md-4 mb-0">
                                                                                            <label for="quantity_color_size">@lang('pages.fields.quantity')</label>
                                                                                            <input wire:model.defer="color_size_products.{{$key}}.quantity_color_size"
                                                                                                   wire:key="quantity-color-size-{{$key}}"
                                                                                                   type="number"
                                                                                                   name="quantity_color_size"
                                                                                                   class="form-control"
                                                                                                   min="1"
                                                                                                   step="1"
                                                                                                   data-inc="1">
                                                                                            @error("color_size_products.$key.quantity_color_size")
                                                                                            <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                                                            @enderror
                                                                                        </div>
                                                                                        <div class="form-group col-md-4 mb-0">
                                                                                            <label for="stock_min_color_size">@lang('pages.fields.stock_min')</label>
                                                                                            <input wire:model.defer="color_size_products.{{$key}}.stock_min_color_size"
                                                                                                   wire:key="stock-min-color-size-{{$key}}"
                                                                                                   type="number"
                                                                                                   name="stock_min_color_size"
                                                                                                   class="form-control"
                                                                                                   min="1"
                                                                                                   step="1"
                                                                                                   data-inc="1">
                                                                                            @error("color_size_products.$key.stock_min_color_size")
                                                                                            <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                                                            @enderror
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="d-flex justify-content-end mt-10">
                                                                                        <button type="button"
                                                                                                class="btn btn-primary btn-default btn-squared text-capitalize"
                                                                                                wire:loading.remove
                                                                                                wire:target="addColorToSize({{$key}})"
                                                                                                wire:key="add-color-size-{{$key}}"
                                                                                                wire:click="addColorToSize({{$key}})">@lang('pages.colors.add')</button>
                                                                                        <span class="btn btn-primary btn-default btn-squared text-capitalize"
                                                                                              wire:key="add-color-size-loading-{{$key}}"
                                                                                              wire:loading
                                                                                              wire:target="addColorToSize({{$key}})"><i class="fa fa-spin fa-spinner"></i></span>
                                                                                    </div>
                                                                                    @if(count($size['colors']))
                                                                                        <div class="userDatatable global-shadow p-0 radius-xl w-100 mt-30 mb-10" wire:key="datatable-{{$key}}">
                                                                                            <div class="table-responsive">
                                                                                                <table class="table table-borderless" wire:key="table-color-{{$key}}">
                                                                                                    <thead>
                                                                                                    <tr class="userDatatable-header">
                                                                                                        <th class="text-center">
                                                                                                            <span class="userDatatable-title">@lang('pages.fields.color')</span>
                                                                                                        </th>
                                                                                                        <th class="text-center">
                                                                                                            <span class="userDatatable-title">@lang('pages.fields.quantity')</span>
                                                                                                        </th>
                                                                                                        <th class="text-center">
                                                                                                            <span class="userDatatable-title">@lang('pages.fields.stock_min')</span>
                                                                                                        </th>
                                                                                                        <th class="text-center">
                                                                                                            <span class="userDatatable-title">@lang('pages.fields.actions')</span>
                                                                                                        </th>
                                                                                                    </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                    @if(count($size['colors']) == count(array_filter(array_column($size['colors'], 'pasive'), function ($value) { return $value; })))
                                                                                                        <tr>
                                                                                                            <td colspan="4">
                                                                                                                <div class="d-flex justify-content-center align-items-center flex-column">
                                                                                                                    <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_records')</p>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    @endif
                                                                                                    @foreach($size['colors'] as $key_color_size => $color_size)
                                                                                                        @if(!$color_size['pasive'])
                                                                                                            <tr wire:key="tr-tbody-{{$key.'-'.$key_color_size}}">
                                                                                                                <td class="text-center">
                                                                                                                    <div class="userDatatable-content">
                                                                                                                        {{$color_size['name']}}
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td class="text-center">
                                                                                                                    <div class="userDatatable-content">
                                                                                                                        {{$color_size['quantity']}}
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td class="text-center">
                                                                                                                    <div class="userDatatable-content">
                                                                                                                        {{$color_size['stock_min']}}
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td class="text-center">
                                                                                                                    <ul class="orderDatatable_actions mb-0 d-flex justify-content-center">
                                                                                                                        <li>
                                                                                                                            <a class="edit cursor-true"
                                                                                                                               wire:click="editColor({{$key_color_size.','.$key}})">
                                                                                                                                <i class="uil uil-edit"></i>
                                                                                                                            </a>
                                                                                                                        </li>
                                                                                                                        <li wire:key="li-color-size-{{$key.'-'.$key_color_size}}"
                                                                                                                            wire:target="removeColorToSize({{$key.','.$key_color_size}})"
                                                                                                                            wire:loading.remove
                                                                                                                        >
                                                                                                                            <a class="cursor-true remove"
                                                                                                                               wire:click="removeColorToSize({{$key.','.$key_color_size}})">
                                                                                                                                <i class="uil uil-trash-alt"></i>
                                                                                                                            </a>
                                                                                                                        </li>
                                                                                                                        <li wire:key="li-color-size-loading-{{$key.'-'.$key_color_size}}"
                                                                                                                            wire:target="removeColorToSize({{$key.','.$key_color_size}})"
                                                                                                                            wire:loading
                                                                                                                        >
                                                                                                                            <a class="cursor-true remove">
                                                                                                                                <i class="fa fa-spin fa-spinner"></i>
                                                                                                                            </a>
                                                                                                                        </li>
                                                                                                                    </ul>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                    @error('sizes.'.$key.'.colors')
                                                                                    <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="button-group add-product-btn d-flex justify-content-sm-end justify-content-center mt-40">
                                    <button type="button" class="btn btn-danger btn-default btn-squared text-capitalize" wire:click="cancelSave">@lang('pages.actions.cancel')</button>
                                    <button type="button" class="btn btn-primary btn-default btn-squared text-capitalize" wire:loading.remove wire:click="save">@lang('pages.products.save')</button>
                                    <span class="btn btn-primary btn-default btn-squared text-capitalize" wire:loading wire:target="save"><i class="fa fa-spin fa-spinner"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Color -->
    <x-modal id="edit-color"
             data-bs-backdrop="static"
             wire:ignore.self
             class-modal="modal-sm"
    >
        <x-slot name="size">modal-sm</x-slot>
        <x-slot name="header" wire:click="resetColorEditFields">
            @lang('pages.colors.edit')
        </x-slot>
        <x-slot name="body">
            <div class="form-group row mb-25">
                <label for="color_id_edit" class="col-sm-3 col-form-label color-dark fs-14 fw-500">@lang('pages.fields.color')</label>
                <div class="col-sm-9">
                    <div class="select-style2">
                        <div class="dm-select" wire:key="select-color-edit">
                            <select wire:model="color_id_edit" name="color_id_edit" id="color_id_edit" class="form-control" disabled>
                                <option value=""></option>
                                @foreach($colors as $color)
                                    <option value="{{$color->id}}">{{$color->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('color_id_edit')
                    <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-25">
                <label for="quantity_color_edit" class="col-sm-3 col-form-label color-dark fs-14 fw-500">@lang('pages.fields.quantity')</label>
                <div class="col-sm-9">
                    <input wire:model.defer="quantity_color_edit"
                           type="number"
                           name="quantity_color_edit"
                           class="form-control ih-medium ip-gray radius-xs b-light px-15"
                           min="0"
                           value="0"
                           step="1"
                           data-inc="1">
                    @error('quantity_color_edit')
                    <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-25">
                <label for="stock_min_color_edit" class="col-sm-3 col-form-label color-dark fs-14 fw-500">@lang('pages.fields.stock_min')</label>
                <div class="col-sm-9">
                    <input wire:model.defer="stock_min_color_edit"
                           type="number"
                           name="stock_min_color_edit"
                           class="form-control ih-medium ip-gray radius-xs b-light px-15"
                           min="0"
                           value="0"
                           step="1"
                           data-inc="1">
                    @error('stock_min_color_edit')
                    <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="resetColorEditFields">@lang('pages.actions.cancel')</button>
            <button type="button" class="btn btn-primary btn-sm" wire:loading.remove wire:click="saveColor">@lang('pages.actions.save')</button>
            <span class="btn btn-primary btn-sm" wire:loading wire:target="saveColor"><i class="fa fa-spin fa-spinner"></i></span>
        </x-slot>
    </x-modal>

    <!-- Modal Edit Size -->
    <x-modal id="edit-size"
             data-bs-backdrop="static"
             wire:ignore.self
             class-modal="modal-sm"
    >
        <x-slot name="size">modal-sm</x-slot>
        <x-slot name="header" wire:click="resetSizeEditFields">
            @lang('pages.sizes.edit')
        </x-slot>
        <x-slot name="body">
            <div class="form-group row mb-25">
                <label for="name_size_edit" class="col-sm-3 col-form-label color-dark fs-14 fw-500">@lang('pages.fields.name')</label>
                <div class="col-sm-9">
                    <input wire:model.defer="name_size_edit"
                           type="text"
                           name="name_size_edit"
                           class="form-control ih-medium ip-gray radius-xs b-light px-15 @error('name_size_edit') is-invalid @enderror"
                           id="name_size_edit" placeholder="@lang('pages.fields.name')"
                    />
                    @error('name_size_edit')
                    <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="resetSizeEditFields">@lang('pages.actions.cancel')</button>
            <button type="button" class="btn btn-primary btn-sm" wire:loading.remove wire:click="saveSize">@lang('pages.actions.save')</button>
            <span class="btn btn-primary btn-sm" wire:loading wire:target="saveSize"><i class="fa fa-spin fa-spinner"></i></span>
        </x-slot>
    </x-modal>

    <!-- Modal Confirm Cancel -->
    <x-confirm-modal
        id="confirm-cancel"
        data-bs-backdrop="static"
        wire:ignore.self
    >
        <x-slot name="question">
            @lang('pages.actions.cancel_question')
        </x-slot>

        <x-slot name="description">
            @lang('pages.actions.cancel_description')
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="resetFields">@lang('pages.actions.no')</button>
            <button type="button" class="btn btn-primary btn-sm" wire:loading.remove wire:click="save">@lang('pages.actions.yes')</button>
            <span class="btn btn-primary btn-sm" wire:loading wire:target="save"><i class="fa fa-spin fa-spinner"></i></span>
        </x-slot>
    </x-confirm-modal>
    @section('scripts')
        <script>
            $(document).ready(function () {
                renderSelect2()

                window.addEventListener('log', event => {
                    console.log(event.detail);
                });

                $(document).on('change', '#category_id', function (e) {
                    @this.set('category_id', e.target.value);
                });

                $(document).on('change', '#subcategory_id', function (e) {
                    @this.set('subcategory_id', e.target.value);
                });

                $(document).on('change', '#color_id', function (e) {
                    @this.set('color_id', e.target.value);
                });

                $(document).on('change', '#detail_size select', e => {
                    @this.set('color_size_products.'+e.target.attributes['data-key'].value+'.color_size_id', e.target.value);
                });

                window.addEventListener('render-select2', event => {
                    renderSelect2();
                });

                window.addEventListener('closeModalEditColor', () => {
                    $('#edit-color').modal('hide');
                });

                window.addEventListener('openModalEditColor', () => {
                    $('#edit-color').modal('show');
                });

                window.addEventListener('closeModalEditSize', () => {
                    $('#edit-size').modal('hide');
                });

                window.addEventListener('openModalEditSize', () => {
                    $('#edit-size').modal('show');
                });

                window.addEventListener('closeModalConfirmCancel', () => {
                    $('#confirm-cancel').modal('hide');
                });

                window.addEventListener('openModalConfirmCancel', () => {
                    $('#confirm-cancel').modal('show');
                });
            });

            $(document).on('keydown', 'input[pattern]', function(e){
                var input = $(this);
                var oldVal = input.val();
                var regex = new RegExp(input.attr('pattern'), 'g');

                setTimeout(function(){
                    var newVal = input.val();
                    if(!regex.test(newVal)){
                        input.val(oldVal);
                    }
                }, 1);
            });

            function renderSelect2() {
                $('select').select2(
                    {
                        placeholder: "{{__('pages.fields.select_option')}}",
                        dropdownCssClass:"alert2",
                        allowClear: true
                    }
                );
            }

        </script>
    @endsection
</div>
