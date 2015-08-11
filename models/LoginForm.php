<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $login;
    public $password;

    private $_user;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors() && (!$this->user || !$this->user->validatePassword($this->password)))
            $this->addError($attribute, 'Неверный логин или пароль.');
    }

    public function login()
    {
        return $this->validate() && Yii::$app->user->login($this->user, 3 * 3600);
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    public function getUser()
    {
        if ($this->_user === null)
            $this->_user = User::findByName($this->login);
        return $this->_user;
    }
}
