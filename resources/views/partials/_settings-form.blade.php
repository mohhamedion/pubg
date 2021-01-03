<div class="form-group">
    {!! Form::label($prefix . $delay . '_price_first', $delay === '48h' ? trans('labels.price_first_48h') : trans('labels.price_first') . ', ' . $currency, '') !!}
    <input type="number" class="form-control" title="Daily price first"
           name={{ $prefix . $delay . '_price_first' . $for_whom }} value="{!! $prices[$prefix . $delay . '_price_first' . $for_whom] !!}"
           step="0.01" required>
</div>
<div class="form-group">
    {!! Form::label($prefix . $delay . 'daily_price_second', $delay === '48h' ? trans('labels.price_second_48h') : trans('labels.price_second') . ', ' . $currency, '') !!}
    <input type="number" class="form-control" title="Daily price second"
           name={{$prefix . $delay . '_price_second' . $for_whom}} value="{!! $prices[$prefix . $delay . '_price_second' . $for_whom] !!}"
           step="0.01" required>
</div>
<div class="form-group">
    {!! Form::label($prefix . $delay . 'daily_price_third', $delay === '48h' ? trans('labels.price_third_48h') : trans('labels.price_third') . ', ' . $currency, '') !!}
    <input type="number" class="form-control" title="Daily price Third"
           name={{$prefix . $delay . '_price_third' . $for_whom}} value="{!! $prices[$prefix . $delay . '_price_third' . $for_whom] !!}"
           step="0.01" required>
</div>
<div class="form-group">
    {!! Form::label($prefix . $delay . 'daily_price_fourth', $delay === '48h' ? trans('labels.price_fourth_48h') : trans('labels.price_fourth') . ', ' . $currency, '') !!}
    <input type="number" class="form-control" title="Daily price Fourth"
           name={{$prefix . $delay . '_price_fourth' . $for_whom}} value="{!! $prices[$prefix . $delay . '_price_fourth' . $for_whom] !!}"
           step="0.01" required>
</div>