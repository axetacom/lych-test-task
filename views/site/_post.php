<?php

/* @var $this yii\web\View */
/* @var $model app\models\Post */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h2><?= Html::encode($model->title) ?></h2>
    
    <p><?= HtmlPurifier::process($model->text) ?></p>
    
    <p><?= Html::a('Подробнее', ['post/view', 'id' => $model->id]) ?></p>
</div>