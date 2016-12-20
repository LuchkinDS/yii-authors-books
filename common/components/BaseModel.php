<?php
/**
 * Created by PhpStorm.
 * User: luchkinds
 * Date: 19.12.16
 * Time: 11:27
 */

namespace common\components;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class BaseModel extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }
}