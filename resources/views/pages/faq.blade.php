@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="header-with-content">
            <h1 class="inline-header">{{ $title }}</h1>
            @if($is_admin)
                <a href="{{ route('faq.create') }}" style="margin-top: 20px"
                   class="button bordered pull-right">@lang('labels.add')</a>
            @endif
        </div>
    </div>

    @include('flash::message')

    
        @if($questions->count())
            <div class="panel panel-questions">
                @foreach($questions as $question)
                    <div class="question">
                        <div class="question-header">
                            <h3 class="question-text">{{ $question->question }}</h3>
                            <div class="question-header__chevron"></div>
                         </div>  
                    </div>  
                        @if($is_admin)
                           
                        @endif
                        <div class="question-answer">
                            <div class="question-answer__text"> {{ $question->answer }} </div>
                            @if($is_admin)
                                <div class="question-answer__actions">
                                    <div class="faq-delete-wrapper">
                                        <a href="{{ route('faq.destroy', $question) }}"
                                        class="faq-delete block-link"
                                        title="@lang('labels.buttons.delete')">
                                            <div class="delete-question"></div>
                                        </a>
                                    </div>
                                    <div class="faq-delete-wrapper">
                                        <a href="{{ route('faq.edit', $question) }}"
                                        class="block-link edit"
                                        title="@lang('labels.buttons.edit')">
                                            <span class="edit-question"></span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    
                @endforeach
                </div>
        @else
            <div class="empty-faq">
                <h3>@lang('labels.empty.data')</h3>
            </div>
        @endif
    
@endsection