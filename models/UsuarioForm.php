<?php

namespace app\models;

class UsuarioForm extends \yii\base\Model
{
    public $nombre;
    public $password;
    public $passwordConfirm;
    public $email;

    public function rules()
    {
        return [
            [['nombre', 'password', 'passwordConfirm', 'email'], 'required'],
            [['nombre'], 'string', 'max' => 15],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Nombre',
            'password' => 'Contraseña',
            'passwordConfirm' => 'Confirmar contraseña',
            'email' => 'Email',
        ];
    }
}
