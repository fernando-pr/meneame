<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comentarios".
 *
 * @property integer $id
 * @property string $comentario
 * @property string $fecha
 * @property integer $id_usuario
 * @property integer $id_noticia
 *
 * @property Noticias $idNoticia
 * @property Usuarios $idUsuario
 */
class Comentario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['comentario', 'id_usuario', 'id_noticia'], 'required'],
            [['comentario'], 'string'],
            [['fecha'], 'safe'],
            [['id_usuario', 'id_noticia'], 'integer'],
            [['id_noticia'], 'exist', 'skipOnError' => true, 'targetClass' => Noticia::className(), 'targetAttribute' => ['id_noticia' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comentario' => 'Comentario',
            'fecha' => 'Fecha',
            'id_usuario' => 'Id Usuario',
            'id_noticia' => 'Id Noticia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdNoticia()
    {
        return $this->hasOne(Noticia::className(), ['id' => 'id_noticia'])->inverseOf('comentarios');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario'])->inverseOf('comentarios');
    }
}
