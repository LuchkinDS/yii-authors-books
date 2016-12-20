<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\entities\Authors;

/**
 * AuthorsSearch represents the model behind the search form about `common\models\entities\Authors`.
 */
class AuthorsSearch extends Authors
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'countBooks'], 'integer'],
            [['created_at', 'updated_at'], 'date', 'format' => 'dd-mm-yyyy'],
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Authors::find()
            ->addSelect('{{%authors}}.*, COUNT({{%authors_books}}.author_id) as countBooks')
            ->joinWith('books')
            ->groupBy('{{%authors}}.id');

        /*
        $query = Authors::find()
            ->addSelect('{{%authors}}.*, COUNT({{%authors_books}}.author_id) as countBooks')
            ->leftJoin('{{%authors_books}}', '{{%authors_books}}.author_id = {{%authors}}.id')
            ->groupBy('{{%authors}}.id');
        */
        // SELECT `authors`.*, COUNT(authors_books.author_id) as count_books FROM `authors` left join authors_books on authors_books.author_id = authors.id GROUP BY authors.id
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                // 'id',
                'name',
                'created_at',
                'updated_at',
                'countBooks',
            ],
        ]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'FROM_UNIXTIME({{%authors}}.created_at, "%d-%m-%Y")' => $this->created_at,
            'FROM_UNIXTIME({{%authors}}.updated_at, "%d-%m-%Y")' => $this->updated_at,
        ]);
        
        /* available since version 2.0.11
        $query->andFilterHaving([
            'countBooks' => $this->countBooks,
        ]);
        */
        
        if ($this->countBooks !== '' && $this->countBooks !== null) {
            $query->having([
                'countBooks' => $this->countBooks,
            ]);
        }
        
        $query->andFilterWhere(['like', 'name', $this->name]);
        
        return $dataProvider;
    }
}
