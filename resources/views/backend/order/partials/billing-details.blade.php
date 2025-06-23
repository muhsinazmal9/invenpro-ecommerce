<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <label for="billing_customer_name"
                class="pb-1">Customer Name <span
                    class="text-danger">*</span></label>
            <x-input-group :type="'text'" :value="old('billing_customer_name')" :name="'billing_customer_name'"
                :placeholder="'Customer Name'" :id="'billing_customer_name'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-12 mt-4">
            <label for="billing_email" class="pb-1">Email <span
                    class="text-danger">*</span></label>
            <x-input-group :type="'email'" :value="old('billing_email')" :name="'billing_email'"
                :placeholder="'Email'" :id="'billing_email'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-12 mt-4">
            <label for="billing_phone" class="pb-1">Phone <span
                    class="text-danger">*</span></label>
            <x-input-group :type="'tel'" :value="old('billing_phone')" :name="'billing_phone'"
                :placeholder="'Phone'" :id="'billing_phone'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-12 mt-4">
            <label for="billing_street_address"
                class="pb-1">Enter street address <span
                    class="text-danger">*</span></label>
            <x-input-group :type="'text'" :value="old('billing_street_address')" :name="'billing_street_address'"
                :placeholder="'Enter street address'" :id="'billing_street_address'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-12 mt-4">
            <label for="billing_apt_or_floor"
                class="pb-1">Apt, Floor, Suite, etc.</label>
            <x-input-group :type="'text'" :value="old('billing_apt_or_floor')" :name="'billing_apt_or_floor'"
                :placeholder="'Apt, Floor, Suite, etc.'" :id="'billing_apt_or_floor'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <div class="col-md-4 mt-4">
            <label for="billing_zip_code"
                class="pb-1">Zip Code</label>
            <x-input-group :type="'number'" :value="old('billing_zip_code')" :name="'billing_zip_code'"
                :placeholder="'Zip Code'" :id="'billing_zip_code'">
                <span class="mdi mdi-shape"></span>
            </x-input-group>
        </div>
        <input type="hidden" name="billing_country" id="billing_country"
            value="{{ $country['name'] }}">
        <div class="col-md-4 mt-4">
            <label for="billing_state" class="pb-1">Select State
                <span class="text-danger">*</span></label>
            <x-input-select :value="old('billing_state')" :name="'billing_state'" :placeholder="'Select State'"
                :id="'billing_state'">
                <option value="">Select State</option>
            </x-input-select>
        </div>
        <div class="col-md-4 mt-4">
            <label for="billing_city"
                class="pb-1">Select City</label>
            <x-input-select :value="old('billing_city')" :name="'billing_city'" :placeholder="'Select City'"
                :id="'billing_city'">
                <option value="">Select City</option>
            </x-input-select>
        </div>
    </div>
</div>
