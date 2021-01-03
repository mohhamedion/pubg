@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <div class="panel single-news">
        <div class="row">
            <div class="header-with-content header-sigle-news">
                <div><h1 class="inline-header">{{ $article->title }}</h1></div>
                @if($is_admin)
                <div class="actions-news">
                    <a href="{{ route('news.edit', $article) }}" 
                       class="button bordered pull-right">@lang('labels.edit_article')</a>
                    {{ Form::open(['method' => 'DELETE', 'route' => ['news.destroy', $article->id],
                    'class' => 'pull-right', 'style' => 'margin-right: 10px']) }}
                    {{ Form::submit(trans('labels.delete_article'), ['class' => 'button delete-news']) }}
                    {{ Form::close() }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            {!! $article->body !!}
        </div>
    </div>
@endsection
