<?php defined('NABU') || exit() ?>

<div class="overlay"></div>
<nav class="nav">
    <figure class="nav__logo-wrapper">
        <img class="nav__logo" src="<?= NABU_DIRECTORY['images'] ?>/nabu-logo.svg" alt="Logo de nabu">
    </figure>
    <span class="nav__burger-icon" id="control-menu"></span>
        <ul class="nav__menu" id="menu">
            <li class="nav__item-logo">
                <a href="<?= NABU_ROUTES['home'] ?>">
                    <img class="nav__logo" src="<?= NABU_DIRECTORY['images'] ?>/nabu-logo.svg" alt="Logo de nabu">
                </a>
            </li>
            <li class="nav__item">
                <span></span><a href="<?= NABU_ROUTES['all-articles'] ?>">Artículos</a>
            </li>
            <?php if (true): ?>
                <li class="nav__item">
                    <span></span><a href="<?= NABU_ROUTES['login'] ?>">Inicia sesión</a>
                </li>
                <li class="nav__item">
                    <span></span><a href="<?= NABU_ROUTES['signup'] ?>">Comienza a escribir</a>
                </li>
            <?php else: ?>
                <?php $username = $_SESSION['user']['username'] ?>
                <?php if (false): ?>
                    <li class="nav__item">
                        <a href="<?= NABU_ROUTES['admin'] ?>">Administración</a>
                    </li>
                <?php endif ?>
                <li class="nav__item">
                    <a href="<?= NABU_ROUTES['sent-articles'] ?>">Artículos enviados</a>
                </li>
                <li class="nav__item">
                    <a href="<?= NABU_ROUTES['favorites'] ?>">Favoritos</a>
                </li>
                <li class="nav__item">
                    <a href="<?= NABU_ROUTES['post-article'] ?>">Publicar un post</a>
                </li>
                <li class="nav__item">
                    <a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($username) ?>"><?= utils::escape($username) ?></a>
                </li>
                <li class="nav__item">
                    <span></span><a href="<?= NABU_ROUTES['logout'] ?>">Cerrar sesión</a>
                </li>
            <?php endif ?>
        </ul>
</nav>
