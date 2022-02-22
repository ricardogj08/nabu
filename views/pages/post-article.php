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

<?php $head_title = 'Publica un post' ?>

<!-- Estilos a cargar -->
<?php $styles = array(
    'components/navbar/navbar.css',
    'components/footer/footer.css',
    'pages/post-article/post-article.css',
) ?>

<!-- Estilos a cargar para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'components/navbar/navbar-desktop.css', 'attributes' => 'media="screen and (min-width: 768px)"'),
    array('file' => 'components/footer/footer-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
    array('file' => 'pages/post-article/post-article-desktop.css', 'attributes' => ''),
) ?>

<!-- Archivos de javascript a cargar -->
<?php $scripts = array(
    'home.js',
    '/post-article/post-article.js'
) ?>

<!-- Componente head -->
<?php require_once 'views/components/head.php' ?>

<!-- HTML body -->
<?php require_once 'views/components/messages.php' ?>
<header class="header">
    <?php require_once 'views/components/navbar.php' ?>
</header>

<main class="hero">
    <form method="POST" action="<?= NABU_ROUTES['post-article'] ?>" enctype="multipart/form-data" class="public__form">
        <input type="hidden" name="csrf" value="<?= $token ?>">

        <input type="text" id="title" name="title" minlength="1" maxlength="246" size="101" required class="public__title" placeholder="Titulo del post">
        
        <textarea type="text" id="synopsis" name="synopsis" minlength="1" maxlength="255"  required class="public__summary" placeholder="Cuentame lo más interesante de tu post"></textarea>
        
        <!-- <label for="body"><b>Contenido del artículo <a href="https://www.markdownguide.org/basic-syntax/" target="_blank">formato Markdown</a></b></label> -->

        <textarea type="text" id="body" name="body" minlength="1" maxlength="<?= NABU_DEFAULT['article-size'] ?>" required class="public__content" placeholder="Escribe lo que tienes para compartir"></textarea>
        <input type="submit" name="post-article-form" value="Enviar" class="public__send">
    </form>

</main>

<!-- footer -->
<?php require_once 'views/components/footer.php' ?>
<link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
<script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

