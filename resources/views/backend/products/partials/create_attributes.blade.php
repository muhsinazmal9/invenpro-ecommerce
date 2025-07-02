<div class="d-flex align-items-center gap-3">
    <h3>Variant</h3>
    <div class="form-check form-switch toggle-switch">
        <input class="form-check-input" type="checkbox" name="enable_variant" id="enableVariantProduct">
    </div>
</div>
<div id="sortableSummaryContainer" class="mt-3"></div>
<div id="variantAttributeContainer" class="mt-3"></div>

<div class="d-flex">
    <a href="javascript:void(0);" class="main-btn light-btn-outline btn-hover btn-sm mt-2 d-none" id="addAttributeBtn">
        <i class="mdi mdi-plus"></i> Add Attribute
    </a>
</div>


<div class="true-variants mt-3 d-none">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-wrapper table-responsive">
                        <table class="table striped-table">
                            <thead>
                                <tr>
                                    <th>
                                        <h6>SKU</h6>
                                    </th>
                                    <th>
                                        <h6>Variant</h6>
                                    </th>
                                    <th>
                                        <h6>Price</h6>
                                    </th>
                                    <th>
                                        <h6>Discount</h6>
                                    </th>
                                    <th>
                                        <h6>Discount Type</h6>
                                    </th>
                                    <th>
                                        <h6>Stock</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="variantTableBody">
                                <!-- Variants will be dynamically generated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden template card -->
<template id="attributeCardTemplate">
    <div class="card mt-3 attribute-card">
        <div class="card-body">
            <x-input-select :label="'Select an attribute'" :class="'attribute-select2'">
            </x-input-select>

            <div>
                <label class="mb-2 mt-3 attribute-value-label d-none"><strong>Attribute Values</strong></label>
                <div class="attribute-value-container"></div>
            </div>

            <a href="javascript:void(0);" class="hover-underline add-attribute-value d-none mt-2">
                <i class="mdi mdi-plus"></i> Add More
            </a>
        </div>
        <div class="card-footer p-2 d-flex justify-content-end gap-2">
            <button type="button" class="main-btn light-btn-outline btn-hover btn-sm cancel-btn">Cancel</button>
            <button type="button" class="main-btn primary-btn btn-hover btn-sm done-btn">Done</button>
        </div>
    </div>
</template>

<!-- Summary template -->
<template id="summaryCardTemplate">
    <div class="card mt-2 d-flex justify-content-between align-items-center p-2 flex-row summary-card">
        <div>
            <strong class="summary-attribute-name"></strong>
            <div class="summary-values small text-muted"></div>

            <div class="summary-hidden-attributes"></div>
        </div>
        <div class="dropdown">
            <button class="btn btn-sm" type="button" data-bs-toggle="dropdown">
                <i class="mdi mdi-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item edit-summary" href="#">Edit</a></li>
                <li><a class="dropdown-item remove-summary" href="#">Remove</a></li>
            </ul>
        </div>
    </div>
</template>



@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const attributes = @json($attributes);
            const enableVariant = document.getElementById('enableVariantProduct');
            const summaryCardTemplate = document.getElementById('summaryCardTemplate');
            const addAttributeBtn = document.getElementById('addAttributeBtn');
            const variantAttributeContainer = document.getElementById('variantAttributeContainer');
            const variantTableBody = document.getElementById('variantTableBody');

            function getUsedAttributeIds() {
                const summaryContainer = document.getElementById('sortableSummaryContainer');
                return Array.from(summaryContainer.querySelectorAll('.summary-hidden-attributes input[name$="[attribute_id]"]')).map(input => input.value);
            }

            function getAvailableAttributes(keepId = null) {
                const usedIds = getUsedAttributeIds();
                return attributes.filter(attr => !usedIds.includes(attr.id.toString()) || attr.id.toString() === keepId);
            }

            function initializeSelect2(select, keepId = null) {
                $(select).select2({
                    placeholder: 'Select an attribute',
                    width: '100%',
                    data: [{
                        id: '',
                        text: 'Select an attribute'
                    }].concat(getAvailableAttributes(keepId).map(attr => ({
                        id: attr.id,
                        text: attr.name,
                        is_color: attr.is_color,
                    })))
                });
            }

            function createAttributeValue(isColor) {
                const attributeValueWrapper = document.createElement('div');
                attributeValueWrapper.className = 'd-flex gap-2 mb-2';

                const text = document.createElement('input');
                text.type = 'text';
                text.name = 'attribute_values[]';
                text.placeholder = 'e.g. Red';
                text.className = 'form-control flex-grow-1';
                attributeValueWrapper.appendChild(text);

                if (isColor) {
                    const color = document.createElement('input');
                    color.type = 'color';
                    color.name = 'attribute_colors[]';
                    color.className = 'rounded-circle p-0 border border-5 border-secondary';
                    color.style.width = '50px';
                    color.style.height = '50px';
                    color.style.flexShrink = '0';
                    color.value = '#fff';
                    attributeValueWrapper.appendChild(color);
                }

                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'btn btn-outline-secondary';
                deleteBtn.innerHTML = '<i class="mdi mdi-trash-can-outline"></i>';
                deleteBtn.onclick = () => attributeValueWrapper.remove();
                attributeValueWrapper.appendChild(deleteBtn);

                return attributeValueWrapper;
            }

            function getAttribute(attributeId) {
                return attributes.find(attr => attr.id == attributeId);
            }

            function createSummaryCard(attributeData, attributeIndex) {
                const clone = summaryCardTemplate.content.cloneNode(true);
                const card = clone.querySelector('.summary-card');
                const name = card.querySelector('.summary-attribute-name');
                const values = card.querySelector('.summary-values');
                const hiddenAttributes = card.querySelector('.summary-hidden-attributes');

                const attribute = getAttribute(attributeData.attribute_id);
                console.log(attribute);
                name.textContent = attribute.name;
                values.textContent = attributeData.attribute_values.map(value => value.name).join(', ');
                hiddenAttributes.innerHTML = '';

                const attributeIdInput = document.createElement('input');
                attributeIdInput.type = 'hidden';
                attributeIdInput.name = `attributes[${attributeIndex}][attribute_id]`;
                attributeIdInput.value = attribute.id;
                hiddenAttributes.appendChild(attributeIdInput);

                attributeData.attribute_values.forEach((value, valueIndex) => {
                    const nameInput = document.createElement('input');
                    nameInput.type = 'hidden';
                    nameInput.name = `attributes[${attributeIndex}][values][${valueIndex}][name]`;
                    nameInput.value = value.name;
                    hiddenAttributes.appendChild(nameInput);

                    const colorInput = document.createElement('input');
                    colorInput.type = 'hidden';
                    colorInput.name = `attributes[${attributeIndex}][values][${valueIndex}][color_code]`;
                    colorInput.value = value.color_code ?? '';
                    hiddenAttributes.appendChild(colorInput);
                });

                card.querySelector('.edit-summary').addEventListener('click', function(e) {
                    e.preventDefault();
                    editSummaryCard(card, attributeData);
                });

                card.querySelector('.remove-summary').addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will remove the attribute and update the variants.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, remove it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            card.remove();
                            updateVariantTable();
                            addAttributeBtn.classList.remove('d-none');
                            const remainingCards = variantAttributeContainer.querySelectorAll(
                                '.attribute-card');
                            remainingCards.forEach(card => {
                                const select = card.querySelector('.attribute-select2');
                                const currentValue = $(select).val();
                                $(select).select2('destroy');
                                initializeSelect2(select);
                                $(select).val(currentValue).trigger('change');
                            });
                        }
                    });
                });

                return card;
            }

            function generateVariantCombinations() {
                const summaryContainer = document.getElementById('sortableSummaryContainer');
                const summaryCards = Array.from(summaryContainer.querySelectorAll('.summary-card'));
                let combinations = [
                    []
                ];
                let attributeData = [];
                summaryCards.forEach(card => {
                    const attributeId = card.querySelector('input[name$="[attribute_id]"]').value;
                    const values = Array.from(card.querySelectorAll('input[name$="[name]"]')).map((input, index) => ({
                        name: input.value,
                        color_code: $(`input[name="attributes[${card.parentNode.children.length - 1}][values][${index}][color_code]"]`, card).val() || null,
                        attribute_id: attributeId
                    }));
                    console.log('values', values);
                    attributeData.push({
                        attribute_id: attributeId,
                        values
                    });
                    console.log('attributeData', attributeData);
                    const newCombinations = [];
                    combinations.forEach(combo => {
                        values.forEach(value => {
                            newCombinations.push([...combo, {
                                name: value.name,
                                attribute_id: value.attribute_id,
                                color_code: value.color_code
                            }]);
                        });
                    });
                    combinations = newCombinations;
                });

                return combinations.map(combo => ({
                    variant: combo.map(v => v.name).join(' / '),
                    attributes: combo.map(v => ({
                        attribute_id: v.attribute_id,
                        value: {
                            name: v.name,
                            color_code: v.color_code
                        }
                    }))
                }));
            }

            function updateVariantTable() {
                variantTableBody.innerHTML = '';
                const combinations = generateVariantCombinations();

                combinations.forEach((variant, index) => {
                    const row = document.createElement('tr');
                    const suggestedSku = `sku-${variant.variant.replace(/ /g, '').replace(/\//g, '-')}`;
                    row.innerHTML = `
                        <td>
                            <div class="input-style-1">
                                <input type="text" placeholder="SKU" class="bg-transparent" name="variants[${index}][sku]" value="${suggestedSku}">
                            </div>
                        </td>
                        <td>
                            <div class="input-style-1">
                                <input type="text" placeholder="Variant" class="bg-transparent" readonly disabled name="variants[${index}][variant]" value="${variant.variant}">
                            </div>
                        </td>
                        <td>
                            <div class="input-style-1">
                                <input type="text" placeholder="Price" class="bg-transparent" name="variants[${index}][price]" value="">
                            </div>
                        </td>
                        <td>
                            <div class="input-style-1">
                                <input type="text" placeholder="Discount" class="bg-transparent" name="variants[${index}][discount]" value="">
                            </div>
                        </td>
                        <td>
                            <div class="select-style-1">
                                <div class="select-position">
                                    <select name="variants[${index}][discount_type]">
                                        <option value="percentage">Percentage</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="input-style-1">
                                <input type="text" placeholder="Stock" class="bg-transparent" name="variants[${index}][stock]" value="">
                            </div>
                        </td>
                        <td class="d-none">
                            <div class="variant-attributes">
                                ${variant.attributes.map((attr, attrIndex) => `
                                        <input type="hidden" name="variants[${index}][attributes][${attrIndex}][attribute_id]" value="${attr.attribute_id}">
                                        <input type="hidden" name="variants[${index}][attributes][${attrIndex}][value][name]" value="${attr.value.name}">
                                        ${attr.value.color_code ? `<input type="hidden" name="variants[${index}][attributes][${attrIndex}][value][color_code]" value="${attr.value.color_code}">` : ''}
                                    `).join('')}
                            </div>
                        </td>
                    `;
                    variantTableBody.appendChild(row);
                });
            }

            function editSummaryCard(card, attributeData) {
                const attributeCardTemplate = document.getElementById('attributeCardTemplate');
                const clone = attributeCardTemplate.content.cloneNode(true);
                const newCard = clone.querySelector('.attribute-card');
                const select = newCard.querySelector('.attribute-select2');
                const doneBtn = newCard.querySelector('.done-btn');
                const cancelBtn = newCard.querySelector('.cancel-btn');
                const container = newCard.querySelector('.attribute-value-container');
                const label = newCard.querySelector('.attribute-value-label');
                const addMore = newCard.querySelector('.add-attribute-value');

                $(cancelBtn).hide();

                variantAttributeContainer.appendChild(newCard);
                initializeSelect2(select, attributeData.attribute_id);
                $(select).val(attributeData.attribute_id).trigger('change');

                const attribute = getAttribute(attributeData.attribute_id);
                label.classList.remove('d-none');
                addMore.classList.remove('d-none');

                attributeData.attribute_values.forEach(value => {
                    const wrapper = createAttributeValue(attribute.is_color);
                    wrapper.querySelector('input[name="attribute_values[]"]').value = value.name;
                    if (attribute.is_color && value.color_code) {
                        wrapper.querySelector('input[name="attribute_colors[]"]').value = value.color_code;
                    }
                    container.appendChild(wrapper);
                });

                addMore.onclick = () => {
                    container.appendChild(createAttributeValue(attribute.is_color));
                };

                $(doneBtn).on('click', function(e) {
                    e.preventDefault();
                    const attributeCard = this.closest('.attribute-card');
                    const select = attributeCard.querySelector('.attribute-select2');
                    const attributeValues = Array.from(attributeCard.querySelectorAll(
                        '.attribute-value-container input[name="attribute_values[]"]')).map(input =>
                        input.value.trim());

                    if (!select.value || attributeValues.length === 0 || attributeValues.every(val =>
                            val === '')) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please select an attribute and provide at least one valid value.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6'
                        });
                        return;
                    }

                    const attributeColors = Array.from(attributeCard.querySelectorAll(
                        '.attribute-value-container input[name="attribute_colors[]"]')).map(input =>
                        input.value);

                    const newAttributeData = {
                        attribute_id: select.value,
                        attribute_values: attributeValues.map((value, index) => ({
                            name: value,
                            color_code: attributeColors[index] ?? null
                        })),
                    };

                    const summaryContainer = document.getElementById('sortableSummaryContainer');
                    const attributeIndex = Array.from(summaryContainer.children).indexOf(card);
                    card.remove();
                    const summaryCard = createSummaryCard(newAttributeData, attributeIndex);
                    summaryContainer.appendChild(summaryCard);

                    attributeCard.remove();
                    addAttributeBtn.classList.remove('d-none');
                    updateVariantTable();

                    const remainingCards = variantAttributeContainer.querySelectorAll('.attribute-card');
                    remainingCards.forEach(card => {
                        const select = card.querySelector('.attribute-select2');
                        const currentValue = $(select).val();
                        $(select).select2('destroy');
                        initializeSelect2(select);
                        $(select).val(currentValue).trigger('change');
                    });
                });

                

                card.remove();
                addAttributeBtn.classList.add('d-none');
                updateVariantTable();
            }

            function addNewAttributeCard() {
                const attributeCardTemplate = document.getElementById('attributeCardTemplate');
                const clone = attributeCardTemplate.content.cloneNode(true);
                const card = clone.querySelector('.attribute-card');
                const select = card.querySelector('.attribute-select2');
                const doneBtn = card.querySelector('.done-btn');
                const cancelBtn = card.querySelector('.cancel-btn');

                variantAttributeContainer.appendChild(card);
                initializeSelect2(select);

                $(select).on('change', function() {
                    const option = $('option:selected', this);
                    const optionId = option.val();

                    const attribute = getAttribute(optionId);
                    const isColor = attribute.is_color;

                    const wrapper = this.closest('.attribute-card');
                    const label = wrapper.querySelector('.attribute-value-label');
                    const container = wrapper.querySelector('.attribute-value-container');
                    const addMore = wrapper.querySelector('.add-attribute-value');

                    container.innerHTML = '';
                    label.classList.remove('d-none');
                    addMore.classList.remove('d-none');

                    container.appendChild(createAttributeValue(isColor));

                    addMore.onclick = () => {
                        container.appendChild(createAttributeValue(isColor));
                    };
                });

                $(doneBtn).on('click', function(e) {
                    e.preventDefault();
                    const attributeCard = this.closest('.attribute-card');
                    const select = attributeCard.querySelector('.attribute-select2');
                    const attributeValues = Array.from(attributeCard.querySelectorAll(
                        '.attribute-value-container input[name="attribute_values[]"]')).map(input =>
                        input.value.trim());

                    if (!select.value || attributeValues.length === 0 || attributeValues.every(val =>
                            val === '')) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Please select an attribute and provide at least one valid value.',
                            icon: 'error',
                            confirmButtonColor: '#3085d6'
                        });
                        return;
                    }

                    const attributeColors = Array.from(attributeCard.querySelectorAll(
                        '.attribute-value-container input[name="attribute_colors[]"]')).map(input =>
                        input.value);

                    const attributeData = {
                        attribute_id: select.value,
                        attribute_values: attributeValues.map((value, index) => ({
                            name: value,
                            color_code: attributeColors[index] ?? null
                        })),
                    };

                    const summaryContainer = document.getElementById('sortableSummaryContainer');
                    const attributeIndex = summaryContainer.children.length;
                    const summaryCard = createSummaryCard(attributeData, attributeIndex);
                    summaryContainer.appendChild(summaryCard);

                    attributeCard.remove();
                    addAttributeBtn.classList.remove('d-none');
                    updateVariantTable();

                    const remainingCards = variantAttributeContainer.querySelectorAll('.attribute-card');
                    remainingCards.forEach(card => {
                        const select = card.querySelector('.attribute-select2');
                        const currentValue = $(select).val();
                        $(select).select2('destroy');
                        initializeSelect2(select);
                        $(select).val(currentValue).trigger('change');
                    });
                });

                $(cancelBtn).on('click', function(e) {
                    e.preventDefault();
                    const attributeCard = this.closest('.attribute-card');
                    attributeCard.remove();
                    addAttributeBtn.classList.remove('d-none');
                });
            }

            addAttributeBtn.addEventListener('click', function() {
                addNewAttributeCard();
                this.classList.add('d-none');
            });

            enableVariant.addEventListener('change', function() {
                if (!this.checked) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('variantAttributeContainer').innerHTML = '';
                            document.getElementById('sortableSummaryContainer').innerHTML = '';
                            variantTableBody.innerHTML = '';
                            addAttributeBtn.classList.add('d-none');
                        } else {
                            this.checked = true;
                        }
                    });
                    return;
                }

                addNewAttributeCard();
            });

            new Sortable(document.getElementById('sortableSummaryContainer'), {
                animation: 150,
                onEnd: function() {
                    updateVariantTable();
                    const summaryCards = document.getElementById('sortableSummaryContainer')
                        .querySelectorAll('.summary-card');
                    summaryCards.forEach((card, index) => {
                        const hiddenAttributes = card.querySelector(
                            '.summary-hidden-attributes');
                        const inputs = hiddenAttributes.querySelectorAll('input');
                        inputs.forEach(input => {
                            const name = input.name.replace(/attributes\[\d+\]/,
                                `attributes[${index}]`);
                            input.name = name;
                        });
                    });
                }
            });
        });
    </script>
@endpush
