<!--
* Este archivo es parte de Nabu.
*
* Nabu es software libre: puedes redistribuirlo y/o modificarlo
* bajo los términos de la Licencia Pública General de GNU Affero publicada por
* la Free Software Foundation, ya sea la versión 3 de la Licencia, o
* (a su elección) cualquier versión posterior.
*
* Nabu se distribuye con la esperanza de que sea de utilidad,
* pero SIN NINGUNA GARANTÍA; incluso sin la garantía implícita de
* COMERCIABILIDAD o APTITUD PARA UN PROPÓSITO PARTICULAR. Consulte la
* Licencia Pública General de GNU Affero para obtener más detalles.
*
* Debería haber recibido una copia de la Licencia Pública General de GNU Affero
* junto con este programa. De lo contrario, consulte <https://www.gnu.org/licenses/>.
-->

<?php defined('NABU') || exit() ?>

<?php $head_title = 'Revisar artículo' ?>

<?php require_once 'views/components/dashboard.php' ?>

<h1>Revisar artículo</h1>

<?php require_once 'views/components/messages.php' ?>

<form method="POST" action="<?= $view ?>" enctype="multipart/form-data">
    <input type="hidden" name="csrf" value="<?= $token ?>">
    <div>
        <label for="cover"><b>Portada del artículo</b></label>
    </div>
    <div>
      <img src="<?= $article['cover'] ?>" alt="Portada del artículo" width="8%">
    </div>
    <div>
      <input type="file" id="cover" name="cover" accept="<?= NABU_DEFAULT['image-formats'] ?>">
    </div>
    <div>
        <label for="title"><b>Título del artículo</b></label>
    </div>
    <div>
        <input type="text" id="title" name="title" minlength="1" maxlength="246" size="101" value="<?= utils::escape($article['title']) ?>" required>
    </div>
    <div>
        <label for="synopsis"><b>Resumen del artículo</b></label>
    </div>
    <div>
        <textarea type="text" id="synopsis" name="synopsis" minlength="1" maxlength="255" rows="3" cols="100" required><?= utils::escape($article['synopsis']) ?></textarea>
    </div>
    <div>
        <label for="body"><b>Contenido del artículo <a href="https://www.markdownguide.org/basic-syntax/" target="_blank">formato Markdown</a></b></label>
    </div>
    <div>
        <textarea type="text" id="body" name="body" minlength="1" maxlength="<?= NABU_DEFAULT['article-size'] ?>" rows="32" cols="100" required><?= utils::escape($article['body']) ?></textarea>
    </div>
    <div>
        <input type="submit" name="review-article-form" value="Enviar">
    </div>
</form>

<?php require_once 'views/components/footer.php' ?>
