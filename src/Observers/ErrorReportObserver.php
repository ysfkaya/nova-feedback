<?php

namespace Ysfkaya\NovaFeedback\Observers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Ysfkaya\NovaFeedback\Mail\NewErrorReportMail;
use Ysfkaya\NovaFeedback\Models\ErrorReport;
use Ysfkaya\NovaFeedback\Models\ErrorReportParticipant;

class ErrorReportObserver
{
    /**
     * @param ErrorReport $errorReport
     */
    public function created($errorReport)
    {
        $this->sendMail($errorReport);
        $this->setParticipants($errorReport);
    }


    /**
     * @param ErrorReport $errorReport
     */
    public function retrieved($errorReport)
    {
        $errorReport->markAsReadByCurrentUser();
    }

    /**
     * In fact, we need to delete the participant from this model.
     *
     * @param ErrorReport $errorReport
     * @return void
     */
    public function deleting($errorReport)
    {
        $errorReport->removeParticipantCurrentUser();
    }

    /**
     * @param ErrorReport $errorReport
     * @return void
     */
    public function restoring($errorReport)
    {
        $errorReport->activateAllParticipants();
    }


    /**
     * @param ErrorReport $errorReport
     */
    protected function setParticipants($errorReport)
    {
        // Sender
        ErrorReportParticipant::create([
            'error_report_id' => $errorReport->id,
            'user_id' => auth()->id(),
            'last_read' => Carbon::now()
        ]);

        $errorReport->addParticipant(1); // Will be configure when users table is ready
    }

    /**
     * @param $errorReport
     */
    protected function sendMail($errorReport): void
    {
        $mails = config('nova-feedback.mails');

        if (empty($mails)) {
            return;
        }

        Mail::to($mails)->send(new NewErrorReportMail($errorReport));
    }
}