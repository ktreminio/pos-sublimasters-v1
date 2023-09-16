<div>
    <x-modal id="new-subcategory" data-bs-backdrop="static" wire:ignore.self class-modal="modal-sm">
        <x-slot name="size">modal-sm</x-slot>
        <x-slot name="header" wire:click="resetFields">
            @lang('pages.subcategories.'.$action)
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

            <div class="form-group row mb-25">
                <label for="category" class="col-sm-3 col-form-label color-dark fs-14 fw-500">@lang('pages.fields.category')</label>
                <div class="col-sm-9">
                    <div class="select-style2">
                        <div class="dm-select " wire:ignore>
                            <select name="category" id="category_id" class="form-control">
                                <option></option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('category_id')
                        <span class="invalid-feedback d-block fs-6" role="alert">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group row mb-25">
                <label for="color" class="col-sm-3 col-form-label  color-dark fs-14 fw-500 align-center">@lang('pages.fields.options')</label>
                <div class="col-sm-9 row">
                    <div class="col-sm-6">
                        <div class="checkbox-theme-default custom-checkbox ">
                            <input wire:model="color" name="color" class="checkbox" type="checkbox" id="color">
                            <label for="color"><span class="checkbox-text">@lang('pages.fields.color')</span></label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox-theme-default custom-checkbox ">
                            <input wire:model="size" name="size" class="checkbox" type="checkbox" id="size">
                            <label for="size"><span class="checkbox-text">@lang('pages.fields.size')</span></label>
                        </div>
                    </div>
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
