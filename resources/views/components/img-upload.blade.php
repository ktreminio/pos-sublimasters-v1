@props(['url','name','size', 'target'])
<img src="{{ $url }}" alt="img" class="img-fluid h-auto img-thumbnail">
<div class=" upload-media-area__title  d-flex flex-wrap align-items-center ms-10">
    <div>
        @if(isset($name) && isset($size))
            <p>{{$name}}</p>
            <span>{{number_format($size/1048576,2)}} MB</span>
        @endif
    </div>
    <div class="upload-media-area__btn">
        <ul class="orderDatatable_actions mb-0 d-flex justify-content-end">
            <li wire:loading.remove
                wire:target="{{$target}}">
                <a class="cursor-true remove" {{$attributes}}>
                    <i class="uil uil-trash-alt"></i>
                </a>
            </li>
            <li wire:target="{{$target}}"
                wire:loading
            >
                <a class="cursor-true remove">
                    <i class="fa fa-spin fa-spinner"></i>
                </a>
            </li>
        </ul>
    </div>
</div>
