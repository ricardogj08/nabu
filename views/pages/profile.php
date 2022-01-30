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
      array('file' => 'components/navbar/navbar-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
      array('file' => 'pages/profile/profile-desktop.css', 'attributes' => '')
) ?>

<!-- Archivos de javascript a cargar -->
<?php $scripts = array(
    'home.js'
) ?>

<!-- HTML head -->
<?php require_once 'views/components/head.php' ?>

<!-- HTML body -->
<header>
    <!-- Nav bar -->
    <?php require_once 'views/components/navbar.php' ?>
    <!-- <div>
        <img src="<?= $profile['background'] ?>" alt="Fondo de perfil" width="20%">
    </div> -->    
    <div class="profile-own">
        <picture class="profile-own__image-wrapper">
            <img src="https://scontent.fcyw4-1.fna.fbcdn.net/v/t39.30808-6/272064856_452115463212117_8803840504382002522_n.jpg?_nc_cat=106&ccb=1-5&_nc_sid=09cbfe&_nc_ohc=kfsgbwKN7z0AX-9v5jd&_nc_ht=scontent.fcyw4-1.fna&oh=00_AT9cA6zq0C9ylsxd_flHjuy1iirmctsUfuDaV5ScX97NdA&oe=61F84F27" alt="Foto de perfil del autor" class="profile-own__image">
        </picture>
        <h2 class='profile-own__title'><?= $profile['username'] ?></h2>
        <p class='profile-own__description'><?= $profile['description'] ?></p>
    </div>
</header>


<?php if ($isMyProfile): ?>
    <a href="<?= NABU_ROUTES['edit-profile'] ?>">Editar perfil</a>
<?php endif ?>

<ul>
    <li>Nombre completo: <?= $profile['name'] ?></li>
    <li>Apodo: <?= $profile['username'] ?></li>
    <li>Descripción: <?= $profile['description'] ?></li>
</ul>

<div>
    <img src="<?= $profile['avatar'] ?>" alt="Foto de perfil" width="8%">
</div>


<section class="public-posts">
    <h2 class='public-posts__title'>Post publicados</h2>
    <section class="public-cards__container">
        <?php require 'views/components/articles.php' ?>
        <?php require 'views/components/articles.php' ?>
        <?php require 'views/components/articles.php' ?>
    </section>
</section>

<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
