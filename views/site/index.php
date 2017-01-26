<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
$noticias = $model;
?>
<div class="site-index">
    <div class="jumbotron">
        <h3>Meneame</h3>
    </div>

    <div class="body-content">
        <div class="col">
            <?php foreach ($noticias as $noticia) {?>
            <?php
                //var_dump($noticia->tipo_noticia);
            ?>
                <div class="row-lg-1">
                    <h2><a href="<?=$noticia->enlace ?>"> <?= $noticia->titulo ?></a></h2>
                    <p><?= $noticia->cuerpo ?></p>
                    <p>
                        subido por :<?= $noticia->usuario->nombre?> |
                        tipo:<?= $noticia->tipoNoticia->tipo?> |
                        fecha:<?= $noticia->publicado ?>
                    </p>
                    <a href="">Comentarios</a>
                </div>
                <?php } ?>

            </div>
        </div>

    </div>
</div>
