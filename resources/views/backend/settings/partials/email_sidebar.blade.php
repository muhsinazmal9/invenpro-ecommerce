<div class="card">
    <div class="card-body">
        <ul class="nav flex-column ">

            <li
                class="nav-item {{ Route::is('admin.settings.email-template.reset-password') ? ' primary-btn btn-hover rounded' : '' }} ">
                <a class="nav-link fw-600 {{ Route::is('admin.settings.email-template.reset-password') ? ' text-white' : ' text-dark ' }} "
                    href="{{ route('admin.settings.email-template.reset-password') }}">
                    {{ __('app.reset_password') }}
                </a>
            </li>


        </ul>
    </div>
</div>
