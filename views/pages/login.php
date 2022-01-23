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

<?php $head_title = 'Inicia sesión' ?>

<!-- Estilos a cargar -->
<?php $styles = array(
    'components/footer/footer.css',
    'pages/signup/signup.css',
    'pages/login/login.css'
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
                <h1 class="sign-up__text">Bienvenido de nuevo.<br><strong>inicia sesión </strong>para continuar</h1>
            </section>
            <section class="form__container">
                <form class="form__sign-up" method="POST" action="<?= NABU_ROUTES['login'] ?>">
                    <input type="hidden" name="csrf" value="<?= $token ?>">

                    <label for="identity">
                        <input class="sign-up__input" type="text" id="identity" name="identity" minlength="1" maxlength="255" autofocus required aria-label="Ingresa tu nombre de usuario o correo" autocomplete="username">
                        <span class="name__field">Nombre de usuario o correo electrónico</span>
                    </label>

                    <label for="password">
                        <input class="sign-up__input" type="password" id="password" name="password" minlength="6" maxlength="255" required aria-label="Ingresa tu contraseña">
                        <span class="name__field">Contraseña</span>
                    </label>

                    <div class="sign-up__container">
                        <input class="sign-up__button" type="submit" name="login-form" value="Iniciar sesión" aria-label="Registrar">
                        <span></span>
                    </div>

                    <p class="form__already">¿No tienes una cuenta?
                         <a href="<?= NABU_ROUTES['signup'] ?>">Registrate</a>.
                    </p>
                </form>
            </section>
        </main>
    </div>
    <picture class="form__image-container">
        <img class="form__image" src="https://cdna.artstation.com/p/assets/images/images/017/677/304/large/kerasumi-1.jpg" alt="">
    </picture>
</div>
<span class="login-plane"></span>

<?php require_once 'views/components/footer.php' ?>
