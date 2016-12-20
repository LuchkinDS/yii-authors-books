<?php

namespace frontend\modules\api;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\rest\UrlRule;

/**
 * api module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\api\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    
        $this->modules = [
            'v1' => [
                'class' => \frontend\modules\api\modules\v1\Module::className(),
            ],
        ];
    }
    
    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            [
                'class' => UrlRule::className(),
                'controller' => ['api/v1/book'],
                // 'extraPatterns' => [],
            ],
        ], false);
    }
}
