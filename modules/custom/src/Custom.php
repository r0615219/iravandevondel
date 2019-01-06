<?php
/**
 * Custom module for Craft CMS 3.x
 *
 * Some cool functions here
 *
 * @link      http://carolineboeykens.be
 * @copyright Copyright (c) 2018 Caroline Boeykens
 */

namespace modules\custom;

use craft\services\Elements;
use modules\custom\assetbundles\custom\CustomAsset;
//use modules\custom\services\CustomService as CustomService;
use modules\custom\services\CustomService;

use Craft;
use craft\events\RegisterTemplateRootsEvent;
use craft\events\TemplateEvent;
use craft\i18n\PhpMessageSource;
use craft\web\View;

use yii\base\Event;
use yii\base\Module;

/**
 * Craft plugins are very much like little applications in and of themselves. We’ve made
 * it as simple as we can, but the training wheels are off. A little prior knowledge is
 * going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL,
 * as well as some semi-advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 *
 * @author    Caroline Boeykens
 * @package   Custom
 * @since     1.0.0
 *
 * @property  CustomServiceService $customService
 */
class Custom extends Module
{
    public static $instance;

    public function __construct($id, $parent = null, array $config = [])
    {
        Craft::setAlias('@modules/custom', $this->getBasePath());
        $this->controllerNamespace = 'modules\custom\controllers';

        // Translation category
        $i18n = Craft::$app->getI18n();
        /** @noinspection UnSafeIsSetOverArrayInspection */
        if (!isset($i18n->translations[$id]) && !isset($i18n->translations[$id.'*'])) {
            $i18n->translations[$id] = [
                'class' => PhpMessageSource::class,
                'sourceLanguage' => 'en-US',
                'basePath' => '@modules/custom/translations',
                'forceTranslation' => true,
                'allowOverrides' => true,
            ];
        }

        // Base template directory
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS, function (RegisterTemplateRootsEvent $e) {
            if (is_dir($baseDir = $this->getBasePath().DIRECTORY_SEPARATOR.'templates')) {
                $e->roots[$this->id] = $baseDir;
            }
        });

        // Set this as the global instance of this module class
        static::setInstance($this);

        parent::__construct($id, $parent, $config);
    }

    public function init()
    {
        parent::init();
        self::$instance = $this;

        // Load our AssetBundle
        if (Craft::$app->getRequest()->getIsCpRequest()) {
            Event::on(
                View::class,
                View::EVENT_BEFORE_RENDER_TEMPLATE,
                function (TemplateEvent $event) {
                    Craft::$app->getView()->registerAssetBundle(CustomAsset::class);
                }
            );
        }
    }
}
