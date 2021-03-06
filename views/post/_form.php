<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Отправить' : 'Сохранить', 
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
         <?= Html::a(
            'Отмена', 
            $model->isNewRecord ? ['site/index'] : ['view', 'id' => $model->id], 
            ['class' => 'btn btn-danger']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
