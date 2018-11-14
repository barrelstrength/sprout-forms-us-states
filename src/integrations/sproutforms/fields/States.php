<?php

namespace barrelstrength\sproutformsusstates\integrations\sproutforms\fields;

use CommerceGuys\Addressing\Subdivision\Subdivision;
use Craft;
use craft\helpers\Template as TemplateHelper;
use craft\base\ElementInterface;
use craft\base\PreviewableFieldInterface;
use CommerceGuys\Addressing\Subdivision\SubdivisionRepository;

use barrelstrength\sproutforms\base\FormField;

/**
 * Class States
 *
 * @package Craft
 */
class States extends FormField implements PreviewableFieldInterface
{
    /**
     * @var string
     */
    public $cssClasses;

    /**
     * @var string|null Default State
     */
    public $defaultState;

    /**
     * @var mixed All States
     */
    public $options;

    public function init()
    {
        if (is_null($this->options)){
            $this->options = $this->getOptions();
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-forms-us-states', 'US States');
    }

    /**
     * @return string
     */
    public function getSvgIconPath(): string
    {
        return '@sproutformsusstatesicons/us-map.svg';
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getSettingsHtml()
    {
        $rendered = Craft::$app->getView()->renderTemplate(
            'sprout-forms-us-states/_integrations/sproutforms/formtemplates/fields/states/settings',
            [
                'field' => $this,
                'options' => $this->options
            ]
        );

        return $rendered;
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        return Craft::$app->getView()->renderTemplate('_includes/forms/select',
            [
                'name' => $this->handle,
                'value' => $value ?? $this->defaultState,
                'options' => $this->options
            ]
        );
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getExampleInputHtml(): string
    {
        $options = $this->getOptions();

        return Craft::$app->getView()->renderTemplate('sprout-forms-us-states/_integrations/sproutforms/formtemplates/fields/states/example',
            [
                'field' => $this,
                'options' => $this->options
            ]
        );
    }

    /**
     * @inheritdoc
     *
     * @throws \Twig_Error_Loader
     * @throws \yii\base\Exception
     */
    public function getFrontEndInputHtml($value, array $renderingOptions = null): \Twig_Markup
    {
        $rendered = Craft::$app->getView()->renderTemplate(
            'states/input',
            [
                'name' => $this->handle,
                'value' => $value ?? $this->defaultState,
                'field' => $this,
                'options' => $this->options,
                'renderingOptions' => $renderingOptions
            ]
        );

        return TemplateHelper::raw($rendered);
    }

    /**
     * @inheritdoc
     */
    public function getTemplatesPath(): string
    {
        return Craft::getAlias('@barrelstrength/sproutformsusstates/templates/_integrations/sproutforms/formtemplates/fields/');
    }

    /**
     * Return US states as options for select field
     *
     * @return array
     */
    private function getOptions()
    {
        $subdivisionObj = new SubdivisionRepository();
        $options[] = Craft::t('sprout-forms-us-states', 'Select...');
        $states = $subdivisionObj->getAll(['US']);

        foreach ($states as $state) {
            /**
             * @var Subdivision $state
             */
            $stateName = $state->getName();
            $options[$stateName] = $stateName;
        }

        return $options;
    }
}
