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
    <link rel="stylesheet" href="{{ mix('css/app.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('css/themes/galactic.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('css/themes/cosmic-void.css') }}" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ mix('css/themes/arthur.css') }}" crossorigin="anonymous">

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