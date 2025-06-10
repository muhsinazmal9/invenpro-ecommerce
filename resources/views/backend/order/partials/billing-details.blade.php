<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <label for="billing_customer_name"
                class="pb-1">{{ __('app.customer_name') }} <span
                    class="text-danger">*</span></label>
            <x-input-group :type="'text'" :value="old('billing_customer_name')" :name="'billing_customer_name'"
                :placeholder="__('app.customer_name')" :id="'billing_customer_name'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-12 mt-4">
            <label for="billing_email" class="pb-1">{{ __('app.email') }} <span
                    class="text-danger">*</span></label>
            <x-input-group :type="'email'" :value="old('billing_email')" :name="'billing_email'"
                :placeholder="__('app.email')" :id="'billing_email'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-12 mt-4">
            <label for="billing_phone" class="pb-1">{{ __('app.phone') }} <span
                    class="text-danger">*</span></label>
            <x-input-group :type="'tel'" :value="old('billing_phone')" :name="'billing_phone'"
                :placeholder="__('app.phone')" :id="'billing_phone'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-12 mt-4">
            <label for="billing_street_address"
                class="pb-1">{{ __('app.enter_street_address') }} <span
                    class="text-danger">*</span></label>
            <x-input-group :type="'text'" :value="old('billing_street_address')" :name="'billing_street_address'"
                :placeholder="__('app.enter_street_address')" :id="'billing_street_address'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-12 mt-4">
            <label for="billing_apt_or_floor"
                class="pb-1">{{ __('app.apt_floor_suite_etc') }}</label>
            <x-input-group :type="'text'" :value="old('billing_apt_or_floor')" :name="'billing_apt_or_floor'"
                :placeholder="__('app.apt_floor_suite_etc')" :id="'billing_apt_or_floor'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-4 mt-4">
            <label for="billing_zip_code"
                class="pb-1">{{ __('app.zip_code') }}</label>
            <x-input-group :type="'number'" :value="old('billing_zip_code')" :name="'billing_zip_code'"
                :placeholder="__('app.zip_code')" :id="'billing_zip_code'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <input type="hidden" name="billing_country" id="billing_country"
            value="{{ $country['name'] }}">
        <div class="col-md-4 mt-4">
            <label for="billing_state" class="pb-1">{{ __('app.select_state') }}
                <span class="text-danger">*</span></label>
            <x-input-select :value="old('billing_state')" :name="'billing_state'" :placeholder="__('app.select_state')"
                :id="'billing_state'">
                <option value="">{{ __('app.select_state') }}</option>
            </x-input-select>
        </div>
        <div class="col-md-4 mt-4">
            <label for="billing_city"
                class="pb-1">{{ __('app.select_city') }}</label>
            <x-input-select :value="old('billing_city')" :name="'billing_city'" :placeholder="__('app.select_city')"
                :id="'billing_city'">
                <option value="">{{ __('app.select_city') }}</option>
            </x-input-select>
        </div>
    </div>
</div>
