<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class DashboardService
{
    public function getTopProduct(Request $request): JsonResponse
    {

        try {
            $columns = [
                0 => 'title',
                1 => 'category_id',
                2 => 'subcategory_id',
                3 => 'price',
                4 => 'sold',
                5 => 'stock',
                6 => 'actions',
            ];

            $products = Product::query()->with('category', 'subcategory')
                ->whereHas('orders', function ($query) {
                    $query->where('order_status', Order::ORDER_STATUS['delivered'])
                        ->where('payment_status', Order::PAYMENT_STATUS['paid']);
                });

            $totalData = $products->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'title';

            if (empty($request->input('search.value'))) {
                $products = $products
                    ->offset($start)
                    ->limit($limit)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $products = $products
                    ->whereHas('orders', function ($query) {
                        $query->where('order_status', Order::ORDER_STATUS['delivered'])
                            ->where('payment_status', Order::PAYMENT_STATUS['paid']);
                    })
                    ->where(function ($query) use ($searchInput) {
                        $query->where('title', 'Like', "%{$searchInput}%")
                            ->orWhere('price', 'like', "%{$searchInput}%")
                            ->orWhere('stock', 'like', "%{$searchInput}%")
                            ->orWhereHas('category', function ($query) use ($searchInput) {
                                $query->where('name', 'like', "%{$searchInput}%");
                            })
                            ->orWhereHas('subcategory', function ($query) use ($searchInput) {
                                $query->where('title', 'like', "%{$searchInput}%");
                            });
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->get();

                $totalFiltered = $products->count();
            }

            $data = [];

            if (! empty($products)) {
                foreach ($products as $product) {
                    $product_id = $product->id;

                    $sold = $product->orders->where('order_status', Order::ORDER_STATUS['delivered'])
                        ->where('payment_status', Order::PAYMENT_STATUS['paid'])
                        ->count();

                    $image = '<img src="'.asset($product->thumbnail).'" alt="'.$product->title.'" class="img-fluid rounded" style="max-width: 50px">';

                    $title = "<a class='text-dark' href='".route('admin.products.show', $product->slug)."'>".$image.'&nbsp;&nbsp;&nbsp;'.$product->title.'</a>';

                    $detailsLink = route('admin.products.show', $product->slug);
                    $detailsBtn = "<a href='{$detailsLink}' class='main-btn secondary-btn btn-hover btn-sm details-btn'><i class='mdi mdi-eye-outline fs-5'></i></a>";

                    $nestedData['title'] = $title;
                    $nestedData['category_id'] = $product->category?->name;
                    $nestedData['subcategory_id'] = $product->subcategory?->title;
                    $nestedData['price'] = $product->price;
                    $nestedData['sold'] = $sold;
                    $nestedData['stock'] = $product->stock;
                    $nestedData['actions'] = $detailsBtn;
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success('list', $json_data);
        } catch (\Exception $e) {
            logError(' List Error ', $e);

            return error('Something went wrong');
        }
    }

    public function getUserActivity(Request $request): JsonResponse
    {
        try {

            $activities = Activity::query()->latest();
            $totalData = $activities->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $activities = $activities
                ->offset($start)
                ->limit($limit)
                ->get();

            $data = [];

            if (! empty($activities)) {
                foreach ($activities as $activity) {

                    $nestedData['user_id'] = $activity->causer?->name;
                    $nestedData['activity'] = $activity->description;
                    $nestedData['created_at'] = $activity->created_at->format('D, M,y h:i A');
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success('activity list', $json_data);
        } catch (\Exception $e) {
            logError('Activity List Error ', $e);

            return error('Something went wrong');
        }
    }

    public function getTodaysTransactionsList(Request $request): JsonResponse
    {

        try {
            $setting = getSetting('currency_symbol');
            $columns = [
                0 => 'name',
                1 => 'transaction_id',
                2 => 'payment_method',
                3 => 'created_at',
                4 => 'amount',
            ];

            $transactions = Transaction::query()->where('status', Transaction::STATUS['success']);

            $totalData = $transactions->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'title';

            if (empty($request->input('search.value'))) {
                $transactions = $transactions
                    ->orderBy('updated_at', 'desc')
                    ->offset($start)
                    ->limit($limit)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $transactions = $transactions
                    ->where(function ($query) use ($searchInput) {
                        $query->whereHas('user', function ($query) use ($searchInput) {
                            $query->where('fname', 'like', "%{$searchInput}%");
                            $query->orWhere('lname', 'like', "%{$searchInput}%");
                        })
                            ->orWhere('transaction_id', 'like', "%{$searchInput}%")
                            ->orWhere(function ($query) use ($searchInput) {
                                if (strtolower($searchInput) == 'online') {
                                    $query->where('payment_method', Transaction::PAYMENT_METHOD['online']);
                                }
                                if (strtolower($searchInput) == 'cod') {
                                    $query->where('payment_method', Transaction::PAYMENT_METHOD['COD']);
                                }
                            })
                            ->orWhere('amount', 'like', "%{$searchInput}%");
                    })
                    ->orderBy('updated_at', 'desc')
                    ->offset($start)
                    ->limit($limit)
                    ->get();

                $totalFiltered = $transactions->count();
            }

            $data = [];

            if (! empty($transactions)) {
                foreach ($transactions as $transaction) {
                    $amount = $transaction->amount;
                    $nestedData['name'] = $transaction->user?->name;
                    $nestedData['transaction_id'] = $transaction->transaction_id;
                    $nestedData['payment_method'] = $transaction->payment_method == 1 ? Transaction::COD : Transaction::ONLINE;
                    $nestedData['created_at'] = $transaction->created_at->format('h:i A');
                    $nestedData['amount'] = $setting . number_format($amount, 2);
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success('list', $json_data);
        } catch (\Exception $e) {
            logError(' List Error ', $e);

            return error('Something went wrong');
        }
    }

    public function getProductReview(Request $request): JsonResponse
    {

        try {
            $columns = [
                0 => 'invoice_id',
                1 => 'user_id',
                2 => 'comment',
                3 => 'rating',
            ];

            $productReviews = ProductReview::query();
            $totalData = $productReviews->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'title';

            $data = [];
            $productReviews = $productReviews->get();
            if (! empty($productReviews)) {
                foreach ($productReviews as $productReview) {

                    $rating = '';

                    for ($i = 0; $i < (int) $productReview->rating; $i++) {
                        $rating .= "<i class='fas fa-star text-warning'></i>";
                    }

                    if ($productReview->ratting - (int) $productReview->rating > 0.5) {
                        $rating .= "<i class='fa-solid fa-star-half-stroke text-warning'></i>";
                    }

                    for ($i = 0; $i < 5 - round($productReview->rating); $i++) {
                        $rating .= "<i class='far fa-star text-warning'></i>";
                    }

                    $nestedData['invoice_id'] = $productReview->order?->invoice_id;
                    $nestedData['user_id'] = $productReview->user?->fname;
                    $nestedData['comment'] = $productReview->comment;
                    $nestedData['rating'] = $rating;
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success('list', $json_data);
        } catch (\Exception $e) {
            logError(' List Error ', $e);

            return error('Something went wrong');
        }
    }
}
