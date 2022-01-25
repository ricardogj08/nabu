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

<?php $head_title = 'Confirmar contraseña' ?>

<!-- Estilos a cargar -->
<?php $styles = array(
    'pages/confirm-password/confirm-password.css',
) ?>

<!-- Estilos a cargar para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'pages/confirm-password/confirm-password-desktop.css', 'attributes' => ''),
) ?>

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
        <input type="submit" name="confirm-password-form" value="Enviar">
    </div>
</form>

<?php require_once 'views/components/footer.php' ?>
