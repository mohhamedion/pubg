@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('flash::message')


    <div class="row justify-content-center">
        <div class="items">
        @foreach($partners as $partner)
            <div class="item">
                <div class="item__image">
                    <img style="margin: 0px auto;" class="img-responsive" src="{{ asset($partner->image_url) }}" alt="{{ $partner->title }}">
                </div>
                <div class="item__title">
                    <span>{{ $partner->title }}</span>
                    <a href="{{ route('settings::index') }}">
                        <span class="item__settings">
                            <i class="fas fa-cog"></i>
                        </span>
                    </a>
                </div>
                <div class="item__switch">
                    <div class="switchBlock">
                        <label class="switch">
                            <input id="" type="checkbox" name="top" value="{{ $partner->id }}" class="switch partner-top"
                                    {{ $partner->top ? 'checked' : '' }}/>
                            <span class="slider round"></span>
                        </label>

                        <span class="switchText">
                            @lang('labels.partners.top')
                        </span>
                    </div>
                    <div class="switchBlock">
                        <label class="switch">
                            <input id="" type="checkbox" name="top" value="{{ $partner->id }}" class="switch partner-available"
                                    {{ $partner->is_available ? 'checked' : '' }}/>
                            <span class="slider round"></span>
                        </label>

                        <span class="switchText">
                            @lang('labels.partners.available')
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>


@endsection