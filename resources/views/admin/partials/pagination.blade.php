@if ($paginator->hasPages())
    <nav class="pgde-pagination" role="navigation" aria-label="Pagination des demandeurs">
        @if ($paginator->onFirstPage())
            <span class="pgde-pagination-arrow is-disabled" aria-disabled="true" aria-label="Page précédente">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </span>
        @else
            <a class="pgde-pagination-arrow" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Page précédente">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </a>
        @endif

        <div class="pgde-pagination-pages">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pgde-pagination-ellipsis" aria-hidden="true">…</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pgde-pagination-page is-current" aria-current="page" aria-label="Page {{ $page }}">{{ $page }}</span>
                        @else
                            <a class="pgde-pagination-page" href="{{ $url }}" aria-label="Aller à la page {{ $page }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        @if ($paginator->hasMorePages())
            <a class="pgde-pagination-arrow" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Page suivante">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </a>
        @else
            <span class="pgde-pagination-arrow is-disabled" aria-disabled="true" aria-label="Page suivante">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </span>
        @endif
    </nav>
@endif
