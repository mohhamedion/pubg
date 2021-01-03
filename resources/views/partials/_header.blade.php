{{--@if($notificationActive)
    <div class="notification-wrapper" style="background-color: {{ $headerNotification->background_color }}">
        <p style="color: {{ $headerNotification->text_color }}">{{ $headerNotification->text }}</p>
        <button type="button" class="close" style="margin-left: 10px" id="closeSystemNotification" aria-label="Close">
            <span>&times;</span>
        </button>
    </div>
@endif--}}

<header class="header{{--{{ $notificationActive ? ' has-notification' : '' }}--}}">
    <div class="header-logoside {{--@if($collapsedMenu) collapsed @endif --}}">
        <div class="logo">
            <a href="{{ route('home') }}" class="block-link">
                <img src="{{ asset('/images/logo_text-x1024.png') }}" style="width: 124px" alt="Mafia"/>
            </a>
        </div>
        <div class="menu-hamburger">
            <button class="navbar-collapse" id="collapse-navbar">
                <i class=""></i>
            </button>
        </div>
    </div>
    <div class="header-main">
        <div class="header-main__items">
            @if($is_manager)
                <div class="header-main__items___balance">
                    <p>
                        @lang('labels.balance')
                        <span class="balance-currency__value">
                            <span id="balance-value" style="margin: 0 4px">{{ auth()->user()->balance }}</span>
                            @lang("labels.currency.Russia.name")
                        </span>
                    </p>
                    <a class="header-main__items___replenish" href="{{ route('account::balance') }}">
                        @lang('labels.replenish')
                    </a>
                </div>
            @endif
            <ul>
               {{-- <li>
                    <a title="@lang('labels.currency.label')" id="toggle_select_currency">
                        <i class="icons8-dollar2"></i>
                    </a>
                    <div class="select_mod" id="select_currency_mod">
                        <ul class="select-currency">
                            @foreach($currencies as $country => $cur)
                                <li class="selectCurrency{{ $selected_currency === $country ? ' active' : '' }}"
                                    data-value="{{ $country }}">
                                    @if($country === 'Russia')
                                        <img src="{{ asset('images/ru-01.png') }}" width="20px" alt="{{ $country }}"/>
                                    @elseif($country === 'USA')
                                        <img src="{{ asset('images/usa-01.png') }}" width="20px" alt="{{ $country }}"/>
                                    @endif
                                    {{ json_decode('"\\' . $cur['unicode'] . '"') . ' - ' . $cur['name'] }}
                                </li>
                           @endforeach
                        </ul>
                    </div>
                </li>--}}
                <!--<li>
                    <a title="@lang('labels.select_language')" id="toggle_select_lang"
                       data-lang="{{ app()->getLocale() }}">
                        <i class="globus"></i>
                    </a>
                    <div class="select_mod" id="select_lang_mod">
                        <ul class="select-languages">
                            <li class="selectLanguage{{ App::isLocale('ru') ? ' active' : '' }}" data-value="ru">
                                <img src="{{ asset('images/ru-01.png') }}" width="20px" alt="RU"/> Русский
                            </li>
                            <li class="selectLanguage{{ App::isLocale('en') ? ' active' : '' }}" data-value="en">
                                <img src="{{ asset('images/gb-01.png') }}" width="20px" alt="EN"/> English
                            </li>
                        </ul>
                    </div>
                </li>-->
                <li>
                    <a title="@lang('labels.support')" id="toggle_support">
                        <i class="info"></i>
                    </a>
                    <div class="select_mod" id="support_mod">
                        <ul class="select-info">
                            <li>
                                <i class="phone"></i>
                                <span>+380970446004</span>
                            </li>
                            <li>
                                <i class="skype"></i>
                                <span>mafia</span>
                            </li>
                            <li>
                                <i class="mail"></i>
                                <span>support@mafia.com</span>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="{{ route('account::index') }}" title="@lang('labels.buttons.profile')"
                       class="{{ request()->url() === route('account::index') ? 'active-icon' : '' }}">
                        <i class="user"></i>
                    </a>
                </li>
               @if($is_admin)
                    <i class="vertical-separator"></i>
                    <li>
                        <a href="{{ route('reviews_moderate') }}" title="@lang('labels.moderating_reviews')"
                           class="{{ request()->url() === route('reviews_moderate') ? 'active-icon' : '' }}"
                           style="padding: 0 0 0 10px; font-size: 22px">

                            <i class="comment"></i><!--fa fa-comment-o-->
                            @if($moderating_reviews > 0)
                                <span class="comment-numb" style="top: -8px"
                                      id="moderating_reviews">{{ $moderating_reviews }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('apps::moderating') }}" title="@lang('labels.moderating_title')"
                           style="padding-right: 0"
                           class="{{ request()->url() === route('apps::moderating') ? 'active-icon' : '' }}">
                            <i class="clock"></i>
                            @if($moderating_apps > 0)
                                <span class="badge danger" id="moderating_apps">{{ $moderating_apps }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('transactions::index') }}"
                           title="@lang('labels.buttons.pending_transactions')"
                           class="{{ request()->url() === route('transactions::index') ? 'active-icon' : '' }}">
                            <i class="bell"></i>
                            @if($pending_transactions > 0)
                                <span class="comment-bell">{{ $pending_transactions }}</span>
                            @endif
                        </a>
                    </li>

                    <li style="vertical-align: sub;margin-right: 6px">
                        <a href="{{ route('stats::index') }}" title="@lang('labels.stats')"
                           class="{{ request()->url() === route('stats::index') ? 'active-icon' : '' }}"
                           style="padding: 0; font-size: 28px">
                            <i class="stats"></i>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('settings::index') }}" title="@lang('labels.buttons.settings')"
                           class="{{ request()->url() === route('settings::index') ? 'active-icon' : '' }}">
                            <i class="cog"></i>
                        </a>
                    </li>
                    <i class="vertical-separator separ2"></i>
                @endif
                <li>
                    <a href="{{ route('logout') }}" title="@lang('labels.buttons.logout')"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="exit"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
