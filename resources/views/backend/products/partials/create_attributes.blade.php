<div class="col-md-12 mx-auto">
    <h3 class="d-flex align-items-center">
        <span>Variant</span>
        <span class="add-field text-primary ms-1 cursor-pointer">
            <span class="mdi mdi-plus-circle"></span>
        </span>
    </h3>
    <hr>
</div>

<div class="col-md-12 my-2">
    <div class="multi-field-wrapper">
        <div class="multi-fields">
            {{-- Hidden Template for New Attribute --}}
            <div class="multi-field-template d-none" data-template="attribute">
                <div class="multi-field card mt-2">
                    <div class="row card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row align-items-center">
                                        <input type="hidden" name="attribute_wrapper[]" value="{{ uniqid() }}">

                                        {{-- Attribute Type --}}
                                        <div class="col-11 my-1">
                                            <x-input-select :name="'type_attr[]'" :class="'type'"
                                                label="Select Attribute">
                                                @foreach ($attributes as $attribute)
                                                    <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                                @endforeach
                                            </x-input-select>
                                        </div>
                                        {{-- Attribute Delete Button --}}
                                        <div class="col-1 my-1">
                                            <div class="col-md-1 input-group-append remove-field">
                                                <span class="mt-4 py-3 d-flex justify-content-center text-danger"
                                                    style="cursor:pointer">
                                                    <i class="fas fa-minus-circle"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    {{-- Attribute Items Template --}}
                                    <div class="attribute-items-template" data-template="attribute-item">
                                        <div class="row attribute-items align-items-center">
                                            <div class="col my-1">
                                                <span class="text-danger remove-item-field" style="cursor:pointer" >
                                                    <i class="mdi mdi-close-circle"></i>
                                                </span>
                                                <label class="mb-1"><strong>Value</strong></label>
                                                <x-input-group type="text" :name="'item_name_attr_{{ uniqid() }}[]'" style="padding:10px"
                                                    placeholder="Enter value" class="item_name_attr">
                                                </x-input-group>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    {{-- Add Attribute Items Button --}}
                                    {{-- <div class="row mt-1">
                                        <div class="col-md-12"> --}}
                                            <button type="button"
                                                class="add-attr-items btn btn-primary cursor-pointer">
                                                Add Value
                                                <span class="mdi mdi-plus-circle"></span>
                                            </button>
                                        {{-- </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Existing Attributes --}}
            @foreach (old('name_attr', []) as $key => $old_name_attr)
                <div class="multi-field card mt-2">
                    <div class="row card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="row align-items-center">
                                    <input type="hidden" name="attribute_wrapper[]" value="{{ $key }}">
                                    {{-- Attribute Name --}}
                                    <div class="col-6 my-1">
                                        <label class="mb-1"><strong>Name</strong></label>
                                        <x-input-group type="text" name="name_attr[]"
                                            placeholder="Enter attribute name" class="name_attr"
                                            value="{{ $old_name_attr }}">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>
                                    </div>
                                    {{-- Attribute Type --}}
                                    <div class="col-5 my-1">
                                        <x-input-select name="type_attr[]" class="type" label="Select Type">
                                            <option value="SIZE" @selected(old('type_attr')[$key] == 'SIZE')>Size</option>
                                            <option value="COLOR" @selected(old('type_attr')[$key] == 'COLOR')>Color</option>
                                            <option value="UNIT" @selected(old('type_attr')[$key] == 'UNIT')>Unit</option>
                                            <option value="CUSTOM" @selected(old('type_attr')[$key] == 'CUSTOM')>Custom</option>
                                        </x-input-select>
                                    </div>
                                    {{-- Attribute Delete Button --}}
                                    <div class="col-1 my-1">
                                        <div class="col-md-1 input-group-append remove-field">
                                            <span class="mt-4 py-3 d-flex justify-content-center text-danger"
                                                style="cursor:pointer">
                                                <i class="fas fa-minus-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                {{-- Attribute Items --}}
                                @foreach (old('item_name_attr_' . $key, []) as $index => $item)
                                    <div class="row attribute-items align-items-center">
                                        <div class="col-md-11">
                                            <div class="row">
                                                {{-- Item Name --}}
                                                <div class="col my-1">
                                                    <label class="mb-1"><strong>Item</strong></label>
                                                    <x-input-group type="text"
                                                        name="item_name_attr_{{ $key }}[]"
                                                        value="{{ $item }}" style="padding:10px"
                                                        placeholder="Enter name" class="item_name_attr"></x-input-group>
                                                </div>
                                                {{-- Item Price --}}
                                                <div class="col my-1">
                                                    <label class="mb-1"><strong>Price Adjustment</strong></label>
                                                    <x-input-group type="number" step="any"
                                                        value="{{ old('price_adjustment_attr_' . $key)[$index] ?? '' }}"
                                                        style="padding:10px"
                                                        name="price_adjustment_attr_{{ $key }}[]"
                                                        placeholder="Enter price"
                                                        class="price_adjustment_attr"></x-input-group>
                                                </div>
                                                {{-- Item Code --}}
                                                <div class="col my-1">
                                                    <label class="mb-1"><strong>Code</strong></label>
                                                    <x-input-group type="text" style="padding:10px"
                                                        value="{{ old('code_attr_' . $key)[$index] ?? '' }}"
                                                        name="code_attr_{{ $key }}[]"
                                                        placeholder="Enter code" class="codesAttr"></x-input-group>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Item Delete --}}
                                        <div class="col-md-1">
                                            <div class="col-md-1 remove-item-field">
                                                <span class="mt-4 py-3 d-flex justify-content-center text-danger"
                                                    style="cursor:pointer">
                                                    <i class="fas fa-minus-circle"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- Add Attribute Items Button --}}
                                <div class="row mt-1">
                                    <div class="col-md-12">
                                        <button type="button"
                                            class="add-attr-items btn btn-primary ms-1 cursor-pointer">
                                            <span class="mdi mdi-plus-circle"></span>
                                        </button>
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



<script>
    $(document).ready(function () {
        const $wrapper = $('.multi-fields');

        // Helper: Generate unique name for attribute group
        const generateWrapperNo = () => Date.now();

        // Helper: Update dynamic input names inside a cloned item group
        function updateInputNames($container, wrapperNo) {
            $container.find('[name^="item_name_attr_"]').attr('name', `item_name_attr_${wrapperNo}[]`);
            $container.find('[name^="price_adjustment_attr_"]').attr('name', `price_adjustment_attr_${wrapperNo}[]`);
            $container.find('[name^="code_attr_"]').attr('name', `code_attr_${wrapperNo}[]`);
        }

        // Add new attribute block
        function addAttributeField() {
            const wrapperNo = generateWrapperNo();
            const $template = $('.multi-field-template')
                .clone()
                .removeClass('d-none multi-field-template')
                .attr('data-wrapper-no', wrapperNo);

            $template.find('input[name="attribute_wrapper[]"]').val(wrapperNo);
            updateInputNames($template, wrapperNo);
            $wrapper.append($template);
        }

        // Add new item under a specific attribute
        function addAttributeItem($btn) {
            const $multiField = $btn.closest('.multi-field');
            const wrapperNo = $multiField.find('input[name="attribute_wrapper[]"]').val();
            const $lastItemInput = $multiField.find('.item_name_attr').last();

            if (!$lastItemInput.val()) {
                alert('Please fill the last item name');
                return;
            }

            const $itemTemplate = $multiField.find('.attribute-items-template .attribute-items').first().clone();
            $itemTemplate.find('input').val('');
            updateInputNames($itemTemplate, wrapperNo);

            $multiField.find('.attribute-items').last().after($itemTemplate);
        }

        // Remove attribute block
        function removeAttributeField($btn) {
            $btn.closest('.multi-field').remove();
        }

        // Remove item inside attribute, ensure at least one remains
        function removeAttributeItem($btn) {
            const $multiField = $btn.closest('.multi-field');
            const $items = $multiField.find('.row.attribute-items');
            if ($items.length > 1) {
                $btn.closest('.row.attribute-items').remove();
            } else {
                alert('You cannot remove this item. At least one item is required.');
            }
        }

        // Event: Add attribute
        $('.add-field').on('click', function () {
            addAttributeField();
        });

        // Delegated Events:
        $wrapper.on('click', '.add-attr-items', function () {
            addAttributeItem($(this));
        });

        $wrapper.on('click', '.remove-field', function () {
            removeAttributeField($(this));
        });

        $wrapper.on('click', '.remove-item-field', function (e) {
            e.preventDefault();
            e.stopPropagation();
            removeAttributeItem($(this));
        });
    });
</script>
