<section class="space-y-6">
    <p class="mt-1 mb-2 text-sm text-gray-600 dark:text-gray-400">
        {{ __('auth.account_delete_warning') }}
    </p>
    <button data-bs-toggle="modal" data-bs-target="#exampleModal"
        class="main-btn danger-btn btn-hover btn-sm rounded-full">{{ 'Delete Account' }}</button>

    <x-modal-center :success_btn="'Delete'" :id="'exampleModal'" :modal_title="__('auth.security_check')" :method="'POST'" :methodSecond="'delete'"
        :action="route('admin.profile.destroy')">

        <h4 class="text-lg mb-3 font-medium text-gray-900 dark:text-gray-100">
            {{ __('auth.are_you_sure_you_want_to_delete_your_account') }}
        </h4>

        <div class="mt-6 my-1">
            <x-input-group :type="'password'" :placeholder="__('auth.enter_password')" :id="'password'" :name="'password'" :required="'required'">
                <i class="lni lni-lock"></i>
            </x-input-group>
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>
    </x-modal-center>
</section>
