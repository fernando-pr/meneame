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
class Usuario extends \yii\db\ActiveRecord
{
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
            [['nombre', 'email', 'password'], 'required'],
            [['created_at'], 'safe'],
            [['nombre'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 255],
            [['token', 'activacion'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 60],
            [['nombre'], 'unique'],
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
