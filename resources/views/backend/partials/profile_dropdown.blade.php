<div class="profile-box ml-15">
    <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile" data-bs-toggle="dropdown"
        aria-expanded="false">
        <div class="profile-info">
            <div class="info">
                <div class="image">
                    <img style="height: 100%; object-fit: cover;" src="{{ asset(auth()->user()->image ?? getSetting(\App\Models\Settings::DEFAULT_AVATAR)) }}" alt="" />
                </div>
                <div>
                    <h6 class="fw-500 text-capitalize">{{ auth()->user()->name }}</h6>
                    <p>{{ Str::replace('_',' ',auth()->user()->roles[0]->name) ?? '' }}</p>
                </div>
            </div>
        </div>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
        <li>
            <div class="author-info flex items-center !p-1">
                <div class="image">
                    <img src="{{ asset(auth()->user()->image ?? getSetting(\App\Models\Settings::DEFAULT_AVATAR)) }}" alt="image">
                </div>
                <div class="content">
                    <h4 class="text-sm">{{ auth()->user()?->name }}</h4>
                    <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs"
                        href="#">{{ auth()->user()?->email }}</a>
                </div>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <a href="{{ route('admin.profile.edit') }}">
                <i class="lni lni-user"></i> {{ 'View Profile' }}
            </a>
        </li>
        <li class="divider"></li>
        <li>
            <a onclick="document.getElementById('logout_form').submit()" href="javascript:void(0)"> <i
                    class="lni lni-exit"></i> {{ 'Sign Out' }} </a>
            <form id="logout_form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>

        </li>
    </ul>
</div>
@push('script')
    <script></script>
@endpush
