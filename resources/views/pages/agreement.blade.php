@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <div class="panel panel-page convention">
        @if($is_manager)
            {!! $agreement[App::getLocale()] !!}
        @else
            {!! Form::open(['route' => 'agreement.update', 'method' => 'put']) !!}
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#agreement_ru" role="tab" data-toggle="tab">@lang('labels.on_rus')</a>
                </li>
                <li role="presentation">
                    <a href="#agreement_en" role="tab" data-toggle="tab">@lang('labels.on_eng')</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="agreement_ru">
                    <textarea name="agreement_ru" title="@lang('labels.nav.agreement')"
                              rows="10">{!! $agreement['ru'] !!}</textarea>
                </div>

                <div role="tabpanel" class="tab-pane fade" id="agreement_en">
                    <textarea name="agreement_en" title="@lang('labels.nav.agreement')"
                              rows="10">{!! $agreement['en'] !!}</textarea>
                </div>
            </div>

            <input type="submit" class="button bordered" style="margin-top: 10px" value="@lang('labels.save')"/>
            {!! Form::close() !!}
        @endif
    </div>
@endsection

@if($is_admin)
    @push('scripts')
        <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('js/tinymce/theme.min.js') }}"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                height: 500,
                menubar: false,
                language: '{{ App::isLocale('ru') ? 'ru' : '' }}',
                plugins: 'textcolor link',
                toolbar: 'undo redo | insert | styleselect | bold italic | forecolor backcolor link | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
            });
        </script>
    @endpush
@endif