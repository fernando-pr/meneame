<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Noticia */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noticia-view">



    <p>
        <h2><a href="<?=$model->enlace ?>"> <?= $model->titulo ?></a></h2>
    </p>
    <p><?= $model->cuerpo ?></p>
    <p>
        subido por :<?= $model->usuario->nombre?> |
        tipo:<?= $model->tipoNoticia->tipo?> |
        fecha:<?= $model->publicado ?>
    </p><br><br>
    <h3>Comentarios (<?= $numComentarios; ?>)</h3><br><br>
    <p>
        <!-- Html::a('Profile', ['user/view', 'id' => $id], ['class' => 'profile-link'])  -->
        <?= Html::a(
            'Comentar',
            ['../comentarios/create', 'id_noticia' => $model->id],
            ['class' => 'btn btn-success']
        ); ?>
    </p>
    <?php foreach ($comentarios as $comentario) {?>
        <div class="bg-info">
            <p>Autor del comentario:<?= $comentario->usuario->nombre ?></p>
            <p><?= $comentario->comentario ?></p>
            <p>Fecha comentario:<?= $comentario->fecha ?></p>
        </div>
        <?php } ?>
    </div>
