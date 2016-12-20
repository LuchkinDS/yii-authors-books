<?php

/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = 'books list';
?>
<div class="site-index">

    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_book',
    ]); ?>
    
</div>
