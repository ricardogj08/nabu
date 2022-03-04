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
    'components/messages/messages.css',
) ?>

<!-- HTML head -->
<?php require_once 'views/components/head.php' ?>

<!-- HTML BODY -->
<?php require_once 'views/components/messages.php' ?>
<div class="wrapper__confirm">
    <section class="confirm__pass">
        <h3 class="confirm__title">Ingresa tu contraseña para completar la operación</h3>
        <picture class="confirm__image-wrapper">
            <img src="/assets/images/EliminarPerfil.svg" alt="Buho triste" class="confirm__image">
        </picture>
        <!-- <p class="confirm__text">Ingresa tu contraseña para completar la operación</p> -->
        <form method="POST" action="<?= $view ?>" class="confirm__form">
            <input type="hidden" name="csrf" value="<?= $token ?>">
            
            <label for="password" class="pass__field">
                <span class="pass__text">Contraseña</span>
                <input type="password" id="password" name="password" minleght="6" maxlenght="255" required class="pass__input">
            </label>
            
            <label for="confirm-password" class="pass__field">
                <span class="pass__text">Confirmar Contraseña</span>
                <input type="password" id="confirm-password" name="confirm-password" minlenght="6" maxlenght="255" required class="pass__input">
            </label>
            
            <input type="submit" name="confirm-password-form" value="Enviar" class="confirm__btn">
        </form>
    </section>
</div>