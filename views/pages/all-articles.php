<?php defined('NABU') || exit ?>
<?php $head_title = 'Muro' ?>
<?php $styles     = array(
    'pages/all-articles/all-articles.css',
    'pages/all-articles/all-articles-desktop.css',
    'components/articles/articles.css',
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Muro</h1>

<?php require_once 'views/components/search.php' ?>
<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/footer.php' ?>
