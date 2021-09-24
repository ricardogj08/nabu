<?php defined('NABU') || exit ?>
<?php $head_title    = NABU_DEFAULT['website-name'] ?>
<?php $styles        = array(
    NABU_DIRECTORY['styles'] . '/pages/home/home.css',
    NABU_DIRECTORY['styles'] . '/pages/home/home-desktop.css',
    NABU_DIRECTORY['styles'] . '/components/articles/articles.css',
) ?>
<?php require_once 'views/components/head.php' ?>

<header class="header">
    <?php require_once 'views/components/navbar.php' ?>
    <div class="hero">
        <picture class="hero__img-wrapper">
            <source srcset="<?= NABU_DIRECTORY['images'] ?>/hero-desktop.png" media="(min-width: 600px)">
            <img src="<?= NABU_DIRECTORY['images'] ?>/hero.png" alt="Imagen inspiración en cualquier momento y cualquier lugar" class="hero__img">
        </picture>
        <h1 class="hero__CTA">Lee, inspírate y escribe</h1>
        <p class="hero__secundary-CTA">
            Lo mejor que puedes compartir es tu conocimiento.
        </p>
        <a href="<?= NABU_ROUTES['signup'] ?>" class="hero__button">Comienza a escribir</a>
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


<h2>Artículos recientes</h2>
<?php $articles = $recent_articles ?>
<!-- <?php require 'views/components/articles.php' ?> -->

<?php require_once 'views/components/footer.php' ?>
