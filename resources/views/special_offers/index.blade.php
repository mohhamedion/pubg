@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="header-with-content">
            <h1 class="inline-header">{{ $title }}</h1>
            @if($is_admin)
                <a href="{{ route('special_offers::create') }}" style="margin-top: 20px"
                   class="button bordered pull-right">@lang('labels.add')</a>
            @endif
        </div>
    </div>

    @include('flash::message')

    
            <!-- EARLIER VERSION ------------------------------------------------
                @if($offers->count())
                @foreach($offers as $offer)
                    <div class="offer{{ $offer->popular ? ' offer-popular' : '' }}">
                        @if($offer->popular)
                            <div class="offer-popular-badge">@lang('labels.popular')</div>
                        @endif
                        <div class="offer-header">{{ $offer->name }}</div>
                        <div class="offer-price">
                            {{ json_decode('"\\' . trans("labels.currency.{$country}.unicode") . '"')}}
                            {{ number_format($offer->amount, 0, '.', '') }}
                            <p class="guarantee">@lang('labels.special_offer_guarantee')</p>
                        </div>
                        <div class="offer-features">
                            <ul class="offer-features-list">
                                @foreach($offer->features as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @if($is_manager)
                            {!! Form::open(['name' => 'special-offer', 'data-id' => $offer->id]) !!}
                            <div class="row" style="padding: 0 15px">
                                <input class="form-control mb10" name="query"
                                       placeholder="@lang('labels.placeholder_search_query')"/>

                                <input class="form-control mb20" name="package_name" required
                                       placeholder="@lang('labels.placeholder_package_name_url')"/>
                                <input name="amount" value="{{ $offer->amount }}" type="hidden">
                            </div>
                        @endif
                        <div class="offer-footer">
                            @if($is_admin)
                                <a href="{{ route('special_offers::edit', $offer) }}"
                                   class="button-edit"><strong>@lang('labels.buttons.edit')</strong>
                                </a>

                                <a href="{{ route('special_offers::delete', $offer) }}"
                                   class="button-edit delete-offer"><strong>@lang('labels.buttons.delete')</strong>
                                </a>
                            @else
                                <button class="button-buy">
                                    <strong>@lang('labels.special_offer_buy')</strong>
                                </button>

                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <h3>@lang('labels.special_offer_empty')</h3>
            @endif -->

            @if($offers->count())
            <div class="panel panel-special-offers">
                <div class="offers-wrapper">
                @foreach($offers as $offer)
                
                    <div class="offer{{ $offer->popular ? ' offer-popular' : '' }}">
                        
                        <div class="offer-header">{{ $offer->name }} @if($offer->popular) <span> + </span> @endif</div>
                        <div class="offer-price">
                            {{ json_decode('"\\' . trans("labels.currency.{$country}.unicode") . '"')}}
                            {{ number_format($offer->amount, 0, '.', '') }}
                            <p class="guarantee">@lang('labels.special_offer_guarantee')</p>
                        </div>
                        <div class="offer-features">
                            <ul class="offer-features-list">
                                @foreach($offer->features as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="offer-footer">
                        @if($is_manager)
                            {!! Form::open(['name' => 'special-offer', 'data-id' => $offer->id]) !!}
                            <div class="offer-footer__inputs">
                                <input class="form-control mb10" name="query"
                                       placeholder="@lang('labels.placeholder_search_query')"/>

                                <input class="form-control mb20" name="package_name" required
                                       placeholder="@lang('labels.placeholder_package_name_url')"/>
                                <input name="amount" value="{{ $offer->amount }}" type="hidden">
                            </div>
                        @endif
                        
                            @if($is_admin)
                                <a href="{{ route('special_offers::edit', $offer) }}"
                                   class="button-edit"><strong>@lang('labels.buttons.edit')</strong>
                                </a>

                                <a href="{{ route('special_offers::delete', $offer) }}"
                                   class="button-edit delete-offer"><strong>@lang('labels.buttons.delete')</strong>
                                </a>
                            @else
                                <button class="button-buy">
                                    <strong>@lang('labels.special_offer_buy')</strong>
                                </button>

                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
    </div>
            @else
            <div class="panel-special-offers__empty">
                <h3>@lang('labels.special_offer_empty')</h3>
            </div>
            @endif
     

    @if($users->count() && $is_admin)
        <div class="panel">
            <h1>@lang('labels.buys')</h1>
            @foreach($users as $user)
                @foreach($user->specialOffers as $offer)
                    <div class="service-request">
                        <div class="row">
                            <div class="col-md-6">
                                <table>
                                    <tr>
                                        <td>@lang('labels.created_by'):</td>
                                        <td class="value">
                                            <a href="{{ route('users::show::index', $user) }}">
                                                {{ !empty($user->name) ? $user->name : $user->email }}
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td class="value">
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('labels.placeholder_package_name_url'):</td>
                                        <td class="value">
                                            <strong>{{ $offer->pivot->package_name }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('labels.placeholder_search_query'):</td>
                                        <td class="value">
                                            {{ !empty($offer->pivot->search_query) ? $offer->pivot->search_query : '-'}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>@lang('labels.special_offer_label'):</td>
                                        <td class="value">
                                            <strong>{{ $offer->name }}</strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <table>
                                    @foreach($offer->features as $feature)
                                        <tr>
                                            <td class="value">
                                                {{ $feature }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="col-md-1 request-delete-wrapper">
                                <a href="{{ route('special_offers::user_destroy', ['user_offer' => $offer->pivot->id]) }}"
                                   class="request-delete block-link" data-target="special_offers"
                                   title="@lang('labels.buttons.delete')">
                                    <i class="icons8-delete"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                <hr/>
            @endforeach
        </div>
    @else
        @include('special_offers._buyModal')
    @endif
@endsection