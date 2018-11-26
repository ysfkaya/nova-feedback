<?php

namespace Ysfkaya\NovaFeedback\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ysfkaya\NovaFeedback\Feedback;
use Ysfkaya\NovaFeedback\Models\ErrorReport;

/**
 * Class ErrorController
 * @package Ysfkaya\NovaFeedback\Http\Controllers
 */
class ErrorController extends Controller
{
    /**
     * @param $id
     * @return ErrorReport
     */
    public function index($id)
    {
        return ErrorReport::with(['creator', 'replies'])->findOrFail($id);
    }

    /**
     * @param ErrorReport $errorReport
     * @return mixed
     */
    public function replies(ErrorReport $errorReport)
    {
        return $errorReport->replies;
    }

    /**
     * @param ErrorReport $errorReport
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function solved(ErrorReport $errorReport, Request $request)
    {

        if (!Feedback::hasDeveloperRole($request)) {
            return response()->json([
                'success' => false,
                'message' => __('Sorry! You are not authorized to perform this action.')
            ]);
        }

        $errorReport->markAsSolved();

        return response()->json([
            'success' => true
        ]);
    }
}