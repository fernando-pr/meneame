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
            [['nombre', 'email', 'password', 'passwordConfirm'], 'required'],
            [['created_at'], 'safe'],
            [['nombre'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 255],
            [['token', 'activacion'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 60],
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
            'password' => 'Password',
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

    public function confirmarPassword($attribute, $params)
    {
        if ($this->password !== $this->passwordConfirm) {
            $this->addError($attribute, 'Las contraseñas no coinciden');
        }
    }

    public function esAdmin()
    {
        return $this->nombre === 'admin';
    }

    public function validarPassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
            $this->token = Yii::$app->security->generateRandomString();
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
