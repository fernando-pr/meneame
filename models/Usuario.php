<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $email
 * @property string $token
 * @property string $activacion
 * @property string $password
 * @property string $created_at
 *
 * @property Comentarios[] $comentarios
 * @property Noticias[] $noticias
 */
class Usuario extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * Valor del escenario para la creación de nuevos usuarios
     * @var string
     */
    const ESCENARIO_CREATE = 'create';

    /**
     * Contraseña del usuario
     * @var string
     */
    public $pass;
    /**
     * Confirmación de la contraseña del usuario
     * @var string
     */
    public $passwordConfirm;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['nombre', 'email', 'password', 'passwordConfirm'], 'required'],
            [['nombre', 'email'], 'required'],
            [['password', 'passwordConfirm'], 'required', 'on' => self::ESCENARIO_CREATE],
            [['password'], 'safe'],
            [['created_at'], 'safe'],
            [['nombre'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 255],
            [['token', 'activacion'], 'string', 'max' => 32],
            [['nombre'], 'unique'],
            [['passwordConfirm'], 'confirmarPassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'email' => 'Email',
            'token' => 'Token',
            'activacion' => 'Activacion',
            'password' => 'Contraseña',
            'passwordConfirm' => 'Confirmar contraseña',
            'created_at' => 'Created At',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * Busca un usuario por el nombre
     * @param  string $nombre   Nombre del usuario
     * @return static           Instancia del usuario que coincida con el nombre
     */
    public static function buscarPorNombre($nombre)
    {
        return static::findOne(['nombre' => $nombre]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->token === $authKey;
    }

    /**
     * Comprueba la contraseña y la confirmacion de la contraseña
     * @param  [type] $attribute [description]
     * @param  [type] $params    [description]
     */
    public function confirmarPassword($attribute, $params)
    {
        if ($this->password !== $this->passwordConfirm) {
            $this->addError($attribute, 'Las contraseñas no coinciden');
        }
    }

    /**
     * Comprueba si el usuario es administrador
     * @return bool Devuelve verdadero si el nombre del usuario es admin
     */
    public function esAdmin()
    {
        return $this->nombre === 'admin';
    }

    /**
     * Comprueba si la contraseña introducida es valida
     * @param  string $password La contraseña del usuario
     * @return bool             Devuelve verdadero si la contraseña valida
     */
    public function validarPassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->password != '' || $insert) {
                $this->password = Yii::$app->security->generatePasswordHash($this->password);
            }
            if ($insert) {
                $this->token = Yii::$app->security->generateRandomString();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::className(), ['id_usuario' => 'id'])->inverseOf('idUsuario');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticias()
    {
        return $this->hasMany(Noticia::className(), ['id_usuario' => 'id'])->inverseOf('idUsuario');
    }
}
