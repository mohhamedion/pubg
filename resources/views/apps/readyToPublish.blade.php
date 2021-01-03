@extends('layouts.app')

@section('title', $title)

@section('content')
    @include('flash::message')

    @if($applications->count())
        @foreach($applications as $application)
            <div class="service-request">
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <table>
                            <tr>
                                <td>@lang('labels.identifier'):</td>
                                <td class="value">
                                    <strong>{{ $application->id }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('labels.total_price'):</td>
                                <td class="value">
                                    <strong>{{ "{$application->amount} {$currency}" }}</strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <table>
                            <tr>
                                <td>@lang('labels.app'):</td>
                                <td class="value">
                                    <strong>{{ "{$application->name}" }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>@lang('labels.app_url'):</td>
                                <td class="value">
                                    <strong><a href="{{ "https://play.google.com/store/apps/details?id={$application->package_name} "}}"
                                            target="_blank">
                                            {{ "https://play.google.com/store/apps/details?id={$application->package_name} "}}</a></strong>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $applications->links() }}
    @else
        <h2>@lang('labels.empty.apps')</h2>
    @endif
@endsection