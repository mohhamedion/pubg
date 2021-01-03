<div class="row mb20">
    <div class="col-md-6">
        <h3 class="mb10">@lang('labels.price_settings_manager')</h3>
        <!-- Nav tabs -->
        <div class="form-group">
            {!! Form::label('other_price', trans('labels.user_price') . ', ' . $currency, '') !!}
            <input type="number" class="form-control" title="@lang('labels.user_price')"
                   name="other_price" value="{{ $prices['other_price'] }}" min="0.01"
                   step="0.01" required>
        </div>
        <div class="form-group">
            {!! Form::label('other_price_keywords', trans('labels.user_price_keywords') . ', ' . $currency, '') !!}
            <input type="number" class="form-control" title="@lang('labels.user_price_keywords')"
                   name="other_price_keywords" value="{{ $prices['other_price_keywords'] }}" min="0.01"
                   step="0.01" required>
        </div>
    </div>
</div>