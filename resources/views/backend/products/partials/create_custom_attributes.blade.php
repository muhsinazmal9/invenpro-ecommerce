<div class="col-md-12 mt-4">
    <h4 class="d-flex align-items-center">
        <span>Custom Attributes</span>
    </h4>
    <hr>
    <div id="custom-attributes-list">
        <!-- New attributes will be appended here -->
        @if (old('custom_attributes'))
            @foreach (old('custom_attributes') as $index => $attribute)
                <div class="card mb-3 attribute-card" data-id="{{ $index + 1 }}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <label for="attribute-key-{{ $index + 1 }}" class="mb-1"><strong>Key</strong></label>
                                <x-input-group 
                                    :type="'text'" 
                                    :name="'custom_attributes[' . ($index + 1) . '][key]'" 
                                    :placeholder="'Enter attribute key'" 
                                    :value="old('custom_attributes.' . $index . '.key')">
                                    <span class="mdi mdi-shape"></span>
                                </x-input-group>
                            </div>
                            <div class="col-md-6">
                                <label for="attribute-value-{{ $index + 1 }}" class="mb-1"><strong>Value</strong></label>
                                <x-input-group 
                                    :type="'text'" 
                                    :name="'custom_attributes[' . ($index + 1) . '][value]'" 
                                    :placeholder="'Enter attribute value'" 
                                    :value="old('custom_attributes.' . $index . '.value')">
                                    <span class="mdi mdi-shape"></span>
                                </x-input-group>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger remove-attribute">
                                    <span class="mdi mdi-close"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <a class="add-custom-attribute" href="#"> 
        <span class="mdi mdi-plus-circle me-1"></span>
        <span class="add-text">{{ old('custom_attributes') ? 'Add Another Custom Attribute' : 'Add Custom Attribute' }}</span>
    </a>
</div>

<template id="custom-attribute-template">
    <div class="card mb-3 attribute-card" data-id="__INDEX__">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <label class="mb-1"><strong>Key</strong></label>
                    <x-input-group :type="'text'" :name="'custom_attributes[__INDEX__][key]'" :placeholder="'Enter attribute key'">
                        <span class="mdi mdi-shape"></span>
                    </x-input-group>
                </div>
                <div class="col-md-6">
                    <label class="mb-1"><strong>Value</strong></label>
                    <x-input-group :type="'text'" :name="'custom_attributes[__INDEX__][value]'" :placeholder="'Enter attribute value'">
                        <span class="mdi mdi-shape"></span>
                    </x-input-group>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger remove-attribute">
                        <span class="mdi mdi-close"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
$(document).ready(function() {
    let attributeCount = {{ old('custom_attributes') ? count(old('custom_attributes')) : 0 }};

    // Handle Add Custom Attribute click
    const template = $('#custom-attribute-template').html();

    $('.add-custom-attribute').on('click', function(e) {
        e.preventDefault();
        attributeCount++;
        const html = template.replace(/__INDEX__/g, attributeCount);
        $('#custom-attributes-list').append(html);
    });
    // Handle Remove button click
    $(document).on('click', '.remove-attribute', function() {
        $(this).closest('.attribute-card').remove();
        attributeCount--;

        // Update link text when no attributes remain
        if (attributeCount === 0) {
            $('.add-text').text('Add Custom Attribute');
        }

        // if (attributeCount < maxAttributes) {
        //     $('.add-custom-attribute').show();
        // }
    });
});
</script>