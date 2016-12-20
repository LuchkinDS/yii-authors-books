<?php

namespace common\models\queries;

/**
 * This is the ActiveQuery class for [[\common\models\entities\Authors]].
 *
 * @see \common\models\entities\Authors
 */
class AuthorsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\entities\Authors[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\entities\Authors|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
