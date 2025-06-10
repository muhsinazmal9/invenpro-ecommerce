<?php

namespace App\Services;

use App\Http\Requests\StoreNewsLetterRequest;
use App\Http\Requests\UpdateNewsLetterRequest;
use App\Jobs\NewsletterJob;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterService
{
    public function create(StoreNewsLetterRequest $request)
    {

        try {
            $input = $request->except('_token');
            $input['status'] = 0;
            $input['to_all'] = (bool) $request->select_all;
            $receiver = [];

            if (! $input['to_all']) {
                $receiverArray = json_decode($request->to_emails, true);

                foreach ($receiverArray as $key => $rec) {
                    $receiver[$key] = $rec['value'];
                }

                $input['receiver'] = $request->to_emails;

            }
            if ($input['to_all']) {

                $subscribers = Subscriber::subscribed()->pluck('email');
                $input['receiver'] = $subscribers->map(function ($subscriber) {
                    return ['value' => $subscriber];
                });

            }

            $newsletter = Newsletter::create($input);

            if ($request->status != 'Draft') {
                NewsletterJob::dispatch($newsletter, $receiver, $input['to_all']);

                $newsletter->update([
                    'status' => Newsletter::STATUS['sent'],
                ]);
            }

            return success(__('app.newsletter_mail_created_successfully'), $newsletter);
        } catch (\Exception $e) {

            logError('News Letter MAil Store Error ', $e);

            return error('Something went wrong');
        }

    }

    public function getList(Request $request): JsonResponse
    {
        try {
            $columns = [
                0 => 'subject',
                1 => 'status',
                2 => 'created_at',
                3 => 'actions',
            ];

            $newsletters = Newsletter::query();
            $totalData = $newsletters->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');

            $dir = $request->input('order.0.dir') ?? 'desc';
            $order = $columns[$request->input('order.0.column')] ?? 'id';

            if ($order == 'actions') {
                $order = 'subject';
            }

            if (empty($request->input('search.value'))) {
                $newsletters = $newsletters
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');
                $newsletters = $newsletters
                    ->where('email', 'like', "%{$searchInput}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $newsletters->count();
            }

            $data = [];

            if (! empty($newsletters)) {
                foreach ($newsletters as $newsletter) {

                    match ($newsletter->status) {
                        0 => $newsletterStatus = __('app.draft'),
                        1 => $newsletterStatus = __('app.sent'),
                        2 => $newsletterStatus = __('app.failed'),
                        default => $newsletterStatus = __('app.draft'),
                    };
                    match ($newsletter->status) {
                        0 => $newsletterStatusClass = 'danger',
                        1 => $newsletterStatusClass = 'success',
                        2 => $newsletterStatusClass = 'danger',
                        default => $newsletterStatusClass = 'danger',
                    };

                    $status = "<button class='main-btn  $newsletterStatusClass-btn-light btn-hover btn-sm'
                                        style='padding:4px 10px'
                                        type='button'>$newsletterStatus
                                        </button>";
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');

                    if ($newsletter->status == 1) {
                        $editBtn = "<a
                                    class='dropdown-item'>
                                        {$edit}
                                </a>";

                    } else {
                        $editBtn = "<a
                                href='".route('admin.newsletter.edit', $newsletter->id)."'
                                   class='dropdown-item'>
                                        {$edit}
                                </a>";

                    }

                    $detailsLink = route('admin.newsletter.show', $newsletter->id);

                    $detailsBtn = "<a href='{$detailsLink}' class='dropdown-item' class='dropdown-item'>{$view}</a>";
                    $deleteBtn = "<button type='button' onclick=deletemailBox('{$newsletter->id}',this.parentElement.parentElement) class='dropdown-item' >{$delete}</button>";
                    $nestedData['subject'] = $newsletter->subject;
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $newsletter->created_at?->format('d/m/y');
                    $nestedData['actions'] = "<div class='dropdown text-center'>
                    <button class='dropdown-toggle' onclick='toggleActions(this)' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        <i class='fa-solid fa-ellipsis'></i>
                    </button>
                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                        {$detailsBtn}
                        {$editBtn}
                        {$deleteBtn}
                    </div>
                  </div>";

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

    public function update(UpdateNewsLetterRequest $request, Newsletter $newsletter): JsonResponse
    {

        if ($newsletter->status == 1) {
            return error(__('app.mail_box_already_sent'));
        }

        try {
            $input = $request->except('_token', '_method');
            $input['status'] = 0;
            $input['to_all'] = (bool) $request->select_all;
            $receiver = [];

            if (! $input['to_all']) {
                $receiverArray = json_decode($request->to_emails, true);

                foreach ($receiverArray as $key => $rec) {
                    $receiver[$key] = $rec['value'];
                }

                $input['receiver'] = json_encode($receiver);
            }
            if ($input['to_all']) {

                $subscribers = Subscriber::subscribed()->pluck('email');
                $input['receiver'] = $subscribers->map(function ($subscriber) {
                    return ['value' => $subscriber];
                });

            }

            $newsletter->update($input);

            if ($request->status != 'Draft') {

                NewsletterJob::dispatch($newsletter, $receiver, $input['to_all']);

                $newsletter->update([
                    'status' => Newsletter::STATUS['sent'],
                ]);
            }

            return success(__('app.newsletter_mail_updated_successfully'), $newsletter);
        } catch (\Exception $e) {
            logError('Mail Update Error ', $e);

            return error('Something went wrong');
        }
    }
}
