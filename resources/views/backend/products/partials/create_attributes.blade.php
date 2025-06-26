<div class="col-md-12 mx-auto">
    <h3 class="d-flex align-items-center justify-content-between">
        <span>Variant</span>
        <span class="add-field text-primary ms-1 cursor-pointer fs-6" data-bs-toggle="modal" data-bs-target="#addVariantModal">
            <span class="mdi mdi-plus"></span>
            Add Variant
        </span>
    </h3>
    <hr>
</div>

<!-- Add Variant Modal -->
<div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVariantModalLabel">Add New Variant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Select or Create Attribute</strong></label>
                    <select name="attribute_id" class="form-select attribute-select" data-create="attribute">
                        <option value="">Select Attribute</option>
                        @foreach ($attributes as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                        @endforeach
                        <option value="create_new">Create New Attribute</option>
                    </select>
                    <input type="text" class="form-control mt-2 attribute-name-input d-none" placeholder="Enter new attribute name">
                </div>
                <div class="mb-3 attribute-values-section">
                    <label class="form-label"><strong>Attribute Values</strong></label>
                    <select name="attribute_values[]" class="form-select attribute-values" multiple data-create="value">
                        <option value="">Select Values</option>
                    </select>
                    <input type="text" class="form-control mt-2 attribute-value-input d-none" placeholder="Enter new value">
                    <button type="button" class="btn btn-primary mt-2 add-value-btn">Add New Value</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary save-variant">Save Variant</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Variant Modal -->
<div class="modal fade" id="editVariantModal" tabindex="-1" aria-labelledby="editVariantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVariantModalLabel">Edit Variant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="edit-wrapper-no">
                <div class="mb-3">
                    <label class="form-label"><strong>Attribute</strong></label>
                    <select name="edit_attribute_id" class="form-select attribute-select" data-create="attribute">
                        <option value="">Select Attribute</option>
                        @foreach ($attributes as $attribute)
                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                        @endforeach
                        <option value="create_new">Create New Attribute</option>
                    </select>
                    <input type="text" class="form-control mt-2 attribute-name-input d-none" placeholder="Enter new attribute name">
                </div>
                <div class="mb-3 attribute-values-section">
                    <label class="form-label"><strong>Attribute Values</strong></label>
                    <select name="edit_attribute_values[]" class="form-select attribute-values" multiple data-create="value">
                        <option value="">Select Values</option>
                    </select>
                    <input type="text" class="form-control mt-2 attribute-value-input d-none" placeholder="Enter new value">
                    <button type="button" class="btn btn-primary mt-2 add-value-btn">Add New Value</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary update-variant">Update Variant</button>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12 my-2">
    <div class="multi-field-wrapper">
        <div class="multi-fields">
            <!-- Hidden Template for New Attribute -->
            <div class="multi-field-template d-none" data-template="attribute">
                <div class="multi-field card mt-2">
                    <div class="row card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <input type="hidden" name="attribute_wrapper[]" value="">
                                        <input type="hidden" name="attribute_id[]">

                                        <!-- Attribute Name -->
                                        <div class="col-10 my-1">
                                            <label class="mb-1"><strong>Attribute</strong></label>
                                            <input type="text" name="name_attr[]" class="form-control name_attr" readonly>
                                        </div>
                                        <!-- Attribute Edit/Delete Buttons -->
                                        <div class="col-2 my-1">
                                            <div class="d-flex justify-content-end">
                                                <span class="edit-field text-primary mx-2 cursor-pointer" data-bs-toggle="modal" data-bs-target="#editVariantModal">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                                <span class="remove-field text-danger cursor-pointer">
                                                    <i class="fas fa-minus-circle"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Attribute Items -->
                                    <div class="attribute-items"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Existing Attributes -->
            @foreach (old('name_attr', []) as $key => $old_name_attr)
                <div class="multi-field card mt-2" data-wrapper-no="{{ $key }}">
                    <div class="row card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-10 my-1">
                                    <label class="mb-1"><strong>Attribute</strong></label>
                                    <input type="text" name="name_attr[]" class="form-control name_attr" readonly>
                                </div>
                                <div class="col-2 my-1">
                                    <div class="d-flex justify-content-end">
                                        <span class="edit-field text-primary mx-2 cursor-pointer" data-bs-toggle="modal" data-bs-target="#editVariantModal">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="remove-field text-danger cursor-pointer">
                                            <i class="fas fa-minus-circle"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@push('script')
<script>
    $(document).ready(function () {
        const $wrapper = $('.multi-fields');

        // Helper: Generate unique wrapper number
        const generateWrapperNo = () => Date.now();

        // Fetch attribute values via AJAX (mock function, implement as needed)
        function getAttributeValues(attributeId) {
            // This should be an AJAX call to your backend
            // Mock data for demonstration
            const $attributes = {!! json_encode($attributes) !!};
            console.log($attributes);
            const values = attributeId ? $attributes.find(attr => attr.id == attributeId)?.attribute_values || [] : [];
            return values.map(value => ({ id: value.id, name: value.name }));
        }

        // Helper: Populate values select
        function populateValues($select, values) {
            $select.find('option:not([value=""])').remove();
            values.forEach(value => {
                $select.append(`<option value="${value.id}">${value.name}</option>`);
            });
        }

        // Helper: Add new attribute block
        function addAttributeField(data) {
            const wrapperNo = generateWrapperNo();
            const $template = $('.multi-field-template')
                .clone()
                .removeClass('d-none multi-field-template')
                .attr('data-wrapper-no', wrapperNo);

            $template.find('input[name="attribute_wrapper[]"]').val(wrapperNo);
            $template.find('input[name="attribute_id[]"]').val(data.attribute_id);
            $template.find('.name_attr').val(data.attribute_name);

            const $items = $template.find('.attribute-items');
            $items.empty();
            data.values.forEach(value => {
                $items.append(`
                    <div class="row attribute-items align-items-center">
                        <div class="col-md-11 my-1">
                            <label class="mb-1"><strong>Value</strong></label>
                            <input type="text" name="item_name_attr_${wrapperNo}[]" value="${value.name}" class="form-control item_name_attr" readonly>
                        </div>
                        <div class="col-md-1 my-1">
                            <span class="remove-item-field text-danger cursor-pointer">
                                <i class="mdi mdi-close-circle"></i>
                            </span>
                        </div>
                    </div>
                `);
            });

            $wrapper.append($template);
            $('#addVariantModal').modal('hide');
        }

        // Add new variant modal handling
        $('.add-field').on('click', function () {
            const $modal = $('#addVariantModal');
            $modal.find('.attribute-select').val('');
            $modal.find('.attribute-name-input').addClass('d-none').val('');
            $modal.find('.attribute-values').find('option:not([value=""])').remove();
            $modal.find('.attribute-value-input').addClass('d-none').val('');
        });

        // Attribute select change
        $('.attribute-select').on('change', function () {
            const $modal = $(this).closest('.modal');
            const $nameInput = $modal.find('.attribute-name-input');
            const $valuesSelect = $modal.find('.attribute-values');
            const $valueInput = $modal.find('.attribute-value-input');

            if ($(this).val() === 'create_new') {
                $nameInput.removeClass('d-none').focus();
                $valuesSelect.find('option:not([value=""])').remove();
                $valueInput.removeClass('d-none');
            } else {
                $nameInput.addClass('d-none').val('');
                $valueInput.addClass('d-none').val('');
                const values = getAttributeValues($(this).val());
                populateValues($valuesSelect, values);
            }
        });

        // Add new value button
        $('.add-value-btn').on('click', function () {
            const $modal = $(this).closest('.modal');
            const $valueInput = $modal.find('.attribute-value-input');
            const $valuesSelect = $modal.find('.attribute-values');
            const value = $valueInput.val().trim();

            if (value) {
                $valuesSelect.append(`<option value="new_${Date.now()}">${value}</option>`);
                $valueInput.val('');
                $valuesSelect.val($valuesSelect.val() || []).push(`new_${Date.now()}`);
            }
        });

        // Save variant
        $('.save-variant').on('click', function () {
            const $modal = $(this).closest('.modal');
            const attributeId = $modal.find('.attribute-select').val();
            const attributeName = attributeId === 'create_new' ? $modal.find('.attribute-name-input').val() : 
                $modal.find('.attribute-select option:selected').text();
            const values = $modal.find('.attribute-values option:selected').map(function() {
                return { id: this.value, name: this.text };
            }).get();

            if (!attributeId || !values.length) {
                alert('Please select an attribute and at least one value');
                return;
            }

            addAttributeField({
                attribute_id: attributeId === 'create_new' ? `new_${Date.now()}` : attributeId,
                attribute_name: attributeName,
                values: values
            });
        });

        // Edit variant
        $wrapper.on('click', '.edit-field', function () {
            const $multiField = $(this).closest('.multi-field');
            const wrapperNo = $multiField.attr('data-wrapper-no');
            const attributeId = $multiField.find('input[name="attribute_id[]"]').val();
            const attributeName = $multiField.find('.name_attr').val();
            const values = $multiField.find('.item_name_attr').map(function() {
                return { id: $(this).attr('name').match(/\d+/)[0], name: $(this).val() };
            }).get();

            const $modal = $('#editVariantModal');
            $modal.find('.edit-wrapper-no').val(wrapperNo);
            $modal.find('.attribute-select').val(attributeId);
            $modal.find('.attribute-name-input').val(attributeId.startsWith('new_') ? attributeName : '').toggleClass('d-none', !attributeId.startsWith('new_'));
            const $valuesSelect = $modal.find('.attribute-values');
            populateValues($valuesSelect, values);
            $valuesSelect.val(values.map(v => v.id));
        });

        // Update variant
        $('.update-variant').on('click', function () {
            const $modal = $(this).closest('.modal');
            const wrapperNo = $modal.find('.edit-wrapper-no').val();
            const attributeId = $modal.find('.attribute-select').val();
            const attributeName = attributeId === 'create_new' ? $modal.find('.attribute-name-input').val() : 
                $modal.find('.attribute-select option:selected').text();
            const values = $modal.find('.attribute-values option:selected').map(function() {
                return { id: this.value, name: this.text };
            }).get();

            if (!attributeId || !values.length) {
                alert('Please select an attribute and at least one value');
                return;
            }

            const $multiField = $wrapper.find(`.multi-field[data-wrapper-no="${wrapperNo}"]`);
            $multiField.find('input[name="attribute_id[]"]').val(attributeId);
            $multiField.find('.name_attr').val(attributeName);
            const $items = $multiField.find('.attribute-items');
            $items.empty();
            values.forEach(value => {
                $items.append(`
                    <div class="row attribute-items align-items-center">
                        <div class="col-md-11 my-1">
                            <label class="mb-1"><strong>Value</strong></label>
                            <input type="text" name="item_name_attr_${wrapperNo}[]" value="${value.name}" class="form-control item_name_attr" readonly>
                        </div>
                        <div class="col-md-1 my-1">
                            <span class="remove-item-field text-danger cursor-pointer">
                                <i class="mdi mdi-close-circle"></i>
                            </span>
                        </div>
                    </div>
                `);
            });

            $('#editVariantModal').modal('hide');
        });

        // Remove attribute block
        $wrapper.on('click', '.remove-field', function () {
            $(this).closest('.multi-field').remove();
        });

        // Remove item inside attribute
        $wrapper.on('click', '.remove-item-field', function (e) {
            e.preventDefault();
            e.stopPropagation();
            const $multiField = $(this).closest('.multi-field');
            const $items = $multiField.find('.row.attribute-items');
            if ($items.length > 1) {
                $(this).closest('.row.attribute-items').remove();
            } else {
                alert('You cannot remove this item. At least one item is required.');
            }
        });
    });
</script>
@endpush
