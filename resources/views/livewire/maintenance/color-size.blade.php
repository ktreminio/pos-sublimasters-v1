<div class="col-12">
    <div class="card p-0 mb-4">
        <div class="card-header d-flex justify-content-between align-items-center p-20">
            <h6>{{ $size_name }}</h6>
            <ul class="orderDatatable_actions mb-0 d-flex justify-content-end">
                <li>
                    <a class="cursor-true remove" wire:click="removeSize">
                        <i class="uil uil-trash-alt"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body p-20 bg-transparent">
            <div class="add-product__body p-0">
                <div class="row">
                    <div class="form-group quantity-appearance col-md-6 mb-0">
                        <label for="color_size">@lang('pages.fields.color')</label>
                        <div class="select-style2">
                            <div class="dm-select" wire:key="select-color">
                                <select wire:model="color_size_id"
                                        name="color_size"
                                        id="color_size_id"
                                        class="form-control">
                                    <option value=""></option>
                                    @foreach($colors as $color)
                                        <option value="{{$color->id}}">{{$color->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error("color_size_id")
                            <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-0">
                        <label for="quantity_color_size">@lang('pages.fields.quantity')</label>
                        <input wire:model.defer="color_size_products.{{$key}}.quantity_color_size"
                               wire:key="quantity-color-size-{{$key}}"
                               type="number"
                               name="quantity_color_size"
                               class="form-control"
                               min="1"
                               step="1"
                               data-inc="1">
                        @error("color_size_products.{{$key}}.quantity_color_size")
                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                        @enderror

                        @if($color_size_products && isset($color_size_products[$key]['quantity_color_size']))
                            {{  $color_size_products[$key]['quantity_color_size'] }}
                        @endif
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-10">
                    <button type="button" class="btn btn-primary btn-default btn-squared text-capitalize" wire:loading.remove wire:click="addColorToSize({{$key}})">@lang('pages.actions.add')</button>
                    <span class="btn btn-primary btn-default btn-squared text-capitalize" wire:loading wire:target="addColorToSize({{$key}})"><i class="fa fa-spin fa-spinner"></i></span>
                </div>
                @error('sizes.'.$key.'.colors')
                <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                @enderror
                @if(count($size['colors']))
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
                                        <span class="userDatatable-title">@lang('pages.fields.actions')</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($size['colors'] as $key_color_size => $color_size)
                                    <tr wire:key="{{$key_color_size}}">
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                {{$color_size['color']}}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                {{$color_size['quantity']}}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <ul class="orderDatatable_actions mb-0 d-flex justify-content-center">
                                                <li>
                                                    <a class="cursor-true remove" wire:click="removeColorToSize({{$key.','.$key_color_size}})">
                                                        <i class="uil uil-trash-alt"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div></div>
