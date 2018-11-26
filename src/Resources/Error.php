<?php

namespace Ysfkaya\NovaFeedback\Resources;

use App\Nova\Resource;
use App\Nova\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Ysfkaya\NovaFeedback\Actions\SolvedError;
use Ysfkaya\NovaFeedback\Feedback;
use Ysfkaya\NovaFeedback\Fields\BelongsToHidden;
use Ysfkaya\NovaFeedback\Fields\Hidden;
use Ysfkaya\NovaFeedback\Fields\ReplyLink;
use Ysfkaya\NovaFeedback\Models\ErrorReport;

/**
 * Class Error
 * @package Ysfkaya\NovaFeedback\Resources
 */
class Error extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Ysfkaya\NovaFeedback\Models\ErrorReport';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * Hide resource from Nova's standard menu.
     *
     * @var bool
     */
    public static $displayInNavigation = false;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'subject'
    ];

    /**
     * @var array
     */
    public static $with = ['creator'];

    /**
     * @var array
     */
    private $priorityOptions = [];

    public function __construct(Model $resource)
    {
        parent::__construct($resource);

        $this->priorityOptions = [
            ErrorReport::PRIORITY_LOW => trans('nova-feedback::priorities.low'),
            ErrorReport::PRIORITY_MEDIUM => trans('nova-feedback::priorities.medium'),
            ErrorReport::PRIORITY_HIGH => trans('nova-feedback::priorities.high'),
            ErrorReport::PRIORITY_URGENT => trans('nova-feedback::priorities.urgent'),
        ];
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsToHidden::make(trans('nova-feedback::error_reports.creator'), 'creator', User::class)->currentUser($request),

            Text::make(trans('nova-feedback::error_reports.subject'), 'subject')->rules('required', 'max:255'),

            Select::make(trans('nova-feedback::error_reports.priority'), 'priority')->options($this->priorityOptions)->rules('required')->displayUsing(function ($value) {
                return ErrorReport::displayPriorityByValue($value);
            })->withMeta([
                'asHtml' => true
            ])->sortable(),

            Text::make(trans('nova-feedback::error_reports.status'), 'status')->exceptOnForms()->displayUsing(function ($value) {
                return ErrorReport::displayStatusByValue($value);
            })->asHtml()->sortable(),

            Trix::make(trans('nova-feedback::error_reports.description'), 'body')
                ->rules('required')
                ->withFiles(),

            Date::make(trans('nova-feedback::error_reports.created_at'), 'created_at', function ($value) {
                return $value->format('Y-m-d H:i');
            })->exceptOnForms()->sortable(),

            ReplyLink::make()
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new SolvedError
        ];
    }


    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return trans('nova-feedback::resources.error_report');
    }


    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return trans('nova-feedback::resources.error_reports');
    }

    public function authorizedToForceDelete(Request $request)
    {
        return Feedback::hasDeveloperRole($request);
    }

}