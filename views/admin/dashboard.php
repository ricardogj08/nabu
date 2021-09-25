<?php defined('NABU') || exit ?>
<?php $head_title    = 'Administración' ?>
<?php $styles        = array(
    'admin/dashboard/dashboard.css',
    'admin/dashboard/dashboard-desktop.css',
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/admin-navbar.php' ?>

<h1>Artículos envíados</h1>

<?php require_once 'views/components/messages.php' ?>

<?php if (!empty($articles)): ?>
<table>
    <tr>
        <th>Título</th>
        <th>Autor</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach ($articles as $article): ?>
    <?php $author = $article['author'] ?>
        <tr>
            <td><?= $article['title'] ?></td>
            <td><a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($author) ?>" target="_blank"><?= utils::escape($author) ?></a></td>
            <td><a href="<?= NABU_ROUTES['authorize-article'] . '&slug=' . $article['slug'] ?>">Publicar</a></td>
            <td><a href="<?= NABU_ROUTES['edit-article'] . '&slug=' . $article['slug'] ?>">Editar</a></td>
            <td><a href="<?= NABU_ROUTES['delete-article'] . '&slug=' . $article['slug'] ?>">Eliminar</a></td>
        </tr>
    <?php endforeach ?>
</table>
<?php endif ?>

<?php require_once 'views/components/footer.php' ?>
