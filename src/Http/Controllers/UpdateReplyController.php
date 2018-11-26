<?php

namespace Ysfkaya\NovaFeedback\Http\Controllers;


use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ysfkaya\NovaFeedback\Models\ErrorReportReply;

class UpdateReplyController extends Controller
{
    use ValidatesRequests;

    public function __invoke(ErrorReportReply $errorReportReply, Request $request)
    {
        $input = 'reply_' . $request->get('index');

        $this->validate($request, [
            $input => 'required'
        ]);

        $errorReportReply->update([
            'reply_body' => $request->get($input),
        ]);

        return response()->json([
            'success' => true,
            'code' => 200,
            'item' => $errorReportReply
        ]);
    }
}