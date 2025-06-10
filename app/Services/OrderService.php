<?php

namespace App\Services;

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class OrderService
{
    public function getList(Request $request): JsonResponse
    {

        if (!checkUserPermission(Order::LIST)) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $getSetting = getSetting('currency_symbol');
            $columns = [
                0 => 'invoice_id',
                1 => 'user_id',
                2 => 'user_id',
                3 => 'grand_total',
                4 => 'payment_method',
                5 => 'payment_status',
                6 => 'order_status',
                7 => 'cancel_request',
                8 => 'actions',
            ];

            if ($request->cancel_request == 'true') {
                $columns[7] = 'cancel_request';
            }

            $orders = Order::query()
            ->with(['user:id,fname,lname,email'])
            ->select('id', 'invoice_id', 'user_id', 'grand_total', 'payment_method', 'payment_status', 'order_status', 'is_cancel_request');

            if ($request->status) {
                $orders = $orders->where('order_status', $request->input('status'));
            }

            if ($request->cancel_request == 'true') {
                $orders = $orders->where('is_cancel_request', Order::CANCEL_REQUEST['requested']);
            }

            $totalData = $orders->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $columnOrder = $columns[$request->input('order.0.column')] ?? 'id';
            $dir = $request->input('order.0.dir', 'desc');

            if ($columnOrder == 'actions') {
                $columnOrder = 'id';
            }

            if (empty($request->input('search.value'))) {
                $orders = $orders
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($columnOrder, $dir)
                    ->get();
            } else {
                $searchValue = $request->input('search.value');

                $orders = $orders->where(function($q) use ($searchValue) {
                    $q->where('invoice_id', 'LIKE', "%{$searchValue}%")
                     ->orWhere(
                        function ($q) use ($searchValue) {
                            $q->whereHas('user', function ($q) use ($searchValue) {
                                $q->where(function ($q) use ($searchValue) {
                                    $q->where('username', 'LIKE', "%{$searchValue}%")
                                    ->orWhere('fname', 'LIKE', "%{$searchValue}%")
                                    ->orWhere('lname', 'LIKE', "%{$searchValue}%")
                                    ->orWhere('email', 'LIKE', "%{$searchValue}%");
                                });
                            });
                        })
                      ->orWhere('shipping_address', 'LIKE', "%{$searchValue}%")
                      ->orWhere('grand_total', 'LIKE', "%{$searchValue}%")
                      ->orWhere('user_id', 'LIKE', "%{$searchValue}%")
                      ->orWhere('payment_method', 'LIKE', "%{$searchValue}%")
                      ->orWhere('payment_status', 'LIKE', "%{$searchValue}%")
                      ->orWhere('order_status', 'LIKE', "%{$searchValue}%");
                    })
                   ->offset($start)
                    ->limit($limit)
                    ->orderBy($columnOrder, $dir)
                    ->get();
                $totalFiltered = $orders->count();
            }

            $data = [];

            if (!empty($orders)) {
                foreach ($orders as $order) {
                    $userName = $order->user?->name;
                    $userEmail = $order->user?->email;

                    $orderStatus = Str::ucfirst($order->order_status);

                    $orderStatusClass = getOrderStatusColor($order->order_status);
                    $paymentStatus = $order->payment_status;
                    $paymentStatusClass = $order->payment_status ? 'success' : 'danger';

                    $status = "<button
                                onclick='updateStatus({$order->id})'
                                class='main-btn {$orderStatusClass}-btn-light btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$orderStatus}
                                </button>";
                    $orderCancelStatus = getCancelRequestStatus($order->is_cancel_request);
                    $cancelStatus = "<button
                                onclick='updateCancelStatus({$order->id})'
                                class='main-btn primary-btn btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$orderCancelStatus}
                                </button>";
                    $paymentStatus = "<button

                                class='main-btn {$paymentStatusClass}-btn-light btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$paymentStatus}
                                </button>";

                    $detailLink = route('admin.orders.show', $order->id);
                    $detailBtn = "<a
                                    type='button'
                                    href='$detailLink'
                                    class='text-dark details-btn fs-5' style='padding: 6px 8px;border-radius: 9px;'>
                                        <i class='lni lni-eye'></i>
                                </a>";

                    $nestedData['invoice_id'] = $order->invoice_id;
                    $nestedData['user_id'] = $userName;
                    $nestedData['email'] = $userEmail;
                    $nestedData['grand_total'] =  $getSetting . number_format($order->grand_total, 2);
                    $nestedData['payment_method'] = $order->payment_method;
                    $nestedData['payment_status'] = $paymentStatus;
                    $nestedData['status'] = $status;
                    if ($request->cancel_request == 'true') {
                        $nestedData['cancel_request'] = $cancelStatus;
                    }
                    $nestedData['actions'] = $detailBtn;
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success(__('app.order_list'), $json_data);
        } catch (\Exception $e) {
            logError('Order List Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }

    public function status(Request $request, Order $order): JsonResponse
    {
        if (!checkUserPermission(Order::STATUS_UPDATE)) {
            return error(__('app.permission_denied'), 403);
        }

        try {

            if (!$request->input('status') || !in_array($request->input('status'), Order::ORDER_STATUS)) {
                return error(__('app.invalid_order_status'));
            }

            $order->update([
                'order_status' => $request->input('status'),
            ]);

            return success(__('app.order_status_updated'), $order);
        } catch (\Exception $e) {
            logError('Order Status Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }
    public function getUserOrderList(Request $request, User $user): JsonResponse
    {
        if (!checkUserPermission(Order::LIST)) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $columns = [
                0 => 'invoice_id',
                1 => 'amount',
                2 => 'status',
                3 => 'product_id',
                4 => 'actions',

            ];

            $orders = Order::query()->with('products')->where('user_id', $user->id);


            $totalData = $orders->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $columnOrder = $columns[$request->input('order.0.column')] ?? 'id';
            $dir = $request->input('order.0.dir', 'desc');

            if ($columnOrder == 'actions') {
                $columnOrder = 'id';
            }

            if (empty($request->input('search.value'))) {
                $orders = $orders
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($columnOrder, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $orders = $orders
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($columnOrder, $dir)
                    ->get();
                $totalFiltered = $orders->count();
            }

            $data = [];

            if (!empty($orders)) {
                foreach ($orders as $order) {

                    $orderStatus = Str::ucfirst($order->order_status);

                    $orderStatusClass = getOrderStatusColor($order->order_status);
                    $status = "<button
                                onclick='updateStatus({$order->id})'
                                class='main-btn {$orderStatusClass}-btn-light btn-hover btn-sm'
                                style='padding:4px 10px'
                                type='button'>{$orderStatus}
                                </button>";

                    $detailLink = route('admin.orders.show', $order->id);
                    $detailBtn = "<a
                                    type='button'
                                    href='$detailLink'
                                    class='text-dark details-btn fs-5' style='padding: 6px 8px;border-radius: 9px;'>
                                        <i class='lni lni-eye'></i>
                                </a>";

                    $nestedData['invoice_id'] = $order->invoice_id;
                    $nestedData['amount'] = getSetting('currency_symbol') . number_format($order->grand_total, 2);
                    $nestedData['status'] = $status;
                    $nestedData['product_id'] = $order->products?->count();
                    $nestedData['actions'] = $detailBtn;
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success(__('app.order_list'), $json_data);
        } catch (\Exception $e) {
            logError('Order List Error ', $e);

            return error(__('app.something_went_wrong'));
        }
    }
}
