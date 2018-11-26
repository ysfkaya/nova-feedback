<?php

namespace Ysfkaya\NovaFeedback\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Trix;
use Vyuldashev\NovaMoneyField\Money;
use Ysfkaya\NovaFeedback\Feedback;
use Ysfkaya\NovaFeedback\Models\Development;

class PricingDevelopment extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;


    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Fiyatlandır';

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
            $model->update([
                'price' => $fields->get('price'),
                'price_desc' => $fields->get('price_desc'),
                'status' => Development::PRICED
            ]);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Number::make(trans('nova-feedback::developments.price'), 'price')->rules('required'),
            Trix::make(trans('nova-feedback::developments.price_desc'), 'price_desc')
        ];
    }

    public function authorizedToRun(Request $request, $model)
    {
        return Feedback::hasDeveloperRole($request);
    }

    public function authorizedToSee(Request $request)
    {
        return Feedback::hasDeveloperRole($request);
    }
}
