<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "noticias".
 *
 * @property integer $id
 * @property string $titulo
 * @property string $cuerpo
 * @property string $enlace
 * @property string $publicado
 * @property integer $tipo_noticia
 * @property integer $id_usuario
 *
 * @property Comentarios[] $comentarios
 * @property TipoNoticia $tipoNoticia
 * @property Usuarios $idUsuario
 */
class Noticia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'noticias';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['titulo', 'cuerpo', 'enlace', 'tipo_noticia', 'id_usuario'], 'required'],
            [['cuerpo'], 'string'],
            [['publicado'], 'safe'],
            [['tipo_noticia', 'id_usuario'], 'integer'],
            [['titulo', 'enlace'], 'string', 'max' => 255],
            [['tipo_noticia'], 'exist', 'skipOnError' => true, 'targetClass' => TipoNoticia::className(), 'targetAttribute' => ['tipo_noticia' => 'id']],
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
            'titulo' => 'Titulo',
            'cuerpo' => 'Cuerpo',
            'enlace' => 'Enlace',
            'publicado' => 'Publicado',
            'tipo_noticia' => 'Tipo Noticia',
            'id_usuario' => 'Id Usuario',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::className(), ['id_noticia' => 'id'])->inverseOf('idNoticia');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNoticia()
    {
        return $this->hasOne(TipoNoticia::className(), ['id' => 'tipo_noticia'])->inverseOf('noticias');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario'])->inverseOf('noticias');
    }
}
