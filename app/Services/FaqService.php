<?php

namespace App\Services;

use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqService
{
    public function create(StoreFaqRequest $request): JsonResponse
    {
        try {
            $input = $request->except('_token');
            $input['status'] = (bool) $request->status;
            $input['slug'] = generateSlug($request->question);
            $faq = Faq::create($input);

            return success(__('app.faq_created_successfully'), $faq);
        } catch (\Exception $e) {
            logError('Faq Store Error ', $e);

            return error('Something went wrong');
        }
    }

    public function update(UpdateFaqRequest $request, Faq $faq): JsonResponse
    {
        try {
            $input = $request->except('_token', '_method');
            $input['status'] = (bool) $request->status;
            $input['slug'] = generateSlug($request->question);
            $faq->update($input);

            return success(__('app.faq_updated_successfully'), $faq);
        } catch (\Exception $e) {
            logError('FAQ Update Error ', $e);

            return error('Something went wrong');
        }
    }

    public function getList(Request $request): JsonResponse
    {
        if (! checkUserPermission(Faq::LIST)) {
            return error(__('app.permission_denied'), 403);
        }

        try {
            $columns = [
                0 => 'question',
                1 => 'category_id',
                2 => 'status',
                3 => 'created_at',
                4 => 'actions',
            ];

            $faqs = Faq::query()->with('category');

            $totalData = $faqs->count();
            $totalFiltered = $totalData;

            $limit = $request->input('length');
            $start = $request->input('start');
            $dir = $request->input('order.0.dir') ?? 'asc';
            $order = $columns[$request->input('order.0.column')] ?? 'question';

            if ($order == 'actions') {
                $order = 'question';
            }

            if (empty($request->input('search.value'))) {
                $faqs = $faqs
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
            } else {
                $searchInput = $request->input('search.value');

                $faqs = $faqs
                    ->where('question', 'LIKE', "%{$searchInput}%")
                    ->orWhere(function ($query) use ($searchInput) {

                        if ($searchInput == 'enabled') {
                            $query->where('status', true);
                        }

                        if ($searchInput == 'disabled') {
                            $query->where('status', false);
                        }
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();
                $totalFiltered = $faqs->count();
            }

            $data = [];

            if (! empty($faqs)) {
                foreach ($faqs as $faq) {

                    $faqStatus = $faq->status ? __('app.enabled') : __('app.disabled');
                    $faqStatusClass = $faq->status ? 'success' : 'danger';
                    $editLink = route('admin.faq.edit', $faq->slug);
                    $view = __('app.view');
                    $edit = __('app.edit');
                    $delete = __('app.delete');


                    $status = "<button onclick=statusUpdate('{$faq->slug}',this) class='main-btn {$faqStatusClass}-btn-light btn-hover btn-sm' style='padding:4px 10px' type='button'>{$faqStatus}</button>";
                    $editBtn = "<a href='{$editLink}' class='dropdown-item'>{$edit}</a>";
                    $deleteBtn = "<button type='button' onclick=deleteFaq('{$faq->slug}',this.parentElement.parentElement) class='dropdown-item'>

                                    {$delete}</button>";

                    $detailsBtn = "<button type='button' class='dropdown-item'  data-bs-toggle='modal' data-bs-target='#detailsModal' onclick='detailsModal({$faq})'>
                    {$view}</button>";

                    $question = "<a class='text-dark' href='{$editLink}'>".$faq->question.'</a>';

                    $nestedData['question'] = $question;
                    $nestedData['category'] = $faq->category?->name;
                    $nestedData['status'] = $status;
                    $nestedData['created_at'] = $faq->created_at?->format('d/m/y');
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

            return success(__('app.faq_list'), $json_data);
        } catch (\Exception $e) {
            logError('Faq List Error ', $e);

            return error('Something went wrong');
        }
    }
}
