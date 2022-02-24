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

<?php $head_title = 'Registrate' ?>

<!-- Estilos a cargar -->
<?php $styles = array(
    'components/footer/footer.css',
    'components/messages/messages.css',
    'pages/signup/signup.css'
) ?>

<!-- Estilos a cargar para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'pages/signup/signup-desktop.css', 'attributes' => 'media="screen and (min-width: 900px)"'),
) ?>

<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/messages.php' ?>

<div class="wrapper">
    <div class="content">
        <header class="header">
            <picture class="header__logo-container">
                <a href="<?= NABU_ROUTES['home'] ?>"><img src="<?= NABU_DIRECTORY['images'] ?>/nabu-logo.svg" alt="Logo de nabu" class="header__logo"></a>
            </picture>
        </header>

        <main class="sign-up">
            <section class="sign-up__title">
                <h1 class="sign-up__text">Registrate en <strong>Nabu</strong></h1>
                <span class="sign-up__plane"></span>
            </section>
            <section class="form__container">
                <form class="form__sign-up" method="POST" action="<?= NABU_ROUTES['signup'] ?>">
                    <input type="hidden" name="csrf" value="<?= $token ?>">

                    <label for="name">
                        <input class="sign-up__input" type="text" minlength="5" maxlength="255" id="name" name="name" required autofocus aria-label="Ingresa tu nombre completo" autocomplete="name">
                        <span class="name__field">Nombre completo</span>
                    </label>

                    <label for="username">
                        <input class="sign-up__input" type="text" id="username" name="username" minlength="1" maxlength="255" required aria-label="Ingresa tu nombre de usuario" autocomplete="username">
                        <span class="name__field">Nombre de usuario</span>
                    </label>

                    <label for="email">
                        <input class="sign-up__input" type="email" id="email" name="email" minlength="5" maxlength="255" required aria-label="Ingresa su correo o email" autocomplete="email">
                        <span class="name__field">Correo(institucional)</span>
                    </label>

                    <label for="password">
                        <input class="sign-up__input" type="password"  id="password" name="password" minlength="6" maxlength="255" required aria-label="Ingresa tu contraseña">
                        <span class="name__field">Contraseña</span>
                    </label>

                    <label for="confirm-password">
                        <input class="sign-up__input" type="password"  id="confirm-password" name="confirm-password" minlength="6" maxlength="255" required aria-label="Confirma tu contraseña">
                        <span class="name__field">Confirmar contraseña</span>
                    </label>

                    <div class="sign-up__container">
                        <input class="sign-up__button" type="submit" name="signup-form" value="Registrarme" aria-label="Registrar">
                        <span></span>
                    </div>

                    <p class="form__already">¿Ya tienes una cuenta?
                         <a href="<?= NABU_ROUTES['login'] ?>">Inicia sesión</a>.
                    </p>

                </form>
            </section>
        </main>
    </div>

    <picture class="form__image-container">
        <img class="form__image" src="/assets/images/login.svg" alt="Imagen de login">
    </picture>
</div>
<?php require_once 'views/components/footer.php' ?>
