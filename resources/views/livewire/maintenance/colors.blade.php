<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb-main user-member justify-content-sm-between ">
                <div class=" d-flex flex-wrap justify-content-center breadcrumb-main__wrapper">
                    <div class="d-flex align-items-center user-member__title justify-content-center me-sm-25">
                        <h4 class="text-capitalize fw-500 breadcrumb-title">@lang('pages.colors.list')</h4>
                    </div>

                    <form action="/" class="d-flex align-items-center user-member__form my-sm-0 my-2">
                        <img src="{{ asset('assets/img/svg/search.svg') }}" alt="search" class="svg">
                        <input wire:model="search" class="form-control me-sm-2 border-0 box-shadow-none" type="search"
                               placeholder="@lang('pages.fields.search')" aria-label="Search">
                    </form>

                </div>
                <div class="action-btn">
                    <button class="btn btn-icon btn-primary btn-squared"
                            data-bs-toggle="modal" data-bs-target="#new-color"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 448 512"><style>svg{fill:#ffffff}</style>
                            <path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/>
                        </svg>
                    </button>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="userDatatable global-shadow border-light-0 p-30 bg-white radius-xl w-100 mb-30">
                <div class="table-responsive">
                    @if(count($colors))
                        <table class="table mb-0 border-0 table-borderless">
                            <thead>
                                <tr class="userDatatable-header">
                                    <th wire:click="sortBy('name')" class="text-center cursor-true">
                                        <span class="userDatatable-title">@lang('pages.fields.name')</span>
                                        <x-sort-icon class="float-end mx-3" field="name" :sort-field="$sortField" :direction="$direction"/>
                                    </th>
                                    <th wire:click="sortBy('pasive')" class="text-center cursor-true">
                                        <span class="userDatatable-title">@lang('pages.fields.status')</span>
                                        <x-sort-icon class="float-end mx-3" field="pasive" :sort-field="$sortField" :direction="$direction"/>
                                    </th>
                                    <th class="text-center">
                                        <span class="userDatatable-title float-end">@lang('pages.fields.actions')</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($colors as $color)
                                <tr>
                                    <td class="text-center">
                                        <div class="userDatatable-content">
                                            {{$color->name}}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="userDatatable-content d-inline-block">
                                            @if($color->pasive)
                                                <span class="bg-opacity-danger  color-danger userDatatable-content-status active">@lang('pages.fields.inactive')</span>
                                            @else
                                                <span class="bg-opacity-success color-success rounded-pill userDatatable-content-status active">@lang('pages.fields.active')</span>
                                            @endif

                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <ul class="orderDatatable_actions mb-0 d-flex flex-wrap">
                                            <li>
                                                <a class="edit cursor-true" wire:click="$emitTo('maintenance.color-form','getColorById',{{$color->id}})">
                                                    <i class="uil uil-edit"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="cursor-true {{$color->pasive ? 'view' : 'remove'}}">
                                                    <i class="uil {{$color->pasive ? 'uil-thumbs-up' : 'uil-thumbs-down'}}"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <p class="color-primary fw-500 mb-0">@lang('pages.actions.no_results')</p>
                        </div>
                    @endif
                </div>
                @if($colors->hasPages())
                    <div class="d-flex border-top justify-content-end pt-20">
                        {{ $colors->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal -->
    <livewire:maintenance.color-form/>
    <!-- Modal -->

    @section('scripts')
        <script>
            $(document).ready(function () {
                window.addEventListener('closeModalColor', () => {
                    $('#new-color').modal('hide');
                });

                window.addEventListener('openModalColor', () => {
                    $('#new-color').modal('show');
                });
            });
        </script>
    @endsection
</div>
