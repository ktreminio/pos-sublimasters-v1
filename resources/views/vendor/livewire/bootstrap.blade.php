<div>
    @if ($paginator->hasPages())
        @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : $this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1)

        <nav class="dm-page">
            <ul class="d-flex justify-content-end">
                @if ($paginator->onFirstPage())
                    <li class="dm-pagination__item m-0 cursor-true disabled" disabled aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <a wire:key="previousPageDisabled" class="dm-pagination__link disabled pagination-control" disabled>
                            <span class="la la-angle-left"></span>
                        </a>
                    </li>
                @else
                    <li class="dm-pagination__item m-0 cursor-true">
                        <a wire:key="previousPage" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="dm-pagination__link pagination-control" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev" aria-label="@lang('pagination.previous')">
                            <span class="la la-angle-left"></span>
                        </a>
                    </li>
                @endif
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="dm-pagination__item m-0 cursor-true disabled" aria-disabled="true">
                            <a class="dm-pagination__link" >
                                <span class="page-number">
                                    {{ $element }}
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="dm-pagination__item m-0 cursor-true">
                                    <a class="dm-pagination__link active" wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}" aria-current="page">
                                        <span class="page-number">{{ $page }}</span>
                                    </a>
                                </li>
                            @else
                                <li class="dm-pagination__item m-0 cursor-true" wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}">
                                    <a class="dm-pagination__link" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">
                                        <span class="page-number">{{ $page }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <li class="dm-pagination__item m-0 cursor-true">
                        <a dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="dm-pagination__link pagination-control" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')">
                            <span class="la la-angle-right"></span>
                        </a>
                    </li>
                @else
                    <li class="dm-pagination__item m-0 cursor-true disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <a class="dm-pagination__link disabled pagination-control">
                            <span class="la la-angle-right"></span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
