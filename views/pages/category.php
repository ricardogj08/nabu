<?php defined('NABU') || exit() ?>
<?php $head_title = 'Categoría' ?>
<?php $styles     = array(
    'pages/category/category.css',
    'components/articles/articles.css',
) ?>
<?php $desktop_styles = array(
    array('pages/category/category-desktop.css', 'attributes' => '')
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Categoría</h1>

<?php require_once 'views/components/search.php' ?>
<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
