<span {{$attributes}}>
    @if($field === $sortField)
        @if($direction == 'asc')
            <i class="fas fa-sort-up ml-1" aria-hidden="true"></i>
        @else
            <i class="fas fa-sort-down ml-1" aria-hidden="true"></i>
        @endif
    @else
        <i class="fas fa-sort ml-1" aria-hidden="true"></i>
    @endif
</span>
