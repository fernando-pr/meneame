<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Usuario;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    /**
     * nombre de usuario
     * @var string
     */
    public $username;
    /**
     * contraseña del usuario
     * @var [type]
     */
    public $password;
    /**
     * casilla para recordad nombre y contraseña
     * @var bool
     */
    public $rememberMe = true;

    /**
     * variable que guarda un usuario
     * @var bool
     */
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Nombre',
            'password' => 'Contraseña',
            'rememberMe' => 'Recuerdame',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validarPassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Busca un usuario por nombre
     *
     * @return $_user|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuario::buscarPorNombre($this->username);
        }

        return $this->_user;
    }
}
