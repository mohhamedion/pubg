@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="create-news-header">
        <h1>{{ $title }} </h1> 
        <div class="upload-image">
            <i class="fas fa-download"></i>
            <a href="{{ route('news.image') }}" target="_blank" class="upload-image__link">@lang('labels.upload_image')</a>
        </div>
    </div>
   

    <div class="panel panel-page panel-faq-form">
        {!! Form::model($article, [
            'route' => $article->id ? ['news.update', $article] : 'news.store',
            'method' => 'POST'
        ]) !!}
        <div class="form-group">
            {!! Form::label('title', trans('labels.article_title'), ['required']) !!}
            {!! Form::input('title', 'title', $article->title, ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('preview', trans('labels.article_preview'), ['required']) !!}
            {!! Form::input('preview', 'preview', $article->preview, ['class' => 'form-control', 'required']) !!}
        </div>

        <textarea name="body" title="@lang('labels.article_body')" rows="10">{!! $article->body !!}</textarea>

        <input type="submit" class="button bordered" style="margin-top: 10px" value="@lang('labels.save')"/>
        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/tinymce/theme.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 500,
            menubar: false,
            language: '{{ App::isLocale('ru') ? 'ru' : '' }}',
            plugins: 'textcolor link image',
            toolbar: 'undo redo | insert | styleselect | bold italic | forecolor backcolor link | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image',
        });
    </script>
@endpush