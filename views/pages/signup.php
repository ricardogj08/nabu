<?php defined('NABU') || exit ?>
<?php $head_title = 'Crea una cuenta' ?>
<?php $styles     = array(
    'pages/signup/signup.css',
) ?>
<?php $desktop_styles = array(
    array('pages/signup/signup-desktop.css', 'attributes' => ''),
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>

<h1>Crea una cuenta</h1>

<?php require_once 'views/components/messages.php' ?>

<form method="POST" action="<?= NABU_ROUTES['signup'] ?>">
    <input type="hidden" name="csrf" value="<?= $token ?>">
    <div>
        <label for="name">Nombre completo</label>
        <input type="text" id="name" name="name" minlength="5" maxlength="255" autofocus required>
    </div>
    <div>
        <label for="username">Apodo</label>
        <input type="text" id="username" name="username" minlength="1" maxlength="255" required>
    </div>
    <div>
        <label for="email">Correo institucional</label>
        <input type="email" id="email" name="email" minlength="5" maxlength="255" required>
    </div>
    <div>
        <label for="password">Constraseña</label>
        <input type="password" id="password" name="password" minlength="6" maxlength="255" required>
    </div>
    <div>
        <label for="confirm-password">Confirmar contraseña</label>
        <input type="password" id="confirm-password" name="confirm-password" minlength="6" maxlength="255" required>
    </div>
    <div>
        <input type="submit" name="signup-submit" value="Registrarme">
        <p>¿Ya tienes cuenta? <a href="<?= NABU_ROUTES['login'] ?>">Inicia sesión</a>.</p>
    </div>
</form>

<?php require_once 'views/components/footer.php' ?>
