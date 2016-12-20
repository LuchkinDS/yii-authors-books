<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\BooksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Books');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="books-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Books'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
    
                // 'id',
                'name',
                [
                    'attribute' => 'created_at',
                    'filter' => DatePicker::widget([
                        'attribute' => 'created_at',
                        'model' => $searchModel,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-mm-yyyy',
                        ]
                    ]),
                    'format' => 'date',
                ],
                [
                    'attribute' => 'updated_at',
                    'filter' => DatePicker::widget([
                        'attribute' => 'updated_at',
                        'model' => $searchModel,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-mm-yyyy',
                        ]
                    ]),
                    'format' => 'date',
                ],
                [
                    'attribute' => 'authorsName',
                    'content' => function($data)
                    {
                        $names = [];
                        foreach ($data->authors as $author) {
                            $names[] = $author->name;
                        }
                        return implode(', ', $names);
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
</div>
