<?php defined('NABU') || exit ?>
<?php $head_title = 'Búsquedas' ?>
<?php $styles     = array(
    NABU_DIRECTORY['styles'] . '/pages/search/search.css',
    NABU_DIRECTORY['styles'] . '/pages/search/search-desktop.css',
    NABU_DIRECTORY['styles'] . '/components/articles/articles.css',
) ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Búsquedas</h1>

<?php require_once 'views/components/search.php' ?>

<!-- Muestra el patrón de búsqueda. -->
<p>Búsqueda: <mark><?= $query ?></mark></p>

<?php require_once 'views/components/messages.php' ?>
<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
