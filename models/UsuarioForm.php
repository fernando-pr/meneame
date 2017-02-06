<?php

namespace app\models;

class UsuarioForm extends \yii\base\Model
{
    /**
     * Nombre del usuario
     * @var string
     */
    public $nombre;
    /**
     * La contraseña del usuario
     * @var string
     */
    public $password;
    /**
     * La contraseña confirmada
     * @var string
     */
    public $passwordConfirm;
    /**
     * El email del usuario
     * @var string
     */
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
