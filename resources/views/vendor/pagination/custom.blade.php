@if ($paginator->hasPages())
    <ul class="pagination" role="navigation">

        {{-- Previous Page Link --}}
        <li class="{{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous" @if($paginator->onFirstPage()) tabindex="-1" aria-disabled="true" @endif>
                &laquo;
            </a>
        </li>

        {{-- Pagination Elements --}}
        @php
            $start = max(1, $paginator->currentPage() - 2);
            $end = min($paginator->lastPage(), $paginator->currentPage() + 2);
        @endphp

        {{-- If first page is not near, show first page and ellipsis --}}
        @if ($start > 1)
            <li><a class="page-link" href="{{ $paginator->url(1) }}">1</a></li>
            @if ($start > 2)
                <li class="disabled"><span class="page-link">...</span></li>
            @endif
        @endif

        {{-- Page Number Links --}}
        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $paginator->currentPage())
                <li class="active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
            @else
                <li><a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a></li>
            @endif
        @endfor

        {{-- If last page is not near, show ellipsis and last page --}}
        @if ($end < $paginator->lastPage())
            @if ($end < $paginator->lastPage() - 1)
                <li class="disabled"><span class="page-link">...</span></li>
            @endif
            <li><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
        @endif

        {{-- Next Page Link --}}
        <li class="{{ !$paginator->hasMorePages() ? 'disabled' : '' }}">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next" @if(!$paginator->hasMorePages()) tabindex="-1" aria-disabled="true" @endif>
                &raquo;
            </a>
        </li>
    </ul>
@endif
