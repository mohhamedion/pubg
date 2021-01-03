@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>
        <a href="{{ route('faq.index') }}"
           class="back"></a>
        {{ $title }}
    </h1>

    <div class="panel panel-faq-form">
        {!! Form::model($faq, ['route' => $faq->id ? ['faq.update', $faq] : 'faq.store',
            'method' => $faq->id ? 'patch' : 'post']) !!}

        <div class="form-group">
            {!! Form::label('question_ru', trans('labels.question_ru')) !!}
            {!! Form::input('question_ru', 'question_ru', $faq->question_ru, ['class' => 'form-control', 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('answer_ru', trans('labels.answer_ru')) !!}
            {!! Form::textarea('answer_ru', $faq->answer_ru,
                ['class' => 'form-control', 'rows' => '3', 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('question_en', trans('labels.question_en')) !!}
            {!! Form::input('question_en', 'question_en', $faq->question_en, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('answer_en', trans('labels.answer_en')) !!}
            {!! Form::textarea('answer_en', $faq->answer_en,
                ['class' => 'form-control', 'rows' => '3']) !!}
        </div>

        <input type="submit" class="button primary" value="@lang('labels.save')"/>

        {!! Form::close() !!}
    </div>
@endsection