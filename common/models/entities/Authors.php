<?php

namespace common\models\entities;

use Yii;
use yii\db\ActiveQuery;
use common\components\BaseModel;
use common\models\queries\AuthorsQuery;

/**
 * This is the model class for table "{{%authors}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthorsBooks[] $authorsBooks
 * @property Books[] $books
 */
class Authors extends BaseModel
{
    public $countBooks;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%authors}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorsBooks()
    {
        return $this->hasMany(AuthorsBooks::className(), ['author_id' => 'id']);
    }
    
    /**
     * @return ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Books::className(), ['id' => 'book_id'])
            ->viaTable(AuthorsBooks::tableName(), ['author_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return \common\models\queries\AuthorsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthorsQuery(get_called_class());
    }
}
