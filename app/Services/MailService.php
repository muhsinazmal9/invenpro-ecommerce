<?php

namespace App\Services;

use App\Mail\EmailVerificationMail;
use App\Mail\NewslettersMail;
use App\Mail\OrderCancellationMail;
use App\Mail\OrderConfirmMail;
use App\Mail\ResetPasswordMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendOrderConfirmation(User $user): JsonResponse
    {
        try {

            Mail::to([$user->email, 'bipob@gmail.com'])->send(new OrderConfirmMail($user));

            return success('Order confirmation mail sent');

        } catch (\Exception $ex) {

            logError('MailService@sendOrderConfirmation', $ex);

            return error($ex->getMessage());
        }
    }

    public function sendOrderCancellationMail(Order $order, User $user): JsonResponse
    {

        try {
            Mail::to($user->email)->send(new OrderCancellationMail($user, $order));

            return success('Order cancellation mail sent');

        } catch (\Exception $ex) {

            logError('MailService@sendOrderCancellationMail', $ex);

            return error($ex->getMessage());
        }
    }

    public function forgetPassword(User $user): JsonResponse
    {
        try {

            Mail::to([$user->email])->send(new ResetPasswordMail($user));

            return success('Reset password link sent to your email');

        } catch (\Exception $ex) {

            logError('MailService@sendOrderConfirmation', $ex);

            return error($ex->getMessage());
        }

    }

    public function sendEmailVerification(User $user): JsonResponse
    {
        try {

            Mail::to($user->email)->send(new EmailVerificationMail($user));

            return success('Email verification OTP sent to your email');

        } catch (\Exception $ex) {

            logError('MailService@sendEmailVerification', $ex);

            return error($ex->getMessage());
        }
    }

    public function sendNewsletterMail(Collection $newsletter): JsonResponse
    {
        try {

            Mail::to([$newsletter->email])->send(new NewslettersMail($newsletter));

            return success('Newsletters Mail sent ');

        } catch (\Exception $ex) {

            logError('MailService@sendNewslettersMail', $ex);

            return error($ex->getMessage());
        }

    }
}
