@extends('backend.layouts.app')
@section('title', 'Create Attribute')
@push('css')
    <style>
        .color-preview {
            width: 30px;
            height: 30px;
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
                            <h2>{{ 'Create Attribute' }}</h2>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard.index') }}">{{ 'Dashboard' }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.attributes.index') }}">{{ 'Attributes' }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ 'Create' }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========== title-wrapper end ========== -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card-style">
                        <form action="{{ route('admin.attributes.store') }}" method="post" id="attributeForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-5 my-2">
                                    <label for="name" class="mb-1"><strong>{{ 'Name' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('name')" :name="'name'" :placeholder="'Enter attribute name'" :id="'name'">
                                        <span class="mdi mdi-shape"></span>
                                    </x-input-group>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="error-message" id="name_error">{{ 'Name is required' }}</span>
                                </div>

                                <div class="col-md-5 my-2">
                                    <label for="slug" class="mb-1"><strong>{{ 'Slug' }}</strong></label>
                                    <x-input-group :type="'text'" :value="old('slug')" :name="'slug'" :placeholder="'Enter slug'" :id="'slug'">
                                        <span class="mdi mdi-link"></span>
                                    </x-input-group>
                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <span class="error-message" id="slug_error">{{ 'Slug is required and must be unique' }}</span>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="main-btn primary-btn btn-hover btn-sm" data-bs-toggle="modal" style="margin-top:42px" data-bs-target="#addValueModal">{{ 'Add Value' }}</button>
                                </div>

                                <div class="col-md-12 my-2">
                                    <input type="hidden" name="attribute_values" id="attribute_values" value="[]">
                                    <div class="value_wrapper table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="30%">{{ 'Name' }}</th>
                                                    <th class="text-center" width="30%">{{ 'Color Code' }}</th>
                                                    <th class="text-center" width="10%">{{ 'Actions' }}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="value_body">
                                                <tr>
                                                    <td class="text-center" colspan="3">{{ 'No Values' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        @error('attribute_values')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <span class="error-message" id="values_error">{{ 'At least one value is required' }}</span>
                                    </div>
                                </div>

                                <div class="col-md-12 my-2">
                                    <x-success-checkbox :id="'status'" :value="'1'" :name="'status'">
                                        {{ 'Status' }}
                                    </x-success-checkbox>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-12 mt-3">
                                    <x-primary-button :type="'submit'">
                                        {{ 'Create' }}
                                    </x-primary-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
    <!-- ========== section end ========== -->

    <!-- Add Value Modal -->
    <div class="modal fade" data-bs-backdrop="static" id="addValueModal" tabindex="-1" aria-labelledby="addValueModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addValueModalLabel">{{ 'Add Attribute Value' }}</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="value_name" class="form-label"><strong>{{ 'Value Name' }}</strong></label>
                        <input type="text" class="form-control" id="value_name" placeholder="Enter value name">
                        <span class="error-message" id="value_name_error">{{ 'Value name is required' }}</span>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_color" name="is_color">
                            <label class="form-check-label" for="is_color">
                                {{ 'Is Color?' }}
                            </label>
                        </div>
                    </div>
                    <div class="mb-3" id="color_code_wrapper" style="display: none;">
                        <label for="color_code" class="form-label"><strong>{{ 'Color Code' }}</strong></label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="color" class="form-control form-control-color" id="color_code" value="#000000">
                            <input type="text" class="form-control" id="color_code_text" placeholder="Enter hex code (e.g., #FFFFFF)">
                            <span class="color-preview" id="color_preview" style="background-color: #000000;"></span>
                        </div>
                        <span class="error-message" id="color_code_error">{{ 'Valid color code is required (e.g., #FFFFFF)' }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="main-btn danger-btn btn-hover btn-sm" data-bs-dismiss="modal">{{ 'Close' }}</button>
                    <button type="button" class="main-btn primary-btn btn-hover btn-sm" id="add_value">{{ 'Add Value' }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Auto-generate slug from name
            $('#name').on('input', function() {
                const name = $(this).val().trim();
                if (name) {
                    const slug = name
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                        .replace(/\s+/g, '-')         // Replace spaces with hyphens
                        .replace(/-+/g, '-');         // Replace multiple hyphens with single
                    $('#slug').val(slug);
                } else {
                    $('#slug').val('');
                }
            });

            // Toggle color code input visibility
            $('#is_color').on('change', function() {
                $('#color_code_wrapper').toggle(this.checked);
                if (!this.checked) {
                    $('#color_code').val('#000000');
                    $('#color_code_text').val('#000000');
                    $('#color_preview').css('background-color', '#000000');
                }
            });

            // Sync color picker and text input
            $('#color_code').on('input', function() {
                const color = $(this).val();
                $('#color_code_text').val(color);
                $('#color_preview').css('background-color', color);
            });

            $('#color_code_text').on('input', function() {
                const color = $(this).val();
                if (/^#([0-9A-F]{3}){1,2}$/i.test(color)) {
                    $('#color_code').val(color);
                    $('#color_preview').css('background-color', color);
                }
            });

            // Add value with validation
            $('#add_value').click(function() {
                const name = $('#value_name').val().trim();
                const isColor = $('#is_color').is(':checked');
                const colorCode = isColor ? $('#color_code').val() : null;

                // Validate value name
                if (!name) {
                    $('#value_name_error').show();
                    return;
                } else {
                    $('#value_name_error').hide();
                }

                // Validate color code if is_color is checked
                if (isColor && !/^#([0-9A-F]{3}){1,2}$/i.test(colorCode)) {
                    $('#color_code_error').show();
                    return;
                } else {
                    $('#color_code_error').hide();
                }

                const values = JSON.parse(localStorage.getItem('attribute_values')) ?? [];
                const value = {
                    id: Date.now(), // Temporary unique ID
                    name: name,
                    color_code: isColor ? colorCode : null
                };

                values.push(value);
                localStorage.setItem('attribute_values', JSON.stringify(values));
                $('#attribute_values').val(JSON.stringify(values.map(v => ({
                    name: v.name,
                    color_code: v.color_code
                }))));
                loopValues();

                // Reset modal
                $('#value_name').val('');
                $('#is_color').prop('checked', false);
                $('#color_code').val('#000000');
                $('#color_code_text').val('#000000');
                $('#color_preview').css('background-color', '#000000');
                $('#color_code_wrapper').hide();
                $('#value_name_error').hide();
                $('#color_code_error').hide();
                $('#addValueModal').modal('hide');
            });

            // Form submission validation
            $('#attributeForm').on('submit', function(e) {
                let isValid = true;

                // Validate name
                if (!$('#name').val().trim()) {
                    $('#name_error').show();
                    isValid = false;
                } else {
                    $('#name_error').hide();
                }

                // Validate slug
                const slug = $('#slug').val().trim();
                if (!slug || !/^[a-z0-9]+(?:-[a-z0-9]+)*$/.test(slug)) {
                    $('#slug_error').show();
                    isValid = false;
                } else {
                    $('#slug_error').hide();
                }

                // Validate attribute values
                const values = JSON.parse(localStorage.getItem('attribute_values') ?? '[]');
                if (values.length === 0) {
                    $('#values_error').show();
                    isValid = false;
                } else {
                    $('#values_error').hide();
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            // Focus on name input when modal opens
            $('#addValueModal').on('shown.bs.modal', function() {
                $('#value_name').focus();
            });

            // Clear modal on close
            $('#addValueModal .close').click(function() {
                $('#value_name').val('');
                $('#is_color').prop('checked', false);
                $('#color_code').val('#000000');
                $('#color_code_text').val('#000000');
                $('#color_preview').css('background-color', '#000000');
                $('#color_code_wrapper').hide();
                $('#value_name_error').hide();
                $('#color_code_error').hide();
            });

            loopValues();
        });

        function loopValues() {
            const values = JSON.parse(localStorage.getItem('attribute_values')) ?? [];
            $('#value_body').empty();

            if (values.length === 0) {
                $('#value_body').append(`
                    <tr>
                        <td class="text-center" colspan="3">{{ 'No Values' }}</td>
                    </tr>
                `);
            } else {
                values.forEach(value => {
                    const html = `
                        <tr>
                            <td class="text-center" width="30%">${value.name}</td>
                            <td class="text-center" width="30%">
                                ${value.color_code ? `<span class="color-preview" style="background-color: ${value.color_code};"></span> ${value.color_code}` : 'N/A'}
                            </td>
                            <td class="text-center" width="10%">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeValue(${value.id})">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    $('#value_body').append(html);
                });
            }
        }

        function removeValue(id) {
            const values = JSON.parse(localStorage.getItem('attribute_values')) ?? [];
            const index = values.findIndex(v => v.id === id);
            if (index !== -1) {
                values.splice(index, 1);
                localStorage.setItem('attribute_values', JSON.stringify(values));
                $('#attribute_values').val(JSON.stringify(values.map(v => ({
                    name: v.name,
                    color_code: v.color_code
                }))));
                loopValues();
            }
        }
    </script>
@endpush