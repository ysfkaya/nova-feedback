<?php

namespace Ysfkaya\NovaFeedback\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Vyuldashev\NovaMoneyField\Money;
use Ysfkaya\NovaFeedback\Feedback;

/**
 * Class UnApprovePricingDevelopment
 * @package Ysfkaya\NovaFeedback\Actions
 */
class UnApprovePricingDevelopment extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Indicates if this action is only available on the resource detail view.
     *
     * @var bool
     */
    public $onlyOnDetail = true;

    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Fiyatı Kabul Etme !';


    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields $fields
     * @param  \Illuminate\Support\Collection $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->markAsUnApproved();
        }
    }


    /**
     * @param Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function authorizedToRun(Request $request, $model)
    {
        return Feedback::hasOwnerRole($request);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function authorizedToSee(Request $request)
    {
        return Feedback::hasOwnerRole($request);
    }

}
