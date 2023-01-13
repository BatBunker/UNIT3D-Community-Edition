@extends('layout.default')
@section('content')
    <div class="page__home">
        @include('blocks.featured')
        <span class="dividerv2 col-md-10 col-sm-10 col-md-offset-1"></span>
        @include('blocks.news')
        <span class="dividerv2 col-md-10 col-sm-10 col-md-offset-1 dividerv2--small-padding"></span>
        @if(true === config('other.show-poll'))
            @include('blocks.poll')
            <span class="dividerv2 col-md-10 col-sm-10 col-md-offset-1"></span>
        @endif
        @include('blocks.top_torrents')
        @include('blocks.top_uploaders')
        @include('blocks.latest_topics')
        @include('blocks.latest_posts')
        @include('blocks.online')
    </div>
@endsection
