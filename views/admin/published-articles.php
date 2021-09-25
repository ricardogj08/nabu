<?php defined('NABU') || exit ?>
<?php $head_title    = 'Artículos publicados' ?>
<?php $styles        = array(
    'admin/published-articles/published-articles.css',
) ?>
<?php $desktop_styles = array(
    array('admin/published-articles/published-articles-desktop.css', 'attributes' => ''),
) ?>
<?php $scripts = array() ?>
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

<?php if (!empty($articles)): ?>
<table>
    <tr>
        <td>Título</td>
        <td>Autor</td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($articles as $article): ?>
    <?php $author = $article['author'] ?>
        <tr>
            <td><?= $article['title'] ?></td>
            <td><a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($author) ?>" target="_blank"><?= utils::escape($author) ?></a></td>
            <td><a href="<?= NABU_ROUTES['edit-article'] . '&slug=' . $article['slug'] ?>">Editar</a></td>
            <td><a href="<?= NABU_ROUTES['delete-article'] . '&slug=' . $article['slug'] ?>">Eliminar</a></td>
        </tr>
    <?php endforeach ?>
</table>
<?php endif ?>

<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
<?php defined('NABU') || exit ?>
