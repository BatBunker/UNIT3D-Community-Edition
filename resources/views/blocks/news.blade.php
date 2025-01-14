@foreach ($articles as $article)
    <div class="panelv3">
        @if ($article->newNews)
            <div>
                <div class="py-2 ">
                    <h4 class="carousel__heading text-2xl font-mono">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                           href="#collapse4" style="color:#ffffff;">
                            @joypixels(':rotating_light:') {{ __('blocks.new-news') }} {{ $article->created_at->diffForHumans() }}
                            @joypixels(':rotating_light:')
                        </a>
                    </h4>
                </div>
                @else
                    <div
                    >
                        <div class="py-2">
                            <h4 class="carousel__heading text-2xl font-mono">
                                <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapse4" style="color:#ffffff;">
                                    <i class="{{ config('other.font-awesome') }} fa-fire"></i>  {{ __('blocks.check-news') }} {{ $article->created_at->diffForHumans() }}
                                </a>
                            </h4>
                        </div>
                        @endif
                        <div aria-expanded="{{ ($article->newNews ? 'true' : 'false') }}" id="collapse4"
                             class="panel-collapse {{ ($article->newNews ?  '': 'in') }}">
                            <div class="panel-body no-padding">
                                <div class="news-blocks">
                                    <a href="{{ route('articles.show', ['id' => $article->id]) }}"
                                       style=" float: right;">
                                        @if ( ! is_null($article->image))
                                            <img src="{{ url('files/img/' . $article->image) }}"
                                                 alt="{{ $article->title }}">
                                        @else
                                            <img src="{{ url('img/missing-image.png') }}" alt="{{ $article->title }}">
                                        @endif
                                    </a>

                                    <h1 class="text-bold" style="display: inline ;">{{ $article->title }}</h1>

                                    <p class="text-muted">
                                        <em>{{ __('articles.published-at') }}
                                            {{ $article->created_at->toDayDateTimeString() }}</em>
                                    </p>

                                    <p style="margin-block: 20px;">
                                        @joypixels(preg_replace('#\[[^\]]+\]#', '', Str::limit($article->content),
                                        150))...
                                    </p>

                                    <a href="{{ route('articles.show', ['id' => $article->id]) }}"
                                       class="btn btn-success pull-right">
                                        {{ __('articles.read-more') }}
                                    <hr class="mx-2">

                                        <a href="{{ route('articles.index') }}" class="btn btn-primary pull-right">
                                            {{ __('common.view-all') }}
                                        </a>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>
@endforeach
