@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('flash::message')

    <div class="panel panel-service">
        <div class="row">
            <div class="col-md-12">
                <label class="mb20">Email:</label> {{ $request->email }}
                <br/>
                <label class="mb20">@lang('labels.app_url'):</label>
                <a href="{{ $request->url }}">{{ $request->url }}</a>
                @if($request->skype_telegram)
                    <br/>
                    <label class="mb20">@lang('labels.skype_telegram'):</label> {{ $request->skype_telegram }}
                @endif
                @if($request->description)
                    <br/>
                    <label class="mb20">@lang('labels.order_description'):</label> {{ $request->description }}
                @endif
            </div>
        </div>
    </div>
@endsection