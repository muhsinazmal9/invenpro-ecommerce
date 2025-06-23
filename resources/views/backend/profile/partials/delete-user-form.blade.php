<section class="space-y-6">
    <p class="mt-1 mb-2 text-sm text-gray-600 dark:text-gray-400">
        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
    </p>
    <button data-bs-toggle="modal" data-bs-target="#exampleModal"
        class="main-btn danger-btn btn-hover btn-sm rounded-full">Delete Account</button>

    <x-modal-center :success_btn="'Delete'" :id="'exampleModal'" :modal_title="'Security Check'" :method="'POST'" :methodSecond="'delete'"
        :action="route('admin.profile.destroy')">

        <h4 class="text-lg mb-3 font-medium text-gray-900 dark:text-gray-100">
            Are you sure you want to delete your account?
        </h4>

        <div class="mt-6 my-1">
            <x-input-group :type="'password'" :placeholder="'Enter password'" :id="'password'" :name="'password'" :required="'required'">
                <i class="lni lni-lock"></i>
            </x-input-group>
            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>
    </x-modal-center>
</section>
