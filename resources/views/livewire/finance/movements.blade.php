<div class="container-fluid p-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="userDatatable orderDatatable global-shadow pt-20 w-100 mb-30 border-0">
                <div class="project-top-wrapper d-flex justify-content-between flex-wrap mb-25 mt-n10">
                    <div class="d-flex align-items-center flex-wrap justify-content-center">
                        <div class="project-search order-search  global-shadow mt-10">
                            <form action="/" class="order-search__form">
                                <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                                <input class="form-control me-sm-2 border-0 box-shadow-none" type="search"
                                       wire:model="search"
                                       placeholder="@lang('pages.fields.search')" aria-label="Search">
                            </form>
                        </div><!-- End: .project-search -->
                    </div><!-- End: .d-flex -->
                    <div class="content-center mt-10">
                        <div class="form-group me-4 mb-0">
                            <label class="fs-16">@lang('pages.fields.balance')</label>
                            <h5 class="{{ $balance > 0 ? 'text-success' : 'text-danger' }}">C$ {{ number_format($balance, 2) }}</h5>
                        </div>
                        <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                            <button type="button" class="btn btn-sm btn-primary me-0 radius-md"
                                    data-bs-toggle="modal" data-bs-target="#new-movement"
                            >
                                <i class="la la-plus"></i> @lang('pages.cash_movements.new')
                            </button>
                        </div>
                    </div><!-- End: .content-center -->
                </div><!-- End: .project-top-wrapper -->
                <div class="tab-content" id="ap-tabContent">
                    <div class="tab-pane fade show active" id="ap-overview" role="tabpanel"
                         aria-labelledby="ap-overview-tab">
                        <!-- Start Table Responsive -->
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless border-0">
                                <thead>
                                <tr class="userDatatable-header">
                                    <th class="text-center">
                                        <span class="userDatatable-title">@lang('pages.fields.date')</span>
                                    </th>
                                    <th class="text-center">
                                        <span class="userDatatable-title">@lang('pages.fields.amount')</span>
                                    </th>
                                    <th class="text-center">
                                        <span class="userDatatable-title">@lang('pages.fields.type_transaction')</span>
                                    </th>
                                    <th class="text-center">
                                        <span class="userDatatable-title">@lang('pages.fields.comment')</span>
                                    </th>
                                    <th class="text-center">
                                        <span class="userDatatable-title float-end">@lang('pages.fields.actions')</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($movements) == 0 && $search != '')
                                    <tr>
                                        <td colspan="7">
                                            <div class="d-flex justify-content-center align-items-center flex-column">
                                                <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_results')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @elseif(count($movements) == 0)
                                    <tr>
                                        <td colspan="7">
                                            <div class="d-flex justify-content-center align-items-center flex-column">
                                                <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_records')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @foreach($movements as $movement)
                                    <tr>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                {{ \Carbon\Carbon::parse($movement->date)->format('d/m/Y')}}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                C$ {{ number_format($movement->amount, 2) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content d-inline-block">

                                                @if($movement->type_transaction == 'SALE')
                                                    <span class="bg-opacity-warning color-warning rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.transaction_type.sale')</span>
                                                @elseif($movement->type_transaction == 'EXPENSE')
                                                    <span class="bg-opacity-danger color-danger rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.transaction_type.expense')</span>
                                                @elseif($movement->type_transaction == 'INCOME')
                                                    <span class="bg-opacity-success color-success rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.transaction_type.income')</span>
                                                @else
                                                    <span class="bg-opacity-info color-info rounded-pill text-uppercase userDatatable-content-status active">@lang('pages.transaction_type.purchase')</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content d-inline-block">
                                                {{ $movement->comment}}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                <li>
                                                    <a class="edit cursor-true">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Table Responsive End -->
                        @if($movements->hasPages())
                            <div class="d-flex justify-content-end pt-20">
                                {{ $movements->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div><!-- End: .userDatatable -->
        </div>
    </div>

    <!-- Modal Movement -->
    <livewire:finance.movement-form/>
    <!-- End Modal -->
</div>
