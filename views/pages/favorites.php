<?php defined('NABU') || exit ?>
<?php $head_title = 'Artículos favoritos' ?>
<?php $styles     = array(
    'pages/favorites/favorites.css',
    'pages/favorites/favorites-desktop.css',
    'components/articles/articles.css',
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Artículos favoritos</h1>

<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
