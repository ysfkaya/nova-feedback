<?php

namespace Ysfkaya\NovaFeedback\Http\Controllers;


use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ysfkaya\NovaFeedback\Models\ErrorReport;

class SendReplyController extends Controller
{
    use ValidatesRequests;

    public function __invoke(ErrorReport $errorReport, Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $errorReport->createReply([
            'reply_body' => $request->get('body'),
            'user_id' => auth()->id(),
            'ip_address' => $request->ip()
        ]);

        return response()->json([
            'success' => true,
            'code' => 200
        ]);

    }
}