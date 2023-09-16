<div {{ $attributes }}
     class="modal fade "
     role="dialog"
     aria-labelledby="staticBackdropLabel"
     aria-hidden="true"
>
    <div class="modal-dialog {{ $size }}" role="document">
        <div class="modal-content  radius-xl">
            <div class="modal-header">
                <h6 class="modal-title fw-500" id="staticBackdropLabel">
                    {{ $header }}
                </h6>
                <button {{$header->attributes}} type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg">
                </button>
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
            <div class="modal-footer">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
