<div class="d-flex align-items-center gap-3">
    <h3>Variant</h3>
    <div class="form-check form-switch toggle-switch">
        <input class="form-check-input" type="checkbox" id="enableVariantProduct">
    </div>
</div>
<div id="hiddenInputsContainer"></div>
<div id="variantAttributeContainer" class="mt-3 sortable-container"></div>


<div class="d-flex">
    <a href="javascript:void(0);" class="main-btn light-btn-outline btn-hover btn-sm mt-2 d-none" id="addAttributeBtn">
        <i class="mdi mdi-plus"></i> Add Attribute
    </a>
</div>

<!-- Hidden template card -->
<template id="attributeCardTemplate">
    <div class="card mt-3 attribute-card">
        <div class="card-body">
            <x-input-select :label="'Select an attribute'" :name="'attribute_id'" :class="'attribute-select2'">
                <option value="">Select an attribute</option>
                @foreach ($attributes as $attribute)
                    <option value="{{ $attribute->id }}" data-is-color="{{ $attribute->is_color ? '1' : '0' }}">
                        {{ $attribute->name }}
                    </option>
                @endforeach
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
    <div class="card mt-2 d-flex justify-content-between align-items-center p-2 flex-row">
        <div>
            <strong class="summary-attribute-name"></strong>
            <div class="summary-values small text-muted"></div>
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
            const enableVariant = document.getElementById('enableVariantProduct');
            const container = document.getElementById('variantAttributeContainer');
            const addBtn = document.getElementById('addAttributeBtn');
            const cardTemplate = document.getElementById('attributeCardTemplate');
            const summaryTemplate = document.getElementById('summaryCardTemplate');

            const attributes = @json($attributes);

            let currentCard = null;

            function initSelect2(select) {
                $(select).select2({
                    placeholder: "Select an attribute",
                    width: '100%'
                }).on('change', function() {
                    const isColor = $('option:selected', this).data('is-color') == 1;
                    const wrapper = this.closest('.card');
                    renderInput(wrapper, isColor);
                    disableUsedOptions(this);
                });
            }

            new Sortable(container, {
                animation: 150,
                handle: '.card', // Optional
                onEnd: function() {
                    // Rebuild order if needed
                    console.log('Reordered attributes');
                }
            });


            function renderInput(card, isColor) {
                const label = card.querySelector('.attribute-value-label');
                const container = card.querySelector('.attribute-value-container');
                const addMore = card.querySelector('.add-attribute-value');

                container.innerHTML = '';
                label.classList.remove('d-none');
                addMore.classList.remove('d-none');

                container.appendChild(createInput(isColor));

                addMore.onclick = () => {
                    container.appendChild(createInput(isColor));
                };
            }

            function createInput(isColor) {
                const wrapper = document.createElement('div');
                wrapper.className = 'd-flex gap-2 mb-2';

                const text = document.createElement('input');
                text.type = 'text';
                text.name = 'attribute_values[]';
                text.placeholder = 'e.g. Red';
                text.className = 'form-control flex-grow-1';

                wrapper.appendChild(text);

                if (isColor) {
                    const color = document.createElement('input');
                    color.type = 'color';
                    color.name = 'attribute_colors[]';
                    color.className = 'rounded-circle p-0 border border-5 border-secondary';
                    color.style.width = '50px';
                    color.style.height = '50px';
                    wrapper.appendChild(color);
                }

                const del = document.createElement('button');
                del.type = 'button';
                del.className = 'btn btn-outline-secondary';
                del.innerHTML = '<i class="mdi mdi-trash-can-outline"></i>';
                del.onclick = () => wrapper.remove();
                wrapper.appendChild(del);

                return wrapper;
            }

            function createAttributeCard() {
                const clone = cardTemplate.content.cloneNode(true);
                const card = clone.querySelector('.attribute-card');

                const select = card.querySelector('.attribute-select2');
                const cancel = card.querySelector('.cancel-btn');
                const done = card.querySelector('.done-btn');
                const hiddenInputsContainer = document.getElementById('hiddenInputsContainer');

                initSelect2(select);

                cancel.onclick = () => {
                    card.remove();
                    currentCard = null;
                };

                done.onclick = () => {
                    const attrId = select.value;
                    if (!attrId) return alert("Please select an attribute");

                    const attr = attributes.find(a => a.id == attrId);
                    console.log(attr);
                    const values = Array.from(card.querySelectorAll('input[type="text"]')).map(i => i.value)
                        .filter(Boolean);

                    if (!values.length) return alert("Please enter at least one value");

                    const summary = summaryTemplate.content.cloneNode(true);
                    summary.querySelector('.summary-attribute-name').textContent = attr.name;
                    summary.querySelector('.summary-values').textContent = values.join(', ');

                    summary.querySelector('.remove-summary').onclick = () => {
                        summaryCard.remove();
                    };

                    summary.querySelector('.edit-summary').onclick = () => {
                        summaryCard.remove();
                        container.appendChild(card);
                        currentCard = card;
                        addBtn.classList.add('d-none');
                    };

                    const summaryCard = summary.firstElementChild;
                    container.appendChild(summaryCard);
                    card.remove();
                    currentCard = null;
                    addBtn.classList.remove('d-none');
                    const hiddenInputs = generateHiddenInputs(attributes.length, attrId, values, attr.is_color);
                    hiddenInputsContainer.appendChild(hiddenInputs);
                };


                container.appendChild(card);
                currentCard = card;
                addBtn.classList.add('d-none');
            }

            function generateHiddenInputs(attributeIndex, attrId, values, isColor) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('hidden-inputs');
                wrapper.innerHTML = `
                    <input type="hidden" name="attribute[${attributeIndex}][id]" value="${attrId}">
                    ${values.map((v, i) => `
                            <input type="hidden" name="attribute[${attributeIndex}][values][${i}][name]" value="${v.name}">
                            <input type="hidden" name="attribute[${attributeIndex}][values][${i}][color_code]" value="${v.color_code ?? ''}">
                        `).join('')}
                `;
                return wrapper;
            }


            function getUsedAttributeIds() {
                return attributes.map(attr => attr.id);
            }


            function disableUsedOptions(select) {
                const used = getUsedAttributeIds();
                for (let option of select.options) {
                    option.disabled = used.includes(parseInt(option.value));
                }
                $(select).trigger('change.select2');
            }

            enableVariant.addEventListener('change', async () => {
                if (!enableVariant.checked && container.children.length > 0) {
                    const result = await Swal.fire({
                        title: 'Are you sure?',
                        text: 'Disabling variants will remove all attributes.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, clear all',
                    });

                    if (result.isConfirmed) {
                        container.innerHTML = '';
                        attributes.length = 0;
                        currentCard = null;
                        addBtn.classList.add('d-none');
                    } else {
                        enableVariant.checked = true;
                        return;
                    }
                }

                if (enableVariant.checked) {
                    addBtn.classList.remove('d-none');
                    if (!currentCard) createAttributeCard();
                }
            });

            if (enableVariant.checked) {
                addBtn.classList.remove('d-none');
                createAttributeCard();
            }

            addBtn.onclick = () => {
                if (currentCard) {
                    alert("Finish the current attribute first.");
                    return;
                }
                createAttributeCard();
            };
        });
    </script>
@endpush
