@extends('layout.default')
@section('content')
    <div class="page__home">
        @include('blocks.featured')
        @include('blocks.news')
        </style>
        @if(config('chat.show-chat'))
            <div id="vue">
                <script src="{{ mix('js/chat.js') }}" crossorigin="anonymous"></script>
                @include('blocks.chat')~
            </div>
        @endif

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
