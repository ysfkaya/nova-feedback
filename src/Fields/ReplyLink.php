<?php

namespace Ysfkaya\NovaFeedback\Fields;


use Laravel\Nova\Fields\Field;

class ReplyLink extends Field
{
    public $component = 'reply-link';

    /**
     * The text alignment for the field's text in tables.
     *
     * @var string
     */
    public $textAlign = 'right';

    public function __construct($name = null, $attribute = 'id')
    {
        parent::__construct($name, $attribute, function ($value, $resource) {
            return $resource->id;
        });

        $this->onlyOnIndex();
    }
}