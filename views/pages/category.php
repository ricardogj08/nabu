<?php defined('NABU') || exit ?>
<?php $head_title = 'Categoría' ?>
<?php $styles     = array(
    NABU_DIRECTORY['styles'] . '/pages/category/category.css',
    NABU_DIRECTORY['styles'] . '/pages/category/category-desktop.css',
    NABU_DIRECTORY['styles'] . '/components/articles/articles.css',
) ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Categoría</h1>

<?php require_once 'views/components/search.php' ?>
<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
