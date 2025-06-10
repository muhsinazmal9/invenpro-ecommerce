<div class="col-md-12">
    <div class="d-flex align-items-center payment-method-container flex-wrap gap-3 justify-content-between">
        <div class="form-check payment-method-option">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_cod" value="cod"
                {{ old('payment_method') == 'cod' || !old('payment_method') ? 'checked' : '' }}>
            <label class="form-check-label" for="payment_method_cod">
                {{ 'Cash On Delivery' }}
            </label>
        </div>
        <div class="form-check payment-method-option">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_method_online"
                value="online" {{ old('payment_method') == 'online' ? 'checked' : '' }}>
            <label class="form-check-label" for="payment_method_online">
                {{ 'Online' }}
            </label>
        </div>
        <div id="online_payment_options" style="display: none" class="flex-grow-1">
            <div class="d-flex align-items-center gap-3">
                <div class="form-check d-flex align-items-center gap-2">
                    <input class="form-check-input" type="radio" name="online_payment_method" id="online_payment_method_stripe" value="stripe" checked>
                    <label class="form-check-label" for="online_payment_method_stripe">
                        <img src="{{ asset('assets/backend/images/logo/stripe-logo.svg') }}" alt="Stripe-logo" width="100">
                    </label>
                </div>
                <div class="form-check d-flex align-items-center gap-2">
                    <input class="form-check-input" type="radio" name="online_payment_method" id="online_payment_method_paypal" value="paypal">
                    <label class="form-check-label" for="online_payment_method_paypal">
                        <img src="{{ asset('assets/backend/images/logo/paypal-logo.svg') }}" alt="Paypal-logo" width="100">
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
@push('css')
    <style>
        .payment-method-option {
            position: relative;
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-grow: 1;
            text-align: center;
        }

        .payment-method-option .form-check-input {
            display: none;
        }

        .payment-method-option .form-check-label {
            display: block;
            margin: 0;
            cursor: pointer;
            font-weight: bold;
        }

        .payment-method-option.active {
            border-color: #007bff;
            background-color: #e7f1ff;
        }

        .payment-method-option.active .form-check-label {
            color: #007bff;
        }

        .payment-method-option.active:hover {
            background-color: inherit;
        }

        .payment-method-option:hover {
            background-color: #f5f5f5;
        }
    </style>
@endpush



@push('script')
    <script>
        $(document).ready(function() {
            $('.payment-method-option').on('click', function() {
                $('.payment-method-option').removeClass('active');
                $(this).addClass('active');
                $(this).find('input[type="radio"]').prop('checked', true);
            });

            // Initialize the active state based on the checked radio button
            $('.payment-method-option input[type="radio"]:checked').each(function() {
                $(this).closest('.payment-method-option').addClass('active');
            });

            updatePaymentMethod();
            $('.payment-method-option').on('change click', function() {
                updatePaymentMethod();
            })
        });

        function updatePaymentMethod() {
            const paymentMethod = $('input[name="payment_method"]:checked').val();
            if (paymentMethod == 'online') {
                $('#online_payment_options').show();
            } else {
                $('#online_payment_options').hide();
            }
        }
    </script>
@endpush
