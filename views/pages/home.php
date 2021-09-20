<?php defined('NABU') || exit ?>
<?php $head_title    = NABU_DEFAULT['website-name'] ?>
<?php $style         = NABU_DIRECTORY['styles'] . '/pages/home/home.css' ?>
<?php $style_desktop = NABU_DIRECTORY['styles'] . '/pages/home/home-desktop.css' ?>
<?php require_once 'views/components/head.php' ?>

<header class="header">
    <?php require_once 'views/components/navbar.php' ?>
    <div class="hero">
        <picture class="hero__img-wrapper">
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
    <section></section>
    <section></section>
    <section></section>
</main>

<h2>Artículos más valorados</h2>
<?php require 'views/components/articles.php' ?>

<h2>Artículos recientes</h2>
<?php $articles = $recent_articles ?>
<?php require 'views/components/articles.php' ?>

<?php require_once 'views/components/footer.php' ?>
