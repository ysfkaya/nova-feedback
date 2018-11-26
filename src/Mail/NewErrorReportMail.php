<?php

namespace Ysfkaya\NovaFeedback\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Ysfkaya\NovaFeedback\Models\ErrorReport;

class NewErrorReportMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var ErrorReport
     */
    private $model;

    /**
     * Create a new message instance.
     *
     * @param ErrorReport $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('nova-feedback::mail.error', ['error' => $this->model])->subject(trans('nova-feedback::resources.error_report') . ' [' . env('SITE_NAME', 'Laravel') . ']');
    }
}
