@if ($featured && $featured->count() > 0)
    <section>
        <div class="carousel__header">
            <h4 class="carousel__heading font-mono">
                <i class="{{ config('other.font-awesome') }} fa-fire"></i> {{ __('blocks.hot-torrents') }}
            </h4>
        </div>
        <div class="panel-body overflow-x-scroll">
            <ul class="flex gap-12 ħ-[250px] justify-center">
                @foreach ($featured as $feature)
                    @if ($feature->torrent === null || ! $feature->torrent->isApproved())
                        @continue
                    @endif
                    @php
                        $meta = match(1) {
                            $feature->torrent->category->tv_meta => App\Models\Tv::query()->with('genres', 'networks', 'seasons')->where('id', '=', $feature->torrent->tmdb ?? 0)->first(),
                            $feature->torrent->category->movie_meta => App\Models\Movie::query()->with('genres', 'cast', 'companies', 'collection')->where('id', '=', $feature->torrent->tmdb ?? 0)->first(),
                            default => null,
                        };
                    @endphp
                    <li class="h-full">
                        <x-torrent.card :meta="$meta" :torrent="$feature->torrent"/>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif