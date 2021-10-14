<?php defined('NABU') || exit() ?>
<?php $head_title = 'Muro' ?>
<?php $styles     = array(
    'components/navbar/navbar.css',
    'pages/all-articles/all-articles.css',
    'components/articles/articles.css',
    'components/footer/footer.css',
) ?>
<?php $desktop_styles = array(
    array('components/navbar/navbar-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
    array('pages/all-articles/all-articles-desktop.css', 'attributes' => ''),
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Muro</h1>

<?php require_once 'views/components/search.php' ?>
<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/footer.php' ?>
