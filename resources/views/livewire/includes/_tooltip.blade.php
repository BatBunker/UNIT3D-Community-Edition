<div style="min-width: 60%" class="col-md-6">
    <div class="card is-torrent">
        <div class="card_head">
            @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                <span title="Origin Country" class="badge-extra text-center"> {{$meta->origin_country ?? 'na'}} </span>
                <span title="Original Language" class="badge-extra text-center">{{ucfirst($meta->original_language ?? '') ?? ''}} </span>

                <span class="{{ rating_color($meta->vote_average ?? 'text-white') }} badge-extra float-right">
                    <i style="color: #01ac61!important;" class="{{ config('other.font-awesome') }} fa-star-half-alt"></i>
                    {{ $meta->vote_average ?? 0 }}/10
                    @endif
                </span>
        </div>
        <div class="card_body">
            <div class="body_poster">
                @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                    <img src="{{ isset($meta->poster) ? tmdb_image('poster_big', $meta->poster) : 'https://via.placeholder.com/600x900' }}"
                         class="show-poster" alt="{{ __('torrent.poster') }}">
                @endif

                @if ($torrent->category->game_meta && isset($meta) && $meta->cover->image_id && $meta->name)
                    <img src="https://images.igdb.com/igdb/image/upload/t_original/{{ $meta->cover->image_id }}.jpg"
                         class="show-poster"
                         data-name='<i style="color: #a5a5a5;">{{ $meta->name ?? 'N/A' }}</i>'
                         data-image='<img src="https://images.igdb.com/igdb/image/upload/t_original/{{ $meta->cover->image_id }}.jpg" alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                         class="torrent-poster-img-small show-poster" alt="{{ __('torrent.poster') }}">
                @endif

                @if ($torrent->category->no_meta || $torrent->category->music_meta)
                    <img src="https://via.placeholder.com/600x900"
                         data-name='<i style="color: #a5a5a5;">N/A</i>'
                         data-image='<img src="https://via.placeholder.com/600x900" alt="{{ __('torrent.poster') }}" style="height: 1000px;">'
                         class="torrent-poster-img-small show-poster " alt="{{ __('torrent.poster') }}">
                @endif
            </div>
            @if ($torrent->category->movie_meta || $torrent->category->tv_meta)
                <div class="body_description"
                     style="background: linear-gradient(to top, rgba(0, 0, 0, .4) 0%, rgba(0, 0, 0, 1) 100%), url('{{ ($meta && $meta->backdrop) ? tmdb_image('back_big', $meta->backdrop) :'' }}');background-position: center center;">
                    @else
                        <div class="body_description">
                            @endif
                            <h3 style="margin-bottom: 5px;" class="description_title">
                                <a href="{{ route('torrent', ['id' => $torrent->id]) }}">
                                    @if ($torrent->category->movie_meta)
                                        {{ $meta->title ?? 'Unknown' }}
                                    @endif
                                    @if ($torrent->category->tv_meta)
                                        {{ $meta->name ?? 'Unknown' }}
                                    @endif
                                    @if($torrent->category->movie_meta)
                                        <span class="text-bold text-pink"> {{ substr($meta->release_date ?? '', 0, 4) ?? '' }}</span>
                                    @endif
                                    @if($torrent->category->tv_meta)
                                        <span class="text-bold text-pink"> {{ substr($meta->first_air_date ?? '', 0, 4) ?? '' }}</span>
                                    @endif
                                </a>
                            </h3>
                            @if (($torrent->category->movie_meta || $torrent->category->tv_meta) && isset($meta->genres))
                                @foreach ($meta->genres as $genre)
                                    <span class="badge-extra">{{ $genre->name }}</span>
                                @endforeach
                            @endif
                            <p style="color:#ffffff;" class="description_plot">
                                {{ $meta->overview ?? '' }}
                            </p>
                            <br>
                            <div style="display:flex;justify-content: center; gap: .6rem;align-items: center" class="cast-list">
                                @if (isset($meta->cast) && $meta->cast->isNotEmpty())
                                    @foreach ($meta->cast->sortBy('order')->take(7) as $cast)
                                        <div class="cast-item" style="max-width: 80px;">
                                            <a href="{{ route('mediahub.persons.show', ['id' => $cast->id]) }}" style="background: rgba(0,0,0,.8)">
                                                <img class="img-responsive" width="40px"
                                                     src="{{ $cast->still ? tmdb_image('cast_face', $cast->still) : 'https://via.placeholder.com/138x175' }}"
                                                     alt="{{ $cast->name }}">
                                                <div style="font-size: 15px" class="cast-name">{{ $cast->name }}</div>
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                </div>
                <br>
                {{--                <div class="card_footer">--}}

                {{--                </div>--}}
        </div>
    </div>