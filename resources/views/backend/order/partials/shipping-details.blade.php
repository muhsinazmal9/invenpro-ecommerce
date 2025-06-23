<div class="col-md-12">
    <div class="row">
        <div class="col-md-12">
            <x-success-checkbox :value="old('same_as_billing_address')" :checked="true" :name="'same_as_billing_address'" :id="'same_as_billing_address'"
                :data_bs_toggle="'tooltip'" :data_bs_placement="'top'" :title="'Same as billing address (click to ship in a different address)'">
                Same As Billing Address
            </x-success-checkbox>
        </div>
        <div id="shipping_details" class="row">
            <div class="col-md-12 mt-4">
                <label for="shipping_customer_name" class="pb-1">Customer Name <span
                        class="text-danger">*</span></label>
                <x-input-group :type="'text'" :value="old('shipping_customer_name')" :name="'shipping_customer_name'" :placeholder="'Customer Name'"
                    :id="'shipping_customer_name'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>
            </div>
            <div class="col-md-12 mt-4">
                <label for="shipping_email" class="pb-1">Email <span
                        class="text-danger">*</span></label>
                <x-input-group :type="'email'" :value="old('shipping_email')" :name="'shipping_email'" :placeholder="'Email'"
                    :id="'shipping_email'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>

            </div>
            <div class="col-md-12 mt-4">
                <label for="shipping_phone" class="pb-1">Phone <span
                        class="text-danger">*</span></label>
                <x-input-group :type="'tel'" :value="old('shipping_phone')" :name="'shipping_phone'" :placeholder="'Phone'"
                    :id="'shipping_phone'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>

            </div>
            <div class="col-md-12 mt-4">
                <label for="shipping_street_address" class="pb-1">Enter street address <span
                        class="text-danger">*</span></label>
                <x-input-group :type="'text'" :value="old('shipping_street_address')" :name="'shipping_street_address'" :placeholder="'Enter street address'"
                    :id="'shipping_street_address'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>
            </div>
            <div class="col-md-12 mt-4">
                <label for="shipping_apt_or_floor" class="pb-1">Apt, Floor, Suite, etc.</label>
                <x-input-group :type="'text'" :value="old('shipping_apt_or_floor')" :name="'shipping_apt_or_floor'" :placeholder="'Apt, Floor, Suite, etc.'"
                    :id="'shipping_apt_or_floor'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>
            </div>
            <div class="col-md-4 mt-4">
                <label for="shipping_zip_code" class="pb-1">Zip Code</label>
                <x-input-group :type="'number'" :value="old('shipping_zip_code')" :name="'shipping_zip_code'" :placeholder="'Zip Code'"
                    :id="'shipping_zip_code'">
                    <span class="mdi mdi-shape"></span>
                </x-input-group>
            </div>

            <input type="hidden" name="shipping_country" id="shipping_country" value="{{ $country['name'] }}">

            <div class="col-md-4 mt-4">
                <label for="shipping_state" class="pb-1">Select State
                    <span class="text-danger">*</span></label>
                <x-input-select :value="old('shipping_state')" :name="'shipping_state'" :placeholder="'Select State'" :id="'shipping_state'">
                    <option value="">Select State</option>
                </x-input-select>
            </div>
            <div class="col-md-4 mt-4">
                <label for="shipping_city" class="pb-1">Select City</label>
                <x-input-select :value="old('shipping_city')" :name="'shipping_city'" :placeholder="'Select City'" :id="'shipping_city'">
                    <option value="">Select City</option>
                </x-input-select>
            </div>


        </div>

    </div>
</div>
