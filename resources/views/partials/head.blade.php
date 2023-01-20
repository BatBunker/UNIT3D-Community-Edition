<meta charset="UTF-8">
@section('title')
    <title>{{ page_title(config('other.title')) }}</title>
@show

<meta name="description" content="{{ config('other.meta_description') }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="_base_url" content="{{ route('home.index') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">

@yield('meta')

<link rel="shortcut icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">
<link rel="icon" href="{{ url('/favicon.ico') }}" type="image/x-icon">

@if (auth()->user()->standalone_css === null)
    @vite('resources/sass/app.scss')
    @if (auth()->user()->style == 1)
        @vite('resources/sass/themes/galactic.scss')
    @elseif (auth()->user()->style == 2)
        @vite(['resources/sass/themes/galactic.scss','resources/sass/themes/dark-blue.scss'])
    @elseif (auth()->user()->style == 3)
        @vite(['resources/sass/themes/galactic.scss','resources/sass/themes/dark-green.scss'])
    @elseif (auth()->user()->style == 4)
        @vite(['resources/sass/themes/galactic.scss','resources/sass/themes/dark-pink.scss'])
    @elseif (auth()->user()->style == 5)
        @vite(['resources/sass/themes/galactic.scss','resources/sass/themes/dark-purple.scss'])
    @elseif (auth()->user()->style == 6)
        @vite(['resources/sass/themes/galactic.scss','resources/sass/themes/dark-red.scss'])
    @elseif (auth()->user()->style == 7)
        @vite(['resources/sass/themes/galactic.scss','resources/sass/themes/dark-teal.css'])
    @elseif (auth()->user()->style == 8)
        @vite(['resources/sass/themes/galactic.scss','resources/sass/themes/dark-yellow.scss'])
    @elseif (auth()->user()->style == 9)
        @vite(['resources/sass/themes/galactic.scss','resources/sass/themes/cosmic-void.scss'])
    @endif
    @vite('resources/sass/themes/arthur.scss')
    @if (isset(auth()->user()->custom_css))
        <link rel="stylesheet" href="{{ auth()->user()->custom_css }}">
    @endif
@else
    <link rel="stylesheet" href="{{ auth()->user()->standalone_css }}">
@endif

@livewireStyles

@yield('stylesheets')


<style>
    .container_v2 {
        width: 1240px !important;
        min-width: 1240px !important;
        max-width: 1240px !important;
    }
</style>