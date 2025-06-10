<div class="col-md-12 mb-3">
    <label for="delivery_instruction"
        class="mb-1"><strong>{{ 'Delivery Instruction' }}</strong></label>
    <x-textarea-group :placeholder="'Delivery Instruction'" :name="'delivery_instruction'"
        :id="'delivery_instruction'"></x-textarea-group>
</div>
<div class="col-md-12 d-flex align-items-center">
    <x-success-checkbox :id="'is_gift'" :value="'1'" :name="'is_gift'">
        {{ 'Make it a gift' }}
    </x-success-checkbox>
</div>
<div class="col-md-12 mt-2 d-none" id="gift_information">
    <div class="d-md-flex justify-content-between align-items-center mb-2">
        <label for="gift_personal_message">{{ 'Personal Message' }}</label>
        <x-success-checkbox :id="'is_gift_wrapping'" :value="'1'" :name="'is_gift_wrapping'">
            {{ 'Add gift wrapping for' . ' ' . getSetting(\App\Models\Settings::CURRENCY_SYMBOL) . getSetting('gift_wrapping_charge') }}
        </x-success-checkbox>
    </div>
    <x-textarea-group :placeholder="'Personal Message'" :name="'gift_personal_message'" :id="'gift_personal_message'"
        :class="'pb-4'">
    </x-textarea-group>
</div>
