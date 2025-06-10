<section>
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-md-12 my-1">
                <div class="input-style-1">
                    <input type="password" placeholder="{{ __('passwords.current_password') }}" name="current_password" id="current_password" autocomplete="password"
                        value="{{ old('password') }}" />
                    <span class="mdi mdi-eye fs-5 toggle-current_password cursor-pointer" toggle="#current_password"
                        style="position: absolute; top: 50%; left: 95%; transform: translateY(-50%);"></span>
                    @error('current_password')
                    <span class="text-sm text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12 my-1">
                <div class="input-style-1">
                    <input type="password" placeholder="{{ __('passwords.new_password') }}" name="password"
                        id="password" autocomplete="new-password" value="{{ old('password') }}" />
                    <span class="mdi mdi-eye fs-5 toggle-password cursor-pointer" toggle="#password"
                        style="position: absolute; top: 50%; left: 95%; transform: translateY(-50%);"></span>
                    @error('password')
                    <span class="text-sm text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-12 my-1">
                <div class="input-style-1">
                    <input type="password" placeholder="{{ __('app.confirm_password') }}" name="password_confirmation"
                        id="password_confirmation" autocomplete="new-password" value="{{ old('password') }}" />
                    <span class="mdi mdi-eye fs-5 toggle-password_confirmation cursor-pointer" toggle="#password_confirmation"
                        style="position: absolute; top: 50%; left: 95%; transform: translateY(-50%);"></span>
                    @error('current_password')
                    <span class="text-sm text-danger" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                </div>

            </div>
        </div>
        <div class="flex items-center gap-4">
            <x-primary-button :type="'submit'">
                <span class="mdi mdi-content-save-settings"></span>
                {{ __('app.save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
<script>
    $(".toggle-password").click(function() {
            $(this).toggleClass("mdi-eye mdi-eye-off");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        $(".toggle-password_confirmation").click(function() {
        $(this).toggleClass("mdi-eye mdi-eye-off");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
        });
        $(".toggle-current_password").click(function() {
        $(this).toggleClass("mdi-eye mdi-eye-off");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
        input.attr("type", "text");
        } else {
        input.attr("type", "password");
        }
        });
</script>
