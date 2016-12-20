<?php

namespace common\models\queries;

/**
 * This is the ActiveQuery class for [[\common\models\entities\Books]].
 *
 * @see \common\models\entities\Books
 */
class BooksQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\entities\Books[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\entities\Books|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
