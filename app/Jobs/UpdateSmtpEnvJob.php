<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateSmtpEnvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private $request
    ) {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $env = file_get_contents(base_path('.env'));

            $env = preg_replace('/MAIL_MAILER=(.*)/', 'MAIL_MAILER=smtp', $env);
            $env = preg_replace('/MAIL_HOST=(.*)/', 'MAIL_HOST='.$this->request['smtp_host'], $env);
            $env = preg_replace('/MAIL_PORT=(.*)/', 'MAIL_PORT='.$this->request['smtp_port'], $env);
            $env = preg_replace('/MAIL_USERNAME=(.*)/', 'MAIL_USERNAME="'.$this->request['smtp_username'].'"', $env);
            $env = preg_replace('/MAIL_PASSWORD=(.*)/', 'MAIL_PASSWORD="'.$this->request['smtp_password'].'"', $env);
            $env = preg_replace('/MAIL_ENCRYPTION=(.*)/', 'MAIL_ENCRYPTION='.$this->request['smtp_encryption'], $env);
            $env = preg_replace('/MAIL_FROM_ADDRESS=(.*)/', 'MAIL_FROM_ADDRESS="'.$this->request['smtp_from_address'].'"', $env);
            $env = preg_replace('/MAIL_FROM_NAME=(.*)/', 'MAIL_FROM_NAME="'.$this->request['smtp_from_name'].'"', $env);

            file_put_contents(base_path('.env'), $env);
        } catch (\Exception $ex) {

            logError('Update SMTP Env Job Error', $ex);
        }
    }
}
