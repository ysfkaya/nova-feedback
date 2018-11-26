<?php

namespace Ysfkaya\NovaFeedback\Resources;

use App\Nova\Resource;
use App\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Ysfkaya\NovaFeedback\Actions\ApprovePricingDevelopment;
use Ysfkaya\NovaFeedback\Actions\PricingDevelopment;
use Ysfkaya\NovaFeedback\Actions\UnApprovePricingDevelopment;
use Ysfkaya\NovaFeedback\Fields\BelongsToHidden;
use Ysfkaya\NovaFeedback\Models\Development as DevelopmentModel;

/**
 * Class Development
 * @package Ysfkaya\NovaFeedback\Resources
 */
class Development extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Ysfkaya\NovaFeedback\Models\Development';

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

            BelongsToHidden::make(trans('nova-feedback::developments.creator'), 'creator', User::class)->currentUser($request),

            Text::make(trans('nova-feedback::developments.subject'), 'subject')->rules('required', 'max:255'),

            Text::make(trans('nova-feedback::developments.status'), 'status')
                ->exceptOnForms()
                ->displayUsing(function ($value) {
                    return DevelopmentModel::displayStatusByValue($value);
                })
                ->asHtml()
                ->sortable(),

            Trix::make(trans('nova-feedback::developments.description'), 'body')
                ->rules('required')
                ->withFiles(),

            Text::make(trans('nova-feedback::developments.price'), 'price')->displayUsing(function ($value) {
                return number_format($value, 2) . ' ₺';
            })->onlyOnDetail(),

            Trix::make(trans('nova-feedback::developments.price_desc'), 'price_desc')->onlyOnDetail(),

            Date::make(trans('nova-feedback::developments.created_at'), 'created_at', function ($value) {
                return $value->format('Y-m-d H:i');
            })->exceptOnForms()->sortable()


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
            new PricingDevelopment,
            new ApprovePricingDevelopment,
            new UnApprovePricingDevelopment,
        ];
    }


    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return trans('nova-feedback::resources.development_request');
    }


    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return trans('nova-feedback::resources.development_requests');
    }


}