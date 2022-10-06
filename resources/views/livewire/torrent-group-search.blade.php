<div>
    <div class="container-fluid">
        <style>
            .form-group {
                margin-bottom: 5px !important;
            }

            .badge-extra {
                margin-bottom: 0;
            }
        </style>
        <div x-data="{ open: false }" class="container box" id="torrent-list-search"
             style="margin-bottom: 0; padding: 10px 100px; border-radius: 5px;">
            <div class="mt-5">
                <div class="row">
                    <div class="form-group col-xs-9">
                        <input wire:model.debounce.500ms="name" type="search" class="form-control" placeholder="Name"/>
                    </div>
                    <div class="form-group col-xs-3">
                        <button class="btn btn-md btn-primary" @click="open = ! open"
                                x-text="open ? '{{ __('common.search-hide') }}' : '{{ __('common.search-advanced') }}'">
                        </button>
                    </div>
                </div>
                <div x-cloak x-show="open" id="torrent-advanced-search">
                    <div class="row">
                        <div class="form-group col-sm-3 col-xs-6 adv-search-description">
                            <label for="description" class="label label-default">{{ __('torrent.description') }}</label>
                            <input wire:model.debounce.500ms="description" type="text" class="form-control"
                                   placeholder="Description">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-mediainfo">
                            <label for="mediainfo" class="label label-default">{{ __('torrent.media-info') }}</label>
                            <input wire:model.debounce.500ms="mediainfo" type="text" class="form-control"
                                   placeholder="Mediainfo">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-keywords">
                            <label for="keywords" class="label label-default">{{ __('torrent.keywords') }}</label>
                            <input wire:model.debounce.500ms="keywords" type="text" class="form-control"
                                   placeholder="Keywords">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-uploader">
                            <label for="uploader" class="label label-default">{{ __('torrent.uploader') }}</label>
                            <input wire:model.debounce.500ms="uploader" type="text" class="form-control"
                                   placeholder="Uploader">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3 col-xs-6 adv-search-tmdb">
                            <label for="tmdbId" class="label label-default">TMDb</label>
                            <input wire:model.debounce.500ms="tmdbId" type="text" class="form-control"
                                   placeholder="TMDb ID">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-imdb">
                            <label for="imdbId" class="label label-default">IMDb</label>
                            <input wire:model.debounce.500ms="imdbId" type="text" class="form-control"
                                   placeholder="IMDb ID">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-tvdb">
                            <label for="tvdbId" class="label label-default">TVDb</label>
                            <input wire:model.debounce.500ms="tvdbId" type="text" class="form-control"
                                   placeholder="TVDb ID">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-mal">
                            <label for="malId" class="label label-default">MAL</label>
                            <input wire:model.debounce.500ms="malId" type="text" class="form-control"
                                   placeholder="MAL ID">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-3 col-xs-6 adv-search-startYear">
                            <label for="startYear" class="label label-default">{{ __('torrent.start-year') }}</label>
                            <input wire:model.debounce.500ms="startYear" type="text" class="form-control"
                                   placeholder="Start Year">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-endYear">
                            <label for="endYear" class="label label-default">{{ __('torrent.end-year') }}</label>
                            <input wire:model.debounce.500ms="endYear" type="text" class="form-control"
                                   placeholder="End Year">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-playlist">
                            <label for="playlist" class="label label-default">Playlist</label>
                            <input wire:model.debounce.500ms="playlistId" type="text" class="form-control"
                                   placeholder="Playlist ID">
                        </div>
                        <div class="form-group col-sm-3 col-xs-6 adv-search-collection">
                            <label for="collection" class="label label-default">Collection</label>
                            <input wire:model.debounce.500ms="collectionId" type="text" class="form-control"
                                   placeholder="Collection ID">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6 col-xs-12 adv-search-region">
                            @php $regions = cache()->remember('regions', 3_600, fn () => App\Models\Region::all()->sortBy('position')) @endphp
                            <label for="region" class="label label-default">Region</label>
                            <div id="regions" wire:ignore></div>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12 adv-search-distributor">
                            @php $distributors = cache()->remember('distributors', 3_600, fn () => App\Models\Distributor::all()->sortBy('position')) @endphp
                            <label for="distributor" class="label label-default">Distributor</label>
                            <div id="distributors" wire:ignore></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-categories">
                            <label for="categories" class="label label-default">{{ __('common.category') }}</label>
                            @php $categories = cache()->remember('categories', 3_600, fn () => App\Models\Category::all()->sortBy('position')) @endphp
                            @foreach ($categories as $category)
                                <span class="badge-user">
									<label class="inline">
										<input type="checkbox" wire:model.prefetch="categories"
                                               value="{{ $category->id }}"> {{ $category->name }}
									</label>
								</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-types">
                            <label for="types" class="label label-default">{{ __('common.type') }}</label>
                            @php $types = cache()->remember('types', 3_600, fn () => App\Models\Type::all()->sortBy('position')) @endphp
                            @foreach ($types as $type)
                                <span class="badge-user">
									<label class="inline">
										<input type="checkbox" wire:model.prefetch="types" value="{{ $type->id }}"> {{ $type->name }}
									</label>
								</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-resolutions">
                            <label for="resolutions" class="label label-default">{{ __('common.resolution') }}</label>
                            @php $resolutions = cache()->remember('resolutions', 3_600, fn () => App\Models\Resolution::all()->sortBy('position')) @endphp
                            @foreach ($resolutions as $resolution)
                                <span class="badge-user">
									<label class="inline">
										<input type="checkbox" wire:model.prefetch="resolutions"
                                               value="{{ $resolution->id }}"> {{ $resolution->name }}
									</label>
								</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-genres">
                            <label for="genres" class="label label-default">{{ __('common.genre') }}</label>
                            @php $genres = cache()->remember('genres', 3_600, fn () => App\Models\Genre::all()->sortBy('name')) @endphp
                            @foreach ($genres as $genre)
                                <span class="badge-user">
									<label class="inline">
										<input type="checkbox" wire:model.prefetch="genres" value="{{ $genre->id }}"> {{ $genre->name }}
									</label>
								</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-buffs">
                            <label for="buffs" class="label label-default">Buff</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="0">
									0% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="25">
									25% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="50">
									50% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="75">
									75% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="free" type="checkbox" value="100">
									100% Freeleech
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="doubleup" type="checkbox" value="1">
									Double Upload
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="featured" type="checkbox" value="1">
									Featured
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-tags">
                            <label for="tags" class="label label-default">Tags</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="stream" type="checkbox" value="1">
									Stream Optimized
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="sd" type="checkbox" value="1">
									SD Content
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="highspeed" type="checkbox" value="1">
									Highspeed
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-extra">
                            <label for="extra" class="label label-default">{{ __('common.extra') }}</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="internal" type="checkbox" value="1">
									Internal
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="personalRelease" type="checkbox" value="1">
									Personal Release
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-misc">
                            <label for="misc" class="label label-default">Misc</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="bookmarked" type="checkbox" value="1">
									Bookmarked
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="wished" type="checkbox" value="1">
									Wished
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-health">
                            <label for="health" class="label label-default">{{ __('torrent.health') }}</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="alive" type="checkbox" value="1">
									{{ __('torrent.alive') }}
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="dying" type="checkbox" value="1">
									{{ __('torrent.dying-torrent') }}
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="dead" type="checkbox" value="1">
									{{ __('torrent.dead-torrent') }}
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-history">
                            <label for="history" class="label label-default">{{ __('torrent.history') }}</label>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="notDownloaded" type="checkbox" value="1">
									Not Downloaded
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="downloaded" type="checkbox" value="1">
									Downloaded
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="seeding" type="checkbox" value="1">
									Seeding
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="leeching" type="checkbox" value="1">
									Leeching
								</label>
							</span>
                            <span class="badge-user">
								<label class="inline">
									<input wire:model.prefetch="incomplete" type="checkbox" value="1">
									Incomplete
								</label>
							</span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12 col-xs-6 adv-search-quantity">
                            <label for="quantity" class="label label-default">{{ __('common.quantity') }}</label>
                            <span>
								<label class="inline">
								<select wire:model="perPage" class="form-control">
									<option value="25">25</option>
									<option value="50">50</option>
									<option value="100">100</option>
								</select>
								</label>
							</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br>
    <div class="text-center">
        {{-- $torrents->links() --}}
    </div>
    <br>
    <div class="torrent-search--grouped block">
        <div class="dropdown torrent-listings-action-bar">
            {{--            <a class="dropdown btn btn-xs btn-success" data-toggle="dropdown" href="#" aria-expanded="true">--}}
            {{--                {{ __('common.publish') }} {{ __('torrent.torrent') }}--}}
            {{--                <i class="fas fa-caret-circle-right"></i>--}}
            {{--            </a>--}}
            {{--            <ul class="dropdown-menu">--}}
            {{--                @foreach($categories as $category)--}}
            {{--                    <li role="presentation">--}}
            {{--                        <a role="menuitem" tabindex="-1" target="_blank"--}}
            {{--                           href="{{ route('upload_form', ['category_id' => $category->id]) }}">--}}
            {{--                            <span class="menu-text">{{ $category->name }}</span>--}}
            {{--                            <span class="selected"></span>--}}
            {{--                        </a>--}}
            {{--                    </li>--}}
            {{--                @endforeach--}}
            {{--            </ul>--}}
        </div>
        <style>
            .torrent-group,
            .torrent-group__info,
            .torrent-group__header {
                display: flex;
            }

            .torrent-group {
                flex-direction: row;
                padding: 10px 15px;
                gap: 1rem;
            }

            .torrent-group__info {
                flex-direction: column;
                flex-grow: 1;
                border-left: 1px solid var(--app-border-light-color) !important;
                padding-inline-start: 10px;
            }

            .torrent-group__header {
                justify-content: space-between;
                align-items: center;
            }

            .torrent-group__header-name > a, h1, time {
                margin: 0;
                text-transform: uppercase;
                font-weight: bold;
                font-size: 20px;
            }

            .torrent-group__plot {
                margin: 10px 10px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                line-clamp: 2;
                -webkit-box-orient: vertical;
                word-wrap: break-word;
                text-overflow: ellipsis;
                overflow: hidden;
            }

            .torrent-search--grouped {
                border: 1px solid var(--app-border-light-color) !important;
            }

            .block {
                border-radius: unset !important;
            }

            .torrent-search--grouped__name {
                margin: 0 !important;
            }

            .torrent-search--grouped__age > time {
                font-size: 14px;
            }

        </style>
        @foreach ($medias as $media)
            @php
                if ($media->category->movie_meta) {
                    $mediaType = 'movie';
                } elseif ($media->category->tv_meta) {
                    $mediaType = 'tv';
                } else {
                    $mediaType = 'no';
                }

                $meta = null;
                if ($media->category->movie_meta && $media->tmdb && $media->tmdb != 0 && $media->tmdb != '') {
                    $meta = \App\Models\Movie::with(['genres'])->find($media->tmdb);
                }
                if ($media->category->tv_meta && $media->tmdb && $media->tmdb != 0 && $media->tmdb != '') {
                    $meta = \App\Models\Tv::with(['genres'])->find($media->tmdb);
                }

                $media->torrents = \App\Models\Torrent::select(['id', 'name', 'size', 'seeders', 'leechers', 'times_completed',
                'category_id', 'type_id', 'resolution_id', 'season_number', 'episode_number', 'user_id', 'free',
                'doubleup', 'stream', 'highspeed', 'internal', 'sd', 'featured', 'anon', 'sticky', 'personal_release',
                'created_at', 'bumped_at', 'fl_until', 'du_until'])
                ->where('tmdb', '=', $media->tmdb)
                ->get();
//            @endphp
            <div class="torrent-group">
                <div class="torrent-group__poster">
                    <a
                            @switch($mediaType)
                                @case('movie')
                                @case('tv')
                                    href="{{ route('torrents.similar', ['category_id' => $media->torrents->first()->category_id, 'tmdb' => $media->tmdb]) }}"
                            @endswitch
                            class="torrent-search--grouped__poster"
                    >
                        <img
                                @switch($mediaType)
                                    @case ('movie')
                                    @case ('tv')
                                        src="{{ isset($meta->poster) ? tmdb_image('poster_small', $meta->poster) : 'https://via.placeholder.com/90x135' }}"
                                @break
                                @case ('game')
                                    src="{{ isset($meta->cover) ? 'https://images.igdb.com/igdb/image/upload/t_cover_small_2x/'.$meta->cover['image_id'].'.png' : 'https://via.placeholder.com/90x135' }}"
                                @break
                                @case ('no')
                                    @if(file_exists(public_path().'/files/img/torrent-cover_'.$media->torrents->first()->id.'.jpg'))
                                        src="{{ url('files/img/torrent-cover_'.$media->torrents->first()->id.'.jpg') }}"
                                @else
                                    src="https://via.placeholder.com/90x135"
                                @endif
                                @break
                                @default
                                    src="https://via.placeholder.com/90x135"
                                @endswitch
                                alt="{{ __('torrent.poster') }}"
                        >
                    </a>
                </div>
                <div class="torrent-group__info">
                    <div class="torrent-group__header">
                        <div class="torrent-group__header-name">
                            <a href="{{ route('torrents.similar', ['category_id' => $media->torrents->first()->category_id, 'tmdb' => $media->tmdb]) }}">
                                <h1>
                                    @switch ($mediaType)
                                        @case('movie')
                                            {{ $meta->title ?? '' }}
                                            <time>{{ \substr($meta->release_date, 0, 4) ?? '' }}</time>
                                            @break
                                        @case('tv')
                                            {{ $meta->name ?? '' }}
                                            <time>{{ \substr($meta->first_air_date, 0, 4) ?? '' }}</time>
                                            @break
                                    @endswitch
                                </h1>
                            </a>
                        </div>
                        <div class="torrent-search--grouped__genres">
                            @if (isset($meta->genres) && $meta->genres->isNotEmpty())
                                @foreach ($meta->genres->take(3) as $genre)
                                    <a href="{{ route('mediahub.genres.show', ['id' => $genre->id]) }}" class="torrent-search--grouped__genre badge-extra">
                                        {{ $genre->name }}
                                    </a>
                                @endforeach
                            @endif
                        </div>

                    </div>
                    <p class="torrent-group__plot">
                        @switch (true)
                            @case($mediaType === 'movie')
                            @case($mediaType === 'tv')
                                {{ $meta->overview }}
                                @break
                        @endswitch
                    </p>
                    <div class="torrent-group__table">
                        @switch ($mediaType)
                            @case('movie')
                                <table class="torrent-search--grouped__movie-torrents">
                                    @foreach ($media->torrents->sortBy('type.position')->values()->groupBy('type_id') as $torrentsByType)
                                        <tbody>
                                        @foreach ($torrentsByType->sortBy([['resolution.position', 'asc'], ['internal', 'desc'], ['size', 'desc']]) as $torrent)
                                            <tr>
                                            @if ($loop->first)
                                                <tr>
                                                    <td colspan="8"
                                                        class="torrent-search--grouped__type"
                                                        scope="rowgroup"
                                                    >
                                                        {{ $torrent->type->name }}
                                                    </td>
                                                </tr>
                                                @endif
                                                @include('livewire.includes._torrent-group-row')
                                                </tr>
                                                @endforeach
                                        </tbody>
                                    @endforeach
                                </table>
                                @break
                            @case('tv')
                                <table width="100%" class="torrent-search--grouped__movie-torrents">
                                    @foreach($media->torrents->groupBy('season_number')->sortKeys() as $season_number => $season)
                                        @if ($season_number === 0)
                                            @foreach ($season->groupBy('episode_number')->sortKeys() as $episode_number => $episode)
                                                @if ($episode_number === 0)
                                                    <tr>
                                                        <td
                                                        ">
                                                        Complete Pack
                                                        </td>
                                                    </tr>
                                                    <table class="torrent-search--grouped__complete-pack-torrents">
                                                        @foreach ($episode->sortBy('type.position')->groupBy('type_id') as $torrentsByType)
                                                            <tbody>
                                                            @foreach ($torrentsByType as $torrent)
                                                                <tr>
                                                                @if ($loop->first)
                                                                    <tr>
                                                                        <td colspan="8"
                                                                            class="torrent-search--grouped__type"
                                                                            scope="rowgroup"
                                                                            {{ $torrent->type->name }}
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                    @include('livewire.includes._torrent-group-row')
                                                                    </tr>
                                                                    @endforeach
                                                            </tbody>
                                                        @endforeach
                                                    </table>
                                                @endif
                                            @endforeach
                                        @else
                                            @if(! empty($season_number) )
                                                <tr>
                                                    <td colspan="8">
                                                        Season {{ $season_number }}
                                                    </td>
                                                </tr>
                                            @endif

                                            @foreach ($season->groupBy('episode_number')->sortKeys() as $episode_number => $episode)

                                                <tr>
                                                    @if ($episode_number === 0)
                                                        <td colspan="8">Season Pack</td>
                                                    @elseif(! empty($episode_number))
                                                        <td colspan="8"> Episode {{ $episode_number }}</td>
                                                    @endif
                                                </tr>
                                                <table
                                                        @if ($episode_number == 0)
                                                            class="torrent-search--grouped__season-pack-torrents"
                                                        @else
                                                            class="torrent-search--grouped__episode-torrents"
                                                        @endif
                                                >
                                                    @foreach ($episode->sortBy('type.position')->groupBy('type_id') as $torrentsByType)
                                                        <tbody>
                                                        @foreach ($torrentsByType->filter(fn ($torrent) => !($torrent->episode_number === 0 && $torrent->season_number === 0))->sortBy([['resolution.position', 'asc'], ['internal', 'desc'], ['size', 'desc']]) as $torrent)
                                                            <tr>
                                                            @if ($loop->first)
                                                                <tr>
                                                                    <td colspan="8"
                                                                        class="torrent-search--grouped__type"
                                                                        scope="rowgroup"
                                                                    >
                                                                        {{ $torrent->type->name }}
                                                                    </td>
                                                                </tr>
                                                                @endif
                                                                @include('livewire.includes._torrent-group-row')
                                                                </tr>
                                                                @endforeach
                                                        </tbody>
                                                    @endforeach
                                                </table>

                                            @endforeach

                                        @endif
                                    @endforeach
                                </table>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>

        @endforeach

        @if (! $medias->count())
            <div class="margin-10 torrent-listings-no-result">
                {{ __('common.no-result') }}
            </div>
        @endif
        <br>
        <div class="text-center torrent-listings-pagination">
            {{ $medias->links() }}
        </div>
        <br>
    </div>
</div>

{{--<script nonce="{{ HDVinnie\SecureHeaders\SecureHeaders::nonce('script') }}">--}}
{{--  document.addEventListener('livewire:load', function () {--}}
{{--    let myOptions = [--}}
{{--            @foreach($regions as $region)--}}
{{--      {--}}
{{--        label: "{{ $region->name }}", value: "{{ $region->id }}"--}}
{{--      },--}}
{{--        @endforeach--}}
{{--    ]--}}
{{--    VirtualSelect.init({--}}
{{--      ele: '#regions',--}}
{{--      options: myOptions,--}}
{{--      multiple: true,--}}
{{--      search: true,--}}
{{--      placeholder: "{{__('Select Regions')}}",--}}
{{--      noOptionsText: "{{__('No results found')}}",--}}
{{--    })--}}

{{--    let regions = document.querySelector('#regions')--}}
{{--    regions.addEventListener('change', () => {--}}
{{--      let data = regions.value--}}
{{--    @this.set('regions', data)--}}
{{--    })--}}

{{--    let myOptions2 = [--}}
{{--            @foreach($distributors as $distributor)--}}
{{--      {--}}
{{--        label: "{{ $distributor->name }}", value: "{{ $distributor->id }}"--}}
{{--      },--}}
{{--        @endforeach--}}
{{--    ]--}}
{{--    VirtualSelect.init({--}}
{{--      ele: '#distributors',--}}
{{--      options: myOptions2,--}}
{{--      multiple: true,--}}
{{--      search: true,--}}
{{--      placeholder: "{{__('Select Distributor')}}",--}}
{{--      noOptionsText: "{{__('No results found')}}",--}}
{{--    })--}}

{{--    let distributors = document.querySelector('#distributors')--}}
{{--    distributors.addEventListener('change', () => {--}}
{{--      let data = distributors.value--}}
{{--    @this.set('distributors', data)--}}
{{--    })--}}
{{--  })--}}
{{--</script>--}}
