<?php defined('NABU') || exit ?>
<?php $head_title = 'Editar artículo' ?>
<?php $styles     = array(
    NABU_DIRECTORY['styles'] . '/pages/edit-article/edit-article.css',
    NABU_DIRECTORY['styles'] . '/pages/edit-article/edit-article-desktop.css',
) ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Editar artículo</h1>

<?php require_once 'views/components/messages.php' ?>

<form method="POST" action="#" enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= $token ?>">
    <div>
        <label for="title"><b>Título del artículo</b></label>
    </div>
    <div>
        <input type="text" id="title" name="title" minlength="1" maxlength="246" size="101" value="<?= $article['title'] ?>" required>
    </div>
    <div>
        <label for="synopsis"><b>Resumen del artículo</b></label>
    </div>
    <div>
        <textarea type="text" id="synopsis" name="synopsis" minlength="1" maxlength="255" rows="3" cols="100" required><?= $article['synopsis'] ?></textarea>
    </div>
    <div>
        <label for="content"><b>Contenido del artículo <a href="https://www.markdownguide.org/basic-syntax/" target="_blank">formato Markdown</a></b></label>
    </div>
    <div>
        <textarea type="text" id="content" name="content" minlength="1" maxlength="<?= NABU_DEFAULT['article-size'] ?>" rows="32" cols="100" required><?= $article['content'] ?></textarea>
    </div>
    <div>
        <input type="submit" name="edit-article-submit" value="Enviar">
    </div>
</form>

<?php require_once 'views/components/footer.php' ?>