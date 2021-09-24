<?php defined('NABU') || exit ?>
<?php $head_title = 'Artículos enviados' ?>
<?php $styles     = array(
    NABU_DIRECTORY['styles'] . '/pages/sent-articles/sent-articles.css',
    NABU_DIRECTORY['styles'] . '/pages/sent-articles/sent-articles-desktop.css',
) ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Artículos en espera de aprobación</h1>

<?php require_once 'views/components/messages.php' ?>

<?php if (!empty($articles)): ?>
<table>
    <tr>
        <td>Título</td>
        <td></td>
        <td></td>
    </tr>
    <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= $article['title'] ?></td>
            <td><a href="<?= $article['slug'] ?>">Editar</a></td>
            <td><a href="<?= $article['slug'] ?>">Reenviar</a></td>
        </tr>
    <?php endforeach ?>
</table>
<?php endif ?>

<?php require_once 'views/components/footer.php' ?>
