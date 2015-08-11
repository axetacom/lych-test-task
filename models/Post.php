<?php

namespace app\models;

use Yii;
use \yii\db\Expression;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property integer $user
 * @property string $title
 * @property string $text
 * @property string $created
 * @property string $updated
 *
 * @property Comment[] $comments
 * @property User $user0
 */
class Post extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'user' => 'Автор',
            'title' => 'Название',
            'text' => 'Текст',
            'created' => 'Создана',
            'updated' => 'Изменена',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['post' => 'id']);
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
        if ($this->isNewRecord)
        {
            $this->user = Yii::$app->user->id;
            $this->created = new Expression('NOW()');
        }
        $this->updated = new Expression("NOW()");
        return parent::beforeSave($insert);
    }
}
