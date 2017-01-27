<?php

namespace app\components;

class User extends \yii\web\User
{
    public function getEsAdmin()
    {
        return ($this->identity) ? $this->identity->nombre === 'admin' : false;
    }
}
