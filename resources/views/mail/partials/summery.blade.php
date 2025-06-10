<div style="background:#FAFAFA;background-color:#FAFAFA;margin:0px auto;max-width:600px;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="background:#FAFAFA;background-color:#FAFAFA;width:100%;">
        <tbody>
            <tr>
                <td style="direction:ltr;font-size:0px;padding:20px 0;text-align:center;">
                    <div class="column-per-50 mj-outlook-group-fix"
                        style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                            style="vertical-align:top;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Roboto;font-size:15px;line-height:1;text-align:left;color:#000000;">
                                            <strong>Summary</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Invoice ID: #<span>{{ $order->invoice_id }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Order Status: <span>{{ $order->order_status }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Order Date: <span>{{ $order->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Cancel status:
                                            <span>{{ getCancelRequestStatus($order->is_cancel_request) }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Expected date of delivery:
                                            <span>{{ $order->delivery_date?->format('d/m/Y') }}</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Total Products: <span>{{ $order->products->count() }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Subtotal:
                                            <span>{{ getSetting('currency_symbol') . number_format($order->subtotal, 2) }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Shipping Charge:
                                            <span>{{ getSetting('currency_symbol') . number_format($order->shipping_charge, 2) }}</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="left" style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Tax:
                                            <span>{{ getSetting('currency_symbol') . number_format($order->tax, 2) }}</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="font-size:0px;padding:8px 25px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            Total Price:
                                            <span>{{ getSetting('currency_symbol') . number_format($order->grand_total, 2) }}</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="column-per-50 mj-outlook-group-fix"
                        style="font-size:0px;text-align:left;direction:ltr;display:inline-block;vertical-align:top;width:100%;">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation"
                            style="vertical-align:top;" width="100%">
                            <tbody>
                                <tr>
                                    <td style="font-size:0px;padding:10px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Roboto;font-size:15px;line-height:1;text-align:left;color:#000000;">
                                            <strong>Shipping Address</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:5px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            {{ $order->shipping_address }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:15px 0 5px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Roboto;font-size:15px;line-height:1;text-align:left;color:#000000;">
                                            <strong>Billing Address</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:5px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            {{ $order->billing_address }}
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:15px 0 5px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Roboto;font-size:15px;line-height:1;text-align:left;color:#000000;">
                                            <strong>Shipping Address</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:5px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            {{ $order->payment_method }}
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-size:0px;padding:15px 0 5px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Roboto;font-size:15px;line-height:1;text-align:left;color:#000000;">
                                            <strong>Payment Status</strong>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-size:0px;padding:8px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            {{ $order->payment_status }}
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-size:0px;padding:15px 0 8px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Roboto;font-size:15px;line-height:1;text-align:left;color:#000000;">
                                            <strong>Delivery Instruction</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:0px;padding:5px 15px;word-break:break-word;">
                                        <div
                                            style="font-family:Helvetica;font-size:13px;line-height:1;text-align:left;color:#000000;">
                                            {{ $order->delivery_instruction }}
                                        </div>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
