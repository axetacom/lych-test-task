<?php

/* @var $this yii\web\View */
/* @var $model app\models\Comment */

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="comment">
    <p><?= HtmlPurifier::process($model->text) ?></p>
    <div class="info">
        <div class="fl_l"><?= Html::encode($model->created) ?></div>
        <div class="fl_r"><?= $model->user ? Html::encode($model->user0->name) : 'Аноним' ?></div>
    </div>
</div>