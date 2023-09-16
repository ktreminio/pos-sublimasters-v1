<div class="alert alert-{{!isset($type) ? 'info' : $type}}  alert-dismissible fade show " role="alert">

    @if(isset($icon) && $icon)
        <div class="alert-icon d-flex align-items-center">
            <i class="{{!isset($classIcon) ? 'fas fa-info-circle' : $classIcon}}"></i>
        </div>
    @endif

    <div class="alert-content">
        <p>{{$slot}}</p>
        @if(isset($button) && $button)
            <button type="button" class="btn-close text-capitalize"
                    data-bs-dismiss="alert" aria-label="Close">
                <img src="{{ asset('assets/img/svg/x.svg') }}" alt="x" class="svg"
                     aria-hidden="true">
            </button>
        @endif
    </div>
</div>
