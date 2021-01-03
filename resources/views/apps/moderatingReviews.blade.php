@extends('layouts.app')

@section('title', $title)

@section('content')
    @include('flash::message')

    <div class="panel campaigns-panel dark_campaigns">
        <div class="row">
            <div class="col-md-12">
                <h2 class="dark_campaigns-title">{{ $title }}</h2>
                <div class="task-review-wrap">
                    <div class="title-line">
                        <h3 class="task-review-app-title dark-app_title" data-id="null">
                            AdvertApp
                            @if($advert_reviews_count > 0)
                                <span class="dark-app_span">{{ $advert_reviews_count }}</span>
                            @endif
                        </h3>
                    </div>
                    <div class="task-review-items"></div>
                </div>
                @foreach($applications as $application)
                    <div class="task-review-wrap">
                        <div class="title-line">
                            <h3 class="task-review-app-title" data-id="{{ $application->id }}">
                                {{ $application->name }}
                                @if($application->reviews_count > 0)
                                    <span class="badge danger">{{ $application->reviews_count }}</span>
                                @endif
                            </h3>
                            <a href="{{ route('apps::show', $application) }}" target="_blank">
                                @lang('labels.go_to_page')
                            </a>
                        </div>
                        <div class="task-review-items"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection