<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $post app\models\Post */
/* @var $comment app\models\Comment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $post->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h1><?= Html::encode($post->title) ?></h1>

    <p class="text"><?= nl2br(Html::encode($post->text)) ?></p>

    <div class="info">
        <div class="fl_l"><?= Html::encode($post->created) ?></div>
        <div class="fl_r"><?= Html::encode($post->user0->name) ?></div>
    </div>

    <? if ($post->user == Yii::$app->user->id || Yii::$app->user->id && Yii::$app->user->identity->isAdmin): ?>
        <p>
            <?= Html::a('Редактировать', ['edit', 'id' => $post->id], ['class' => 'btn btn-primary']) ?>
            <? if (Yii::$app->user->id && Yii::$app->user->identity->isAdmin): ?>
                <?= Html::a('Удалить', ['delete', 'id' => $post->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы действительно хотите удалить эту статью?',
                        'method' => 'post',
                    ],
                ]) ?>
            <? endif; ?>
        </p>
    <? endif; ?>
    
    <h3 class="mt50">Комментарии</h3>
    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_comment',
        'emptyText' => 'Нет комментариев',
        'summary' => '',
    ]); ?>
    
    <h4 class="mt30">Оставить комментарий</h4>
    
    <div class="comment-form">

        <?php $form = ActiveForm::begin(['action' => ['comment', 'post' => $post->id]]); ?>

        <?= $form->field($comment, 'text')->textarea(['rows' => 6])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton(
                'Отправить', 
                ['class' => 'btn btn-success']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    
</div>
