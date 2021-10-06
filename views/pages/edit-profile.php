<?php defined('NABU') || exit() ?>
<?php $head_title = 'Editar perfil' ?>
<?php $styles     = array(
    'pages/edit-profile/edit-profile.css',
) ?>
<?php $desktop_styles = array(
    array('pages/edit-profile/edit-profile-desktop.css', 'attributes' => '')
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>

<h1>Editar perfil</h1>

<?php require_once 'views/components/messages.php' ?>

<form method="POST" action="<?= NABU_ROUTES['edit-profile'] ?>" enctype="multipart/form-data">
    <fieldset>
        <legend>Perfil</legend>
        <input type="hidden" name="csrf" value="<?= $token ?>">
        <div>
            <div>
                <label for="avatar"><b>Editar foto de perfil</b></label>
            </div>
            <div>
                <img src="<?= $user['avatar'] ?>" alt="Foto de perfil" width="8%">
            </div>
            <div>
                <input type="file" id="avatar" name="avatar" accept="<?= NABU_DEFAULT['image-formats'] ?>">
            </div>
        </div>
        <div>
            <div>
                <label for="background"><b>Editar fondo de perfil</b></label>
            </div>
            <div>
                <img src="<?= $user['background'] ?>" alt="Fondo de perfil" width="32%">
            </div>
            <div>
                <input type="file" id="background" name="background" accept="<?= NABU_DEFAULT['image-formats'] ?>">
            </div>
        </div>
        <div>
            <div>
                <label for="description"><b>Descripción</b></label>
            </div>
            <div>
                <textarea id="description" name="description" maxlength="255" rows="5" cols="51"><?= $user['description'] ?></textarea>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <legend>Datos personales</legend>
        <div>
            <label for="name"><b>Nombre completo</b></label>
            <input type="text" id="name" name="name" minlength="5" maxlength="255" value="<?= $user['name'] ?>">
        </div>
        <div>
            <label for="username"><b>Apodo</b></label>
            <input type="text" id="username" name="username" minlength="1" value="<?= $user['username'] ?>" maxlength="255">
        </div>
        <div>
            <label for="password"><b>Nueva constraseña</b></label>
            <input type="password" id="password" name="password" minlength="6" maxlength="255">
        </div>
        <div>
            <label for="confirm-password"><b>Confirmar contraseña</b></label>
            <input type="password" id="confirm-password" name="confirm-password" minlength="6" maxlength="255">
        </div>
    </fieldset>
    <div>
        <a href="<?= NABU_ROUTES['delete-profile'] ?>">Eliminar cuenta</a>
        <input type="submit" name="edit-profile-submit" value="Guardar">
    </div>
</form>

<?php require_once 'views/components/footer.php' ?>
