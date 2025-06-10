 <form method="post" action="{{ route('admin.users.update', $user->username) }}" class="mt-6 space-y-6">
     @csrf
     @method('patch')
     <div class="row">
        {{-- <div class="col-md-6 my-1">
            <x-input-group :type="'text'" :placeholder="__('auth.full_name')" :id="'name'" :name="'name'" :value="old('name', $user->name)"
                :autocomplete="'name'">
                <i class="lni lni-user"></i>
            </x-input-group>
            @error('name')
                <div class="text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div> --}}
        <div class="col-md-6 my-2">
            <label for="fname" class="mb-1"><strong>{{ __('app.first_name') }}</strong></label>
            <x-input-group :type="'text'" :value="old('fname', $user->fname)" :name="'fname'" :placeholder="__('app.first_name')"
                :id="'fname'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
            @error('fname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="col-md-6 my-2">
            <label for="lname" class="mb-1"><strong>{{ __('app.last_name') }}</strong></label>
            <x-input-group :type="'text'" :value="old('lname', $user->lname)" :name="'lname'" :placeholder="__('app.last_name')"
                :id="'lname'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
            @error('lname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
         <div class="col-md-6 my-1">
            <label for="fname" class="mb-1"><strong>{{ __('auth.email') }}</strong></label>
             <x-input-group :type="'email'" :placeholder="__('auth.email_address')" :id="'email'" :name="'email'" :value="old('email', $user->email)"
                 :autocomplete="'email'">
                 <i class="lni lni-envelope"></i>
             </x-input-group>
             @error('email')
                 <div class="text-danger">
                     {{ $message }}
                 </div>
             @enderror
         </div>
         <div class="col-md-6 my-2">
            <label for="password" class="mb-1"><strong>{{ __('app.password') }}</strong></label>
             <div class="input-style-1">
                <input type="password" placeholder="{{ __('auth.password') }}" name="password" id="password" autocomplete="password"
                    value="{{ old('password') }}" />
                <span class="mdi mdi-eye fs-5 toggle-password cursor-pointer" toggle="#password"
                    style="position: absolute; top: 50%; left: 95%; transform: translateY(-50%);"></span>
                @error('password')
                <span class="text-sm text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>
         </div>
         <div class="col-md-6 my-2">
             <label for="password_confirmation"class="mb-1"><strong>{{ __('passwords.confirm_password') }}</strong></label>

             <div class="input-style-1">
                <input type="password" placeholder="{{ __('app.confirm_password') }}" name="password_confirmation" id="password_confirmation" autocomplete="password_confirmation"
                    value="{{ old('password_confirmation') }}" />
                <span class="mdi mdi-eye fs-5 toggle-password_confirmation cursor-pointer" toggle="#password_confirmation"
                    style="position: absolute; top: 50%; left: 95%; transform: translateY(-50%);"></span>
                @error('password_confirmation')
                <span class="text-sm text-danger" role="alert">
                    {{ $message }}
                </span>
                @enderror
            </div>

         </div>

         <div class="col-md-6 my-2">

             <x-input-select :label="__('app.select_role')" :name="'role'" :id="'role'">
                 <option value="">{{ __('app.select_role') }}</option>
                 @foreach ($roles as $role)
                     <option value="{{ $role->name }}" @selected(old('role', empty($user->roles()->pluck('name')[0]) ? '' : $user->roles()->pluck('name')[0]) == $role->name)>
                         {{ $role->name }}
                     </option>
                 @endforeach

             </x-input-select>

             @error('role')
                 <span class="text-danger">{{ $message }}</span>
             @enderror
         </div>
         <div class="col-md-12 my-2">
            <label for="image" class="mb-1"><strong>{{ __('app.change_image') }}</strong></label>
            <div class="image-wrapper border-red-500 cursor-pointer">
                <label for="image_input">
                    <input type="hidden" name="image" id="image" value="{{ old('image') }}">
                    <input class="d-none image-crop" type="file" accept="image/*" name="image_input" id="image_input">
                    <img id="image-preview" class="img-fluid cursor-pointer" src="{{ asset($user->image) }}"
                        alt="preview_img" />
                </label>
            </div>
            <div class="d-flex gap-2 mt-2">
                <button type="button" class="main-btn primary-btn btn-hover btn-sm" id="change_image">
                    <span class="mdi mdi-file-image"></span>
                    {{ __('app.change_image') }}
                </button>
                <button type="button" class="main-btn danger-btn btn-hover btn-sm" id="reset_image">
                    <span class="mdi mdi-refresh"></span>
                    {{ __('app.reset') }}
                </button>
            </div>
            @error('image')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
         <div class="col-md-6 my-2 d-flex align-items-center">
             @if ($user->status == 'ACTIVE')
                 <x-success-checkbox :id="'status'" :value="'ACTIVE'" :name="'status'" :checked="'status'">
                     {{ __('app.status') }}
                 </x-success-checkbox>
             @else
                 <x-success-checkbox :id="'status'" :value="'ACTIVE'" :name="'status'">
                     {{ __('app.status') }}
                 </x-success-checkbox>
             @endif
             @error('status')
                 <span class="text-danger">{{ $message }}</span>
             @enderror
         </div>
         <div class="col-md-12 my-1">
             <x-primary-button :type="'submit'">
                 <span class="mdi mdi-content-save-settings"></span>
                 {{ __('app.save') }}
             </x-primary-button>
         </div>
     </div>
 </form>
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
</script>
