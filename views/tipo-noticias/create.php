<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TipoNoticia */

$this->title = 'Create Tipo Noticia';
$this->params['breadcrumbs'][] = ['label' => 'Tipo Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-noticia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
