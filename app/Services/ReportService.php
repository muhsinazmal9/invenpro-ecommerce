<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportService
{
    public function getSalesList(Request $request): JsonResponse
    {
        try {
            $columns = [
                0 => 'invoice_id',
                1 => 'user_id',
                2 => 'subtotal',
                3 => 'shipping_charge',
                4 => 'tax',
                5 => 'grand_total',
                6 => 'actions',
            ];

            $orders = Order::query();

            $totalData = $orders->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $order = $columns[$request->input('order.0.column')] ?? 'invoice_id';
            $dir = $request->input('order.0.dir', 'desc');

            if ($order == 'actions') {
                $order = 'invoice_id';
            }

            if (empty($request->input('search.value'))) {
                $orders = $orders
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $orders = $orders
                    ->where('order_status', Order::ORDER_STATUS['delivered'])
                    ->where(function ($query) use ($searchInput) {
                        $query->where('invoice_id', 'LIKE', "%{$searchInput}%")
                            ->orWhereHas('user', function ($query) use ($searchInput) {
                                $query->where('fname', 'LIKE', "%{$searchInput}%")
                                    ->orWhere('lname', 'LIKE', "%{$searchInput}%");
                            })
                            ->orWhere('subtotal', 'LIKE', "%{$searchInput}%")
                            ->orWhere('shipping_charge', 'LIKE', "%{$searchInput}%")
                            ->orWhere('tax', 'LIKE', "%{$searchInput}%")
                            ->orWhere('grand_total', 'LIKE', "%{$searchInput}%");

                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $orders->count();
            }

            $data = [];

            if (! empty($orders)) {
                foreach ($orders as $order) {

                    $invoiceDownloadLink = route('admin.orders.invoice.pdf.stream', $order->id);

                    $button = "<a target='_blank' href='{$invoiceDownloadLink}' class=''><span class='btn-hover mdi fs-1 mdi-download-box'></span></a>";

                    $nestedData['invoice_id'] = $order->invoice_id;
                    $nestedData['user_id'] = $order->user?->name;
                    $nestedData['subtotal'] = getSetting('currency_symbol').number_format($order->subtotal, 2);
                    $nestedData['shipping_charge'] = getSetting('currency_symbol').number_format($order->shipping_charge, 2);
                    $nestedData['tax'] = getSetting('currency_symbol').number_format($order->tax, 2);
                    $nestedData['grand_total'] = getSetting('currency_symbol').number_format($order->grand_total, 2);
                    $nestedData['actions'] = $button;
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success('Sales List', $json_data);
        } catch (\Exception $e) {
            logError('Sales List Error ', $e);

            return error('Sales List Error. Please try again.');
        }
    }

    public function getTransactionList(Request $request): JsonResponse
    {
        try {
            $columns = [
                0 => 'user_id',
                1 => 'transaction_id',
                2 => 'payment_method',
                3 => 'status',
                4 => 'created_at',
                5 => 'amount',
            ];

            $transactions = Transaction::query();

            if ($request->input('status') == 'success') {
                $transactions = $transactions->success();
            }

            $totalData = $transactions->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'created_at';

            if (empty($request->input('search.value'))) {
                $transactions = $transactions
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $transactions = $transactions
                    ->where(function ($query) use ($searchInput) {
                        $query->whereHas('user', function ($query) use ($searchInput) {
                            $query->where('fname', 'like', "%{$searchInput}%");
                            $query->orWhere('lname', 'like', "%{$searchInput}%");
                        })->orWhere('transaction_id', 'like', "%{$searchInput}%")
                            ->orWhere(function ($query) use ($searchInput) {
                                if (strtolower($searchInput) == 'online') {
                                    $query->where('payment_method', Transaction::PAYMENT_METHOD['online']);
                                }
                                if (strtolower($searchInput) == 'cod') {
                                    $query->where('payment_method', Transaction::PAYMENT_METHOD['COD']);
                                }
                            })->orWhere(function ($query) use ($searchInput) {
                                if (strtolower($searchInput) == 'success') {
                                    $query->where('status', Transaction::STATUS['success']);
                                }
                                if (strtolower($searchInput) == 'pending') {
                                    $query->where('status', Transaction::STATUS['pending']);
                                }
                            })
                            ->orWhere('amount', 'like', "%{$searchInput}%");

                    })
                    ->orderBy($order, $dir)
                    ->offset($start)
                    ->limit($limit)
                    ->get();

                $totalFiltered = $transactions->count();
            }

            $data = [];

            if (! empty($transactions)) {
                foreach ($transactions as $transaction) {

                    $amount = $transaction->amount;
                    $status = "<span class='text-".getTransactionStatusColor($transaction->status)."'>".ucwords(getTransactionStatus($transaction->status)).'</span>';

                    $nestedData['customer_name'] = $transaction->user?->name;
                    $nestedData['transaction_id'] = $transaction->transaction_id;
                    $nestedData['payment_method'] = $transaction->payment_method == 1 ? Transaction::COD : Transaction::ONLINE;
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $transaction->created_at->format('D, d/M/Y, h:i A');
                    $nestedData['amount'] = getSetting('currency_symbol').number_format($amount, 2);
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success(__('app.list'), $json_data);
        } catch (\Exception $e) {
            logError(' List Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }
}
