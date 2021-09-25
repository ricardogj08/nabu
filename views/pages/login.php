<?php defined('NABU') || exit ?>
<?php $head_title = 'Iniciar sesión' ?>
<?php $styles     = array(
    'pages/login/login.css',
) ?>
<?php $desktop_styles = array(
    array('pages/login/login-desktop.css', 'attributes' => ''),
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>

<h1>Iniciar sesión</h1>

<?php require_once 'views/components/messages.php' ?>

<form method="POST" action="<?= NABU_ROUTES['login'] ?>">
    <input type="hidden" name="csrf" value="<?= $token ?>">
    <div>
        <label for="identity">Correo institucional o usuario</label>
        <input type="text" id="identity" name="identity" minlength="1" maxlength="255" autofocus required>
    </div>
    <div>
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" minlength="6" maxlength="255" required>
    </div>
    <div>
        <input type="submit" name="login-submit" value="Ingresar">
        <p>¿No tienes cuenta? <a href="<?= NABU_ROUTES['signup'] ?>">Regístrate en <?= NABU_DEFAULT['website-name'] ?></a>.</p>
    </div>
</form>

<?php require_once 'views/components/footer.php' ?>
