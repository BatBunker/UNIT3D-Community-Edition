@extends('layout.default')

@section('title')
    <title>{{ page_title($article->title) }} </title>
@endsection

@section('meta')
    <meta name="description" content="{{ substr(strip_tags($article->content), 0, 200) }}...">
@endsection

@section('breadcrumbs')
    <li class="breadcrumbV2">
        <a href="{{ route('articles.index') }}" class="breadcrumb__link">
            {{ __('articles.articles') }}
        </a>
    </li>
    <li class="breadcrumb--active">
        {{ $article->title }}
    </li>
@endsection

@section('page', 'page__articles--show')

@section('main')
<section class="panelV2">
    <header class="panel__header">
        <h1 class="panel__heading">{{ $article->title }}</h1>
        <div class="panel__actions">
            <time class="panel__action page__published" datetime="{{ $article->created_at }}">
                {{ $article->created_at->toDayDateTimeString() }}
            </time>
        </div>
    </header>
    <div class="panel__body">
        @joypixels($article->getContentHtml())
    </div>
</section>
<section class="panelV2">
    <h4 class="panel__heading">
        <i class="{{ config('other.font-awesome') }} fa-comment"></i>
        {{ __('common.comments') }}
    </h4>
    <div class="panel-body no-padding">
        <livewire:comments :model="$article"/>
    </div>
</section>
@endsection
