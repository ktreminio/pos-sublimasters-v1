<div>
    <x-modal id="new-movement" data-bs-backdrop="static" wire:ignore.self class-modal="modal-sm">
        <x-slot name="size">modal-sm</x-slot>
        <x-slot name="header" wire:click="resetFields">
            @lang('pages.cash_movements.'.$action)
        </x-slot>
        <x-slot name="body">
            <div class="form-group row form-group-calender">
                <label for="date"
                       class="col-sm-3 col-form-label color-dark fs-14 fw-500 align-center">@lang('pages.fields.date')</label>
                <div class="col-sm-9">
                    <div class="position-relative">
                        <input type="text" wire:model="date"
                               class="form-control ih-medium ip-light radius-xs b-light px-15"
                               name="date" id="date" placeholder="{{date('d/m/Y')}}"
                        />
                        <a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="svg replaced-svg"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        </a>
                    </div>
                    @error('date')
                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label color-dark fs-14 fw-500 align-center"
                       for="amount">@lang('pages.fields.amount')</label>
                <div class="col-sm-9">
                    <input type="number"
                           wire:model.defer="amount"
                           min="0"
                           step="1"
                           name="amount"
                           class="form-control ih-medium ip-light radius-xs b-light px-15"
                           id="amount">
                    @error('amount')
                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label align-center color-dark fs-14 fw-500"
                       for="type">@lang('pages.fields.type_transaction')</label>
                <div class="select-style2 col-sm-9">
                    <div class="dm-select" wire:key="select-movement" wire:ignore>
                        <select wire:model="type"
                                name="type"
                                id="type"
                                class="form-control">
                            <option value=""></option>
                            <option value="EXPENSE">@lang('pages.transaction_type.expense')</option>
                            <option value="INCOME">@lang('pages.transaction_type.income')</option>
                        </select>
                    </div>
                    @error('type')
                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group form-element-textarea row">
                <label for="comment"
                       class="col-sm-3 col-form-label color-dark fs-14 fw-500 align-center">
                    @lang('pages.fields.comment')
                </label>
                <div class="col-sm-9">
                    <textarea class="form-control"
                              wire:model.defer="comment"
                              name="comment"
                              id="comment"
                              placeholder="@lang('pages.fields.comment')"
                    ></textarea>

                    @error('comment')
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
</div>
