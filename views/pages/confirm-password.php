<?php defined('NABU') || exit ?>
<?php $head_title = 'Confirmar contraseña' ?>
<?php $styles     = array(
    'pages/confirm-password/confirm-password.css',
    'pages/confirm-password/confirm-password-desktop.css',
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>

<h1>Confirmar contraseña</h1>

<?php require_once 'views/components/messages.php' ?>

<p>Ingresa tu contraseña para completar la operación.</p>

<form method="POST" action="<?= $view ?>">
    <input type="hidden" name="csrf" value="<?= $token ?>">
    <div>
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" minleght="6" maxlenght="255" required>
    </div>
    <div>
        <label for="confirm-password">Confirmar contraseña</label>
        <input type="password" id="confirm-password" name="confirm-password" minlenght="6" maxlenght="255" required>
    </div>
    <div>
        <input type="submit" name="confirm-password-submit" value="Enviar">
    </div>
</form>

<?php require_once 'views/components/footer.php' ?>
