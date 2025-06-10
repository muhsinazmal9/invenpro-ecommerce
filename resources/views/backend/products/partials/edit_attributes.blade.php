<div class="col-md-12 mt-4 mx-auto">
    <h3 class="d-flex align-items-center ">
        <span>Attributes</span>
        <span class="add-field  text-primary ms-1 cursor-pointer">
            <span class="mdi mdi-plus-circle"></span>
        </span>
    </h3>
    <hr>
</div>
<div class="col-md-12 my-2">
    <div class="multi-field-wrapper">
        <div class="multi-fields">
            {{-- Attributes Fields Start --}}

            @foreach ($product->attributes as $key => $attr)
                <div class="multi-field card mt-2">
                    <div class="row card-body">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="row align-items-center">
                                    <input type="hidden" name="attribute_wrapper[]" value="{{ $key }}">
                                    {{-- Attribute Name --}}
                                    <div class="col-6 my-1">
                                        <label class="mb-1"><strong>Name</strong></label>
                                        <x-input-group :type="'text'" :name="'name_attr[]'" :placeholder="'Enter attribute name'"
                                            :class="'name_attr'" :value="$attr->name">
                                            <span class="mdi mdi-shape"></span>
                                        </x-input-group>
                                    </div>

                                    {{-- Attribute Type --}}
                                    <div class="col-5 my-1">
                                        <x-input-select :name="'type_attr[]'" :class="'type'" : :label="'Select Type'">
                                            <option value="SIZE" @selected($attr->type == 'SIZE')>Size</option>
                                            <option value="COLOR" @selected($attr->type == 'COLOR')>Color</option>
                                            <option value="UNIT" @selected($attr->type == 'UNIT')>Unit</option>
                                            <option value="CUSTOM" @selected($attr->type == 'CUSTOM')>Custom</option>
                                        </x-input-select>
                                    </div>

                                    {{-- Attribute Delete Button --}}
                                    <div class="col-1 my-1">
                                        <div class="col-md-1 input-group-append remove-field">
                                            <span class="mt-4 py-3  d-flex justify-content-center text-danger"
                                                style="cursor:pointer">
                                                <i class=" fas fa-minus-circle"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Attribute Items --}}
                                @foreach ($attr->items as $index => $item)
                                    <div class="row attribute-items align-items-center">
                                        <div class="col-md-11">
                                            <div class="row">
                                                {{-- Item Name --}}
                                                <div class="col my-1">
                                                    <label class="mb-1"><strong>Item</strong></label>
                                                    <x-input-group :type="'text'" :name="'item_name_attr_' . $key . '[]'"
                                                        :value="$item->name" :style="'padding:10px'" :placeholder="'Enter name'"
                                                        :class="'item_name_attr'">
                                                    </x-input-group>
                                                </div>

                                                {{-- Item Price --}}
                                                <div class="col  my-1">
                                                    <label class="mb-1"><strong>Price Adustment</strong></label>
                                                    <x-input-group :type="'number'" :step="'any'"
                                                        :value="$item->price_adjustment" :style="'padding:10px'" :name="'price_adjustment_attr_' . $key . '[]'"
                                                        :placeholder="'Enter price'" :class="'price_adjustment_attr'">
                                                    </x-input-group>
                                                </div>
                                                {{-- Item Code --}}
                                                <div class="col  my-1">
                                                    <label class="mb-1"><strong>Code</strong></label>
                                                    <x-input-group :type="'text'" :style="'padding:10px'"
                                                        :value="$item->code" :name="'code_attr_' . $key . '[]'" :placeholder="'Enter code'"
                                                        :class="'codesAttr'">
                                                    </x-input-group>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- item delete --}}
                                        <div class='col-md-1'>
                                            <div class="col-md-1 input-group-append remove-item-field">
                                                <span class="mt-4 py-3  d-flex justify-content-center text-danger"
                                                    style="cursor:pointer">
                                                    <i class=" fas fa-minus-circle"></i>
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach



                                {{-- Add Attribute Items --}}
                                <div class="row mt-1">
                                    <div class="col-md-12">
                                        <button type="button"
                                            class="add-attr-items  btn btn-primary ms-1 cursor-pointer">
                                            <span class="mdi mdi-plus-circle"></span>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            @endforeach


            {{-- Attributes Fields End --}}
        </div>
    </div>
</div>



<script>
    // Attributes add and remove

    $(document).ready(function() {


        $('.multi-field-wrapper').each(function() {
            var $wrapper = $('.multi-fields', this)
            $('.add-field').click(function() {

                // wrapper no
                const wrapperNo = $('.multi-field').length;


                const buildHTML = `
                                        <div class="multi-field card mt-2">
                                            <div class="row card-body">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="row align-items-center">
                                                            <input type="hidden" name="attribute_wrapper[]" value="${wrapperNo}">
                                                            {{-- Attribute Name --}}
                                                            <div class="col-6 my-1">
                                                                <label class="mb-1"><strong>Name</strong></label>
                                                                <x-input-group :type="'text'"  :name="'name_attr[]'" :placeholder="'Enter attribute name'" :class="'name_attr'">
                                                                    <span class="mdi mdi-shape"></span>
                                                                </x-input-group>
                                                            </div>
                                                            
                                                            {{-- Attribute Type --}}
                                                            <div class="col-5 my-1">
                                                                <x-input-select :name="'type_attr[]'" :class="'type'" : :label="'Select Type'">
                                                                    <option value="SIZE">Size</option>
                                                                    <option value="COLOR">Color</option>
                                                                    <option value="UNIT">Unit</option>
                                                                    <option value="CUSTOM">Custom</option>
                                                                </x-input-select>
                                                            </div>

                                                            {{-- Attribute Delete Button --}}
                                                            <div class="col-1 my-1">
                                                                <div class="col-md-1 input-group-append remove-field">
                                                                    <span class="mt-4 py-3  d-flex justify-content-center text-danger" style="cursor:pointer">
                                                                        <i class=" fas fa-minus-circle"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Attribute Items --}}
                                                        <div class="row attribute-items align-items-center">
                                                            <div class="col-md-11">
                                                                <div class="row">
                                                                    {{-- Item Name --}}
                                                                    <div class="col my-1">
                                                                        <label class="mb-1"><strong>Item</strong></label>
                                                                        <x-input-group :type="'text'"  :name="'item_name_attr_${wrapperNo}[]'" :style="'padding:10px'" :placeholder="'Enter name'" :class="'item_name_attr'">
                                                                        </x-input-group>
                                                                    </div>

                                                                    {{-- Item Price --}}
                                                                    <div class="col  my-1">
                                                                        <label class="mb-1"><strong>Price Adustment</strong></label>
                                                                        <x-input-group :type="'number'" :step="'any'" :style="'padding:10px'"  :name="'price_adjustment_attr_${wrapperNo}[]'" :placeholder="'Enter price'" :class="'price_adjustment_attr'">
                                                                        </x-input-group>
                                                                    </div>
                                                                    {{-- Item Code --}}
                                                                    <div class="col  my-1">
                                                                        <label class="mb-1"><strong>Code</strong></label>
                                                                        <x-input-group :type="'text'"  :style="'padding:10px'"  :name="'code_attr_${wrapperNo}[]'" :placeholder="'Enter code'" :class="'codesAttr'">
                                                                        </x-input-group>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- item delete --}}
                                                            <div class='col-md-1'>
                                                                <div class="col-md-1 input-group-append remove-item-field">
                                                                    <span class="mt-4 py-3  d-flex justify-content-center text-danger" style="cursor:pointer">
                                                                        <i class=" fas fa-minus-circle"></i>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        {{-- Add Attribute Items --}}
                                                        <div class="row mt-1">
                                                            <div class="col-md-12">
                                                                <button type="button" class="add-attr-items  btn btn-primary ms-1 cursor-pointer">
                                                                    <span class="mdi mdi-plus-circle"></span>
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>`;
                $wrapper.append(buildHTML)

            });

            $(document).on('click', '.remove-field', function() {
                $(this).closest('.multi-field').remove();
            });


            // Remove Attribute 

            $(document).on('click', '.add-attr-items', function(e) {


                // if last item name is empty then do not add new item 
                const lasItemName = $(this).closest('.multi-field').find('.item_name_attr')
                    .last().val();
                if (lasItemName == '') {
                    alert('Please fill the last item name')
                    return;
                }


                const wrapperNo = $(this).closest('.multi-field').find(
                        'input[name="attribute_wrapper[]"]')
                    .val();

                let buildHTML = `
                            <div class="row attribute-items align-items-center">
                                <div class="col-md-11">
                                    <div class="row">
                                        {{-- Item Name --}}
                                        <div class="col  my-1">
                                            <label class="mb-1"><strong>Item</strong></label>
                                            <x-input-group :type="'text'"  :name="'item_name_attr_${wrapperNo}[]'" :style="'padding:10px'" :placeholder="'Enter name'" :class="'item_name_attr'">
                                            </x-input-group>
                                        </div>
                                        {{-- Item Price --}}
                                        <div class="col  my-1">
                                            <label class="mb-1"><strong>Price Adustment</strong></label>
                                            <x-input-group :type="'number'" :step="'any'" :style="'padding:10px'"  :name="'price_adjustment_attr_${wrapperNo}[]'" :placeholder="'Enter price'" :class="'price_adjustment_attr'">
                                            </x-input-group>
                                        </div>
                                        {{-- Item Code --}}
                                        <div class="col  my-1">
                                            <label class="mb-1"><strong>Code</strong></label>
                                            <x-input-group :type="'text'"  :style="'padding:10px'"  :name="'code_attr_${wrapperNo}[]'" :placeholder="'Enter code'" :class="'code_attr'">
                                            </x-input-group>
                                        </div>
                                    </div>
                                </div>
                                {{-- item delete --}}
                                <div class='col-md-1'>
                                    <div class="col-md-1 input-group-append remove-item-field">
                                        <span class="mt-4 py-3  d-flex justify-content-center text-danger" style="cursor:pointer">
                                            <i class=" fas fa-minus-circle"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>`;
                $(this).closest('.multi-field').find('.row.attribute-items').last().after(
                    buildHTML)
            })

            // Remove Attribute Items

            $(document).on('click', '.remove-item-field', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // remove item when there is more than one item
                if ($(this).closest('.multi-field').find('.row.attribute-items').length > 1) {
                    $(this).closest('.row.attribute-items').remove();
                } else {
                    alert('You can not remove this item, At least one item is required')
                }
            });
        });
    });
</script>
