<div class="card">
    <div class="card-body">
        <ul class="nav flex-column ">
            @if (checkUserPermission(App\Models\Settings::STRIPE_SETTINGS))
                <li
                    class="nav-item {{ Route::is('admin.settings.payment-gateway.stripe') ? ' primary-btn btn-hover rounded' : '' }} ">
                    <a class="nav-link fw-600 {{ Route::is('admin.settings.payment-gateway.stripe') ? ' text-white' : ' text-dark ' }} "
                        href="{{ route('admin.settings.payment-gateway.stripe') }}">
                        {{ 'Stripe' }}
                    </a>
                </li>
            @endif

        </ul>
    </div>
</div>
