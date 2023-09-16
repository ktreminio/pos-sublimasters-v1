<x-layouts.app>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <x-breadcrumb page-actual="pages.cash_register.title" title="pages.cash_register.cash_register_and_movement"/>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default card-md mb-4" style="min-height: 400px">
                    <div class="card-body">
                        <div class="tab-wrapper">
                            <div class="dm-tab tab-horizontal">
                                <ul class="nav nav-tabs vertical-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tab-v-1-tab" data-bs-toggle="tab"
                                           href="#tab-cash-register" role="tab" aria-selected="true">@lang('pages.cash_register.title')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-v-2-tab" data-bs-toggle="tab" href="#tab-v-2"
                                           role="tab" aria-selected="false">@lang('pages.cash_movements.title')</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab-cash-register" role="tabpanel"
                                         aria-labelledby="tab-v-1-tab">
                                        <livewire:finance.cash-registers/>
                                    </div>
                                    <div class="tab-pane fade" id="tab-v-2" role="tabpanel"
                                         aria-labelledby="tab-v-2-tab">
                                        <livewire:finance.movements/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay-dark"></div>
</x-layouts.app>
