<?php defined('NABU') || exit ?>
<?php $head_title = 'Error' ?>
<?php $styles     = array(
    NABU_DIRECTORY['styles'] . '/pages/errors/errors.css',
    NABU_DIRECTORY['styles'] . '/pages/errors/errors-desktop.css',
) ?>
<?php require_once 'views/components/head.php' ?>

<p><a href="<?= NABU_ROUTES['home'] ?>">Volver</a></p>

<p><mark><?= $error ?>.</mark></p>

<?php require_once 'views/components/footer.php' ?>
