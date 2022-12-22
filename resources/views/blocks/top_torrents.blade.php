<div class="col-md-10 col-sm-10 col-md-offset-1 panelv3">
    <div class="clearfix visible-sm-block panelv3"></div>
    <div class="">
        <div class=pb15">
            <h4 class="panelv3__heading panel__heading--transparent"><i
                        class="{{ config('other.font-awesome') }} fa-trophy"></i> {{ __('blocks.top-torrents') }}
                <a role="button" class="pull-right btn btn-primary " href="{{route('top10.index')}}"> View Top 10</a>
            </h4>
        </div>
        <ul class="tabs" role="tablist">
            <li class="active chip">
                <a href="#newtorrents" role="tab" data-toggle="tab" aria-expanded="true">
                    <i class="{{ config('other.font-awesome') }} fa-trophy text-gold"></i> {{ __('blocks.new-torrents') }}
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
        <div class="tab-content" x-data>
            <div class="tab-pane fade active in" id="newtorrents">
                <ul class="featured-carousel" style="display: flex"
                    x-ref="new"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
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
                        <li class="featured-carousel__slide">
                            <x-torrent.card :meta="$meta" :torrent="$new"/>
                        </li>
                    @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous"
                            x-on:click="$refs.new.scrollLeft == 0 ? $refs.new.scrollLeft = $refs.new.scrollWidth : $refs.new.scrollLeft -= (($refs.new.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next"
                            x-on:click="$refs.new.scrollLeft == ($refs.new.scrollWidth - $refs.new.offsetWidth) ? $refs.new.scrollLeft = 0 : $refs.new.scrollLeft += (($refs.new.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
            <div class="tab-pane fade" id="topseeded">
                <ul class="featured-carousel" style="display: flex"
                    x-ref="seed"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >
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
                        <li class="featured-carousel__slide">
                            <x-torrent.card :meta="$meta" :torrent="$seed"/>
                        </li>
                    @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous"
                            x-on:click="$refs.seed.scrollLeft == 0 ? $refs.seed.scrollLeft = $refs.seed.scrollWidth : $refs.seed.scrollLeft -= (($refs.seed.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next"
                            x-on:click="$refs.seed.scrollLeft == ($refs.seed.scrollWidth - $refs.seed.offsetWidth) ? $refs.seed.scrollLeft = 0 : $refs.seed.scrollLeft += (($refs.seed.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
            <div class="tab-pane fade" id="topleeched">
                <ul class="featured-carousel" style="display: flex"
                    x-ref="leech"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >
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
                        <li class="featured-carousel__slide">
                            <x-torrent.card :meta="$meta" :torrent="$leech"/>
                        </li>
                    @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous"
                            x-on:click="$refs.leech.scrollLeft == 0 ? $refs.leech.scrollLeft = $refs.leech.scrollWidth : $refs.leech.scrollLeft -= (($refs.leech.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next"
                            x-on:click="$refs.leech.scrollLeft == ($refs.leech.scrollWidth - $refs.leech.offsetWidth) ? $refs.leech.scrollLeft = 0 : $refs.leech.scrollLeft += (($refs.leech.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>

            <div class="tab-pane fade" id="dyingtorrents">
                <ul class="featured-carousel" style="display: flex"
                    x-ref="dying"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >
                    @foreach ($dying as $d)
                        @php $meta = null @endphp
                        @if ($d->category->tv_meta)
                            @if ($d->tmdb || $d->tmdb != 0)
                                @php $meta = cache()->remember('tvmeta:'.$d->tmdb.$d->category_id, 3_600, fn () => App\Models\Tv::query()->with('genres', 'networks', 'seasons')->where('id', '=', $d->tmdb)->first()) @endphp
                            @endif
                        @endif
                        @if ($d->category->movie_meta)
                            @if ($d->tmdb || $d->tmdb != 0)
                                @php $meta = cache()->remember('moviemeta:'.$leech->tmdb.$new->category_id, 3_600, fn () => App\Models\Movie::query()->with('genres', 'cast', 'companies', 'collection')->where('id', '=', $d->tmdb)->first()) @endphp
                            @endif
                        @endif
                        <li class="featured-carousel__slide">
                            <x-torrent.card :meta="$meta" :torrent="$d"/>
                        </li>
                    @endforeach
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous"
                            x-on:click="$refs.dying.scrollLeft == 0 ? $refs.dying.scrollLeft = $refs.dying.scrollWidth : $refs.dying.scrollLeft -= (($refs.dying.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next"
                            x-on:click="$refs.dying.scrollLeft == ($refs.dying.scrollWidth - $refs.dying.offsetWidth) ? $refs.dying.scrollLeft = 0 : $refs.dying.scrollLeft += (($refs.dying.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>

            <div class="tab-pane fade" id="deadtorrents">
                <ul class="featured-carousel" style="display: flex"
                    x-ref="dead"
                    x-init="setInterval(function () {$el.parentNode.matches(':hover') ? null : (($el.scrollLeft == $el.scrollWidth - $el.offsetWidth - 16) ? $el.scrollLeft = 0 : $el.scrollLeft += (($el.children[0].offsetWidth + 16) / 2 + 1)) }, 5000)"
                >
                    @foreach ($dead as $d)
                        @php $meta = null @endphp
                        @if ($d->category->tv_meta)
                            @if ($d->tmdb || $d->tmdb != 0)
                                @php $meta = cache()->remember('tvmeta:'.$d->tmdb.$d->category_id, 3_600, fn () => App\Models\Tv::query()->with('genres', 'networks', 'seasons')->where('id', '=', $d->tmdb)->first()) @endphp
                            @endif
                        @endif
                        @if ($d->category->movie_meta)
                            @if ($d->tmdb || $d->tmdb != 0)
                                @php $meta = cache()->remember('moviemeta:'.$leech->tmdb.$new->category_id, 3_600, fn () => App\Models\Movie::query()->with('genres', 'cast', 'companies', 'collection')->where('id', '=', $d->tmdb)->first()) @endphp
                            @endif
                        @endif
                        <li class="featured-carousel__slide">
                            <x-torrent.card :meta="$meta" :torrent="$d"/>
                        </li>
                        @endforeach
                        </tbody>
                        </table>
                </ul>
                <nav class="featured-carousel__nav">
                    <button class="featured-carousel__previous"
                            x-on:click="$refs.dead.scrollLeft == 0 ? $refs.dead.scrollLeft = $refs.dead.scrollWidth : $refs.dead.scrollLeft -= (($refs.dead.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-left"></i>
                    </button>
                    <button class="featured-carousel__next"
                            x-on:click="$refs.dead.scrollLeft == ($refs.dead.scrollWidth - $refs.dead.offsetWidth) ? $refs.dead.scrollLeft = 0 : $refs.dead.scrollLeft += (($refs.dead.children[0].offsetWidth + 16) / 2 + 1)">
                        <i class="{{ \config('other.font-awesome') }} fa-angle-right"></i>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</div>
