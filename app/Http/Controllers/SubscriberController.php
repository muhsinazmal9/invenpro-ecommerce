<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriberRequest as RequestsStoreSubscriberRequest;
use App\Models\Subscriber;
use App\Services\SubscriberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function __construct(
        private SubscriberService $subscriberService
    ) {
        $this->middleware('can:'.Subscriber::LIST)->only(['getList']);
        $this->middleware('can:'.Subscriber::CREATE)->only(['index,create']);

    }

    public function index()
    {
        return view('backend.subscriber.index');
    }

    public function getList(Request $request): JsonResponse
    {
        $subscribers = $this->subscriberService->getList($request);

        if ($subscribers->getData()->success) {
            return response()->json($subscribers->getData()->data);
        }

        return response()->json([]);
    }

    public function destroy(Subscriber $subscriber): JsonResponse
    {
        $subscriber->delete();

        return success('Mail deleted successfully');
    }

    public function toggleSubscribe(Subscriber $subscriber)
    {

        $subscription = false;

        if (auth()->check()) {
            $subscription = ! $subscriber->is_subscribed;
        }

        $subscriber->is_subscribed = $subscription;
        $subscriber->save();

        if (auth()->check()) {
            return success('Subscription status updated', $subscriber);
        }

        return view('backend.subscriber.unsubscribe_view');
    }

    // public function statusUpdate(Subscriber $subscriber)
    // {

    //    $subscriber->is_subscribed =! $subscriber->is_subscribed;
    //    $subscriber->save();

    //     return success('Product featured status updated successfully', $subscriber);

    // }

    public function store(RequestsStoreSubscriberRequest $request): JsonResponse
    {

        $create = $this->subscriberService->create($request);

        if ($create->getData()->success) {
            return success('Subscriber created successfully');

        }

        return error('something went went', $create->getData()->message);

    }
}
