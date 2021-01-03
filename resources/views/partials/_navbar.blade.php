<nav class="nav{{--{{ $notificationActive ? ' has-notification' : '' }} @if($collapsedMenu) collapsed @endif--}}">
    <div class="nav-wrapper">
        <ul>
            @if($is_admin)
                @include('partials.navbar._adminItems')
            @elseif($is_manager)
                @include('partials.navbar._managerItems')
            @elseif($is_editor)
                @include('partials.navbar._editorItems')
            @endif
                <!-- <li>
                    <a title="@lang('labels.nav.night_mode')"
                    >
                        <span class="panelIcon night_mode"></span>
                        <span class="menu-text">@lang('labels.nav.night_mode')</span>
                        <span class="switchNight_mode">
                            <label class="switch" id="nightMode_switch">
                                <input type="checkbox" id="change-theme"
                                       @if ($theme == 'dark')
                                           checked
                                       @endif
                                >
                                <span class="slider round"></span>
                            </label>
</span>
                    </a>
                </li> -->
        </ul>
        {{--
        <div class="nav-footer">
            <a href="https://play.google.com/store/apps/details?id=com.apppay.android"
               class="color-primary" target="_blank">AdvertApp</a>
        </div>
        --}}
        <p id="server_time">
        @lang('labels.server_time'):
        <span>{{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
    </p>
    </div>
    
</nav>

@push('scripts')
    <script>
        $().ready(function () {
            server_time = $('#server_time > span').html().match(/([0-9]{2}):([0-9]{2}):([0-9]{2})/);
            hours = server_time[1];
            minutes = server_time[2];
            seconds = server_time[3];

            setInterval(function () {
                seconds++;

                if (seconds == 60) {
                    minutes++;
                    seconds = '00';
                }
                if (minutes == 60) {
                    hours++;
                    minutes = 0;
                }
                if (hours == 24) {
                    hours = 0;
                }

                seconds = seconds < 10 ? '0' + +seconds : seconds;
                minutes = minutes < 10 ? '0' + +minutes : minutes;
                hours = hours < 10 ? '0' + +hours : hours;

                $('#server_time > span').html(hours + ':' + minutes + ':' + seconds);
            }, 1000);
        });
    </script>
@endpush