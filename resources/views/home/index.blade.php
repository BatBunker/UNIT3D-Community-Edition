@extends('layout.default')
@section('content')
    <div class="page__home">
        @include('blocks.featured')
        <span class="dividerv2 "></span>
        @include('blocks.news')
        <span class="dividerv2"></span>
        @if(true === config('other.show-poll'))
            @include('blocks.poll')
            <span class="dividerv2"></span>
        @endif
        @include('blocks.top_torrents')
        <span class="dividerv2"></span>
        @include('blocks.top_uploaders')
        <span class="dividerv2"></span>
        @include('blocks.latest_topics')
        <span class="dividerv2"></span>
        @include('blocks.latest_posts')
        <span class="dividerv2"></span>
        @include('blocks.online')
    </div>
@endsection
