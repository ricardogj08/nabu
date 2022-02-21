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

<?php $head_title = $profile['username'] ?>

<!-- Estilos cargados -->
<?php $styles = array(
    'components/navbar/navbar.css',
    'components/articles/articles.css',
    'components/footer/footer.css',
    'pages/profile/profile.css',
) ?>

<!-- Estilos para el responsive design -->
<?php $desktop_styles = array(
      array('file' => 'components/navbar/navbar-desktop.css', 'attributes' => 'media="screen and (min-width: 768px)"'),
      array('file' => 'pages/profile/profile-desktop.css',    'attributes' => 'media="screen and (min-width: 768px)"')
) ?>

<!-- Archivos de javascript a cargar -->
<?php $scripts = array(
    'home.js'
) ?>

<!-- HTML head -->
<?php require_once 'views/components/head.php' ?>

<!-- HTML body -->
<header style='background-image: url("<?= $profile['background']?>");'>
    <!-- Nav bar -->
    <?php require_once 'views/components/navbar.php' ?>
    <div class="profile-own">
        <picture class="profile-own__image-wrapper">
            <img src="<?= $profile['avatar'] ?>" class="profile-own__image" alt='Foto de Perfil'>
        </picture>
        <h2 class='profile-own__title'><?= $profile['username'] ?></h2>
        <p class='profile-own__description'><?= $profile['description'] ?></p>
        <?php if ($isMyProfile): ?>
            <a href="<?= NABU_ROUTES['edit-profile'] ?>" title='Editar Perfil' class='profile__link-edit'>&#9881</a>
        <?php endif ?>
    </div>
</header>

<section class="public-posts">
    <h2 class='public-posts__title'>Post publicados</h2>
    <div class="public-cards__container">
        <?php require 'views/components/articles.php' ?>
    </div>
</section>

<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
