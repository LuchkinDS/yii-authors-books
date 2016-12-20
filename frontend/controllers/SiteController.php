<?php
namespace frontend\controllers;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use common\models\entities\Books;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Books::find()->with('authors')->orderBy('updated_at DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
