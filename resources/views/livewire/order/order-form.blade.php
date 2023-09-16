<div>
    <div class="cartPage global-shadow px-0 py-sm-15 radius-xl w-100">
        <div class="row justify-content-center">
            <div class="cus-xl-8 col-lg-8 col-12">
                <div class="row mb-30">
                    <div class="form-group col-md-8">
                        <label class="col-form-label align-center color-gray fs-14 fw-500 me-4" for="product">@lang('pages.fields.product')</label>
                        <div class="select-style2">
                            <div class="dm-select" wire:key="select-product">
                                <select wire:model="product_id"
                                        name="product"
                                        id="product_id"
                                        class="form-control select2">
                                    <option value=""></option>
                                    @foreach($products as $product)
                                        <option value="{{$product['id']}}">{{$product['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @error('product_id')
                            <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="row px-0 col-md-4">
                        @if(count($sizes))
                            <div class="form-group quantity-appearance col-md-6 mb-0">
                                <label class="col-form-label align-center color-gray fs-14 fw-500 me-4" for="size">@lang('pages.fields.size')</label>
                                <div class="select-style2">
                                    <div class="dm-select" wire:key="select-size">
                                        <select wire:model="size_id"
                                                name="size"
                                                id="size_id"
                                                class="form-control form-control-default select2">
                                            <option value=""></option>
                                            @foreach($sizes as $size)
                                                <option value="{{$size['id']}}">{{$size['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('size_id')
                                <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        @if(count($colors))
                            <div class="form-group quantity-appearance col-md-6 mb-0">
                                <label class="col-form-label align-center color-gray fs-14 fw-500 me-4" for="color">@lang('pages.fields.color')</label>
                                <div class="select-style2">
                                    <div class="dm-select" wire:key="select-color">
                                        <select wire:model="color_id"
                                                name="color"
                                                id="color_id"
                                                class="form-control form-control-default select2">
                                            <option value=""></option>
                                            @foreach($colors as $color)
                                                <option value="{{$color['color_id']}}">{{$color['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @error('color_id')
                                <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>

                <div class="product-cart mb-sm-0 mb-20">
                    <div class="table-responsive">
                        <table id="cart" class="table table-borderless table-hover">
                            <thead>
                                <tr class="product-cart__header">
                                    <th style="width:30%" scope="col" class="text-center">@lang('pages.fields.product')</th>
                                    <th style="width:20%" scope="col" class="text-center">@lang('pages.fields.price')</th>
                                    <th style="width:20%" scope="col" class="text-center">@lang('pages.fields.quantity')</th>
                                    <th style="width:20%" scope="col" class="text-center">@lang('pages.fields.total')</th>
                                    <th style="width:10%" scope="col" class=""></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(isset($orderProducts) && count($orderProducts))
                                @foreach($orderProducts as $index => $orderProduct)
                                    <tr>
                                        <td class="Product-cart-title pb-0">
                                            <div class="media align-items-center flex-wrap">
                                                <img class="me-3 wh-80 align-self-center img-thumbnail"
                                                     src="{{'storage/'.$orderProduct['image']}}"
                                                     alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h5 class="mt-0">{{$orderProduct['name']}}</h5>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="price align-top text-center pb-0"><p class="mt-4">C$ {{number_format($orderProduct['price'], 2)}}</p></td>
                                        <td class="align-top pb-0">
                                            <div class="quantity product-cart__quantity mt-3">
                                                <input type="button"
                                                       wire:click="onChangeQuantity({{$index . ',' . $orderProduct['quantity'] . ',' . 0}})"
                                                       value="-"
                                                       {{ $orderProduct['quantity'] == 1 ? 'disabled' : '' }}
                                                       wire:loading.attr="disabled"
                                                       wire:target="onChangeQuantity({{$index . ',' . $orderProduct['quantity'] . ',' . 0}})"
                                                       class="qty-minus bttn bttn-left wh-36"/>
                                                <input min="1" step="1"
                                                       data-inc="1"
                                                       data-key="{{$index}}"
                                                       pattern="^[1-9]\d*$"
                                                       wire:model="orderProducts.{{$index}}.quantity"
                                                       type="number"
                                                       value="{{ $orderProduct['quantity'] }}"
                                                       class="input-qty qty qh-36 input" />
                                                <input type="button"
                                                       {{ $orderProduct['quantity'] == $orderProduct['available_stock'] ? 'disabled' : '' }}
                                                       wire:loading.attr="disabled"
                                                       wire:target="onChangeQuantity({{$index . ',' . $orderProduct['quantity'] . ',' . 1}})"
                                                       wire:click="onChangeQuantity({{$index . ',' . $orderProduct['quantity'] . ',' . 1}})"
                                                       value="+"
                                                       class="qty-plus bttn bttn-right wh-36"/>
                                            </div>
                                        </td>
                                        <td class="text-center subtotal align-top pb-0">
                                            <p class="mt-4">C$ {{number_format($orderProduct['total'], 2)}}</p>
                                        </td>
                                        <td class="actions align-top pb-0">
                                            <button type="button"
                                                    wire:loading.remove
                                                    wire:click="removeProduct({{$index}})"
                                                    wire:target="removeProduct({{$index}})"
                                                    class="action-btn float-end mt-3"
                                            >
                                                <i class="las la-trash-alt"></i>
                                            </button>
                                            <button type="button"
                                                    wire:loading.class.remove="d-none"
                                                    wire:target="removeProduct({{$index}})"
                                                    class="action-btn float-end d-none mt-3"
                                            >
                                                <i class="fa fa-spin fa-spinner"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="Product-cart-title py-0">
                                            <div class="media align-items-center flex-wrap">
                                                <div class="media-body">
                                                    <div class="d-flex">
                                                        @if($orderProduct['size_name'])
                                                            <p>@lang('pages.fields.size'):<span>{{$orderProduct['size_name']}}</span></p>
                                                        @endif
                                                        @if($orderProduct['color_name'])
                                                            <p class="align-center"> @lang('pages.fields.color'):
                                                                <span class="color-circle" style="background-color: {{$orderProduct['hex']}}"></span>
                                                            </p>
                                                        @endif
                                                        <p>@lang('pages.fields.stock'):<span>{{$orderProduct['new_available_stock']}}</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">
                                        <div class="d-flex justify-content-center align-items-center flex-column">
                                            <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_records')</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="px-0">
                                        <div class="form-group form-element-textarea mb-20">
                                            <label for="description"
                                                   class="fs-14 fw-500 align-center mb-10">
                                                @lang('pages.fields.description')
                                            </label>
                                            <textarea class="form-control bg-normal"
                                                      wire:model="description"
                                                      id="description"
                                                      placeholder="@lang('pages.orders.description_optional')"
                                            >
                                            </textarea>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="cus-xl-4 col-lg-4 col-md-8">
                <div class="card order-summery p-sm-25 p-15 order-summery--width mt-lg-0 mt-20">
                    <div class="card-header border-0 p-0 pb-15">
                        <h5 class="fw-500">@lang('pages.orders.summary')</h5>
                    </div>
                    <div class="card-body px-sm-25 px-20">
                        <div class="form-group d-flex justify-content-between form-group-calender mb-20">
                            <label for="deadline" class="col-form-label align-center color-gray fs-14 fw-500 me-4">@lang('pages.fields.deadline'):</label>
                            <div class="position-relative">
                                <input type="text"
                                       class="form-control form-control-default"
                                       id="deadline" placeholder="{{date('d/m/Y')}}"/>
                                <a><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg replaced-svg"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg></a>
                            </div>
                        </div>
                        @error('deadline')
                            <span class="invalid-feedback d-block fs-6 mt-0 mb-3" role="alert">{{ $message }}</span>
                        @enderror
                        <div class="total">
                            <div class="subtotalTotal">
                                @lang('pages.orders.subtotal'): <span>C$ {{number_format($subTotal, 2)}}</span>
                            </div>
                            <div class="taxes">
                                @lang('pages.orders.discount'): <span class=text-danger>-C$ {{number_format($discount, 2)}}</span>
                            </div>
                        </div>
                        <div class="select-cupon position-relative mb-4" wire:ignore>
                            <span class="percent text-success me-3"><i class="fas fa-money-check-alt"></i></span>
                            <select class="js-example-basic-single js-states form-control" id="cupon">
                                <option value="CASH">@lang('pages.actions.payment_method.cash')</option>
                                <option value="TRANSFER">@lang('pages.actions.payment_method.transfer')</option>
                            </select>
                        </div>
                        @error('paymentMethod')
                            <span class="invalid-feedback d-block fs-6 mt-0 mb-3" role="alert">{{ $message }}</span>
                        @enderror

                        @if($paymentMethod == 'CASH')
                            <div class="d-flex justify-content-between mb-4">
                                <label class="col-form-label align-center color-gray fs-14 fw-500 me-4" style="width: 80px" for="payWith">@lang('pages.orders.pay_with'):</label>
                                <div class="with-icon">
                                    <span class="fas fa-hand-holding-usd color-light"></span>
                                    <input type="number"
                                           wire:model="payWith"
                                           pattern="^\d*(\.\d{0,2})?$"
                                           class="form-control b-light form-control-sm py-2"
                                           id="payWith"
                                           min="1"
                                           step=".01"
                                           data-inc="1" />
                                </div>
                            </div>
                            <div class="total">
                                <div class="subtotalTotal">
                                    @lang('pages.orders.exchange'): <span>C$ {{number_format($exchange, 2)}}</span>
                                </div>
                            </div>
                        @endif

                        <div class="total-money d-flex justify-content-between">
                            <h6>@lang('pages.orders.total'):</h6>
                            <h5>C$ {{ number_format($total, 2) }}</h5>
                        </div>
                        <a type="button"
                           wire:click="save"
                           class="checkout btn-secondary content-center w-100 btn-lg mt-20">
                            <span wire:loading.remove wire:target="save">@lang('pages.actions.make_order') <i class="las la-arrow-right"></i></span>
                            <span wire:loading wire:target="save"><i class="fa fa-spin fa-spinner"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $(document).ready(function () {
                renderSelect2();

                $('#deadline').datepicker({
                    dateFormat:"dd/mm/yy",
                    minDate: 0
                });

                $(document).on('blur', '.input-qty', function () {
                    let key = $(this).data('key');
                    let value = $(this).val();
                    @this.call('onChangeQuantity', key, value, 2);
                });

                $(document).on('change', '#cupon', function () {
                    let value = $(this).val();
                    @this.set('paymentMethod', value);
                });

                $(document).on('change', '#deadline', function () {
                    let value = $(this).val();
                    @this.set('deadline', value);
                });

                $(document).on('change', '#product_id', function () {
                    let value = $(this).val();
                    @this.call('onChangeProduct', value);
                });

                $(document).on('change', '#size_id', function () {
                    let value = $(this).val();
                    @this.call('onChangeSize', value);
                });

                $(document).on('change', '#color_id', function () {
                    let value = $(this).val();
                    @this.call('onChangeColor', value);
                });

                $(document).on('keydown', 'input[pattern]', function(){
                    let input = $(this);
                    let oldVal = input.val();
                    let regex = new RegExp(input.attr('pattern'), 'g');

                    setTimeout(function(){
                        let newVal = input.val();
                        if(!regex.test(newVal)){
                            input.val(oldVal);
                        }
                    }, 1);
                });

                document.addEventListener('log-data', function (e) {
                    console.log(e.detail);
                });

                window.addEventListener('reset-selects', event => {
                    renderSelect2();
                });

                $(document).on('change', '#event-category', function () {
                    let value = $(this).val();
                    console.log(value);
                    @this.emitTo('order.orders', 'filterByStatus', value);
                });
            });

            function renderSelect2() {
                $('.dm-select .select2').select2(
                    {
                        placeholder: "{{__('pages.actions.select')}}",
                        dropdownCssClass:"alert2",
                        allowClear: true
                    }
                );
            }
        </script>
    @endsection
</div>
