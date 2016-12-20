<?php

namespace common\models\entities;

use Yii;
use yii\db\ActiveQuery;
use common\components\BaseModel;
use common\models\queries\BooksQuery;
use common\components\behaviors\ManyToManyBehavior;

/**
 * This is the model class for table "{{%books}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthorsBooks[] $authorsBooks
 * @property Authors[] $authors
 */
class Books extends BaseModel
{
    public $authorsName;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%books}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'authors'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'integer'],
            ['authors', 'each', 'rule' => ['integer']],
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
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => ManyToManyBehavior::className(),
            'relationAttribute' => 'authors',
        ];
        return $behaviors;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthorsBooks()
    {
        return $this->hasMany(AuthorsBooks::className(), ['book_id' => 'id']);
    }
    
    /**
     * @return ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Authors::className(), ['id' => 'author_id'])
            ->viaTable(AuthorsBooks::tableName(), ['book_id' => 'id']);
    }
    
    /**
     * @param $authors
     */
    public function setAuthors($authors)
    {
        $this->populateRelation('authors', $authors);
    }
    
    /**
     * @inheritdoc
     * @return \common\models\queries\BooksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BooksQuery(get_called_class());
    }
    
    /**
     * @return array
     */
    public function fields()
    {
        return ['id', 'name', 'created_at', 'updated_at', 'authors'];
    }
}
