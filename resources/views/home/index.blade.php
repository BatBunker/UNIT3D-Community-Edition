@extends('layout.default')
@section('content')
    <div class="page__home flex gap-4">
        <div style="width: 75%">
            @include('blocks.top_torrents')
            <span class="dividerv2 "></span>
            @include('blocks.news')
            <span class="dividerv2"></span>
            @if(true === config('other.show-poll'))
                @include('blocks.poll')
                <span class="dividerv2"></span>
            @endif
            @include('blocks.latest_topics')
            <span class="dividerv2"></span>
            @include('blocks.latest_posts')
            <span class="dividerv2"></span>
            @include('blocks.online')
        </div>
        <div>
            @include('blocks.randomTorrent')
            <span class="dividerv2"></span>
            @include('blocks.top_uploaders')
            <span class="dividerv2"></span>

        </div>
    </div>

@endsection
