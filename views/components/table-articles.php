<?php defined('NABU') || exit ?>

<?php if (!empty($articles)): ?>
<table>
    <tr>
        <td>Título</td>
        <td>Autor</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($articles as $article): ?>
    <?php $author = $article['author'] ?>
        <tr>
            <td><?= $article['title'] ?></td>
            <td><a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($author) ?>" target="_blank"><?= utils::escape($author) ?></a></td>
            <td><a href="<?= NABU_ROUTES['delete-article'] . '&slug=' . $article['slug'] ?>">Eliminar</a></td>
            <td><a href="<?= NABU_ROUTES['authorize-article'] . '&slug=' . $article['slug'] ?>">Publicar</a></td>
        </tr>
    <?php endforeach ?>
</table>
<?php endif ?>
