<?php defined('NABU') || exit() ?>

<?php $head_title = 'Error' ?>

<!-- Estilos a cargar -->
<?php $styles = array(
    'pages/errors/errors.css'
) ?>

<!-- Estilos a cargar para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'pages/errors/errors-desktop.css', 'attributes' => '')
) ?>

<?php require_once 'views/components/head.php' ?>

<p><mark><?= $error ?>.</mark></p>

<?php require_once 'views/components/footer.php' ?>
