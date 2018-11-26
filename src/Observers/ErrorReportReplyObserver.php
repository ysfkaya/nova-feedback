<?php

namespace Ysfkaya\NovaFeedback\Observers;


use Ysfkaya\NovaFeedback\Models\ErrorReportReply;

class ErrorReportReplyObserver
{
    /**
     * @param ErrorReportReply $reply
     */
    public function created($reply)
    {
        $reply->errorReport->markAsAnswered();
        $reply->errorReport->addReplierAsParticipant();
    }


    /**
     * @param ErrorReportReply $reply
     */
    public function creating($reply)
    {
        $reply->errorReport->activateAllParticipants();
    }

    /**
     * @param ErrorReportReply $reply
     */
    public function deleted($reply)
    {
        if (!$reply->count()) {
            $reply->errorReport->markAsOnHold();
        }
    }


}