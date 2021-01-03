@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('flash::message')


    <div class="row justify-content-center">
        <div class="items">
        @foreach($videos as $video)
            <div class="item">
                <div class="item__image">
                    <img class="img-responsive" src="{{ asset($video->image_url) }}" alt="{{ $video->title }}">
                </div>
                <div class="item__title">
                    <span>{{ $video->title }}</span>
                    <a href="{{ route('settings::index') }}">
                        <span class="item__settings">
                            <i class="fas fa-cog"></i>
                        </span>
                    </a>
                </div>
                <div class="item__switch">
                    <div class="switchBlock">
                        <label class="switch">
                            <input id="" type="checkbox" name="top" value="{{ $video->id }}" class="switch video-top"
                                    {{ $video->top ? 'checked' : '' }}/>
                            <span class="slider round"></span>
                        </label>

                        <span class="switchText">
                            @lang('labels.videos.top')
                        </span>
                    </div>
                    <div class="switchBlock">
                        <label class="switch">
                            <input id="" type="checkbox" name="top" value="{{ $video->id }}" class="switch video-available"
                                    {{ $video->available ? 'checked' : '' }}/>
                            <span class="slider round"></span>
                        </label>

                        <span class="switchText">
                            @lang('labels.videos.available')
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>


@endsection