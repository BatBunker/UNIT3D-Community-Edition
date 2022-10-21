@extends('layout.default')
@section('content')
    <div class="page__home">
        @include('blocks.news')
        @include('blocks.featured')

        @if(true === config('other.show-poll'))
            @include('blocks.poll')
        @endif

        @include('blocks.top_torrents')
        @include('blocks.top_uploaders')
        @include('blocks.latest_topics')
        @include('blocks.latest_posts')
        @include('blocks.online')
    </div>
@endsection
