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

<?php $head_title = 'Edita tu perfil' ?>

<!-- Estilos a cargar -->
<?php $styles = array(
    'components/footer/footer.css',
    'components/messages/messages.css',
    'pages/edit-profile/edit-profile.css',
) ?>

<!-- Estilos a cargar para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'pages/edit-profile/edit-profile-desktop.css', 'attributes' => 'media="screen and (min-width: 768px)"'),
) ?>

<!-- Archivos de javascript a cargar -->
<?php $scripts = array(
    'home.js'
) ?>

<!-- HTML head -->
<?php require_once 'views/components/head.php' ?>
<!-- Componente del modal para alertas -->
<?php require_once 'views/components/messages.php' ?>
<!-- HTML body -->
<header style='background-image: url("<?= $profile['background']?>");'>
    <div class="profile-own">
        <picture class="profile-own__image-wrapper">
            <img src="<?= $profile['avatar'] ?>" class="profile-own__image" alt='Foto de Perfil'>
        </picture>
        <h2 class='profile-own__title'><?= $profile['username'] ?></h2>
    </div>
</header>

<section class='profile__edit'>
    <form method="POST" action="<?= NABU_ROUTES['edit-profile'] ?>" enctype="multipart/form-data" class='edit__form'>
        <input type="hidden" name="csrf" value="<?= $token ?>">

        <label for="avatar" class="edit__field-out edit__field-avatar">
            <input type="file" id="avatar" name="avatar" accept="<?= NABU_DEFAULT['image-formats'] ?>"  class='edit__btn-photo btn-photo'>
        </label>

        <label for="background" class="edit__field-out edit__field-background">
            <input type="file" id="background" name="background" accept="<?= NABU_DEFAULT['image-formats'] ?>" class='edit__btn-photo btn-backPhoto'>
        </label>
       

        <label for="username" class="edit__field">
            <span class="edit__entry">Nombre de Usuario</span>
            <input type="text" id="username" name="username" minlength="1" maxlength="255" value="<?= utils::escape($profile['username']) ?>" class="edit__input">
        </label>
        
        <label for="name" class="edit__field">
            <span class="edit__entry">Nombre Completo</span>
            <input type="text" id="name" name="name" minlength="5" maxlength="255" value="<?= utils::escape($profile['name']) ?>" class="edit__input">
        </label>
        
        <label for="description" class="edit__field">
            <span class="edit__entry">Descripción</span>
            <textarea id="description" name="description" maxlength="255" rows="5" cols="51" class="edit__input"><?= utils::escape($profile['description']) ?></textarea>
        </label>
        
        <label for="password" class="edit__field">
            <span class="edit__entry">Nueva Contraseña</span>
            <input type="password" id="password" name="password" minlength="6" maxlength="255" class="edit__input">
        </label>
       
        <label for="confirm-password" class="edit__field">
            <span class="edit__entry">Confirmar contraseña</span>
            <input type="password" id="confirm-password" name="confirm-password" minlength="6" maxlength="255" class="edit__input">
        </label>

        <div class="edit__buttons">
            <a href="<?= NABU_ROUTES['delete-profile'] ?>" class="edit__btn">
                Eliminar pefil
            </a>
            <input type="submit" name="edit-profile-form" value="Guardar" class="edit__btn">
        </div>
    </form>
</section>

<?php require_once 'views/components/footer.php' ?>
