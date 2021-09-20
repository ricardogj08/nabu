<?php defined('NABU') || exit ?>

<?php foreach ($articles as $article): ?>
<hr>
    <img src="<?= $article['cover'] ?>" alt="Portada del artículo">
    <p><b>Título:</b> <a href="<?= $article['url'] ?>"><?= $article['title'] ?></a></p>
    <p><b>Sinopisis:</b> <?= $article['synopsis'] ?></p>
    <p><b>Autor:</b> <?= $article['author'] ?></p>
    <p><b>Número de favoritos:</b> <?= $article['favorites'] ?></p>
    <p><b>Número de comentarios:</b> <?= $article['comments'] ?></p>
<div>
<?php endforeach ?>
