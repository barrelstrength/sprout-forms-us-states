<?php
/**
 * Sprout Forms States plugin for Craft CMS 3.x
 *
 * US states fields for Sprout Forms
 *
 * @link      https://www.barrelstrengthdesign.com/
 * @copyright Copyright (c) 2018 Barrel Strength
 */

namespace barrelstrength\sproutformsusstates;

use barrelstrength\sproutforms\services\Fields;
use barrelstrength\sproutforms\events\RegisterFieldsEvent;
use barrelstrength\sproutformsusstates\integrations\sproutforms\fields\States;

use craft\base\Plugin;

use yii\base\Event;

class SproutFormsUsStates extends Plugin
{
    public $hasCpSettings = false;

    public $hasCpSection = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELDS, function(RegisterFieldsEvent $event) {
            $event->fields[] = new States();
        });
    }
}
