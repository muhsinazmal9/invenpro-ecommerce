<div class="col-md-12 mt-4">
    <h4 class="d-flex align-items-center">
        <span>{{ 'Custom Attributes' }}</span>
    </h4>
    <hr>
    <div id="custom-attributes-list">
        @php
            $attributes = old('custom_attributes', $product->customAttributes ?? []);
        @endphp
        @if (count($attributes) > 0)
            @foreach ($attributes as $index => $attribute)
                <div class="card mb-3 attribute-card" data-id="{{ $index + 1 }}">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <label for="attribute-key-{{ $index + 1 }}" class="mb-1"><strong>Key</strong></label>
                                <x-input-group 
                                    :type="'text'" 
                                    :name="'custom_attributes[' . ($index + 1) . '][key]'" 
                                    :placeholder="'Enter attribute key'" 
                                    :value="old('custom_attributes.' . $index . '.key', $attribute['key'] ?? '')">
                                    <span class="mdi mdi-shape"></span>
                                </x-input-group>
                            </div>
                            <div class="col-md-6">
                                <label for="attribute-value-{{ $index + 1 }}" class="mb-1"><strong>Value</strong></label>
                                <x-input-group 
                                    :type="'text'" 
                                    :name="'custom_attributes[' . ($index + 1) . '][value]'" 
                                    :placeholder="'Enter attribute value'" 
                                    :value="old('custom_attributes.' . $index . '.value', $attribute['value'] ?? '')">
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
        <span class="add-text">{{ count($attributes) > 0 ? 'Add Another Custom Attribute' : 'Add Custom Attribute' }}</span>
    </a>
</div>

<script>
$(document).ready(function() {
    let attributeCount = {{ count($attributes) }};

    // Handle Add Custom Attribute click
    $('.add-custom-attribute').on('click', function(e) {
        e.preventDefault();

        // const maxAttributes = 5;
        // if (attributeCount >= maxAttributes) {
        //     alert('Maximum of 5 custom attributes allowed.');
        //     return;
        // }

        attributeCount++;

        const attributeHtml = `
            <div class="card mb-3 attribute-card" data-id="${attributeCount}">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <label for="attribute-key-${attributeCount}" class="mb-1"><strong>Key</strong></label>
                            <x-input-group :type="'text'" :name="'custom_attributes[${attributeCount}][key]'" :placeholder="'Enter attribute key'">
                                <span class="mdi mdi-shape"></span>
                            </x-input-group>
                        </div>
                        <div class="col-md-6">
                            <label for="attribute-value-${attributeCount}" class="mb-1"><strong>Value</strong></label>
                            <x-input-group :type="'text'" :name="'custom_attributes[${attributeCount}][value]'" :placeholder="'Enter attribute value'">
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
        `;

        $('#custom-attributes-list').append(attributeHtml);

        // Update link text after adding first attribute
        if (attributeCount === 1) {
            $('.add-text').text('Add Another Custom Attribute');
        }

        // if (attributeCount >= maxAttributes) {
        //     $('.add-custom-attribute').hide();
        // }
    });

    // Handle Remove button click
    $(document).on('click', '.remove-attribute', function() {
        $(this).closest('.attribute-card').remove();
        attributeCount--;

        // Update link text when no attributes remain
        if (attributeCount === 0) {
            $('.add-text').text('Add Custom Attribute');
        }

        // Show add link if below maximum
        // if (attributeCount < maxAttributes) {
        //     $('.add-custom-attribute').show();
        // }
    });
});
</script>