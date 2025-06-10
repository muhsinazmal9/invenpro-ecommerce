<div class="col-md-12 mb-3">
    <label for="delivery_instruction"
        class="mb-1"><strong>{{ __('app.delivery_instruction') }}</strong></label>
    <x-textarea-group :placeholder="__('app.delivery_instruction')" :name="'delivery_instruction'"
        :id="'delivery_instruction'"></x-textarea-group>
</div>
<div class="col-md-12 d-flex align-items-center">
    <x-success-checkbox :id="'is_gift'" :value="'1'" :name="'is_gift'">
        {{ __('app.make_it_a_gift') }}
    </x-success-checkbox>
</div>
<div class="col-md-12 mt-2 d-none" id="gift_information">
    <div class="d-md-flex justify-content-between align-items-center mb-2">
        <label for="gift_personal_message">{{ __('app.personal_message') }}</label>
        <x-success-checkbox :id="'is_gift_wrapping'" :value="'1'" :name="'is_gift_wrapping'">
            {{ __('app.add_gift_wrapping_for') . ' ' . getSetting(\App\Models\Settings::CURRENCY_SYMBOL) . getSetting('gift_wrapping_charge') }}
        </x-success-checkbox>
    </div>
    <x-textarea-group :placeholder="__('app.personal_message')" :name="'gift_personal_message'" :id="'gift_personal_message'"
        :class="'pb-4'">
    </x-textarea-group>
</div>
