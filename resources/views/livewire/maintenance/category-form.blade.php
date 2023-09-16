<div>
    <x-modal id="new-category" data-bs-backdrop="static" wire:ignore.self class-modal="modal-sm">
        <x-slot name="size">modal-sm</x-slot>
        <x-slot name="header" wire:click="resetFields">
            @lang('pages.categories.'.$action)
        </x-slot>
        <x-slot name="body">
            <div class="form-group row mb-25">
                <label for="name" class="col-sm-3 col-form-label color-dark fs-14 fw-500">@lang('pages.fields.name')</label>
                <div class="col-sm-9">
                    <input wire:model.defer="name"
                           type="text"
                           name="name"
                           class="form-control ih-medium ip-gray radius-xs b-light px-15 @error('name') is-invalid @enderror"
                           id="name" placeholder="@lang('pages.fields.name')"
                    />
                    @error('name')
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
