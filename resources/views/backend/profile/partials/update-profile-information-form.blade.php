<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col-md-6 my-1">
                <x-input-group :type="'text'" :placeholder="'First Name'" :id="'fname'" :name="'fname'" :value="old('fname', $user->fname)"
                    :required="'required'" :autocomplete="'fname'">
                    <i class="lni lni-user"></i>
                </x-input-group>

            </div>
            <div class="col-md-6 my-1">
                <x-input-group :type="'text'" :placeholder="'Last Name'" :id="'lname'" :name="'lname'" :value="old('lname', $user->lname)"
                    :autocomplete="'lname'">
                    <i class="lni lni-user"></i>
                </x-input-group>
            </div>
            <div class="col-md-6 my-1">
                <x-input-group :type="'email'" :placeholder="'Email Address'" :id="'email'" :name="'email'"
                    :value="old('email', $user->email)" :required="'required'" :autocomplete="'email'">
                    <i class="lni lni-envelope"></i>
                </x-input-group>
            </div>
            <div class="col-md-12 my-1">
                <x-primary-button :type="'submit'">
                    <span class="mdi mdi-content-save-settings"></span>
                    Save
                </x-primary-button>
            </div>

            <div class="col-md-12 my-1">
                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                            Your email address is unverified.

                            <button form="send-verification"
                                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Click here to re-send the verification email.
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                A new verification link has been sent to your email address.
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-4 my-1">
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
