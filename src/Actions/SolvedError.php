<?php

namespace Ysfkaya\NovaFeedback\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Ysfkaya\NovaFeedback\Feedback;

/**
 * Class SolvedError
 * @package Ysfkaya\NovaFeedback\Actions
 */
class SolvedError extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;


    /**
     * The displayable name of the action.
     *
     * @var string
     */
    public $name = 'Çözüldü İşaretle';

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
            $model->markAsSolved();
        }

        return Action::message('İşlem gerçekleştirildi');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [];
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function authorizedToSee(Request $request)
    {
        return Feedback::hasDeveloperRole($request);
    }

    /**
     * @param Request $request
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function authorizedToRun(Request $request, $model)
    {
        return Feedback::hasDeveloperRole($request);
    }
}
