<?php

namespace common\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\entities\Books;

/**
 * BooksSearch represents the model behind the search form about `common\models\entities\Books`.
 */
class BooksSearch extends Books
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['created_at', 'updated_at'], 'date', 'format' => 'dd-mm-yyyy'],
            [['name', 'authorsName'], 'safe'],
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
        $query = Books::find()->with('authors');
        
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'FROM_UNIXTIME({{%books}}.created_at, "%d-%m-%Y")' => $this->created_at,
            'FROM_UNIXTIME({{%books}}.updated_at, "%d-%m-%Y")' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', '{{%books}}.name', $this->name]);
        
        $query->joinWith('authors')->andFilterWhere(['like', '{{%authors}}.name', $this->authorsName]);
        
        return $dataProvider;
    }
}
