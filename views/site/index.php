<?php

use yii\helpers\Html;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$noticias = $model;
?>
<div class="site-index">
    <div class="jumbotron">
        <h3>Meneame</h3>
    </div>

    <div class="body-content">
        <?= Html::a(
            'Publicar noticia',
            '../noticias/create',
            ['class' => 'btn btn-success pull-right']
        ); ?>
        <br><br><br>
        <div class="col">
            <?php foreach ($noticias as $noticia) {?>
                <div class="row-lg-1">
                    <h2><a href="<?=$noticia->enlace ?>"> <?= $noticia->titulo ?></a></h2>
                    <p><?= $noticia->cuerpo ?></p>
                    <p>
                        subido por :<?= $noticia->usuario->nombre?> |
                        tipo:<?= $noticia->tipoNoticia->tipo?> |
                        fecha:<?= $noticia->publicado ?>
                    </p>
                    <a href="../noticia/<?= $noticia->id?>">Comentarios (<?= $noticia->cuantosComentarios($noticia->id); ?>)</a>
                </div>
                <?php } ?>

            </div>
        </div>

    </div>
</div>
