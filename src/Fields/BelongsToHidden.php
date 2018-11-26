<?php

namespace Ysfkaya\NovaFeedback\Fields;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\ResourceDetailRequest;
use Laravel\Nova\Http\Requests\ResourceIndexRequest;

class BelongsToHidden extends BelongsTo
{

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'belongsto-hidden-field';

    /**
     * Fill the field value with the provided value.
     *
     * @param  string $value
     * @param $request
     * @return $this
     */
    public function default($request, string $value = null)
    {
        if ($request instanceof ResourceDetailRequest || $request instanceof ResourceIndexRequest) {
            return $this;
        }

        return $this->withMeta(['value' => $value]);
    }

    /**
     * Fill the field value with the current user id.
     *
     * @param Request $request
     * @return $this
     */
    public function currentUser($request)
    {
        if ($request instanceof ResourceDetailRequest || $request instanceof ResourceIndexRequest) {
            return $this;
        }

        return $this->withMeta([
            'value' => $request->user()->id,
        ]);
    }

}