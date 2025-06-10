@extends('backend.layouts.app')

@section('title', __('app.order'))

@section('content')
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">

                    <div class="col-md-6">
                        <div class="title">
                            <h2>{{ __('app.create_order') }}</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item ">
                                        <a href="{{ route('admin.dashboard.index') }}">{{ __('app.dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('app.orders') }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->

            <div class="col-md-12">
                <form method="post" id="orderForm">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card-style">
                                <div class="row">
                                    @csrf

                                    <div class="accordion mb-3" id="orderSteps">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="billingHeading">
                                                <div class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#billingContent" aria-expanded="true"
                                                    aria-controls="billingContent">
                                                    {{-- relevent icon --}}
                                                    <div class="p-2 rounded bg-white d-flex align-items-center justify-content-center shadow-sm me-2"
                                                        style="height: 50px; width: 50px;">
                                                        <i class="mdi mdi-map-marker fs-4"></i>
                                                    </div>
                                                    {{ __('app.billing_details') }}&nbsp;<span>*</span>
                                                </div>
                                            </h2>
                                            <div id="billingContent" class="accordion-collapse collapse show"
                                                aria-labelledby="billingHeading" data-bs-parent="#orderSteps">
                                                <div class="accordion-body">
                                                    @include('backend.order.partials.billing-details')
                                                    @include('backend.order.partials.accordion-navigator')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="shippingHeading">
                                                <div class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#shippingContent"
                                                    aria-expanded="false" aria-controls="shippingContent">
                                                    <div class="p-2 rounded bg-white d-flex align-items-center justify-content-center shadow-sm me-2"
                                                        style="height: 50px; width: 50px;">
                                                        <i class="mdi mdi-bus-marker fs-4"></i>
                                                    </div>
                                                    {{ __('app.shipping_details') }}&nbsp;<span>*</span>
                                                </div>
                                            </h2>
                                            <div id="shippingContent" class="accordion-collapse collapse"
                                                aria-labelledby="shippingHeading" data-bs-parent="#orderSteps">
                                                <div class="accordion-body">
                                                    @include('backend.order.partials.shipping-details')
                                                    @include('backend.order.partials.accordion-navigator')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="deliveryInstructionHeading">
                                                <div class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#deliveryInstructionContent"
                                                    aria-expanded="false" aria-controls="deliveryInstructionContent">
                                                    <div class="p-2 rounded bg-white d-flex align-items-center justify-content-center shadow-sm me-2"
                                                        style="height: 50px; width: 50px;">
                                                        <i class="mdi mdi-truck-delivery fs-4"></i>
                                                    </div>

                                                    {{ __('app.delivery_instruction') }}
                                                </div>
                                            </h2>
                                            <div id="deliveryInstructionContent" class="accordion-collapse collapse"
                                                aria-labelledby="deliveryInstructionHeading" data-bs-parent="#orderSteps">
                                                <div class="accordion-body">
                                                    @include('backend.order.partials.delivery-instruction')
                                                    @include('backend.order.partials.accordion-navigator')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="deliveryDateHeading">
                                                <div class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#deliveryDateContent"
                                                    aria-expanded="false" aria-controls="deliveryDateContent">
                                                    <div class="p-2 rounded bg-white d-flex align-items-center justify-content-center shadow-sm me-2"
                                                        style="height: 50px; width: 50px;">
                                                        <i class="mdi mdi-calendar-clock fs-4"></i>
                                                    </div>
                                                    {{ __('app.delivery_date') }}&nbsp;<span>*</span>
                                                </div>
                                            </h2>
                                            <div id="deliveryDateContent" class="accordion-collapse collapse"
                                                aria-labelledby="deliveryDateHeading" data-bs-parent="#orderSteps">
                                                <div class="accordion-body">
                                                    @include('backend.order.partials.delivery-date')
                                                    @include('backend.order.partials.accordion-navigator')
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="paymentHeading">
                                                <div class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#paymentContent"
                                                    aria-expanded="false" aria-controls="paymentContent">
                                                    <div class="p-2 rounded bg-white d-flex align-items-center justify-content-center shadow-sm me-2"
                                                        style="height: 50px; width: 50px;">
                                                        <i class="mdi mdi-credit-card fs-4"></i>
                                                    </div>
                                                    {{ __('app.payment_method') }} &nbsp;<span>*</span>
                                                </div>
                                            </h2>
                                            <div id="paymentContent" class="accordion-collapse collapse"
                                                aria-labelledby="paymentHeading" data-bs-parent="#orderSteps">
                                                <div class="accordion-body">
                                                    @include('backend.order.partials.payment-details')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="customer" class="mb-1"><strong>{{ __('app.customer') }}
                                                <span class="text-danger">*</span></strong></label>
                                        <x-input-select :type="'text'" :value="old('customer')" :name="'customer'"
                                            :id="'customer'">
                                            <option value="">{{ __('app.select_customer') }}</option>
                                        </x-input-select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            <div class="card-style">
                                <div class="d-flex mb-3 align-items-center">
                                    <div class="me-auto fw-semibold"><span id="total_selected_item"></span>&nbsp;items
                                    </div>
                                    <div>
                                        <button type="button" class="main-btn primary-btn btn-hover btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addProductModal">{{ __('app.add_product') }}</button>
                                    </div>
                                </div>
                                <hr>
                                <div id="products_wrapper" class="d-flex flex-column gap-1">
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-style-2 mb-0">
                                            <input type="text" name="promo" id="promo"
                                                placeholder="Apply promo">
                                                <style>
                                                    .input-style-2 .append {
                                                        padding: 8px !important;
                                                    }
                                                </style>
                                            <span class="append">
                                                <button type="button" id="apply_promo_button"
                                                    class="main-btn primary-btn btn-hover btn-sm"
                                                    onclick="searchPromo(this)" id="promo">
                                                    {{ __('app.apply') }}
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p class="form-text" id="promo_message"></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex mb-3">
                                    <div class="me-auto p-2"><span>{{ __('app.subtotal') }}</span></div>
                                    <div class="p-2">
                                        <strong id="subtotal"></strong>
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <div class="me-auto p-2"><span>{{ __('app.shipping_charge') }}</span></div>
                                    <div class="p-2">
                                        <strong id="shipping_charge"></strong>
                                    </div>
                                </div>
                                <div id="gift-wrapper-charge-wrapper" class="d-none">
                                    <div class="d-flex mb-3">
                                        <div class="me-auto p-2"><span>{{ __('app.gift_wrapper_charge') }}</span></div>
                                        <div class="p-2">
                                            <strong id="gift_wrapper_charge"></strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="me-auto p-2"><span>{{ __('app.service_charge') }}</span></div>
                                    <div class="p-2">
                                        <strong id="service_charge"></strong>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="me-auto p-2"><span>{{ __('app.tax') }}</span></div>
                                    <div class="p-2">
                                        <strong id="tax"></strong>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="me-auto p-2"><span>{{ __('app.discount') }}</span></div>
                                    <div class="p-2">
                                        <strong id="discount"></strong>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex mb-3">
                                    <div class="me-auto p-2"><strong>{{ __('app.total_to_pay') }}</strong></div>
                                    <div class="p-2">
                                        <strong id="grand_total"></strong>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="checkout_button"
                                class="mt-3 main-btn primary-btn btn-hover w-100">
                                {{ __('app.checkout') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>

    <div class="modal fade" data-bs-backdrop="static" id="addProductModal" tabindex="-1"
        aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addProductModalLabel">{{ __('app.add_product') }}</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="header-search">
                        <form style="max-width: 100% !important" class="w-full" role="search">
                            <input id="productSearch" class="form-control" type="search" placeholder="Search" autofocus
                                aria-label="Search">
                            <button><i class="lni lni-search-alt"></i></button>
                        </form>
                    </div>
                    <div id="product_container">
                        <div class="text-center p-4">
                            <i class="lni lni-keyword-research fs-1"></i>
                            <p>Search product</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" data-bs-backdrop="static" id="updateProductModal" tabindex="-1"
        aria-labelledby="updateProductModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateProductModalLabel">{{ __('app.edit_product') }}</h1>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="update_product_container">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('#billing_state, #shipping_state, #billing_city, #shipping_city').select2();
        $('#customer').select2({
            ajax: {
                url: "{{ route('admin.dashboard.get.all.users') }}",
                type: 'GET',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    let data = {
                        searchItem: params.term,
                        page: params.page || 1,
                        perPage: 10
                    }

                    return data;
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.data,
                        pagination: {
                            more: data.last_page != params.page
                        }
                    };
                },
                cache: true
            },
            placeholder: "{{ __('app.select_customer') }}",
            minimumInputLength: 1,
            templateResult: formatUser,
            templateSelection: formatUser
        });

        function accordionBackButton(button) {

            let $accordionItem = $(button).closest('.accordion-item');
            $accordionItem.prev().find('[data-bs-toggle="collapse"]').click();
        };

        function accordionNextButton(button) {
            let $accordionItem = $(button).closest('.accordion-item');
            $accordionItem.next().find('[data-bs-toggle="collapse"]').click();
        };

        function formatUser(user) {
            if (!user.id) {
                return user.text;
            }
            if (user.loading) {
                return user.text;
            }
            // if (user.loading)
            return $(
                `<span><img src="${user.image}" width="20" height="20" style="margin-right: 10px; border-radius: 50%;" /> ${user.fname} <small>${user.email}</small></span>`
            );
        }

        $(document).ready(function() {
            $("#is_gift").on('change', function() {
                const is_checked = $(this).is(':checked');
                $("#gift_information").toggleClass('d-none', !is_checked);
            });


            $('#is_gift_wrapping').on('click change', function() {
                const is_checked = $('#is_gift_wrapping').is(':checked');
                const giftWrapperCharge = "{{ getSetting('gift_wrapping_charge') }}";
                if (is_checked) {
                    $("#gift-wrapper-charge-wrapper").removeClass('d-none');
                    $("#gift_wrapper_charge").html(
                        `{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}${(+giftWrapperCharge).toFixed(2)}`
                    );
                    calculateTotalAmounts();
                } else {
                    $("#gift-wrapper-charge-wrapper").addClass('d-none');
                    $("#gift_wrapper_charge").text('');
                    calculateTotalAmounts();
                }
            });

            $('#same_as_billing_address').on('click change', toggleShippingFields);
            toggleShippingFields();


            let timeoutID = null;

            $('#productSearch').on('input', function(e) {
                clearTimeout(timeoutID);
                const keyword = e.target.value;

                timeoutID = setTimeout(() => {
                    if (keyword === '') {
                        $("#product_container").css('opacity', 0).slideDown("fast").animate({
                            opacity: 1
                        }, 500);

                        $("#product_container").html(`
                            <div class="text-center p-4">
                                <i class="lni lni-keyword-research fs-1"></i>
                                <p>Search product</p>
                            </div>
                        `);
                        return;
                    }

                    productSearch(keyword);
                }, 500);
            });

            loopProductItems();
            getStates();
        })

        function toggleShippingFields() {
            const is_checked = $('#same_as_billing_address').is(':checked');
            if (is_checked) {
                $('[name^="shipping_"]').each(function() {
                    $(this).prop('disabled', true).css('cursor', 'no-drop');
                });
                $('#shipping_details').addClass('d-none');
            } else {
                $('[name^="shipping_"]').each(function() {
                    $(this).prop('disabled', false).css('cursor', 'inherit');
                });
                $('#shipping_details').removeClass('d-none');
            }
        }

        function getStates() {
            let url = "{{ route('admin.settings.get.states', ':country_id') }}";
            url = url.replace(':country_id', {{ $country['id'] }});
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        $('#billing_state').append(
                            `<option value="${key}">${value}</option>`
                        );
                        $('#shipping_state').append(
                            `<option value="${key}">${value}</option>`
                        );
                    });
                }
            })
        }

        $('#billing_state').on('change', function() {
            if ($(this).val()) {
                $('#billing_city').empty();
                $('#billing_city').append(`<option value="">{{ __('app.select_city') }}</option>`);
                getCities($(this).val(), '#billing_city');
            }
        });


        $('#shipping_state').on('change', function() {
            if ($(this).val()) {
                $('#shipping_city').empty();
                $('#shipping_city').append(`<option value="">{{ __('app.select_city') }}</option>`);
                getCities($(this).val(), '#shipping_city');
            }
        });


        function getCities(state_id, city_select) {
            let url = "{{ route('admin.settings.get.cities', ':state_id') }}";
            url = url.replace(':state_id', state_id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $.each(response.data, function(key, value) {
                        $(city_select).append(
                            `<option value="${key}">${value}</option>`
                        );
                    });
                }
            })
        }


        $('#checkout_button').click(function(e) {
            console.log('what it is', e);
            e.preventDefault();

            const localStorageDiscountKeyName = `discountDetails`;
            const selected_discount = JSON.parse(localStorage.getItem(localStorageDiscountKeyName)) ?? {};

            const localStorageKeyName = `selected_products`;
            const selected_products = JSON.parse(localStorage.getItem(localStorageKeyName)) ?? [];

            // jsons
            const billing_data = {};
            $('#orderForm [name^="billing_"]').each(function() {
                switch (this.name) {
                    case 'billing_city':
                    case 'billing_state':
                        billing_data[this.name] = this.options[this.selectedIndex].value ? this.options[this
                            .selectedIndex].text : '';
                        break;
                    default:
                        billing_data[this.name] = this.value;
                        break;
                }
            });
            const billingJson = JSON.stringify(billing_data);

            let shipping_data = {};
            if ($('#same_as_billing_address').is(':checked')) {
                shipping_data = billing_data;
            } else {
                $('#orderForm [name^="shipping_"]').each(function() {
                    switch (this.name) {
                        case 'shipping_city':
                        case 'shipping_state':
                            shipping_data[this.name] = this.options[this.selectedIndex].value ? this
                                .options[this.selectedIndex].text : '';
                            break;
                        default:
                            shipping_data[this.name] = this.value;
                            break;
                    }
                });
            }
            const shippingJson = JSON.stringify(shipping_data);

            const gift_data = {};
            $('#gift_information [name^="gift_"]').each(function() {
                gift_data[this.name] = this.value;
            });
            const giftJson = JSON.stringify(gift_data);
            // end jsons

            let promo_code = null;
            if (Object.keys(selected_discount).length > 0) {
                promo_code = selected_discount.code;
            }
            const userId = $('#customer').val();
            const productsJson = JSON.stringify(selected_products);
            const paymentMethod = $('input[name="payment_method"]:checked').val();
            const onlinePaymentMethod = paymentMethod === 'online' ? $('input[name="online_payment_method"]:checked') : null;
            const deliveryDate = $('#delivery_date').val();
            const isGift = $('#is_gift').is(':checked') ? 1 : 0;
            const isGiftWrapping = $('#is_gift_wrapping').is(':checked') ? 1 : 0;
            const deliveryInstruction = $('#delivery_instruction').val();

            // Validation
            const billing_fields = [
                $("#billing_customer_name"),
                $("#billing_email"),
                $("#billing_phone"),
                $("#billing_street_address"),
                $("#billing_state"),
                $("#billing_country")
            ];


            const shipping_fields = $('#same_as_billing_address').is(':checked') ? [] : [
                $("#shipping_customer_name"),
                $("#shipping_email"),
                $("#shipping_phone"),
                $("#shipping_street_address"),
                $("#shipping_state"),
                $("#shipping_country")
            ];


            const other_fields = [
                $("input[name='payment_method']"),
                $("#delivery_date"),
                $("#customer"),
            ];

            if (paymentMethod === 'online') {
                other_fields.push($('input[name="online_payment_method"]'));
            }

            // button spinner animation
            const button = $('#checkout_button');

            let isError = false
            const fields = [...billing_fields, ...shipping_fields, ...other_fields];
            fields.forEach(field => {
                if (!validateRequest(field)) {
                    isError = true;
                }
            });
            if (productsJson === '[]') {
                $('#products_wrapper p.text-danger').remove();
                $('#products_wrapper').append(
                    '<p class="text-danger">Please add at least one product to order</p>');
                isError = true;
            }
            if (isError) {
                toastr.error('Please fill all required fields');
                return false;
            }

            $.ajax({
                type: "POST",
                url: "{{ url('api/v1/checkout') }}",
                // add auth:sanctum middleware
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{ auth()->user()->createToken('API Token')->plainTextToken }}'
                },
                data: {
                    'products': productsJson,
                    'shipping_address': shippingJson,
                    'billing_address': billingJson,
                    'payment_method': paymentMethod,
                    'online_payment_method': onlinePaymentMethod ? onlinePaymentMethod.val() : null,
                    'delivery_date': deliveryDate,
                    'is_gift': isGift,
                    'is_gift_wrapping': isGiftWrapping,
                    'gift': giftJson,
                    'delivery_instruction': deliveryInstruction,
                    'is_admin': true,
                    'user_id': userId,
                    'promo_code': promo_code,
                },
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    if (res.success) {
                        console.log(res.data);
                        localStorage.removeItem(localStorageKeyName);
                        localStorage.removeItem(localStorageDiscountKeyName);
                        loopProductItems();
                        toastr.success(res.message);
                        if (res.data.url) {
                            window.location.href = res.data.url;
                        } else {
                            window.location.href = "{{ route('admin.orders.show', ':id') }}".replace(':id', res.data?.order_id);
                        }
                    } else {
                        console.log(res);
                        toastr.error(res.message);
                    }
                },
                error: function(res) {
                    console.log(res);
                }
            })
        })

        $('#addProductModal').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        })

        $("#addProductModal .close").click(function() {
            setTimeout(() => {
                $("#productSearch").val('');
                $("#product_container").html(`
                    <div class="text-center p-4">
                            <i class="lni lni-keyword-research fs-1"></i>
                            <p>Search product</p>
                    </div>
                `);
            }, 1000);
        })

        function selectProduct(button, product_id, title, slug, thumbnail, price, tax) {

            const quantity = $(`#quantity_${product_id}`)[0].value;
            if (quantity < 0 || isNaN(quantity) || quantity == '') {
                toastr.error("Please add atleast one quantity");
                return;
            }


            const attrWrapper = $(`#attribute_wrapper_${product_id}`);
            // get selected attributes
            let selectedAttr = [];
            for (let i = 0; i < attrWrapper[0].children.length; i++) {
                let perAttribute = attrWrapper[0].children[i];
                let checkedInputs = perAttribute.querySelectorAll('input[type="radio"]:checked');
                if (checkedInputs.length == 0) {
                    let selectedAttr = [];
                    toastr.error("Please select an option for each attribute");
                    return;
                }
                selectedAttr.push({
                    'id': checkedInputs[0].dataset.attribute_id,
                    'key': checkedInputs[0].dataset.attribute_key,
                    'name': checkedInputs[0].dataset.attribute_name,
                    'value': checkedInputs[0].value,
                    'code': checkedInputs[0].dataset.code,
                });
                // console.log(ccheckedInputs[0].value.value, checkedInputs[0].dataset.code);
            }


            // let stock = 0;
            // $.ajax({
            //     url: `{{ route('admin.products.check.stock', ':slug') }}`.replace(':slug', slug),
            //     type: 'GET',
            //     async: false,
            //     success: function(res) {
            //         stock = res.data;
            //     }
            // })

            // if (stock < 1) {
            //     toastr.error("Product out of stock");
            //     return;
            // }

            $(`#select_button_${product_id}`).prepend(`
                <div class="spinner-border spinner-border-sm text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `);

            $(`#select_button_${product_id}`).attr('disabled', true);


            let product = {
                'id': product_id,
                'quantity': quantity,
                'attributes': selectedAttr,
                'title': title,
                'slug': slug,
                'thumbnail': thumbnail,
                'price': (price * quantity),
                'tax': tax
            };


            setTimeout(() => {
                const localStorageKeyName = `selected_products`;
                const selected_products = JSON.parse(localStorage.getItem(localStorageKeyName)) ?? [];

                if (selected_products != null && selected_products.length > 0) {
                    for (let i = 0; i < selected_products.length; i++) {
                        const selectedProduct = selected_products[i];
                        if (selectedProduct.id === product.id) {
                            $('.spinner-border', `#select_button_${product_id}`).remove();
                            $(`#select_button_${product_id}`).after(
                                `<span style="font-size: 13px;" id="already_exist_${product_id}" class="text-danger">{{ __('app.this_product_is_already_in_list') }}</span>`
                            );
                            $(`#select_button_${product_id}`).prop('disabled', false);

                            return false;
                        }
                    }
                    selected_products.push(product);
                } else {
                    selected_products.push(product);
                }

                localStorage.setItem(localStorageKeyName, JSON.stringify(selected_products));
                $('.spinner-border', `#select_button_${product_id}`).remove();
                $(`#select_button_${product_id}`)
                    .removeClass('primary-btn')
                    .addClass('success-btn')
                    .css('cursor', 'no-drop')
                    .text('Selected');

                loopProductItems();

            }, 1000);

        }

        function loopProductItems() {
            const localStorageKeyName = `selected_products`;
            const products = JSON.parse(localStorage.getItem(localStorageKeyName)) ?? [];
            if (products.length > 0) {
                $("#products_wrapper").empty();
                products.forEach(product => {

                    let url = "{{ url('api/v1/products/:slug') }}";
                    url = url.replace(':slug', product.slug);

                    let product_details = [];
                    $.ajax({
                        type: "GET",
                        url: url,
                        async: false,
                        success: function(res) {
                            product_details = res.data;
                        }
                    })

                    $("#products_wrapper").append(`
                    <div class="p-2 shadow-sm rounded d-flex justify-content-between align-items-center products_wrapper_${product['id']}">
                            <div class="d-flex gap-3 my-3">
                                    <div class="d-flex justify-content-center align-items-center p-2 rounded border shadow-sm" style="width: 75px; height: 75px; position: relative;">
                                        <img src="${product['thumbnail']}" class="img-fluid" style="object-fit: cover; object-position: center center;" alt="placeholder">
                                        <span class="badge bg-secondary rounded-pill position-absolute top-0 start-100 translate-middle" style="transform: translate(50%, -50%)">${product['quantity']}</span>
                                    </div>
                                <div>
                                    <p class="fw-bold">${product['title']}</p>
                                    <p class="fw-semibold" style="font-size: 0.8rem; line-height: 2;">
                                        ${(product_details.discount > 0) ? `<del class="text-muted" style="color: grey !important;"> {{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}${ product_details.price.toFixed(2) }</del>
                                        ` : ''}
                                        {{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}${(product['price'] / product['quantity']).toFixed(2)}
                                    </p>

                                    <div id="product_item_attribute_${product['id']}">
                                    </div>

                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn text-primary px-1" onclick="updateProductSearch(${product['id']})">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <button type="button" class="btn text-danger px-1" onclick="removeProduct(${product['id']})">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>

                        </div>
                    `);

                    product['attributes'].forEach(productAttribute => {
                        if (productAttribute['key'] ==
                            `{{ \App\Models\ProductAttribute::ATTRIBUTE_TYPE['color'] }}`) {
                            $("#product_item_attribute_" + product['id']).append(`
                                <p class="d-flex align-items-center gap-1" style="font-size: 0.8rem; line-height: 1.5;">
                                    <span>${productAttribute['name']}: </span>
                                    <i style="width: 15px; height: 15px; border-radius: 50%; outline: 1px solid grey; background-color: ${productAttribute['code']}"></i>
                                </p>
                            `);
                        } else {
                            $("#product_item_attribute_" + product['id']).append(`
                                <p style="font-size: 0.8rem; line-height: 1.5;">
                                    <span>${productAttribute['name']}: </span>
                                    <span>${productAttribute['value']}</span>
                                </p>
                            `);
                        }
                    })
                });
            } else {
                $("#products_wrapper").html(`
                    <div class="text-center p-4">
                        <i class="mdi mdi-view-grid-plus fs-1"></i>
                        <p>Add products to your order</p>
                    </div>
                `);
            }

            $("#total_selected_item").html(products.length ?? 0)
            calculateTotalAmounts();
        }

        function productSearch(keyword) {

            const data = {
                'keyword': keyword,
                'is_admin': true,
            };

            const url = "{{ url('/api/v1/product/search') }}/?" + $.param(data);

            $.get(url, function(response) {
                if (response.success) {
                    productLoop(response.data);
                }
            })
        }

        function productLoop(products) {
            $("#product_container").empty();
            if (products.length == 0) {
                $("#product_container").css('opacity', 0).slideDown("fast").animate({
                    opacity: 1
                }, 500);
                $("#product_container").append(`
                    <div class="text-center p-4">
                        <i class="lni lni-shopping-basket fs-1 text-danger"></i>
                        <h4 class="pb-1">No products found</h4>
                        <p>Your search did not match any products</p>
                    </div>
                `)
            } else {
                products.forEach((product, index) => {
                    let price;
                    if (product.discount > 0) {
                        if (product.discount_type == "FIXED") {
                            price = product.price - product.discount;
                        } else {
                            price = product.price - (product.price * product.discount) / 100;
                        }
                    } else {
                        price = product.price;
                    }

                    const tax = product.tax?.rate ?? 0;

                    let buildProductHtml = `
                        <div class="card mt-3" id="product_card_${product.id}" style="opacity: 0;">
                            <div class="card-body d-flex gap-2 align-items-center">
                                <div>
                                    <img style="height: 100px; width: 100px; object-fit: cover;"
                                        src="${product.thumbnail}" alt="product_thumbnail">
                                </div>
                                <div class="flex-fill align-self-start">
                                    <h5 class="card-title">${product.title}</h5>
                                    <div class="d-flex gap-1 align-items-center">
                                        <i style="font-size: 12px" class="fas fa-star text-warning"></i>
                                        <i style="font-size: 12px" class="fas fa-star text-warning"></i>
                                        <i style="font-size: 12px" class="fas fa-star text-warning"></i>
                                        <i style="font-size: 12px" class="fa-solid fa-star-half-stroke text-warning"></i>
                                        <i style="font-size: 12px" class="far fa-star text-warning"></i>
                                    </div>
                                    <p class="mt-1">
                                        ${(product.discount > 0) ? `<del class="text-muted" style="font-size: 0.8rem; vertical-align: middle;">{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}${(product.price).toFixed(2)}</del>` : ''}
                                        {{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}${(price).toFixed(2)}
                                    </p>
                                    <p class="mt-2" style="font-size: 14px">
                                        ${product.short_description.length > 30 ? product.short_description.substring(0,30) + '...' : product.short_description}
                                    </p>
                                </div>
                                <div>
                                    <a data-bs-toggle="collapse" href="#collapse_${product.id}" role="button" aria-expanded="false" aria-controls="collapse_${product.id}">
                                        <i class="mdi mdi-plus-box fs-2"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body pt-0 collapse row" id="collapse_${product.id}">
                                <div class="col-md-12">
                                    <div class="row" id="attribute_wrapper_${product.id}"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <p>
                                        Stock:
                                        ${product.stock > 0 ?
                                            `<span class="${product.stock > `{{ getSetting(\App\Models\Settings::LOW_STOCK) }}` ? 'text-success' : 'text-danger' }">${product.stock}</span>` :
                                            `<span class="text-danger">Out of stock</span>`
                                        }
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <div class="input-group" style="width: 165px">
                                        <button class="main-btn btn-hover btn-sm" type="button" onclick="decreaseQuantity(${product.id})" id="button-decrease-quantity">-</button>
                                        <input type="text" class="form-control" id="quantity_${product.id}" oninput="updateQuantity(${product.id}, ${product.stock})" placeholder="" value="1">
                                        <button class="main-btn btn-hover btn-sm" type="button" onclick="increaseQuantity(${product.id}, ${product.stock})" id="button-increase-quantity">+</button>
                                    </div>
                                </div>

                                <div class="col-md-6 align-self-end">
                                    <button type="button" class="main-btn primary-btn btn-hover btn-sm d-block" id="select_button_${product.id}" onclick="selectProduct(this, ${product.id}, '${product.title}', '${product.slug}', '${product.thumbnail}', ${price}, ${tax})">Select</button>
                                </div>
                            </div>
                        </div>
                    `;
                    // console.log(product.tax?.rate > 0 ? price + (price * product.tax?.rate) / 100 : price);

                    $("#product_container").append(buildProductHtml);
                    $("#product_card_" + product.id).delay(index * 50).animate({
                        opacity: 1,
                    }, 500);

                    if (product.attributes.length > 0) {
                        product.attributes.forEach(attribute => {
                            let buildAttributeHtml = `
                                <div class="col-md-6 mb-3">
                                    <label for="${attribute.name}_${attribute.id}" class="form-label">Select ${attribute.name}</label>
                                    <div class="d-flex flex-wrap gap-2 align-items-center" role="group" id="item_group_${attribute.name}_${attribute.id}" aria-label="Basic radio toggle button group">
                                    </div>
                                </div>
                            `;
                            $(`#attribute_wrapper_${product.id}`).prepend(buildAttributeHtml);

                            if (attribute.type ==
                                "{{ \App\Models\ProductAttribute::ATTRIBUTE_TYPE['color'] }}") {
                                attribute.items.forEach(item => {
                                    let buildAttributeItemHtml = `
                                        <style>
                                            input[name="${attribute.name}_${attribute.id}"]:checked+label {
                                                width: 20px !important;
                                                height: 20px !important;
                                                outline: 2px solid #0d6efd;
                                                outline-offset: 2px;
                                            }
                                        </style>
                                        <input type="radio" data-code="${item.code}" data-attribute_key="${attribute.type}" data-attribute_id="${attribute.id}" data-attribute_name="${attribute.name}" value="${item.name}" class="btn-check" name="${attribute.name}_${attribute.id}" id="${item.id}" autocomplete="off">
                                        <label style="width: 25px; height: 25px; background:${item.code}; cursor: pointer;" class="rounded-full p-0" for="${item.id}"></label>
                                    `;
                                    $(`#item_group_${attribute.name}_${attribute.id}`).prepend(
                                        buildAttributeItemHtml);
                                })
                            } else {
                                attribute.items.forEach(item => {
                                    let buildAttributeItemHtml = `
                                        <input type="radio" data-code="${item.code}" data-attribute_key="${attribute.type}" data-attribute_id="${attribute.id}" data-attribute_name="${attribute.name}" value="${item.name}" class="btn-check" name="${attribute.name}_${attribute.id}" id="${item.id}" autocomplete="off">
                                        <label class="btn btn-outline-primary btn-sm" for="${item.id}">${item.name}</label>
                                    `;
                                    $(`#item_group_${attribute.name}_${attribute.id}`).prepend(
                                        buildAttributeItemHtml);
                                })
                            }
                        })
                    }
                });
            }
        }



        function decreaseQuantity(product_id) {
            let quantity = parseInt($(`#quantity_${product_id}`).val());
            if (quantity > 1) {
                $(`#quantity_${product_id}`).val(quantity - 1);
            }
        }

        function increaseQuantity(product_id, stock) {
            let quantity = parseInt($(`#quantity_${product_id}`).val());

            if (quantity == '' || quantity == null || isNaN(quantity)) {
                $(`#quantity_${product_id}`).val(0);
                quantity = 0;
            }

            if (quantity < stock) {
                $(`#quantity_${product_id}`).val(quantity + 1);
            }
        }

        function updateQuantity(product_id, stock) {
            let quantity = parseInt($(`#quantity_${product_id}`).val());

            if (quantity < 1) {
                $(`#quantity_${product_id}`).val(1);
            } else if (quantity > stock) {
                $(`#quantity_${product_id}`).val(stock);
            }
            console.log(quantity);
        }

        function removeProduct(product_id) {

            // set loader to the html
            $(`.products_wrapper_${product_id}`).css('opacity', '50%');
            $(`.products_wrapper_${product_id}`).find('button').prop('disabled', true).css('cursor', 'no-drop');


            const localStorageKeyName = `selected_products`;
            const selected_products = JSON.parse(localStorage.getItem(localStorageKeyName)) ?? [];
            const newSelectedProducts = selected_products.filter(product => product.id != product_id);
            localStorage.setItem(localStorageKeyName, JSON.stringify(newSelectedProducts));
            setTimeout(() => {
                loopProductItems();
            }, 1000);
        }

        function updateProductSearch(product_id) {
            $(`#updateProductModal`).modal('show');
            const localStorageKeyName = `selected_products`;
            const selected_products = JSON.parse(localStorage.getItem(localStorageKeyName)) ?? [];
            const selected_product = selected_products.find(product => product.id === product_id);

            let url = "{{ url('api/v1/products/:slug') }}";
            url = url.replace(':slug', selected_product['slug']);

            $.ajax({
                type: "GET",
                url: url,
                success: function(res) {
                    const product_details = res.data;
                    updateProduct(product_details, selected_product)
                }
            })
        }

        function updateProduct(product_details, selected_product) {
            let product_id = selected_product['id'];
            let price;
            if (product_details.discount > 0) {
                if (product_details.discount_type == "FIXED") {
                    // discount = product_details.discount;
                    price = product_details.price - product_details.discount;
                } else {
                    // discount = (product_details.price * product_details.discount) / 100;
                    price = product_details.price - (product_details.price * product_details.discount) / 100;
                }
            } else {
                price = product_details.price;
            }
            $(`#update_product_container`).html(`
                <div class="card-style" id="update_product_card_${product_id}">
                    <div class="card-body d-flex gap-2 align-items-center">
                        <div>
                            <img style="height: 75px; width: 75px; object-fit: cover;" src="${selected_product['thumbnail']}" alt="product_thumbnail">
                        </div>
                        <div class="flex-fill align-self-start">
                            <h5 class="card-title">${selected_product['title']}</h5>
                            <div class="d-flex gap-1 align-items-center mt-2">
                                <i style="font-size: 12px" class="fas fa-star text-warning"></i>
                                <i style="font-size: 12px" class="fas fa-star text-warning"></i>
                                <i style="font-size: 12px" class="fas fa-star text-warning"></i>
                                <i style="font-size: 12px" class="fa-solid fa-star-half-stroke text-warning"></i>
                                <i style="font-size: 12px" class="far fa-star text-warning"></i>
                            </div>
                            <p class="mt-1">
                                ${(product_details.discount > 0) ? `<del class="text-muted" style="font-size: 0.8rem; vertical-align: middle;"> {{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}${ product_details.price.toFixed(2) }</del>` : ''}
                                {{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}${(selected_product['price'] / selected_product['quantity']).toFixed(2)}


                            </p>
                        </div>
                    </div>
                    <div class="card-body mt-3 row">
                        <div class="col-md-12">
                            <div class="row" id="update_product_attribute_wrapper_${product_id}">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p>
                                Stock:
                                ${product_details.stock > `{{ getSetting(\App\Models\Settings::LOW_STOCK) }}` ?
                                    `<span class="text-success">${product_details.stock}</span>` :
                                    `<span class="text-danger">${product_details.stock}</span>`
                                }
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <div class="input-group" style="width: 165px">
                                <button class="main-btn btn-hover btn-sm" type="button" onclick="decreaseQuantity(${product_id})" id="button-decrease-quantity">-</button>
                                <input type="text" class="form-control" id="quantity_${product_id}" oninput="updateQuantity(${product_id}, ${product_details.stock})" placeholder="quantity" value="${selected_product['quantity']}" >
                                <button class="main-btn btn-hover btn-sm" type="button" onclick="increaseQuantity(${product_id}, ${product_details.stock})" id="button-increase-quantity">+</button>
                            </div>
                        </div>
                        <div class="col-md-6 align-self-end">
                            <button type="button" class="main-btn primary-btn btn-hover btn-sm d-block" onclick="updateProductSubmit(this, ${product_id}, '${product_details.title}', '${product_details.slug}', '${product_details.thumbnail}', '${price}')">Update</button>
                        </div>
                    </div>
                </div>
            `);

            if (product_details.attributes.length > 0) {
                product_details.attributes.forEach(attribute => {
                    // console.log(attribute);
                    let buildAttributeHtml = `
                        <div class="col-md-6 mb-3">
                            <label for="${attribute.name}_${attribute.id}" class="form-label">Select ${attribute.name}</label>
                            <div class="d-flex flex-wrap gap-2 align-items-center" role="group" id="item_group_${attribute.name}_${attribute.id}" aria-label="Basic radio toggle button group">
                            </div>
                        </div>
                    `;
                    $(`#update_product_attribute_wrapper_${product_id}`).append(buildAttributeHtml);

                    attribute.items.forEach(item => {
                        if (attribute.type ==
                            "{{ \App\Models\ProductAttribute::ATTRIBUTE_TYPE['color'] }}") {
                            let buildAttributeItemHtml = `
                                <style>
                                    input[name="${attribute.name}_${attribute.id}"]:checked+label {
                                        width: 20px !important;
                                        height: 20px !important;
                                        outline: 2px solid #0d6efd;
                                        outline-offset: 2px;
                                    }
                                </style>
                                <input type="radio" data-code="${item.code}" data-attribute_key="${attribute.type}" data-attribute_id="${attribute.id}" data-attribute_name="${attribute.name}" value="${item.name}" class="btn-check" name="${attribute.name}_${attribute.id}" id="${item.id}" autocomplete="off">
                                <label style="width: 25px; height: 25px; background:${item.code}; cursor: pointer;" class="rounded-full p-0" for="${item.id}"></label>
                            `;
                            $(`#item_group_${attribute.name}_${attribute.id}`).append(
                                buildAttributeItemHtml);
                        } else {
                            let buildAttributeItemHtml = `
                                <input type="radio" data-code="${item.code}" data-attribute_key="${attribute.type}" data-attribute_id="${attribute.id}" data-attribute_name="${attribute.name}" value="${item.name}" class="btn-check" name="${attribute.name}_${attribute.id}" id="${item.id}" autocomplete="off">
                                <label class="btn btn-outline-primary btn-sm" for="${item.id}">${item.name}</label>
                            `;
                            $(`#item_group_${attribute.name}_${attribute.id}`).append(
                                buildAttributeItemHtml);
                        }
                    });

                    if (selected_product['attributes'].length > 0) {
                        selected_product['attributes'].forEach(selected_attribute => {
                            // console.log(selected_attribute);
                            if (selected_attribute.id == attribute.id) {
                                $(`#item_group_${attribute.name}_${attribute.id} input[type="radio"][value="${selected_attribute.value}"]`)
                                    .prop('checked', true);
                            }
                        });
                    }
                });
            }
        }

        function updateProductSubmit(button, product_id, title, slug, thumbnail, price) {
            const quantity = $(`#quantity_${product_id}`).val();
            if (quantity < 0 || isNaN(quantity) || quantity == '') {
                toastr.error("Please add atleast one quantity");
                return;
            }

            const attrWrapper = $(`#update_product_attribute_wrapper_${product_id}`);

            // get selected attributes
            let selectedAttr = [];
            for (let i = 0; i < attrWrapper[0].children.length; i++) {
                let perAttribute = attrWrapper[0].children[i];
                let checkedInputs = perAttribute.querySelectorAll('input[type="radio"]:checked');
                if (checkedInputs.length == 0) {
                    let selectedAttr = [];
                    toastr.error("Please select an option for each attribute");
                    return;
                }
                selectedAttr.push({
                    'id': checkedInputs[0].dataset.attribute_id,
                    'key': checkedInputs[0].dataset.attribute_key,
                    'name': checkedInputs[0].dataset.attribute_name,
                    'value': checkedInputs[0].value,
                    'code': checkedInputs[0].dataset.code,
                });
                // console.log(ccheckedInputs[0].value.value, checkedInputs[0].dataset.code);
            }

            $(button).prepend(`
                <div class="spinner-border spinner-border-sm text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            `);

            $(button).attr('disabled', true);

            const updated_data = {
                'product_id': product_id,
                'quantity': quantity,
                'attributes': selectedAttr,
                'title': title,
                'slug': slug,
                'thumbnail': thumbnail,
                'price': (price * quantity),
            };

            setTimeout(() => {
                const localStorageKeyName = `selected_products`;
                const selected_products = JSON.parse(localStorage.getItem(localStorageKeyName)) ?? [];
                const index = selected_products.findIndex(product => product.id === product_id);
                if (index !== -1) {
                    selected_products[index] = {
                        ...selected_products[index],
                        ...updated_data
                    };
                    localStorage.setItem(localStorageKeyName, JSON.stringify(selected_products));
                }

                // $(`#updateProductModal`).modal('hide');

                loopProductItems();

                $('.spinner-border', button).remove();
                $(button).removeClass('primary-btn').addClass('success-btn').text('Updated');

            }, 1000);

            setTimeout(() => {
                $(button).addClass('primary-btn').removeClass('success-btn').text('Update').attr('disabled', false);
            }, 2000);

        }

        function calculateTotalAmounts() {
            console.log('calculate');
            const localStorageKeyName = `selected_products`;
            const products = JSON.parse(localStorage.getItem(localStorageKeyName)) ?? [];

            const localStorageDiscountKeyName = `discountDetails`;
            if (products.length == 0) {
                localStorage.removeItem(localStorageDiscountKeyName);
            }
            const discountDetails = JSON.parse(localStorage.getItem(localStorageDiscountKeyName)) ?? {};

            let discount_type, discount = 0;
            if (Object.keys(discountDetails).length > 0) {
                discount_type = discountDetails['discount_type'];
                discount = discountDetails['discount'];
                $('#promo').val(discountDetails['code']);
                $(apply_promo_button).addClass('success-btn').removeClass('primary-btn').text('Applied');
                $('#promo_message').next().remove();
                $("#promo_message").html(
                    `<span class="fw-bold">${discountDetails['code']}</span> Promo applied successfully!`);
                $('#promo_message').after(
                    '<button type="button" class="btn text-danger px-1" onclick="removePromo(\'Promo removed successfully!\')"><i class="fa-regular fa-circle-xmark"></i></button>'
                );
            } else {
                $('#promo').val('');
                $(apply_promo_button).addClass('primary-btn').removeClass('success-btn').text('Apply');
                $("#promo_message").text('');
                $('#promo_message').next().remove();
            }

            let tax = 0;
            let subtotal = 0;
            let service_charge = 0;
            let shipping_charge = 0;
            if (products.length > 0) {
                service_charge = parseFloat("{{ getSetting('service_charge') ?? 0 }}");
                shipping_charge += parseFloat(`{{ getSetting('shipping_charge') ?? 0 }}`);
            }
            let giftWrapperCharge = 0;

            if ($('#is_gift_wrapping').is(':checked')) {
                giftWrapperCharge = parseFloat("{{ getSetting('gift_wrapping_charge') ?? 0 }}");
            }

            products.forEach(product => {
                let url = "{{ route('admin.products.tax.get', ':slug') }}";
                url = url.replace(':slug', product['slug']);
                $.ajax({
                    type: "GET",
                    url: url,
                    async: false,
                    success: function(res) {
                        tax += (product.price) * (parseFloat(res.data.rate) / 100);
                    },
                    error: function(res) {
                        console.log(res);
                    }
                })

                subtotal += product?.price ?? 0;
            })

            if (discount_type == "PERCENTAGE") {
                discount = (subtotal * discount) / 100;
            }


            let grand_total = ((subtotal - discount) + shipping_charge + service_charge + tax + giftWrapperCharge).toFixed(
                2);

            subtotal = subtotal.toFixed(2);
            shipping_charge = shipping_charge.toFixed(2);
            tax = tax.toFixed(2);
            service_charge = service_charge.toFixed(2);
            discount = discount.toFixed(2);

            $("#subtotal").html(
                `{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}<span id="subtotal_text">${subtotal}</span>`);
            $("#shipping_charge").html(
                `{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}<span id="shipping_charge_text">${shipping_charge}</span>`
            );
            $("#tax").html(`{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}<span id="tax_text">${tax}</span>`);
            $("#service_charge").html(
                `{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}<span id="service_charge_text">${service_charge}</span>`
            );
            $("#discount").html(
                    `${discount > 0 ? '-' : ''}{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}<span id="discount_text">${discount}</span>`
                )
                .toggleClass('text-danger', discount > 0);
            $("#grand_total").html(
                `{{ getSetting(\App\Models\Settings::CURRENCY_SYMBOL) }}<span id="grand_total_text">${grand_total}</span>`
            );
        }

        function searchPromo(btn) {
            // if doesn't have any product in localstorage give an error
            const localStorageKeyName = `selected_products`;
            const selected_products = JSON.parse(localStorage.getItem(localStorageKeyName)) ?? [];

            if (selected_products.length == 0) {
                toastr.error("Please add products first");
                return;
            }

            let promo = $("input[name='promo']").val();
            console.log(promo);

            if (promo == "") {
                toastr.error("Please enter promo code");
                return;
            }

            let url = "{{ url('api/v1/promos/:code') }}";
            url = url.replace(':code', promo);

            $.ajax({
                url: url,
                type: "GET",
                success: function(res) {
                    if (res.success) {
                        const discountDetails = res.data;
                        applyPromo(discountDetails, btn);
                    } else {
                        removePromo(res.message);
                        // $("#promo_message").text(res.message);

                    }
                },
                error: function(res) {
                    console.log(res);
                }
            });
        }

        function applyPromo(discountDetails, btn) {
            const localStorageKeyName = `discountDetails`;
            setTimeout(() => {
                localStorage.setItem(localStorageKeyName, JSON.stringify(discountDetails));
                calculateTotalAmounts();
                $(btn).addClass('success-btn').removeClass('primary-btn').text('Applied');
                $("#promo_message").html(
                    `<span class="fw-bold">${discountDetails.code}</span> Promo applied successfully!`);
            }, 500);
        }

        function removePromo(message) {
            const localStorageKeyName = `discountDetails`;
            localStorage.removeItem(localStorageKeyName);
            calculateTotalAmounts();
            $("#promo_message").text(message);
        }

        function validateRequest(field_name) {
            let name = $(field_name).attr('name');
            name = name.replace(/_/g, ' ');
            if ($(field_name).val() === '') {
                $(field_name).css('border', '1px solid red');
                $(field_name).next('p').remove();
                $(field_name).after(`<p class="form-text text-danger">Please enter ${name} field</p>`);
                return false;
            } else {
                $(field_name).css('border', '1px solid #e5e5e5');
                $(field_name).next('p').remove();
                return true;
            }
        }
    </script>
@endpush

@push('css')
    <style>
        #orderSteps .accordion-button:focus {
            outline: none;
            box-shadow: none;
        }

        #orderSteps .accordion-button {
            border: none;
            font-weight: 600;
        }

        /* #orderSteps .accordion-button:not(.collapsed) {
                    background-color: transparent;
                } */
        #orderSteps .accordion-item {
            background: #fff;
            color: inherit;
        }
    </style>
@endpush
