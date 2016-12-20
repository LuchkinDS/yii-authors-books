<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\entities\Authors */

$this->title = Yii::t('app', 'Create Authors');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Authors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
