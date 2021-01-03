@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="header-with-content">
            <h1 class="inline-header">{{ $title }}</h1>
            @if($is_admin)
                <a href="{{ route('news.create') }}" style="margin-top: 20px"
                   class="button bordered pull-right">@lang('labels.create_article')</a>
            @endif
        </div>
    </div>

    @include('flash::message')

    <div class="row">
        
            @if($articles->count())
            <div class="articles-wrapper">
                @foreach($articles as $article)
                    <div class="article">
                        <a href="{{ route('news.show', $article) }}">
                            <h3 {{ $article->is_read ? '' : 'class=unread' }}>{{ $article->title }}</h3>
                            <p class="date">{{ $article->created_at->format('H:i d.m.Y') }}</p>
                            <p>{{ $article->preview }}</p>
                        </a>
                    </div>
                @endforeach
                </div>
            @else
                <div class="news-empty">
                    <h3>@lang('labels.articles_empty')</h3>
                </div>
            @endif
        
    </div>
@endsection