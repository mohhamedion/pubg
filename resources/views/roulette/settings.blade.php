@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>
        <a href="{{ route('roulette::index') }}"
           title="@lang('labels.roulette_settings')"><i class="fa fa-chevron-left"></i></a>
        {{ $title }}
    </h1>

    <div class="panel panel-roulette">
        <div class="row">
            <div class="col-md-12">
            @include('flash::message')
            {!! Form::model($settings, ['url' => '/roulette/settings', 'method' => 'PATCH']) !!}
            <!--- Chance Field --->
                <div class="form-group">
                    {!! Form::label('chance', trans('labels.chance_for_win')) !!}
                    {!! Form::input('chance', 'chance', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <!--- Ratio Field --->
                <div class="form-group">
                    {!! Form::label('ratio', trans('labels.ratio')) !!}
                    {!! Form::input('ratio', 'ratio', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <!--- First Bet Amount Field --->
                <div class="form-group">
                    {!! Form::label('first_bet_amount',trans('labels.bet', ['index' => trans('labels.index.female.first'), 'currency' => $currency])) !!}
                    {!! Form::input('first_bet_amount', 'first_bet_amount', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <!--- Second Bet Amount Field --->
                <div class="form-group">
                    {!! Form::label('second_bet_amount', trans('labels.bet', ['index' => trans('labels.index.female.second'), 'currency' => $currency])) !!}
                    {!! Form::input('second_bet_amount', 'second_bet_amount', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <!--- Third Bet Amount Field --->
                <div class="form-group">
                    {!! Form::label('third_bet_amount', trans('labels.bet', ['index' => trans('labels.index.female.third'), 'currency' => $currency])) !!}
                    {!! Form::input('third_bet_amount', 'third_bet_amount', null, ['class' => 'form-control', 'required']) !!}
                </div>

                <input type="submit" class="button button-submit primary" value="@lang('labels.save')"/>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
