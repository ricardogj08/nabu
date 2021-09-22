<?php defined('NABU') || exit ?>
<?php $head_title = 'Artículo' ?>
<?php $styles     = array(
    NABU_DIRECTORY['styles'] . '/pages/article/article.css',
    NABU_DIRECTORY['styles'] . '/pages/article/article-desktop.css',
    NABU_DIRECTORY['styles'] . '/components/articles/articles.css',
) ?>
<?php require_once 'views/components/head.php' ?>

<h1><?= $article['title'] ?></h1>

<div>
    <p>Autor:</p>
    <a href="<?= $author_profile ?>"><img src="<?= $article['author-avatar'] ?>" alt="Foto de perfil del autor" width="8%"></a>
    <p><a href="<?= $author_profile ?>"><?= $article['author-username'] ?></a></p>
    <p><?= $article['date'] ?></p>
</div>

<div>
    <?= $article['content'] ?>
</div>

<h2>Datos del autor</h2>

<div>
    <a href="<?= $author_profile ?>"><img src="<?= $article['author-avatar'] ?>" alt="Foto de perfil del autor" width="8%"></a>
    <p><a href="<?= $author_profile ?>"><?= $article['author'] ?></a></p>
    <p><?= $article['author-description'] ?></p>
</div>

<h2>Otros artículos</h2>

<?php require_once 'views/components/articles.php' ?>

<h2>Comentarios</h2>

<?php require_once 'views/components/messages.php' ?>
<?php require_once 'views/components/footer.php' ?>
