<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\entities\Authors */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Authors',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="authors-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
