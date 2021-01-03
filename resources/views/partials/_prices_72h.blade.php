<div class="row mb20">
    <div class="col-md-6">
        <h3 class="mb10">@lang('labels.price_settings_user')</h3>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#android_user" aria-controls="android_user" role="tab"
                   data-toggle="tab">Android</a>
            </li>
            <li role="presentation">
                <a href="#ios_user" aria-controls="ios_user" role="tab"
                   data-toggle="tab">iOS</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            {{-- ANDROID TAB --}}
            <div role="tabpanel" class="tab-pane fade in active" id="android_user">
                @include('partials._settings-form',
                    ['prefix' => 'android_', 'for_whom' => '_user', 'delay' => '72h'])
            </div>

            {{-- IOS TAB --}}
            <div role="tabpanel" class="tab-pane fade" id="ios_user">
                @include('partials._settings-form',
                    ['prefix' => 'ios_', 'for_whom' => '_user', 'delay' => '72h'])
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <h3 class="mb10">@lang('labels.price_settings_manager')</h3>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#android_manager"
                                                      aria-controls="android_manager" role="tab"
                                                      data-toggle="tab">Android</a></li>
            <li role="presentation"><a href="#ios_manager" aria-controls="ios_manager"
                                       role="tab"
                                       data-toggle="tab">iOS</a>
            </li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            {{-- ANDROID TAB --}}
            <div role="tabpanel" class="tab-pane fade in active" id="android_manager">
                @include('partials._settings-form',
                    ['prefix' => 'android_', 'for_whom' => '_manager', 'delay' => '72h'])
            </div>

            {{-- IOS TAB --}}
            <div role="tabpanel" class="tab-pane fade" id="ios_manager">
                @include('partials._settings-form',
                    ['prefix' => 'ios_', 'for_whom' => '_manager', 'delay' => '72h'])
            </div>
        </div>
    </div>
</div>