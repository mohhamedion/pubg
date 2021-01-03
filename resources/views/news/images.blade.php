@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <div class="panel panel-page panel-faq-form">
        {!! Form::open([
            'route' => 'news.post.image',
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ]) !!}
        <div class="form-group mb20">
            {!! Form::file('file[]', ['accept' => 'image/*', 'multiple', 'required']) !!}
        </div>
        <input type="submit" class="button bordered" style="margin-top: 10px" value="@lang('labels.upload')"/>
        {!! Form::close() !!}
    </div>

    @if (count($images))
        <div class="panel panel-page">
            @foreach($images as $image)
                <div class="article-image">
                    <div class="article-image_image">
                        <a href="{{ $image->url }}" target="_blank" class="block-link">
                            <img src="{{ $image->url }}"/>
                        </a>
                        <div class="article-image_link">
                            <input type="text" value="{{ $image->url }}"/>
                            <button class="btn btn-info btn-copy">Copy</button>
                            <button class="btn btn-danger btn-delete pull-right" data-url="{{ route('news.delete.image', $image->id) }}">Delete</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
