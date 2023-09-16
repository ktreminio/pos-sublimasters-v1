<x-layouts.app>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <x-breadcrumb title="pages.orders.title"/>
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
                                           href="#tab-cash-register" role="tab" aria-selected="true">@lang('pages.orders.new')</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-v-2-tab" data-bs-toggle="tab" href="#tab-v-2"
                                           role="tab" aria-selected="false">@lang('pages.orders.history')</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab-cash-register" role="tabpanel"
                                         aria-labelledby="tab-v-1-tab">
                                        <livewire:order.order-form/>
                                    </div>
                                    <div class="tab-pane fade" id="tab-v-2" role="tabpanel"
                                         aria-labelledby="tab-v-2-tab">
                                        <livewire:order.orders/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
