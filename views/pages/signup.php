<?php defined('NABU') || exit ?>
<?php $head_title = 'Crea una cuenta' ?>
<?php $styles     = array(
    'components/footer/footer.css',
    'pages/signup/signup.css',
) ?>
<?php $desktop_styles = array(
    array('pages/signup/signup-desktop.css', 'attributes' => 'media="screen and (min-width: 900px)"'),
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>


<?php require_once 'views/components/messages.php' ?>
<div class="wrapper">
    <div class="content">
        <header class="header">
            <picture class="header__logo-container">
                <img src="<?= NABU_DIRECTORY['images'] ?>/nabu-logo.svg" alt="Logo de nabu" class="header__logo">
            </picture>
        </header>
        
        <main class="sign-up">
            <section class="sign-up__title">
                <h1 class="sign-up__text">Registrate en <strong>Nabu</strong></h1>
                <span class="sign-up__plane"></span>
            </section>
            <section class="form__container">
                <form class="form__sign-up" action="POST" action="<?= NABU_ROUTES['signup'] ?>">
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

                    <input class="sign-up__button"type="submit" name="signup-submit" value="Registrarme" aria-label="Registrar">
                    <p class="form__already">¿Ya tienes cuenta?
                         <a href="<?= NABU_ROUTES['login'] ?>">Inicia sesión</a>.
                    </p>
        
                </form>
            </section>
        </main>
    </div>
    
    <picture class="form__image-container">
        <img class="form__image" src="https://cdna.artstation.com/p/assets/images/images/017/677/304/large/kerasumi-1.jpg?1556911326" alt="">
    </picture>
</div>
<?php require_once 'views/components/footer.php' ?>

<!--  
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
-->


