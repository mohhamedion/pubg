@extends('layouts.app')

@section('title', $title)

@section('content')
    <h1>{{ $title }}</h1>

    @include('flash::message')

    <div class="panel panel-balance">
    <span>@lang('labels.your_balance')</span>
        <label class="balance-label">
            {{ $user->balance_formatted }}
        </label>
        <hr/>

        <form id="payment" name="payment" action="{{ route('account::post.balance') }}" method="POST" enctype="utf-8">
            {{ csrf_field() }}
            <div class="form-group balance-formgroup">
                <label for="amount">@lang('labels.replenishment_hint')</label>
                <div class="input-group mb10">
                    <input class="form-control" name="amount" type="number" value="{{ $min_replenishment }}"
                           min="{{ $min_replenishment }}" title="amount for replenishment"/>
                    <span class="input-group-addon">{{ $currency }}</span>
                </div>
                <span class="text-danger validation-hint validate-numeric hidden">
                    @lang('validation.numeric', ['attribute' => trans('labels.amount_to_pay')])
                </span>
                <span class="text-danger validation-hint validate-minimal hidden">
                    @lang('validation.min.numeric', [
                        'attribute' => trans('labels.amount_to_pay'),
                        'min' => "${min_replenishment} ${currency}"
                    ])
                </span>
            </div>
            <input class="button bordered btn-large mb40" type="submit"
                   value="@lang('labels.replenish')">
        </form>

        @include('partials._replenishmentHistory')
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let form = $('#payment');
            let amountInput = $('input[name=amount]');
            let formSum = $('input[name=sum]');
            formSum.val(amountInput.val());
            let minimalValue = parseFloat("{{ $min_replenishment }}");

            form.on('submit', function (event) {
                refresh_errors();
                let inputValue = parseFloat(formSum.val());
                let value = inputValue.toFixed(2);
                let formValid = validate_amount(value);
                if (!formValid || inputValue === 0) {
                    event.preventDefault();
                    $('.validate-numeric').toggleClass('hidden');
                } else if (inputValue < minimalValue) {
                    event.preventDefault();
                    $('.validate-minimal').toggleClass('hidden');
                }
            });

            amountInput.keydown(function (event) {
                if (event.shiftKey === true) {
                    event.preventDefault();
                }

                if (event.keyCode === 13) {
                    form.submit();
                }

                if ((event.keyCode >= 48 && event.keyCode <= 57) ||
                    (event.keyCode >= 96 && event.keyCode <= 105) ||
                    event.keyCode === 8 || event.keyCode === 9 || event.keyCode === 37 ||
                    event.keyCode === 39 || event.keyCode === 46 || event.keyCode === 190 || event.keyCode === 110) {
                } else {
                    event.preventDefault();
                }

                if ($(this).val().indexOf('.') !== -1 && (event.keyCode === 110 || event.keyCode === 190)) {
                    event.preventDefault(); //if a decimal has been added, disable the "." - button
                }
            });

            amountInput.on('keyup', function () {
                let value = $(this).val();
                if (value !== '') {
                    formSum.val(value);
                    ikDataAmount.val(value);
                }
            });
        });

        /**
         * Validate input value is a correct amount for replenishment.
         * @param value
         * @returns {boolean}
         */
        function validate_amount(value) {
            return typeof value !== 'number';
        }

        /**
         * To clear errors field
         */
        function refresh_errors() {
            $('.validate-numeric').addClass('hidden');
            $('.validate-minimal').addClass('hidden');
        }
    </script>
@endpush