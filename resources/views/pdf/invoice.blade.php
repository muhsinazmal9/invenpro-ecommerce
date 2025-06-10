<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Invoice - {{ $order->invoice_id }}</title>


    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 40px;
        }

        .invoice-wrapper {
            max-width: 1080px;
            margin: 0 auto;
            padding: 10px;
        }

        .w-100 {
            width: 100%;
        }

        #data tr.border {
            border: 1px solid #e5e3e357;
        }

        td {
            vertical-align: top;
        }

        #bottom {
            background: #e1e1e1ad;
            border-radius: 5px;
            padding: 20px 5px;
        }
    </style>

</head>

<body>
    <div class="invoice-wrapper">
        <section id="heading">
            <table class="w-100">
                <tr>
                    <td>
                        <h1 style="font-size: 3rem;">INVOICE</h1>
                        <br>
                        <p>
                            <span>{{ getSetting('site_title') }}</span><br>
                            @if (getSetting('email'))
                                <span><a href="mailto:{{ getSetting('email') }}">{{ getSetting('email') }}</a></span><br>
                            @endif
                            @if (getSetting('phone_1'))
                            <span><a
                                    href="tel:{{ getSetting('default_phone_code') . getSetting('phone_1') }}">{{ getSetting('default_phone_code') . getSetting('phone_1') }}</a></span><br>

                            @endif
                            @if (getSetting('frontend_url'))
                                <span><a href="{{ getSetting('frontend_url') }}">{{ getSetting('frontend_url') }}</a></span><br>
                            @endif
                            @if (getSetting('address'))
                                <span>{{ getSetting('address') }}</span>
                            @endif
                        </p>

                    </td>
                    <td style="text-align: right">
                        <img style="max-width: 110px" src="{{ public_path(getSetting('primary_logo')) }}"
                            alt="">
                                <p style="margin-top: 16px">
                                    <strong>Invoice No: </strong> #{{ $order->invoice_id }}<br>
                                    <strong>Invoice Date:</strong> {{ $order->created_at->format('d/M/Y') }}<br>
                                </p>
                    </td>
                </tr>
            </table>
        </section>
        <br>
        <br>
        <hr>
        <br>
        <section id="details">
            <table class="w-100" style="padding:0 15px 0 15px">
                <tr>
                    <td style="display:inline-block;" width="50%">
                        <h3>Bill to</h3>
                          @php
                            $shipping_address = json_decode($order->shipping_address, true);
                            $billing_address = json_decode($order->billing_address, true);
                          @endphp
                           @if(is_array($billing_address) || is_object($billing_address))
                            @forelse ($billing_address as $key => $value)

                            @php
                            $key = str_replace(['shipping_', 'billing_'], '', $key);
                            @endphp

                            <p class="my-2 border-bottom pb-2">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</p>
                            @empty
                            <p>{{ __('app.no_address') }}</p>
                            @endforelse
                            @endif

                    </td>
                    <td style="display:inline-block " width="50%">
                        <h3>Ship to</h3>
                        @if(is_array($shipping_address) || is_object($shipping_address))
                        @forelse ($shipping_address as $key => $value)

                        @php
                        $key = str_replace(['shipping_', 'billing_'], '', $key);
                        @endphp

                        <p class="my-2 border-bottom pb-2">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</p>
                        @empty
                        <p>{{ __('app.no_address') }}</p>
                        @endforelse
                        @endif
                    </td>
                </tr>
            </table>
        </section>
        <br>
        <br>
        <section id="data">
            <table class="w-100" style="padding: 5px; border-collapse: collapse;">
                <tr style="background:#bfb9b940">
                    <th style="text-align: left;padding:8px">Product Title</th>
                    <th style="padding:8px">Variation</th>
                    <th style="padding:8px">Quantity</th>
                    <th style="padding:8px">Item Price</th>
                    <th style="text-align: center;padding:8px">Amout</th>
                </tr>
                @foreach ($order->products as $product)
                    @php
                        $productData = json_decode($product->product_json, true);
                    @endphp

                    <tr class="border">
                        <td style="text-align: left;padding:8px">{{ $productData['title'] }}</td>
                        <td style="text-align: center;padding:8px">
                            @foreach (json_decode($product->meta) as $key => $item)
                                {{ $item->value }}
                                {{ count(json_decode($product->meta)) - 1 > $key ? ',' : '' }}
                            @endforeach
                        </td>
                        <td style="text-align: center;padding:8px">{{ $product->quantity }}x</td>
                        <td style="text-align: center;padding:8px">
                            {{ getSetting('currency_symbol') . number_format($productData['price'], 2) }}
                        </td>
                        <td style="text-align: center;padding:8px">
                            {{ getSetting('currency_symbol') . number_format($product->quantity * $productData['price'], 2) }}
                        </td>
                    </tr>
                @endforeach
            </table>
        </section>
        <br>
        <br> 
        <section>
            <table class="w-100">
                <tr>
                    <td style="width: 65%">
                        <p style="margin-bottom: 18px">Payment Method: <span style="background: #3fdb8040; color: #005c4d;
                        margin: 0 5px; padding: 5px 8px; border-radius: 5px">{{ $order->payment_method }}</span></p>
                        <h3>Delivery instruction</h3><br>
                        <p>{{ $order->delivery_instruction }}</p>
                    </td>
                    <td style="width: 35%">
                        <table class="w-100">

                            <tr>
                                <td style="font-weight: bold">Sub Total:</td>
                                <td style="text-align: right">
                                    {{ getSetting('currency_symbol') . number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Shipping Charge:
                                </td>
                                <td style="text-align: right">
                                    {{ getSetting('currency_symbol') . number_format($order->shipping_charge, 2) }}
                                </td>
                            </tr>
                            @if ($order->gift_wrapper_charge)
                                <tr>
                                    <td>Gift Wrapper Charge:</td>
                                    <td style="text-align: right">
                                        {{ getSetting('currency_symbol') . number_format($order->gift_wrapper_charge, 2) }}</td>
                                </tr>

                            @endif
                            <tr>
                                <td>Service Charge:</td>
                                <td style="text-align: right">
                                    {{ getSetting('currency_symbol') . number_format($order->service_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Discount:</td>
                                <td style="text-align: right">
                                    {{ getSetting('currency_symbol') . number_format($order->discount, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Tax:</td>
                                <td style="text-align: right">
                                    {{ getSetting('currency_symbol') . number_format($order->tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold">Total:</td>
                                <td style="text-align: right">
                                    {{ getSetting('currency_symbol') . number_format($order->grand_total, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Amount paid:</td>
                                <td style="text-align: right; color:green">
                                    {{ getSetting('currency_symbol') . number_format($order->transaction()->success()->sum('amount'),2) }}
                                </td>
                            </tr>
                        </table>
                        <hr>
                        <table class="w-100">
                            <tr>
                                <td style="font-weight: bold;font-size:20px">DUE:</td>
                                <td style="text-align: right; color: red;font-size:20px">
                                    {{ getSetting('currency_symbol') . number_format($order->grand_total - $order->transaction()->success()->sum('amount'), 2) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            <br>
            <br>


        </section>

    </div>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "This is auto generated invoice, signature is not required.";
            $size = 10;
            // add color hash color

            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2.5;
            $y = $pdf->get_height() - 30;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
        if (isset($pdf)) {
            $text = "page {PAGE_NUM} of {PAGE_COUNT}";
            $size = 10;
            $font = $fontMetrics->getFont("Verdana");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 12;
            $y = 10;
            $pdf->page_text($x, $y, $text, $font, $size);
        }



</script>
</body>

</html>
