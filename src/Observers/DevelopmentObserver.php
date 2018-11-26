<?php

namespace Ysfkaya\NovaFeedback\Observers;

use Illuminate\Support\Facades\Mail;
use Ysfkaya\NovaFeedback\Mail\NewDevelopmentMail;
use Ysfkaya\NovaFeedback\Models\Development;

class DevelopmentObserver
{
    /**
     * @param Development $development
     */
    public function created($development)
    {
        $this->sendMail($development);

    }

    /**
     * @param $development
     */
    protected function sendMail($development): void
    {
        $mails = config('nova-feedback.mails');

        if (empty($mails)) {
            return;
        }

        Mail::to($mails)->send(new NewDevelopmentMail($development));
    }
}