@if ($paginator->hasPages())
    <div class="security-pagination-layout">
        <p class="security-pagination-summary">
            Affichage <strong>{{ number_format($paginator->firstItem(), 0, ',', ' ') }}</strong>
            à <strong>{{ number_format($paginator->lastItem(), 0, ',', ' ') }}</strong>
            sur <strong>{{ number_format($paginator->total(), 0, ',', ' ') }}</strong>
        </p>

        <nav class="security-pagination-nav" role="navigation" aria-label="Pagination des tentatives de connexion">
            @if ($paginator->onFirstPage())
                <span class="security-page-control is-disabled" aria-disabled="true" aria-label="Page précédente">
                    <i class="fas fa-chevron-left" aria-hidden="true"></i><span>Précédent</span>
                </span>
            @else
                <a class="security-page-control" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Page précédente">
                    <i class="fas fa-chevron-left" aria-hidden="true"></i><span>Précédent</span>
                </a>
            @endif

            <div class="security-page-numbers" aria-label="Pages">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="security-page-ellipsis" aria-hidden="true">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="security-page-number is-current" aria-current="page" aria-label="Page {{ $page }}">{{ $page }}</span>
                            @else
                                <a class="security-page-number" href="{{ $url }}" aria-label="Aller à la page {{ $page }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a class="security-page-control" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Page suivante">
                    <span>Suivant</span><i class="fas fa-chevron-right" aria-hidden="true"></i>
                </a>
            @else
                <span class="security-page-control is-disabled" aria-disabled="true" aria-label="Page suivante">
                    <span>Suivant</span><i class="fas fa-chevron-right" aria-hidden="true"></i>
                </span>
            @endif
        </nav>
    </div>
@endif
