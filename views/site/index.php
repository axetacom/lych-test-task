<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тестовый блог';
?>
<div class="site-index">

    <div class="body-content">
    
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_post',
            'emptyText' => 'Статей не найдено',
            'summary' => '',
        ]); ?>
    
    </div>
</div>
