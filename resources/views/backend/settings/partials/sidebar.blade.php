<div class="card">
    <div class="card-body">
        <ul class="nav flex-column ">
            @if (checkUserPermission(App\Models\Settings::SITE_SETTINGS))
                <li class="nav-item {{ Route::is('admin.settings.site') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.site') ? ' text-white' : ' text-dark ' }} "
                        href="{{ route('admin.settings.site') }}">
                        {{ 'Site Settings' }}
                    </a>
                </li>
            @endif


            @if (checkUserPermission(App\Models\Settings::BUSINESS_SETTINGS))
                <li class="nav-item {{ Route::is('admin.settings.business') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.business') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.business') }}">
                        {{ 'Business Settings' }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::LOGO_SETTINGS))
                <li class="nav-item {{ Route::is('admin.settings.logo') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.logo') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.logo') }}">
                        {{ 'Logo and Favicon' }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::SMTP_SETTINGS))
                <li class="nav-item {{ Route::is('admin.settings.smtp') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.smtp') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.smtp') }}">
                        {{ 'SMTP' }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::CHARGES_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.charges') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.charges') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.charges') }}">
                        {{ 'Charges' }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::STOCK_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.stock') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.stock') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.stock') }}">
                        {{ 'Stock' }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\TaxSettings::TAX_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.tax.index') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.tax.index') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.tax.index') }}">
                        {{ 'TAX' }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\SocialMedia::SOCIAL_MEDIA_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.social-media.index') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.social-media.index') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.social-media.index') }}">
                        {{ 'Social Media' }}
                    </a>
                </li>
            @endif
            @if (checkUserPermission(App\Models\Settings::ORDER_SETTING))
                <li
                    class="nav-item {{ Route::is('admin.settings.order') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.order') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.order') }}">
                        {{ 'Order' }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::COLOR_SETTING))
                <li class="nav-item {{ Route::is('admin.settings.color') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.color') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.color') }}">
                        {{ 'Color Settings' }}
                    </a>
                </li>

            @endif

            @if (checkUserPermission(App\Models\Settings::AUTHENTICATION_SETTING))
                <li class="nav-item {{ Route::is('admin.settings.authentication') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.authentication') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.authentication') }}">
                        {{ 'Authentication' }}
                    </a>
                </li>
            @endif

            @if (checkUserPermission(App\Models\Settings::PAYMENT_GATEWAY_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.payment-gateway.stripe') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.payment-gateway.stripe') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.payment-gateway.stripe') }}">
                        {{ 'Payment Gateway' }}
                    </a>
                </li>
            @endif

            {{-- External API keys --}}

            @if (checkUserPermission(App\Models\Settings::EXTERNAL_API_KEYS))
                <li
                    class="nav-item {{ Route::is('admin.settings.external-api') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.external-api') ? ' text-white' : ' text-dark ' }}"
                        href="{{ route('admin.settings.external-api') }}">
                        {{ 'External API Keys' }}
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
