<div class="row mb20">
    <div class="col-md-6">
        <label class="mb10">@lang('labels.price_settings_user')</label>
             <div class="form-group">
        
        <input type="number" class="form-control" title="@lang('labels.user_price')"
               name="android_install_price_user" value="{{ $prices['android_install_price_user'] }}" min="0.01"
               step="0.01" required>
            
        </div>
    </div>

    <div class="col-md-6">
        <label class="mb10">@lang('labels.price_settings_manager')</label>
        <div class="form-group">

        <input type="number" class="form-control" title="@lang('labels.manager_price')"
               name="android_install_price_manager" value="{{ $prices['android_install_price_manager'] }}" min="0.01"
               step="0.01" required>
               </div>
    </div>
</div>