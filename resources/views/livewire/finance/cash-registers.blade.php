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
                        <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                            <button type="button" class="btn btn-sm btn-primary me-0 radius-md"
                                    data-bs-toggle="modal" data-bs-target="#new-cash-register"
                            >
                                <i class="la la-plus"></i> @lang('pages.cash_register.new')
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
                                            <span class="userDatatable-title">@lang('pages.fields.opening_time')</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="userDatatable-title">@lang('pages.fields.closing_time')</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="userDatatable-title">@lang('pages.fields.system')</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="userDatatable-title">@lang('pages.fields.user')</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="userDatatable-title">@lang('pages.fields.difference')</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="userDatatable-title">@lang('pages.fields.status')</span>
                                        </th>
                                        <th class="text-center">
                                            <span class="userDatatable-title float-end">@lang('pages.fields.actions')</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if(count($cash_registers) == 0 && $search != '')
                                    <tr>
                                        <td colspan="7">
                                            <div class="d-flex justify-content-center align-items-center flex-column">
                                                <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_results')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @elseif(count($cash_registers) == 0)
                                    <tr>
                                        <td colspan="7">
                                            <div class="d-flex justify-content-center align-items-center flex-column">
                                                <p class="color-primary fs-16 fw-500 mb-0">@lang('pages.actions.no_records')</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @foreach($cash_registers as $cash_register)
                                    <tr>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                {{ date_format(date_create($cash_register->opening_date), 'd/m/Y') . ' ' . $cash_register->opening_time}}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                {{$cash_register->closing_date . ' ' . $cash_register->closing_time}}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                C$ {{ number_format($cash_register->cash_according_to_system, 2) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                C$ {{ number_format($cash_register->transfer_according_to_user, 2) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content">
                                                C$ {{ number_format($cash_register->difference, 2) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="userDatatable-content d-inline-block">
                                                @if($cash_register->is_closed)
                                                    <span class="bg-opacity-danger color-danger rounded-pill userDatatable-content-status active">@lang('pages.fields.closed')</span>
                                                @else
                                                    <span class="bg-opacity-success color-success rounded-pill userDatatable-content-status active">@lang('pages.fields.opened')</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                                <li>
                                                    <a class="edit cursor-true drawer-trigger"
                                                       wire:click="$emitTo('finance.cash-register-form', 'getEditCashRegister', {{$cash_register->id}})"
                                                       data-drawer="basic">
                                                        <i class="uil uil-edit"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="cursor-true {{$cash_register->pasive ? 'view' : 'remove'}}">
                                                        <i class="uil {{$cash_register->pasive ? 'uil-thumbs-up' : 'uil-thumbs-down'}}"></i>
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
                        @if($cash_registers->hasPages())
                            <div class="d-flex justify-content-end pt-20">
                                {{ $cash_registers->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div><!-- End: .userDatatable -->
        </div>
    </div>

    <!-- Modal Cash Register -->
    <livewire:finance.cash-register-form/>
    <!-- End Modal -->

    @section('scripts')
        <script>
            $(document).ready(function () {
                $('#type').select2(
                    {
                        placeholder: "{{__('pages.actions.select')}}",
                        dropdownCssClass:"alert2",
                        allowClear: true,
                        minimumResultsForSearch: -1
                    }
                );

                $('#opening_date, #date').datepicker({
                    dateFormat:"dd/mm/yy"
                });

                $('#opening_time').flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true
                });

                $(document).on('change', '#opening_date', function (e) {
                    Livewire.emitTo('finance.cash-register-form','setOpeningDate', e.target.value);
                });

                $(document).on('change', '#opening_time', function (e) {
                    Livewire.emitTo('finance.cash-register-form','setOpeningTime', e.target.value);
                });

                window.addEventListener('closeModalCashRegister', () => {
                    $('#new-cash-register').modal('hide');
                });

                window.addEventListener('openModalCashRegister', () => {
                    $('#new-cash-register').modal('show');
                });

                // Movement
                $(document).on('change', '#date', function (e) {
                    Livewire.emitTo('finance.movement-form','setDate', e.target.value);
                });

                $(document).on('change', '#type', function (e) {
                    Livewire.emitTo('finance.movement-form','setType', e.target.value);
                });

                window.addEventListener('closeModalMovement', () => {
                    $('#new-movement').modal('hide');
                });

                window.addEventListener('openModalMovement', () => {
                    $('#new-movement').modal('show');
                });
            });
        </script>
    @endsection
</div>
