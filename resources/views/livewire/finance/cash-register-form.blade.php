<div>
    <x-modal id="new-cash-register" data-bs-backdrop="static" wire:ignore.self class-modal="modal-sm">
        <x-slot name="size">modal-sm</x-slot>
        <x-slot name="header" wire:click="resetFields">
            @lang('pages.cash_register.'.$action)
        </x-slot>
        <x-slot name="body">
            @error('closed')
                <x-alert button="true">
                    {{ $message }}
                </x-alert>
            @enderror
            <div class="form-group row form-group-calender">
                <label for="opening_date"
                       class="col-sm-3 col-form-label color-dark fs-14 fw-500 align-center">@lang('pages.fields.opening_time')</label>
                <div class="col-sm-5">
                    <div class="position-relative">
                        <input type="text" wire:model="opening_date"
                               class="form-control  ih-medium ip-light radius-xs b-light px-15"
                               id="opening_date" placeholder="{{date('d/m/Y')}}"
                        />
                        <a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg replaced-svg"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </a>
                    </div>
                    @error('opening_date')
                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-4 time-picker">
                    <div class="form-group mb-0">
                        <div class="input-container icon-right position-relative w-100 color-light">
                            <span class="input-icon icon-right">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg replaced-svg">
                                  <circle cx="12" cy="12" r="10"></circle>
                                  <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </span>
                            <input type="text"
                                wire:model="opening_time"
                                id="opening_time"
                                class="form-control ih-medium ip-light radius-xs b-light px-15 color-lighten"
                            />
                        </div>
                    </div>
                    @error('opening_time')
                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label color-dark fs-14 fw-500 align-center"
                       for="opening_amount">@lang('pages.fields.opening_amount')</label>
                <div class="col-sm-9">
                    <input type="number"
                            wire:model.defer="opening_amount"
                           min="0"
                           step="1"
                           class="form-control ih-medium ip-light radius-xs b-light px-15"
                           id="opening_amount">
                    @error('opening_amount')
                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="resetFields">@lang('pages.actions.cancel')</button>
            <button type="button" class="btn btn-primary btn-sm" wire:loading.remove wire:click="save">@lang('pages.actions.save')</button>
            <span class="btn btn-primary btn-sm" wire:loading wire:target="save"><i class="fa fa-spin fa-spinner"></i></span>
        </x-slot>
    </x-modal>

    <!-- Drawer Edit -->
    <div class="drawer-basic-wrap" wire:ignore.self>
        <div class="dm-drawer drawer-basic d-none" style="min-width: 450px!important;">
            <div class="dm-drawer__header d-flex aling-items-center justify-content-between text-center">
                <h6 class="drawer-title text-uppercase">@lang('pages.cash_register.title')</h6>
                <a class="btdrawer-close cursor-true"><i class="la la-times"></i></a>
            </div>
            <div class="dm-drawer__body">
                <div class="drawer-content">
                    <div class="form-group row mb-25">
                        <label class="col-sm-4 col-form-label">@lang('pages.fields.opening_time')</label>
                        <div class="col-sm-8">
                            <label class="col-form-label color-dark fs-14 fw-500">{{ $opening_date . ' ' . $opening_time}}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Drawer Edit -->
</div>
