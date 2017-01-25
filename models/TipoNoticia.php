<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_noticia".
 *
 * @property integer $id
 * @property string $tipo
 *
 * @property Noticias[] $noticias
 */
class TipoNoticia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo_noticia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo'], 'required'],
            [['tipo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticias()
    {
        return $this->hasMany(Noticia::className(), ['tipo_noticia' => 'id'])->inverseOf('tipoNoticia');
    }
}
