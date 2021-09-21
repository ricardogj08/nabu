<?php defined('NABU') || exit ?>
<?php $head_title    = 'Artículos publicados' ?>
<?php $styles        = array(
    NABU_DIRECTORY['styles'] . '/admin/published-articles/published-articles.css',
    NABU_DIRECTORY['styles'] . '/admin/published-articles/published-articles-desktop.css',
) ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/admin-navbar.php' ?>

<h1>Artículos publicados</h1>

<?php require_once 'views/components/messages.php' ?>

<form method="POST" action="<?= NABU_ROUTES['admin'] ?>">
    <input type="hidden" name="csrf" value="<?= $token ?>">
    <span>
        <input type="text" name="q" minlength="1" maxlength="246" required>
    </span>
    <span>
        <input type="submit" name="search-submit" value="&#x1F50E">
    </span>
</form>

<?php require_once 'views/components/table-articles.php' ?>
<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
