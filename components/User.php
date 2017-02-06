<?php

namespace app\components;

class User extends \yii\web\User
{
    /**
     * Comprueba si el usuario tiene como nombre admin
     * @return bool Devuelve verdadero si el nombre del usuario es admin
     */
    public function getEsAdmin()
    {
        return ($this->identity) ? $this->identity->nombre === 'admin' : false;
    }
}
