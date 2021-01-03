@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('flash::message')

    <div class="panel panel-service">
        <div class="row">
            <div class="col-md-12">
                @if($is_manager)
                    @include('service_request._form', compact('type'))
                @else   
                    @include('service_request._show')
                @endif
            </div>
        </div>
    </div>
@endsection