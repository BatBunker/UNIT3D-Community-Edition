<section class="panelv3 mt-2">
        <div class="py-2">
            <h4 class="carousel__heading text-2xl font-mono	">
                <i class="{{ config('other.font-awesome') }} fa-trophy"></i> {{ __('blocks.top-torrents') }}
            </h4>
        </div>
        <div class="panel-body">
            <ul class="tabs just justify-center" role="tablist">
                <li class="active chip">
                        <a href="#featuredtorrents" role="tab" data-toggle="tab" aria-expanded="true">
                            <i class="{{ config('other.font-awesome') }} fa-trophy text-gold"></i> Featured
                        </a>
                    </li>
                <li class="chip">
                    <a href="#newtorrents" role="tab" data-toggle="tab" aria-expanded="true">
                        <i class="{{ config('other.font-awesome') }} fa-trophy text-gold"></i> New
                    </a>
                </li>
                <li class="chip">
                    <a href="#topseeded" role="tab" data-toggle="tab" aria-expanded="false">
                        <i class="{{ config('other.font-awesome') }} fa-arrow-up text-success"></i>
                        {{ __('torrent.top-seeded') }}
                    </a>
                </li>
                <li class="chip">
                    <a href="#topleeched" role="tab" data-toggle="tab" aria-expanded="false">
                        <i class="{{ config('other.font-awesome') }} fa-arrow-down text-danger"></i>
                        {{ __('torrent.top-leeched') }}
                    </a>
                </li>
                <li class="chip">
                    <a href="#dyingtorrents" role="tab" data-toggle="tab" aria-expanded="false">
                        <i class="{{ config('other.font-awesome') }} fa-arrow-down text-red"></i>
                        {{ __('torrent.dying-torrents') }}
                        <i class="{{ config('other.font-awesome') }} fa-recycle text-red" data-toggle="tooltip"
                           data-original-title="{{ __('torrent.requires-reseed') }}"></i>
                    </a>
                </li>
                <li class="chip">
                    <a href="#deadtorrents" role="tab" data-toggle="tab" aria-expanded="false">
                        <i class="{{ config('other.font-awesome') }} fa-exclamation-triangle text-red"></i>
                        {{ __('torrent.dead-torrents') }}
                        <i class="{{ config('other.font-awesome') }} fa-recycle text-red" data-toggle="tooltip"
                           data-original-title="{{ __('torrent.requires-reseed') }}"></i>
                    </a>
                </li>
            </ul>
            <br>
            <div class="tab-content overflow-hidden">
                <div class="tab-pane fade active in" id="featuredtorrents">
                    <ul class="flex gap-12 ħ-[250px] justify-start">
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


                <div class="tab-pane fade" id="newtorrents">
                    <ul class="flex gap-12 ħ-[250px] justify-center"
                    >
                        @foreach ($newest as $new)
                            @php $meta = null @endphp
                            @if ($new->category->tv_meta)
                                @if ($new->tmdb || $new->tmdb != 0)
                                    @php $meta = cache()->remember('tvmeta:'.$new->tmdb.$new->category_id, 3_600, fn () => App\Models\Tv::query()->with('genres', 'networks', 'seasons')->where('id', '=', $new->tmdb)->first()) @endphp
                                @endif
                            @endif
                            @if ($new->category->movie_meta)
                                @if ($new->tmdb || $new->tmdb != 0)
                                    @php $meta = cache()->remember('moviemeta:'.$new->tmdb.$new->category_id, 3_600, fn () => App\Models\Movie::query()->with('genres', 'cast', 'companies', 'collection')->where('id', '=', $new->tmdb)->first()) @endphp
                                @endif
                            @endif
                            <li class="">
                                <x-torrent.card :meta="$meta" :torrent="$new"/>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="topseeded">
                    <ul class="flex gap-12 ħ-[250px] justify-center">
                        @foreach ($seeded as $seed)
                            @php $meta = null @endphp
                            @if ($seed->category->tv_meta)
                                @if ($seed->tmdb || $seed->tmdb != 0)
                                    @php $meta = cache()->remember('tvmeta:'.$seed->tmdb.$seed->category_id, 3_600, fn () => App\Models\Tv::query()->with('genres', 'networks', 'seasons')->where('id', '=', $seed->tmdb)->first()) @endphp
                                @endif
                            @endif
                            @if ($seed->category->movie_meta)
                                @if ($seed->tmdb || $seed->tmdb != 0)
                                    @php $meta = cache()->remember('moviemeta:'.$seed->tmdb.$seed->category_id, 3_600, fn () => App\Models\Movie::query()->with('genres', 'cast', 'companies', 'collection')->where('id', '=', $seed->tmdb)->first()) @endphp
                                @endif
                            @endif
                            <li>
                                <x-torrent.card :meta="$meta" :torrent="$seed"/>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="topleeched">
                    <ul class=" flex gap-12 ħ-[250px] justify-center">
                        @foreach ($leeched as $leech)
                            @php $meta = null @endphp
                            @if ($leech->category->tv_meta)
                                @if ($leech->tmdb || $leech->tmdb != 0)
                                    @php $meta = cache()->remember('tvmeta:'.$leech->tmdb.$leech->category_id, 3_600, fn () => App\Models\Tv::query()->with('genres', 'networks', 'seasons')->where('id', '=', $leech->tmdb)->first()) @endphp
                                @endif
                            @endif
                            @if ($leech->category->movie_meta)
                                @if ($leech->tmdb || $leech->tmdb != 0)
                                    @php $meta = cache()->remember('moviemeta:'.$leech->tmdb.$leech->category_id, 3_600, fn () => App\Models\Movie::query()->with('genres', 'cast', 'companies', 'collection')->where('id', '=', $leech->tmdb)->first()) @endphp
                                @endif
                            @endif
                            <li>
                                <x-torrent.card :meta="$meta" :torrent="$leech"/>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="dyingtorrents">
                    <ul class="flex gap-12 ħ-[250px] justify-center">
                        @foreach ($dying as $d)
                            @php $meta = null @endphp
                            @if ($d->category->tv_meta)
                                @if ($d->tmdb || $d->tmdb != 0)
                                    @php $meta = cache()->remember('tvmeta:'.$d->tmdb.$d->category_id, 3_600, fn () => App\Models\Tv::query()->with('genres', 'networks', 'seasons')->where('id', '=', $d->tmdb)->first()) @endphp
                                @endif
                            @endif
                            @if ($d->category->movie_meta)
                                @if ($d->tmdb || $d->tmdb != 0)
                                    @php $meta = cache()->remember('moviemeta:'.$d->tmdb.$d->category_id, 3_600, fn () => App\Models\Movie::query()->with('genres', 'cast', 'companies', 'collection')->where('id', '=', $d->tmdb)->first()) @endphp
                                @endif
                            @endif
                            <li>
                                <x-torrent.card :meta="$meta" :torrent="$d"/>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-pane fade" id="deadtorrents">
                    <ul class="flex gap-12 ħ-[250px] justify-center">
                        @foreach ($dead as $d)
                            @php $meta = null @endphp
                            @if ($d->category->tv_meta)
                                @if ($d->tmdb || $d->tmdb != 0)
                                    @php $meta = cache()->remember('tvmeta:'.$d->tmdb.$d->category_id, 3_600, fn () => App\Models\Tv::query()->with('genres', 'networks', 'seasons')->where('id', '=', $d->tmdb)->first()) @endphp
                                @endif
                            @endif
                            @if ($d->category->movie_meta)
                                @if ($d->tmdb || $d->tmdb != 0)
                                    @php $meta = cache()->remember('moviemeta:'.$d->tmdb.$d->category_id, 3_600, fn () => App\Models\Movie::query()->with('genres', 'cast', 'companies', 'collection')->where('id', '=', $d->tmdb)->first()) @endphp
                                @endif
                            @endif
                            <li>
                                <x-torrent.card :meta="$meta" :torrent="$d"/>
                            </li>
                        @endforeach
                    </ul>
                </div>
        </div>
    </div>
</section>
