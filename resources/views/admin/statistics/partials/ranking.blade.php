@php($variant = $variant ?? 'ranking')
@if($items->isEmpty())
    <p class="pgde-dashboard-empty">Aucune donnée disponible pour cette période.</p>
@elseif($variant === 'tiles')
    <div class="pgde-statistics-tiles">
        @foreach($items as $item)
            <div class="pgde-statistics-tile"><strong>{{ number_format($item['count'], 0, ',', ' ') }}</strong><span>{{ $item['label'] }}</span></div>
        @endforeach
    </div>
@elseif($variant === 'chips')
    <div class="pgde-statistics-chips">
        @foreach($items as $item)
            <div class="pgde-statistics-chip"><span>{{ $item['label'] }}</span><strong>{{ number_format($item['count'], 0, ',', ' ') }}</strong></div>
        @endforeach
    </div>
@else
    <ol class="pgde-statistics-ranking">
        @foreach($items as $item)
            <li><span class="pgde-statistics-rank-number">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span><span class="pgde-statistics-rank-label" title="{{ $item['label'] }}">{{ $item['label'] }}</span><strong>{{ number_format($item['count'], 0, ',', ' ') }}</strong></li>
        @endforeach
    </ol>
@endif
