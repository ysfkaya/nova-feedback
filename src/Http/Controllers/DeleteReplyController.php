<?php

namespace Ysfkaya\NovaFeedback\Http\Controllers;


use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ysfkaya\NovaFeedback\Models\ErrorReportReply;

class DeleteReplyController extends Controller
{
    use ValidatesRequests;

    public function __invoke(ErrorReportReply $errorReportReply, Request $request)
    {
        $errorReportReply->delete();

        return response()->json([
            'success' => true,
            'code' => 200,
        ]);
    }
}