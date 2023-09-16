<div class="modal-info-confirmed modal fade show"
     {{ $attributes }}
     role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-sm modal-info" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-info-body d-flex">
                    <div class="modal-info-icon warning">
                        <img src="{{ asset('assets/img/svg/alert-circle.svg') }} " alt="alert-circle" class="svg">
                    </div>

                    <div class="modal-info-text">
                        <h6>{{ $question }}</h6>
                        <p>{{ $description }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
