<?php defined('NABU') || exit() ?>

<?php $head_title = 'Error' ?>

<!-- Estilos a cargar -->
<?php $styles = array(
    'components/footer/footer.css',
    'pages/errors/errors.css'
) ?>

<!-- Estilos a cargar para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'pages/errors/errors-desktop.css', 'attributes' => 'media="screen and (min-width: 768px)"')
) ?>

<!-- HTML head -->
<?php require_once 'views/components/head.php' ?>

<!-- HTML body -->
<div class="container">
    <main class="error__hero">
        <picture class="error__image-wrapper">
            <img src="/assets/images/404.svg" alt="Nabu error imagen" class="error__img">
        </picture>
        <div class="error__info">
            <h2 class="error__title">¡Whoops!</h2>
            <p class="error__message">No pudimos encontrar la pagina que buscas</p>
            <!-- <p><mark><?= $error ?>.</mark></p> -->
            <a href="/index.php" class="error__link-back">← Volver</a>
        </div>
    </main> 
    <!-- footer -->
</div>
<?php require_once 'views/components/footer.php' ?>
