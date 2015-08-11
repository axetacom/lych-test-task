<?php

namespace app\models;

use Yii;
use \yii\db\Expression;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $post
 * @property integer $user
 * @property string $text
 * @property string $created
 *
 * @property Post $post0
 * @property User $user0
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'post' => '№ статьи',
            'user' => 'Автор',
            'text' => 'Текст',
            'created' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost0()
    {
        return $this->hasOne(Post::className(), ['id' => 'post']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
    
    public function beforeSave($insert)
    {
        $this->user = Yii::$app->user->id;
        $this->created = new Expression('NOW()');
        return parent::beforeSave($insert);
    }
}
