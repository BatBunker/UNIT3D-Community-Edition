@if($random_torrent!== null )
    <section class="w-[220px] mt-2">
        @php
            $meta = match(1) {
            $random_torrent->category->tv_meta => App\Models\Tv::query()->where('id', '=', $random_torrent->tmdb ?? 0)->first(),
            $random_torrent->category->movie_meta => App\Models\Movie::query()->where('id', '=', $random_torrent->tmdb ?? 0)->first(),
            default => null,
            };
        @endphp
        <div class="carousel__header py-2 text-center">
            <h3 class="carousel__heading text-2xl font-mono	">
                Torrent Of The Day
            </h3>
        </div>
        <a href="{{route('torrent', ['id' => $random_torrent->id])}}"
           title="{{Str::limit(strip_tags($meta->overview ?: $meta->summary), 350, '...') }}">
            <figure class="flex flex-col w-[220px] text-center">
                <img style="border: var(--app-border-light-color) 1px solid" class="object-contain "
                     @switch (true)
                         @case ($random_torrent->category->movie_meta || $random_torrent->category->tv_meta)
                             src="{{ isset($meta->poster) ? tmdb_image('poster_mid', $meta->poster) : 'https://via.placeholder.com/160x240' }}"
                     @break
                     @case ($random_torrent->category->no_meta || $random_torrent->category->music_meta)
                         src="https://via.placeholder.com/160x240"
                     @break
                     @endswitch
                     alt="{{ __('torrent.poster') }}"
                />

                <figcaption class="mt-1 font-bold block text-lg"
                            title="{{ $meta->name_sort ?? $meta->name_short ?? 'N/A' }}">
                    {{ Str::limit($meta->name_sort ?? $meta->name_short ?? 'N/A', 11,'...') }}

                    <span>
            @if(isset($meta->first_air_date))
                            [{{ substr($meta->first_air_date, 0, 4) ?? '' }}]
                        @elseif(isset($meta->release_date))
                            [{{ substr($meta->release_date, 0, 4) ?? '' }}]
                        @endif
        </span>

                </figcaption>
            </figure>
        </a>

    </section>
@endif
