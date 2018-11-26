<?php

namespace Ysfkaya\NovaFeedback;

use Illuminate\Http\Request;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Ysfkaya\NovaFeedback\Resources\Development;
use Ysfkaya\NovaFeedback\Resources\Error;

class NovaFeedback extends Tool
{

    public $errorResource = Error::class;

    public $developmentResource = Development::class;

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('nova-feedback', __DIR__ . '/../dist/js/tool.js');
        Nova::script('tinymce_tr', __DIR__ . '/../dist/js/tr_TR.js');
        Nova::script('nova-feedback-field', __DIR__ . '/../dist/js/field.js');
        Nova::style('nova-feedback', __DIR__ . '/../dist/css/tool.css');


        if (Feedback::isInstalled()) {
            Nova::resources([
                $this->errorResource,
                $this->developmentResource
            ]);
        }
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return \Illuminate\View\View
     */
    public function renderNavigation()
    {
        return view('nova-feedback::navigation');
    }


    public function authorizedToSee(Request $request)
    {
        return Feedback::authorize($request, parent::authorizedToSee($request));
    }


    public function setErrorResource($resource)
    {
        $this->errorResource = $resource;

        return $this;
    }

    public function setDevelopmentResource($resource)
    {
        $this->developmentResource = $resource;

        return $this;
    }


}
