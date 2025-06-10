<?php

namespace App\Jobs;

use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Newsletter $newsletter,
        private array $receiverEmail,
        private bool $isAll,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $subscribers = Subscriber::query()->subscribed();

        if (! $this->isAll) {
            $subscribers = $subscribers->whereIn('email', $this->receiverEmail);
        }

        foreach ($subscribers->get() as $subscriber) {

            try {
                NewsletterMailJob::dispatch($subscriber, $this->newsletter);
            } catch (\Exception $ex) {
                logError('Newsletter Mail Job Error', $ex);
            }
        }

    }
}
