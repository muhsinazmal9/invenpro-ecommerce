<?php

namespace App\Jobs;

use App\Mail\NewslettersMail;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewsletterMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Subscriber $subscriber,
        private Newsletter $newsletter
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {
            Mail::to($this->subscriber?->email)->send(new NewslettersMail($this->subscriber, $this->newsletter));
            info('Newsletter mail sent to '.$this->subscriber?->email);
        } catch (\Exception $ex) {
            // Log the error
            logError('Newsletter mail error ', $ex);
        }
    }
}
