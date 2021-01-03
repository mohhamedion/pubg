@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('flash::message')

    <div class="panel panel-offer-form">
        {!! Form::model($offer, ['route' => $offer->id ? ['special_offers::update', $offer] : 'special_offers::store',
                    'method' => $offer->id ? 'patch' : 'post']) !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', trans('labels.special_offer_title')) !!}
            {!! Form::input('text', 'name', $offer->name, ['class' => 'form-control', 'required']) !!}
            @if($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', trans('labels.price')) !!}
            <div class="input-group">
                <span class="input-group-addon">{{ $currency }}</span>
                {!! Form::number('amount', $offer->amount, ['class' => 'form-control', 'step' => '0.01', 'required']) !!}
                @if($errors->has('amount'))
                    <span class="help-block">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label for="popular">@lang('labels.popular')</label><br/>
            <label class="switch" title="@lang('labels.popular')" style="margin-left: 0">
                <input type="checkbox" name="popular" value="1" class="switch"
                       id="popular" {{ $offer->popular ? 'checked' : '' }}/>
                <span class="slider round"></span>
            </label>
        </div>

        <div class="form-group mb40">
            {!! Form::label('features', trans('labels.special_offer_features')) !!}

            @if(count($offer->features))
                @foreach($offer->features as $feature)
                    <div class="row">
                        <div class="col-xs-11">
                            <input name="features[]" class="form-control mb20"
                                   title="@lang('labels.special_offer_features')" value="{{ $feature }}"/>
                        </div>
                        <div class="col-xs-1 feature-delete-wrapper ">
                            <button title="@lang('labels.buttons.delete')" type="button" class="feature-delete icon-button">
                                <i class="icons8-delete"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            @endif

            <button class="button primary add-feature" type="button">@lang('labels.add')</button>
        </div>

        <input type="submit" class="button primary" value="@lang('labels.save')"/>

        {!! Form::close() !!}
    </div>
@endsection

