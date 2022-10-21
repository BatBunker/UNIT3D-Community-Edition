@extends("layout.default")
@section('content')
    <style>
        .hidden-text {
            text-align: center;
            font-weight: bolder;
            text-decoration: underline;
        }
    </style>
    @if(false === auth()->user()->chat_hidden && true === config('chat.show-chat'))
        <h1 class="hidden-text">THE CHAT BOX IS HIDDEN !</h1>
    @else
        <div id="vue" style="margin: 0 calc(max(0px, 45vw - 800px)*-1)">
            <script src="{{ mix('js/chat.js') }}" crossorigin="anonymous"></script>
            @include('blocks.chat')
        </div>
    @endif
@endsection