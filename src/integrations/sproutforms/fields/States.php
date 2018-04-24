<?php

namespace barrelstrength\sproutformsusstates\integrations\sproutforms\fields;

use Craft;
use craft\helpers\Template as TemplateHelper;
use craft\base\ElementInterface;
use craft\base\PreviewableFieldInterface;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;

use barrelstrength\sproutforms\contracts\BaseFormField;

/**
 * Class States
 *
 * @package Craft
 */
class States extends BaseFormField implements PreviewableFieldInterface
{
    /**
     * @var string
     */
    public $cssClasses;

    /**
     * @var int|null The maximum number of characters allowed in the field
     */
    public $defaultState;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-forms-usstates', 'US States');
    }

    /**
     * @return string
     */
    public function getSvgIconPath()
    {
        return '@sproutbaseicons/united-states-state.svg';
    }

    /**
     * @inheritdoc
     * @throws \yii\base\Exception
     */
    public function getSettingsHtml()
    {
        $options = $this->getOptions();

        $rendered = Craft::$app->getView()->renderTemplate(
            'sprout-forms-usstates/_formtemplates/fields/states/settings',
            [
                'field' => $this,
                'options' => $options
            ]
        );

        return $rendered;
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        return Craft::$app->getView()->renderTemplate('sprout-base/sproutfields/_fields/singleline/input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
            ]);
    }

    /**
     * @inheritdoc
     * @throws \yii\base\Exception
     */
    public function getExampleInputHtml()
    {
        $options = $this->getOptions();
        return Craft::$app->getView()->renderTemplate('sprout-forms-usstates/_formtemplates/fields/states/example',
            [
                'field' => $this,
                'options' => $options
            ]
        );
    }

    /**
     * @inheritdoc
     * @throws \yii\base\Exception
     */
    public function getFrontEndInputHtml($value, array $renderingOptions = null): string
    {
        $options = $this->getOptions();
        $rendered = Craft::$app->getView()->renderTemplate(
            'states/input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'options' => $options,
                'renderingOptions' => $renderingOptions
            ]
        );

        return TemplateHelper::raw($rendered);
    }

    /**
     * @inheritdoc
     */
    public function getTemplatesPath()
    {
        return Craft::getAlias('@barrelstrength/sproutformsusstates/templates/_formtemplates/fields/');
    }

    /**
     * Return US states as options for select field
     * @return array
     */
    private function getOptions()
    {
        $subdivisionObj = new SubdivisionRepository;
        $options = [];
        $states = $subdivisionObj->getAll('US');

        foreach ($states as $state) {
            $stateName = $state->getName();
            $options[$stateName] = $stateName;
        }

        return $options;
    }
}
