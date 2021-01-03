@extends('layouts.app')

@section('title', $title)

@section('content')
    @include('flash::message')

    <div class="panel panel-page">
        @if($is_admin)
            <div class="row">
                {!! Form::open(['route' => 'video_tour.update', 'method' => 'put']) !!}
                <div class="form-group">
                    {!! Form::label('video_tour_frame', trans('labels.insert_video_frame'), ['class' => 'mb10']) !!}
                    {!! Form::textarea('video_tour_frame', null,
                    ['class' => 'form-control mb10', 'rows' => '2', 'required']) !!}
                    <input class="button primary" type="submit" value="@lang('labels.save')"/>
                </div>
                {!! Form::close() !!}
            </div>
        @endif

        @if($is_manager && empty($video_tour_frame))
            <h3>@lang('labels.empty.data')</h3>
        @endif

        <div class="row">
            {!! $video_tour_frame !!}
        </div>
    </div>
@endsection