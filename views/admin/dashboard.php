<?php defined('NABU') || exit ?>
<?php $head_title    = 'Administración' ?>
<?php $styles        = array(
    NABU_DIRECTORY['styles'] . '/admin/dashboard/dashboard.css',
    NABU_DIRECTORY['styles'] . '/admin/dashboard/dashboard-desktop.css',
) ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/admin-navbar.php' ?>

<h1>Artículos envíados</h1>

<?php require_once 'views/components/messages.php' ?>
<?php require_once 'views/components/table-articles.php' ?>
<?php require_once 'views/components/footer.php' ?>
