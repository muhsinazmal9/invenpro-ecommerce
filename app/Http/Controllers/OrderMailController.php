<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MailService;

class OrderMailController extends Controller
{
    public function __construct(
        private MailService $mailService
    ) {

    }

    public function sendOrderConfirmation()
    {

        $user = User::find(2);

        $mail = $this->mailService->sendOrderConfirmation($user);

        if ($mail->getData()->success) {
            return success($mail->getData()->message);
        } else {
            return error($mail->getData()->message);
        }
    }
}
