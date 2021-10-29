<?php defined('NABU') || exit() ?>
<?php $head_title = 'Muro' ?>

<!-- Estilos cargados -->
<?php $styles     = array(
    'components/navbar/navbar.css',
    'components/search/search.css',
    'pages/all-articles/all-articles.css',
    'components/articles/articles.css',
    'components/footer/footer.css',
) ?>

<!-- Estilos para el responsive design -->
<?php $desktop_styles = array(
    array('components/navbar/navbar-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
    array('pages/all-articles/all-articles-desktop.css', 'attributes' => ''),
) ?>

<!-- Archivos de javascript -->
<?php $scripts = array(
    'home.js',
) ?>

<!-- Componente head -->
<?php require_once 'views/components/head.php' ?>

<header class="header">
    <?php require_once 'views/components/navbar.php' ?>
</header>

<main>
    <section class="searcher">
        <div class="searcher__content">
            <span class="searcher__image"></span>
            <?php require_once 'views/components/search.php' ?>
        </div>
    </section>
    
    <section class="articles">
        <div class="articles__data">
            <h1 class = "articles__title">Muro</h1>
            <span class="articles__icon"></span>
        </div>
        <div class="articles__cards">
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
        </div>
    </section>
    <section class="CTA">
        <div class="CTA__container">
            <div class="CTA__text">
                <h2 class="CTA__title">Interesante, ¿No? 🤔</h2>
                <p class="CTA__description">Déjanos tu e-mail y te compartiremos los posts más recientes, además de recursos para mejorar tu escritura en medios digitales. 😉</p>
            </div>
            <div class="CTA__mail">
                <form class="CTA__form" method="POST" action="">
                    <input class = "form__input-mail" type="text" minlength="1" placeholder="Tu e-mail" maxlength="246" required>
                    <input class = "form__join" type="submit" name="mail-submit" value="Unirme">
                </form>
            </div>
            <span class="CTA__image"></span>
        </div>
    </section>
</main>

<?php require_once 'views/components/footer.php' ?>
