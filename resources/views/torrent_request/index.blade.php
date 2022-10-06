@extends('layout.default')

@section('title')
    <title>{{ page_title(__('request.requests')) }}</title>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb--active">
        {{ __('request.requests') }}
    </li>
@endsection

@section('content')
    <div>
        @livewire('torrent-request-search')
    </div>
@endsection