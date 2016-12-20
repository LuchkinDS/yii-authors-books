<?php
/**
 * Created by PhpStorm.
 * User: luchkinds
 * Date: 19.12.16
 * Time: 15:46
 */

/* @var $model \common\models\entities\Books */

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo Yii::$app->formatter->asDate($model->updated_at, 'long'); ?></h3>
    </div>
    <div class="panel-body">
        <?php echo $model->name; ?>
    </div>
    <div class="panel-footer">
        <?php foreach ($model->authors as $author) { ?>
            <a href="#"><?php echo $author->name; ?></a>
        <?php } ?>
    </div>
</div>