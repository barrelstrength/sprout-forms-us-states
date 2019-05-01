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
use Craft;

use craft\base\Plugin;

use yii\base\Event;

class SproutFormsUsStates extends Plugin
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Craft::setAlias('@sproutformsusstatesicons', $this->getBasePath().'/web/icons');

        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELDS, static function(RegisterFieldsEvent $event) {
            $event->fields[] = new States();
        });
    }
}
