<?php

namespace App\Http\Controllers\Api\V1;

use App\Constants\Activity;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\TrackOrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function list(Request $request)
    {
        try {
            $limit = $request->limit ?? 20;
            $order_status = $request->order_status;
            $payment_status = $request->payment_status;
            $payment_method = $request->payment_method;

            $orders = Order::query()->where('user_id', auth()->user()->id);

            if ($order_status) {

                if (! in_array($order_status, Order::ORDER_STATUS)) {
                    return error('Invalid status', 403);
                }

                $orders = $orders->where('order_status', $order_status);
            }

            if ($payment_status) {

                if (! in_array($payment_status, Order::PAYMENT_STATUS)) {
                    return error('Invalid status', 403);
                }

                $orders = $orders->where('payment_status', $payment_status);
            }

            if ($payment_method) {

                if (! in_array($payment_method, Order::PAYMENT_METHOD)) {
                    return error('Invalid payment method', 403);
                }

                $orders = $orders->where('payment_method', $payment_method);
            }

            $orders = $orders->paginate($limit);

            return paginator('Order list retrieved successfully', OrderResource::collection($orders));

        } catch (\Exception $e) {

            logError('Error while fetching order list, User id:'.auth()->user()->id, $e);

            return error('Something went wrong', 500);
        }

    }

    public function details(Order $order)
    {
        // Check if order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            return error('Unauthorized', 401);
        }

        return success('success', new OrderResource($order));
    }

    public function trackOrder(Request $request)
    {

        $validateData = validateData([
            'invoice_id' => 'required|exists:orders,invoice_id',
            'email' => 'required|exists:users,email',
        ]);

        if ($validateData->fails()) {
            return error('Validation error', 403, $validateData->errors());
        }

        $order = Order::where('invoice_id', $request->invoice_id)
            ->whereHas('user', function ($query) use ($request) {
                $query->where('email', $request->email);
            })
            ->first();

        if (! $order) {
            return error('Order not found', 404);
        }

        return success('Order tracking success', new TrackOrderResource($order));
    }

    public function storeReview(Request $request, Order $order)
    {
        $validation = $request->validate([
            'product_slug' => 'required|exists:products,slug',
            'rating' => 'required|between:1,5',
            'comment' => 'nullable|string',
            'files.*' => 'nullable|mimes:jpeg,jpg,png,mp4,mov,ogg,qt,pdf|max:50000',
        ]);
         
        try {
            // Check if order belongs to the authenticated user
            if ($order->user_id !== auth()->id()) {
                return error('Unauthorized', 401);
            }

            $product = Product::where('slug', $request->product_slug)->first();

            if (! $product) {
                return error('Product do not exists!');
            }

            // Check if review already added for this product

            $existReview = ProductReview::where('order_id', $order->id)
                ->where('product_id', $product->id)
                ->first();

            if ($existReview) {
                return error('Review already added for this product', 409, new ProductReviewResource($existReview));
            }

            // Check if order is delivered or not
            if ($order->order_status !== Order::ORDER_STATUS['delivered']) {
                return error('Order is not delivered yet', 403);
            }

            // check if product belongs to the order

            if (! $order->products()->where('product_id', $product->id)->first()) {
                return error('Product not found in the order', 404);
            }

            $uploadedFiles = [];
            if (!empty($request->file('files')) && $request->has('files')) {
                $uploadedFiles[] = $this->reviewFileUpload($request);
            }

            $review = ProductReview::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
                'files' => !empty($uploadedFiles) ? json_encode($uploadedFiles) : null,
            ]);
            // add activity log
            activity()
                ->performedOn($review)
                ->causedBy(auth()->user())
                ->event(Activity::CREATED)
                ->withProperties([
                    Activity::CREATED => $review->toArray(),
                ])->log('Product review added');

            return success('Review added successfully', new ProductReviewResource($review));

        } catch (\Exception $e) {
            logError('Error while adding review', $e);

            return error('Something went wrong', 500);
        }
    }

    private function reviewFileUpload(Request $request) : array
    {
        $files = $request->file('files', []);
        $uploadedFiles = [];
        $localPath = Product::PRODUCT_REVIEWS_DIRECTORY;
        $fullPath = public_path($localPath);
     
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0777, true);
        }
 
        if (is_array($files)) {
            foreach ($files as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move($fullPath, $filename);
                $uploadedFiles[] = $localPath . $filename;
            }
        }else{
            $filename = time() . '_' . $files->getClientOriginalName();
            $files->move($fullPath, $filename);
            $uploadedFiles[] = $localPath . $filename;
        } 
        return $uploadedFiles ?? [];
    }
    public function cancelOrder(Order $order, Request $request)
    {
        // Check if order belongs to the authenticated user
        if ($order->user_id !== auth()->id()) {
            return error('Unauthorized', 401);
        }

        // check order status
        if ($order->order_status == Order::ORDER_STATUS['shipped'] || $order->order_status == Order::ORDER_STATUS['delivered'] || $order->order_status == Order::ORDER_STATUS['cancelled']) {
            return error('Order is already '.$order->order_status, 403);
        }

        if ($order->is_cancel_request == Order::CANCEL_REQUEST['requested'] || $order->is_cancel_request == Order::CANCEL_REQUEST['approved']) {
            return error('Cancel request already submitted', 403);
        }

        $order->update([
            'is_cancel_request' => Order::CANCEL_REQUEST['requested'],
        ]);

        if ($order->is_cancel_request == Order::CANCEL_REQUEST['approved']) {
            return success('Order cancel request approved');
        }

        // added activity log

        activity()
            ->performedOn($order)
            ->causedBy(auth()->user())
            ->event(Activity::ORDER_CANCEL)
            ->withProperties([
                Activity::ORDER_CANCEL => $order,
            ])->log('Order cancel request submitted');

        return success('Order cancel request submitted successfully');
    }
}
