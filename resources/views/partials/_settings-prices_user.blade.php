<div class="form-group">
    <h4>@lang('labels.30_sec')</h4>
    <input type="number" class="form-control" title="android_30s_price_user"
           name="android_30s_price_user" value="{{ $prices->android_30s_price_user }}"
           step="0.01" >
</div>

<div class="form-group">
    <h4>@lang('labels.1_min')</h4>
    <input type="number" class="form-control" title="android_60s_price_user"
           name="android_60s_price_user" value="{{ $prices->android_60s_price_user }}"
           step="0.01" >
</div>

<div class="form-group">
    <h4>@lang('labels.2_min')</h4>
    <input type="number" class="form-control" title="android_120s_price_user"
           name="android_120s_price_user" value="{{ $prices->android_120s_price_user }}"
           step="0.01" >
</div>

<div class="form-group">
    <h4>@lang('labels.5_min')</h4>
    <input type="number" class="form-control" title="android_300s_price_user"
           name="android_300s_price_user" value="{{ $prices->android_300s_price_user }}"
           step="0.01" >
</div>