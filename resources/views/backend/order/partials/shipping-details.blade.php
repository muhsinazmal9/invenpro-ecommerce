<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <x-success-checkbox :value="old('same_as_billing_address')" :checked="true" :name="'same_as_billing_address'" :id="'same_as_billing_address'"
                :data_bs_toggle="'tooltip'" :data_bs_placement="'top'" :title="__('app.same_as_billing_address_tooltip')">
                {{ __('app.same_as_billing_address') }}
            </x-success-checkbox>
        </div>
        <div id="shipping_details" class="row">
            <div class="col-md-12 mt-4">
                <label for="shipping_customer_name" class="pb-1">{{ __('app.customer_name') }} <span
                        class="text-danger">*</span></label>
                <x-input-group :type="'text'" :value="old('shipping_customer_name')" :name="'shipping_customer_name'" :placeholder="__('app.customer_name')"
                    :id="'shipping_customer_name'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>
            </div>
            <div class="col-md-12 mt-4">
                <label for="shipping_email" class="pb-1">{{ __('app.email') }} <span
                        class="text-danger">*</span></label>
                <x-input-group :type="'email'" :value="old('shipping_email')" :name="'shipping_email'" :placeholder="__('app.email')"
                    :id="'shipping_email'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>

            </div>
            <div class="col-md-12 mt-4">
                <label for="shipping_phone" class="pb-1">{{ __('app.phone') }} <span
                        class="text-danger">*</span></label>
                <x-input-group :type="'tel'" :value="old('shipping_phone')" :name="'shipping_phone'" :placeholder="__('app.phone')"
                    :id="'shipping_phone'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>

            </div>
            <div class="col-md-12 mt-4">
                <label for="shipping_street_address" class="pb-1">{{ __('app.enter_street_address') }} <span
                        class="text-danger">*</span></label>
                <x-input-group :type="'text'" :value="old('shipping_street_address')" :name="'shipping_street_address'" :placeholder="__('app.enter_street_address')"
                    :id="'shipping_street_address'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>
            </div>
            <div class="col-md-12 mt-4">
                <label for="shipping_apt_or_floor" class="pb-1">{{ __('app.apt_floor_suite_etc') }}</label>
                <x-input-group :type="'text'" :value="old('shipping_apt_or_floor')" :name="'shipping_apt_or_floor'" :placeholder="__('app.apt_floor_suite_etc')"
                    :id="'shipping_apt_or_floor'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>
            </div>
            <div class="col-md-4 mt-4">
                <label for="shipping_zip_code" class="pb-1">{{ __('app.zip_code') }}</label>
                <x-input-group :type="'number'" :value="old('shipping_zip_code')" :name="'shipping_zip_code'" :placeholder="__('app.zip_code')"
                    :id="'shipping_zip_code'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>
            </div>

            <input type="hidden" name="shipping_country" id="shipping_country" value="{{ $country['name'] }}">

            <div class="col-md-4 mt-4">
                <label for="shipping_state" class="pb-1">{{ __('app.select_state') }}
                    <span class="text-danger">*</span></label>
                <x-input-select :value="old('shipping_state')" :name="'shipping_state'" :placeholder="__('app.select_state')" :id="'shipping_state'">
                    <option value="">{{ __('app.select_state') }}</option>
                </x-input-select>
            </div>
            <div class="col-md-4 mt-4">
                <label for="shipping_city" class="pb-1">{{ __('app.select_city') }}</label>
                <x-input-select :value="old('shipping_city')" :name="'shipping_city'" :placeholder="__('app.select_city')" :id="'shipping_city'">
                    <option value="">{{ __('app.select_city') }}</option>
                </x-input-select>
            </div>


        </div>

    </div>
</div>
