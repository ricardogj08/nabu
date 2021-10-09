<?php defined('NABU') || exit() ?>
<?php $head_title = NABU_DEFAULT['website-name'] ?>
<!-- Estilos cargados -->
<?php $styles     = array(
    'components/navbar/navbar.css',
    'components/articles/articles.css',
    'components/footer/footer.css',
    'pages/home/home.css',
) ?>
<!-- Estilos para el responsive design -->
<?php $desktop_styles = array(
    array('components/navbar/navbar-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
    array('pages/home/home-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
) ?>
<!-- Archivos de javascript -->
<?php $scripts = array(
    'home.js',
) ?>

<!-- Componente head -->
<?php require_once 'views/components/head.php' ?>

<header class="header">
    <?php require_once 'views/components/navbar.php' ?>
    <div class="hero">
        <picture class="hero__img-wrapper">
            <source srcset="<?= NABU_DIRECTORY['images'] ?>/hero-desktop.png" media="(min-width: 500px)">
            <img src="<?= NABU_DIRECTORY['images'] ?>/hero.png" alt="Imagen inspiración en cualquier momento y cualquier lugar" class="hero__img">
        </picture>
        <div class="hero__text-container">
            <h1 class="hero__CTA">Lee, inspírate y escribe</h1>
            <p class="hero__secundary-CTA">
                Lo mejor que puedes compartir es tu conocimiento.
            </p>
            <a href="<?= NABU_ROUTES['signup'] ?>" class="hero__button">Comienza a escribir</a>
        </div>
    </div>
</header>

<main>
    <section class="popular-posts">
        <h2 class="popular-posts__title">Posts imperdibles del mes, échales un ojo</h2>
        <section class="popular-cards__container">
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
        </section>
    </section>
    <section class="recent__posts">
        <h2 class="recent-posts__title">Posts más recientes</h2>
        <section class="recent-cards__container">
            <?php $articles = $recent_articles ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
            <?php require 'views/components/articles.php' ?>
        </section>
    </section>
    <section class = "CTA">
        <span class="CTA__plane"></span>
        <div class="CTA__container">
            <h3 class="CTA__title">Tus palabras merecen ser leidas, escribe algo e inicia un viaje de descubrimiento</h3>
            <a href="<?= NABU_ROUTES['signup'] ?>" class="CTA__button">Quiero compartir lo que sé</a>
        </div>
    </section>
</main>

<?php require_once 'views/components/footer.php' ?>
