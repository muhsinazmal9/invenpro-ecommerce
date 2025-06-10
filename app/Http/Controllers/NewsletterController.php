<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Services\MailService;
use Illuminate\Http\JsonResponse;
use App\Services\NewsletterService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreNewsLetterRequest;
use App\Http\Requests\UpdateNewsLetterRequest;

class NewsletterController extends Controller
{
    public function __construct(
        private NewsletterService $newsletterService,
        private MailService $mailService
    ) {
        $this->middleware('can:'.Newsletter::LIST)->only(['index', 'getList']);
        $this->middleware('can:'.Newsletter::CREATE)->only(['create']);
        $this->middleware('can:'.Newsletter::UPDATE)->only(['edit', 'update']);
    }

    public function index(): View
    {

        return view('backend.newsletter.mailbox');
    }

    public function create(): View
    {
        $subscribers = Subscriber::subscribed()->pluck('email');

        return view('backend.newsletter.create', compact('subscribers'));
    }

    public function store(StoreNewsLetterRequest $request)
    {

        $create = $this->newsletterService->create($request);

        if ($create->getData()->success) {
            return redirect()->route('admin.newsletter.index')->with('success', $create->getData()->message);
        }

        return back()->with('error', $create->getData()->message)->withInput();
    }

    public function show(Newsletter $newsletter): View
    {

        return view('backend.newsletter.show', compact('newsletter'));
    }

    public function getList(Request $request): JsonResponse
    {
        $newsletterMails = $this->newsletterService->getList($request);

        if ($newsletterMails->getData()->success) {
            return response()->json($newsletterMails->getData()->data);
        }

        return response()->json([]);
    }

    public function destroyMail(Newsletter $newsletter): JsonResponse
    {
        $newsletter->delete();

        return success(__('app.newsletter_deleted_successfully'));
    }

    public function edit(Newsletter $newsletter): View|RedirectResponse
    {
        if ($newsletter->status == 1) {
            return back()->with('error', __('app.mail_box_already_sent'));
        }
        $subscribers = Subscriber::subscribed()->pluck('email');

        return view('backend.newsletter.edit', compact('newsletter', 'subscribers'));
    }

    public function update(UpdateNewsLetterRequest $request, Newsletter $newsletter): RedirectResponse
    {

        $update = $this->newsletterService->update($request, $newsletter);

        if ($update->getData()->success) {
            return redirect()->route('admin.newsletter.index')->with('success', $update->getData()->message);
        }

        return back()->with('error', $update->getData()->message);

    }
}
