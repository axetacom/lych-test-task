<?

namespace app\components;

class PhpAuthManager extends \yii\rbac\PhpManager
{
    public function init()
    {
        parent::init();
        $this->removeAll();
        $guestRole = $this->createRole('guest');
        $this->add($guestRole);
        if (\Yii::$app->user->isGuest)
            $this->assign($guestRole, \Yii::$app->user->id);
        else
        {
            $userRole = $this->createRole('user');
            $this->add($userRole);
            $this->addChild($userRole, $this->getRole('guest'));
            if (\Yii::$app->user->identity->isAdmin)
            {
                $adminRole = $this->createRole('admin');
                $this->add($adminRole);
                $this->addChild($adminRole, $userRole);
                $this->assign($adminRole, \Yii::$app->user->id);
            }
            else
                $this->assign($userRole, \Yii::$app->user->id);
        }
    }
}
