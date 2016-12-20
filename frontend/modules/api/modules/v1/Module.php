<?php

namespace frontend\modules\api\modules\v1;

use Yii;

/**
 * v1 module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    
        Yii::$app->user->enableSession = false;
    }
}
