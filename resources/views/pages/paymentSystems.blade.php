@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    <!-- <div class="row justify-content-center">
        <div class="items">
            @foreach($payment_systems as $system)
                <div class="item">
                    <div class="logo">
                        <img class="img-responsive" src="{{ asset($system->image_url) }}" alt="{{ $system->title }}">
                    </div>
                    <div class="item__title">
                        <span>{{ $system->title }}</span>
                        <a href="{{ route('settings::index') }}">
                        <span class="item__settings">
                            <i class="fas fa-cog"></i>
                        </span>
                        </a>
                    </div>
                    <div class="item__switch">
                        <div class="switchBlock">
                            <label class="switch">
                                <input id="" type="checkbox" name="top" value="{{ $system->id }}" class="switch system-top"
                                        {{ $system->top ? 'checked' : '' }}/>
                                <span class="slider round"></span>
                            </label>

                            <span class="switchText">
                            @lang('labels.videos.top')
                        </span>
                        </div>
                        <div class="switchBlock">
                            <label class="switch">
                                <input id="" type="checkbox" name="active" value="{{ $system->id }}" class="switch system-active"
                                        {{ $system->active ? 'checked' : '' }}/>
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
    </div> -->

    <div class="panel payment-systems-panel">
        @foreach($payment_systems as $system)
            <div class="payment-system{{ $system->active ? '' : ' non-active' }}"
                 title="{{ $system->active ? $system->name : trans('labels.not-active') }}">
                <div class="logo">
                    <img src="{{ asset($system->image_url) }}" alt="{{ $system->name }}">
                </div>
                <div class="system">
                    <p>{{ $system->name }}</p>
                    @if($is_admin)
                    <div class="item__switch">
                    <div class="switchBlock">
                    <div class="switchText">
                        @lang('labels.videos.top')
                    </div>
                        <label class="switch">
                            <input id="" type="checkbox" name="top" value="{{ $system->id }}" class="switch system-top"
                                    {{ $system->top ? 'checked' : '' }}/>
                            <span class="slider round"></span>
                        </label>

                       
                    </div>
                    <div class="switchBlock">
                    <div class="switchText">
                        @lang('labels.videos.available')
                    </div>
                        <label class="switch">
                            <input id="" type="checkbox" name="active" value="{{ $system->id }}" class="switch system-active"
                                    {{ $system->active ? 'checked' : '' }}/>
                            <span class="slider round"></span>
                        </label>

                        
                    </div>
                </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

@endsection