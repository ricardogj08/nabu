<?php defined('NABU') || exit ?>
<?php $head_title = 'Muro' ?>
<?php $styles     = array(
    NABU_DIRECTORY['styles'] . '/pages/all-articles/all-articles.css',
    NABU_DIRECTORY['styles'] . '/pages/all-articles/all-articles-desktop.css',
    NABU_DIRECTORY['styles'] . '/components/articles/articles.css',
) ?>
<?php require_once 'views/components/head.php' ?>

<h1>Muro</h1>
<?php require_once 'views/components/search.php' ?>
<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/footer.php' ?>
