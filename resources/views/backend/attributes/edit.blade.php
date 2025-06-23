@extends('backend.layouts.app')
@section('title', 'Edit Attribute')

@push('css')
    <style>
        .color-preview {
            width: 30px;
            height: 30px;
            aspect-ratio: 1;
            border-radius: 50%;
            display: inline-block;
            border: 1px solid #ccc;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }
    </style>
@endpush

@section('content')
    <!-- ========== section start ========== -->
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Edit Attribute</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard.index') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.attributes.index') }}">Attributes</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Edit
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========== title-wrapper end ========== -->
            <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="post" id="attributeForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-5">
                        <div class="card-style">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="mb-1"><strong>Name</strong></label>
                                    <x-input-group :type="'text'" :value="old('name', $attribute->name)" :name="'name'" :placeholder="'Enter attribute name'"
                                        :id="'name'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="error-message" id="name_error">Name is required</span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="slug" class="mb-1"><strong>Slug</strong></label>
                                    <x-input-group :type="'text'" :value="old('slug', $attribute->slug)" :name="'slug'" :placeholder="'Enter slug'"
                                        :id="'slug'">
                                        <span class="mdi mdi-link"></span>
                                    </x-input-group>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="error-message" id="slug_error">Slug is required and must be unique</span>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <x-success-checkbox :id="'is_color'" :value="'1'" :name="'is_color'"
                                        :checked="old('is_color', $attribute->is_color)">
                                        Is Color?
                                    </x-success-checkbox>
                                    @error('is_color')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <x-success-checkbox :id="'status'" :value="'1'" :name="'status'"
                                        :checked="old('status', $attribute->status)">
                                        Status
                                    </x-success-checkbox>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <x-primary-button :type="'submit'">
                                        Update
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card-style">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="main-btn primary-btn btn-hover btn-sm"
                                        data-bs-toggle="modal" data-bs-target="#addValueModal">Add Value</button>
                                </div>
                                <div class="col-md-12 my-2">
                                    <input type="hidden" name="attribute_values" id="attribute_values"
                                        value="{{ old('attribute_values', json_encode($attribute->attributeValues->map(function($value) {
                                            return ['id' => $value->id, 'name' => $value->name, 'color_code' => $value->color_code];
                                        })->toArray())) }}">
                                    <div class="value_wrapper table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="30%">Name</th>
                                                    <th class="text-center color-code-column" width="30%"
                                                        style="display: none;">Color Code</th>
                                                    <th class="text-center" width="10%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="value_body">
                                                <tr>
                                                    <td class="text-center" colspan="3">No Values</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @error('attribute_values')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="error-message" id="values_error">At least one value is required</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
            </form>
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

    <!-- Add Value Modal -->
    <div class="modal fade" data-bs-backdrop="static" id="addValueModal" tabindex="-1" aria-labelledby="addValueModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addValueModalLabel">Add Attribute Value</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="value_name" class="form-label"><strong>Value Name</strong></label>
                        <input type="text" class="form-control" id="value_name" placeholder="Enter value name">
                        <span class="error-message" id="value_name_error">Value name is required</span>
                    </div>
                    <div class="mb-3" id="color_code_wrapper" style="display: none;">
                        <label for="color_code" class="form-label"><strong>Color Code</strong></label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" class="form-control" id="color_code_text"
                                placeholder="Enter hex code (e.g., #FFFFFF)">
                            <input type="color" class="form-control form-control-color" id="color_code"
                                value="#000000">
                        </div>
                        <span class="error-message" id="color_code_error">Valid color code is required (e.g.,
                            #FFFFFF)</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="main-btn danger-btn btn-hover btn-sm"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="main-btn primary-btn btn-hover btn-sm" id="add_value">Add
                        Value</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Value Modal -->
    <div class="modal fade" data-bs-backdrop="static" id="editValueModal" tabindex="-1"
        aria-labelledby="editValueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editValueModalLabel">Edit Attribute Value</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_value_id">
                    <div class="mb-3">
                        <label for="edit_value_name" class="form-label"><strong>Edit Value Name</strong></label>
                        <input type="text" class="form-control" id="edit_value_name" placeholder="Enter value name">
                        <span class="error-message" id="edit_value_name_error">Value name is required</span>
                    </div>
                    <div class="mb-3" id="edit_color_code_wrapper" style="display: none;">
                        <label for="edit_color_code" class="form-label"><strong>Color Code</strong></label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" class="form-control" id="edit_color_code_text"
                                placeholder="Enter hex code (e.g., #FFFFFF)">
                            <input type="color" class="form-control form-control-color" id="edit_color_code"
                                value="#000000">
                        </div>
                        <span class="error-message" id="edit_color_code_error">Valid color code is required (e.g.,
                            #FFFFFF)</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="main-btn danger-btn btn-hover btn-sm"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="main-btn primary-btn btn-hover btn-sm" id="save_value">Save
                        Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/slugify@1.6.6/slugify.min.js"></script>
<script>
$(document).ready(function () {
    let attributeValues = parseInitialValues(
        @json(old('attribute_values', $attribute->attributeValues))
    );

    syncInputValues();
    toggleColorFields($('#is_color').is(':checked'));
    renderValues();

    $('#name').on('input', function () {
        const input = $(this).val().trim();
        $('#slug').val(input ? slugify(input, { lower: true, strict: true, locale: 'en' }) : '');
    });

    $('#is_color').on('change', function () {
        toggleColorFields(this.checked);
        resetColorInputs();
        renderValues();
    });

    // Add Modal sync
    bindColorInputSync('#color_code', '#color_code_text');
    bindColorInputSync('#color_code_text', '#color_code');

    // Edit Modal sync
    bindColorInputSync('#edit_color_code', '#edit_color_code_text');
    bindColorInputSync('#edit_color_code_text', '#edit_color_code');

    $('#add_value').click(handleAddValue);
    $('#save_value').click(handleEditValue);
    $(document).on('click', '.edit-btn', showEditModal);
    $('#attributeForm').on('submit', validateForm);

    // Modal show/hide hooks
    $('#addValueModal').on('shown.bs.modal', () => {
        $('#value_name').focus();
        $('#color_code_wrapper').toggle($('#is_color').is(':checked'));
    }).on('click', '.close', resetAddModal);

    $('#editValueModal').on('shown.bs.modal', () => {
        $('#edit_value_name').focus();
        $('#edit_color_code_wrapper').toggle($('#is_color').is(':checked'));
    }).on('click', '.close', resetEditModal);

    function parseInitialValues(data) {
        try {
            return Array.isArray(data) ? data.map((v, i) => ({
                id: v.id || Date.now() + i,
                name: v.name,
                color_code: v.color_code
            })) : [];
        } catch {
            return [];
        }
    }

    function syncInputValues() {
        $('#attribute_values').val(JSON.stringify(attributeValues.map(v => ({
            id: v.id,
            name: v.name,
            color_code: v.color_code
        }))));
    }

    function bindColorInputSync(source, target) {
        $(source).on('input', function () {
            const color = $(this).val();
            if (/^#([0-9A-F]{3}){1,2}$/i.test(color)) {
                $(target).val(color);
            }
        });
    }

    function toggleColorFields(show) {
        $('.color-code-column, #color_code_wrapper, #edit_color_code_wrapper').toggle(show);
    }

    function resetColorInputs() {
        $('#color_code, #color_code_text, #edit_color_code, #edit_color_code_text').val('#000000');
    }

    function handleAddValue() {
        const name = $('#value_name').val().trim();
        const isColor = $('#is_color').is(':checked');
        const colorCode = isColor ? $('#color_code').val() : null;

        if (!name) return $('#value_name_error').show();
        $('#value_name_error').hide();

        if (isColor && !/^#([0-9A-F]{3}){1,2}$/i.test(colorCode)) return $('#color_code_error').show();
        $('#color_code_error').hide();

        attributeValues.push({ id: Date.now(), name, color_code: colorCode });
        syncInputValues();
        renderValues();
        resetAddModal();
        $('#addValueModal').modal('hide');
    }

    function showEditModal() {
        const id = parseInt($(this).data('id'));
        const value = attributeValues.find(v => v.id === id);
        if (!value) return;

        $('#edit_value_id').val(id);
        $('#edit_value_name').val(value.name);
        $('#edit_color_code, #edit_color_code_text').val(value.color_code || '#000000');
        $('#editValueModal').modal('show');
    }

    function handleEditValue() {
        const id = parseInt($('#edit_value_id').val());
        const name = $('#edit_value_name').val().trim();
        const isColor = $('#is_color').is(':checked');
        const colorCode = isColor ? $('#edit_color_code').val() : null;

        if (!name) return $('#edit_value_name_error').show();
        $('#edit_value_name_error').hide();

        if (isColor && !/^#([0-9A-F]{3}){1,2}$/i.test(colorCode)) return $('#edit_color_code_error').show();
        $('#edit_color_code_error').hide();

        const index = attributeValues.findIndex(v => v.id === id);
        if (index !== -1) {
            attributeValues[index] = { id, name, color_code: colorCode };
            syncInputValues();
            renderValues();
            resetEditModal();
            $('#editValueModal').modal('hide');
        }
    }

    function renderValues() {
        const isColor = $('#is_color').is(':checked');
        const tbody = $('#value_body').empty();

        if (attributeValues.length === 0) {
            return tbody.append(`<tr><td class="text-center" colspan="${isColor ? 3 : 2}">No Values</td></tr>`);
        }

        attributeValues.forEach(value => {
            const colorCell = isColor ? `<td class="text-center color-code-column"><span class="color-preview" style="background-color: ${value.color_code};"></span></td>` : '';
            tbody.append(`
                <tr>
                    <td class="text-center">${value.name}</td>
                    ${colorCell}
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm edit-btn" data-id="${value.id}"><span class="mdi mdi-pencil"></span></button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeValue(${value.id})"><span class="mdi mdi-trash-can-outline"></span></button>
                    </td>
                </tr>
            `);
        });
    }

    window.removeValue = function (id) {
        attributeValues = attributeValues.filter(v => v.id !== id);
        syncInputValues();
        renderValues();
    };

    function validateForm(e) {
        let isValid = true;
        const name = $('#name').val().trim();
        const slug = $('#slug').val().trim();
        const isColor = $('#is_color').is(':checked');

        if (!name) { $('#name_error').show(); isValid = false; } else { $('#name_error').hide(); }
        if (!slug || !/^[a-z0-9-]+$/.test(slug)) { $('#slug_error').show(); isValid = false; } else { $('#slug_error').hide(); }
        if (attributeValues.length === 0) {
            $('#values_error').text('At least one value is required.').show();
            isValid = false;
        } else if (isColor && attributeValues.some(v => !v.color_code)) {
            $('#values_error').text('All values must have a valid color code when "Is Color?" is checked').show();
            isValid = false;
        } else {
            $('#values_error').hide();
        }

        if (!isValid) e.preventDefault();
    }

    function resetAddModal() {
        $('#value_name').val('');
        $('#color_code, #color_code_text').val('#000000');
        $('#value_name_error, #color_code_error').hide();
    }

    function resetEditModal() {
        $('#edit_value_name').val('');
        $('#edit_color_code, #edit_color_code_text').val('#000000');
        $('#edit_value_name_error, #edit_color_code_error').hide();
    }
});
</script>
@endpush