<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="userDatatable orderDatatable global-shadow pt-20 w-100 mb-30 border-0">
                <div class="project-top-wrapper d-flex justify-content-between flex-wrap mb-25 mt-n10">
                    <div class="d-flex align-items-center flex-wrap justify-content-center">
                        <div class="project-search order-search global-shadow mt-10">
                            <form action="/" class="order-search__form">
                                <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                <input class="form-control me-sm-2 border-0 box-shadow-none" type="search"
                                       wire:model="search"
                                       placeholder="@lang('pages.fields.search')" aria-label="Search">
                            </form>
                        </div>


                    </div>
                    <div class="content-center mt-10">
                        <div class="project-category">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 me-10 fs-14 color-light">@lang('pages.fields.status'):</p>
                                <div wire:ignore class="project-category__select">
                                    <select wire:model="statusFilter" class="js-example-basic-single js-states form-control" id="event-category">
                                        <option value="ALL">@lang('pages.status.all')</option>
                                        <option value="{{\App\Enums\OrderStatus::NEW_ORDER}}">@lang('pages.status.new_order')</option>
                                        <option value="{{\App\Enums\OrderStatus::IN_PROGRESS}}">@lang('pages.status.in_progress')</option>
                                        <option value="{{\App\Enums\OrderStatus::DELIVERED}}">@lang('pages.status.delivered')</option>
                                        <option value="{{\App\Enums\OrderStatus::CANCELED}}">@lang('pages.status.canceled')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="ap-tabContent">
                    <div class="tab-pane fade show active" id="ap-overview" role="tabpanel"
                         aria-labelledby="ap-overview-tab">
                        <!-- Start Table Responsive -->
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless border-0">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th wire:click="sortBy('deadline')" class="text-center cursor-true">
                                            <span class="userDatatable-title">@lang('pages.fields.deadline')</span>
                                            <x-sort-icon class="float-end mx-3" field="deadline" :sort-field="$sortField" :direction="$direction"/>
                                        </th>
                                        <th wire:click="sortBy('total')" class="text-center cursor-true">
                                            <span class="userDatatable-title">@lang('pages.fields.amount')</span>
                                            <x-sort-icon class="float-end mx-3" field="total" :sort-field="$sortField" :direction="$direction"/>
                                        </th>
                                        <th wire:click="sortBy('payment_method')" class="text-center cursor-true">
                                            <span class="userDatatable-title">@lang('pages.fields.payment_method')</span>
                                            <x-sort-icon class="float-end mx-3" field="payment_method" :sort-field="$sortField" :direction="$direction"/>
                                        </th>
                                        <th wire:click="sortBy('payment_status')" class="text-center cursor-true">
                                            <span class="userDatatable-title">@lang('pages.fields.payment_status')</span>
                                            <x-sort-icon class="float-end mx-3" field="payment_status" :sort-field="$sortField" :direction="$direction"/>
                                        </th>
                                        <th wire:click="sortBy('status')" class="text-center cursor-true">
                                            <span class="userDatatable-title">@lang('pages.fields.status')</span>
                                            <x-sort-icon class="float-end mx-3" field="status" :sort-field="$sortField" :direction="$direction"/>
                                        </th>
                                        <th class="text-center">
                                            <span class="userDatatable-title float-end">@lang('pages.fields.actions')</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($orders) == 0 && $search != '')
                                    <tr>
                                        <td colspan="7">
                                            <div class="d-flex justify-content-center align-items-center flex-column">
                                                <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_results')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @elseif(count($orders) == 0)
                                    <tr>
                                        <td colspan="7">
                                            <div class="d-flex justify-content-center align-items-center flex-column">
                                                <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_records')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @foreach($orders as $order)
                                    <tr>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                {{ \Carbon\Carbon::parse($order->deadline)->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                C$ {{ number_format($order->total, 2) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content d-inline-block">
                                                @if($order->payment_method == 'TRANSFER')
                                                    <span class="bg-opacity-warning color-warning rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.actions.payment_method.transfer')</span>
                                                @else
                                                    <span class="bg-opacity-success color-success rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.actions.payment_method.cash')</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content d-inline-block">
                                                @if($order->payment_status == 'CANCELED')
                                                    <span class="bg-opacity-danger color-danger rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.status.canceled')</span>
                                                @elseif($order->payment_status == 'PENDING')
                                                    <span class="bg-opacity-info color-info rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.status.pending')</span>
                                                @else
                                                    <span class="bg-opacity-success color-success rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.status.delivered')</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content d-inline-block">
                                                @if($order->status == 'CANCELED')
                                                    <span class="bg-opacity-danger color-danger rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.status.canceled')</span>
                                                @elseif($order->status == 'NEW_ORDER')
                                                    <span class="bg-opacity-secondary color-secondary rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.status.new_order')</span>
                                                @elseif($order->status == 'IN_PROGRESS')
                                                    <span class="bg-opacity-warning color-warning rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.status.in_progress')</span>
                                                @else
                                                    <span class="bg-opacity-success color-success rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.status.delivered')</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                <li>
                                                    <a class="edit cursor-true">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="cursor-true {{$order->pasive ? 'view' : 'remove'}}">
                                                        <i class="uil {{$order->pasive ? 'uil-thumbs-up' : 'uil-thumbs-down'}}"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($orders->hasPages())
                            <div class="d-flex justify-content-end pt-20">
                                {{ $orders->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
