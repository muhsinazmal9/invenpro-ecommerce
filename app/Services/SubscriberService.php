<?php

namespace App\Services;

use App\Http\Requests\StoreSubscriberRequest;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriberService
{
    public function getList(Request $request): JsonResponse
    {

        try {
            $columns = [
                0 => 'email',
                1 => 'is_subscribed',
                2 => 'actions',
            ];

            $subscribers = Subscriber::query();
            $totalData = $subscribers->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'email';

            if ($order == 'actions') {
                $order = 'email';
            }

            if (empty($request->input('search.value'))) {
                $subscribers = $subscribers
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');
                $subscribers = $subscribers
                    ->where('email', 'like', "%{$searchInput}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $subscribers->count();
            }

            $data = [];

            if (! empty($subscribers)) {
                foreach ($subscribers as $subscriber) {

                    $subscriberStatus = $subscriber->is_subscribed ? __('app.subscribed') : __('app.unsubscribed');
                    $subscriberStatusClass = $subscriber->is_subscribed ? 'success' : 'danger';
                    $status = "<button class='main-btn {$subscriberStatusClass}-btn-light btn-hover btn-sm' style='padding:4px 20px' type='button' onclick=toggleSubscribe('{$subscriber->token}',this) >{$subscriberStatus}</button>";
                    $deleteBtn = "<button type='button' onclick=deleteSubscriber('{$subscriber->token}',this.parentElement.parentElement)  class='main-btn danger-btn btn-hover btn-sm delete-btn'><i class='mdi mdi-trash-can-outline'></i></button>";
                    $nestedData['email'] = $subscriber->email;
                    $nestedData['is_subscribed'] = $status;
                    $nestedData['actions'] = $deleteBtn;
                    $data[] = $nestedData;
                }
            }

            $json_data = [
                'draw' => intval($request->input('draw')),
                'recordsTotal' => intval($totalData),
                'recordsFiltered' => intval($totalFiltered),
                'data' => $data,
            ];

            return success(__('app.news_letter_list'), $json_data);
        } catch (\Exception $e) {
            logError('Newsletter List Error', $e);

            return error('Something went wrong');
        }
    }

    public function create(StoreSubscriberRequest $request): JsonResponse
    {
        try {

            Subscriber::create([
                'email' => $request->email,
                'is_subscribed' => (bool) $request->status,
                'meta' => json_encode(['ip' => $request->getClientIp(), 'http_host' => $request->getHttpHost()]),
                'token' => Str::random(20).'--'.Str::random(15),
            ]);

            return success(__('app.subscriber_created_successfully'));
        } catch (\Exception $e) {
            logError('Subscriber Store error:', $e);

            return error('Something went wrong', $e->getMessage());
        }

    }
}
