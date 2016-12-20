<?php

namespace frontend\modules\api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use yii\filters\ContentNegotiator;
use yii\rest\OptionsAction;
use yii\web\Response;
use yii\filters\Cors;
use yii\data\ActiveDataProvider;
use common\models\entities\Books;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `v1` module
 */
class BookController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'charset' => 'UTF-8',
            ],
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
        ];
        return $behaviors;
    }
    
    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::className(),
            ],
        ];
    }
    
    /**
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        return new ActiveDataProvider([
            'query' => Books::find()->with('authors')->orderBy('updated_at DESC'),
        ]);
    }
    
    /**
     * @param $id
     * @return array
     */
    public function actionView($id)
    {
        try {
            Yii::$app->getResponse()->setStatusCode(200);
            return [
                'success' => true,
                'data' => $this->findBook($id),
            ];
        } catch (NotFoundHttpException $exc) {
            Yii::$app->response->setStatusCode(404);
            return [
                'success' => false,
                'errors' => "Record not found!",
            ];
        }
    }
    
    /**
     * @return array
     */
    public function actionCreate()
    {
        $books = new Books();
        if ($books->load(Yii::$app->request->post()) && $books->save()) {
            return [
                'success' => true,
                'message' => "Book was added!",
            ];
        }
        return [
            'success' => false,
            'message' => $books->errors,
        ];
    }
    
    /**
     * @param $id
     * @return array
     */
    public function actionUpdate($id)
    {
        $book = $this->findBook($id);
        if ($book->load(Yii::$app->request->post()) && $book->save()) {
            return [
                'success' => true,
                'message' => "Book was updated!",
            ];
        }
        return [
            'success' => false,
            'message' => $book->errors,
        ];
    }
    
    /**
     * @param $id
     * @return array
     */
    public function actionDelete($id) {
        $book = $this->findBook($id);
        if ($book->delete()) {
            return [
                'success' => true,
                'message' => "Book was deleted!",
            ];
        }
        return [
            'success' => false,
            'message' => $book->errors,
        ];
    }
    
    /**
     * @param $id
     * @return array|Books|null
     * @throws NotFoundHttpException
     */
    protected function findBook($id)
    {
        if (($model = Books::find()->where(['id' => $id])->with('authors')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
