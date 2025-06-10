<div class="card">
    <div class="card-body">
        <ul class="nav flex-column ">
            @if (checkUserPermission(App\Models\Settings::SITE_SETTINGS))
                <li class="nav-item {{ Route::is('admin.settings.site') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.site') ? ' text-white' : ' text-dark ' }} "
                        href="{{ route('admin.settings.site') }}">
                        {{ __('app.site_settings') }}
                    </a>
                </li>
            @endif


            @if (checkUserPermission(App\Models\Settings::BUSINESS_SETTINGS))
                <li class="nav-item {{ Route::is('admin.settings.business') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.business') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.business') }}">
                        {{ __('app.business_settings') }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::LOGO_SETTINGS))
                <li class="nav-item {{ Route::is('admin.settings.logo') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.logo') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.logo') }}">
                        {{ __('app.logo_and_favicon') }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::SMTP_SETTINGS))
                <li class="nav-item {{ Route::is('admin.settings.smtp') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.smtp') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.smtp') }}">
                        {{ __('app.smtp') }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::CHARGES_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.charges') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.charges') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.charges') }}">
                        {{ __('app.charges') }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::STOCK_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.stock') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.stock') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.stock') }}">
                        {{ __('app.stock') }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\TaxSettings::TAX_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.tax.index') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.tax.index') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.tax.index') }}">
                        {{ __('app.tax') }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\SocialMedia::SOCIAL_MEDIA_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.social-media.index') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.social-media.index') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.social-media.index') }}">
                        {{ __('app.social_media') }}
                    </a>
                </li>
            @endif
            @if (checkUserPermission(App\Models\Settings::ORDER_SETTING))
                <li
                    class="nav-item {{ Route::is('admin.settings.order') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.order') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.order') }}">
                        {{ __('app.order') }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::COLOR_SETTING))
                <li class="nav-item {{ Route::is('admin.settings.color') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.color') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.color') }}">
                        {{ __('app.color_settings') }}
                    </a>
                </li>

            @endif

            @if (checkUserPermission(App\Models\Settings::AUTHENTICATION_SETTING))
                <li class="nav-item {{ Route::is('admin.settings.authentication') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.authentication') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.authentication') }}">
                        {{ __('app.authentication') }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::PAYMENT_GATEWAY_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.payment-gateway.stripe') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.payment-gateway.stripe') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.payment-gateway.stripe') }}">
                        {{ __('app.payment_gateway') }}
                    </a>
                </li>
            @endif

            {{-- External API keys --}}

            @if (checkUserPermission(App\Models\Settings::EXTERNAL_API_KEYS))
                <li
                    class="nav-item {{ Route::is('admin.settings.external-api') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.external-api') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.external-api') }}">
                        {{ __('app.external_api_keys') }}
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
