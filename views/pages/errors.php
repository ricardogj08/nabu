<?php defined('NABU') || exit() ?>
<?php $head_title = 'Error' ?>
<?php $styles     = array(
    'pages/errors/errors.css',
) ?>
<?php $desktop_styles = array(
    array('pages/errors/errors-desktop.css', 'attributes' => '')
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>

<p><mark><?= $error ?>.</mark></p>

<?php require_once 'views/components/footer.php' ?>
