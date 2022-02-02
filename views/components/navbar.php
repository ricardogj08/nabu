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

<div class="overlay"></div>
<nav class="nav">
    <div class='nav__polygon'></div>
    <figure class="nav__logo-wrapper">
        <a href="<?= NABU_ROUTES['home'] ?>">
            <img class="nav__logo" src="<?= NABU_DIRECTORY['images'] ?>/nabu-logo.svg" alt="Logo de nabu">
        </a>
    </figure>
    <span class="nav__burger-icon" id="control-menu">&#9776;</span>
        <ul class="nav__menu" id="menu">
            <li class="nav__item-logo">
                <a href="<?= NABU_ROUTES['home'] ?>">
                    <img class="nav__logo-menu" src="<?= NABU_DIRECTORY['images'] ?>/nabu-logo.svg" alt="Logo de nabu">
                </a>
            </li>
            <li class="nav__item">
                <span></span><a href="<?= NABU_ROUTES['all-articles'] ?>">Muro</a>
            </li>
            <?php if (isset($_SESSION['user'])): ?>
                <?php $user = $_SESSION['user'] ?>
                <?php if ($user['role'] == 'admin'): ?>
                    <li class="nav__item">
                        <a href="<?= NABU_ROUTES['admin'] ?>">Administración</a>
                    </li>
                <?php endif ?>
                <li class="nav__item">
                    <a href="<?= NABU_ROUTES['post-article'] ?>">Publicar un post</a>
                </li>
                <li class="nav__item">
                    <a href="<?= NABU_ROUTES['favorites'] ?>">Favoritos</a>
                </li>
                <li class="nav__item">
                    <a href="<?= NABU_ROUTES['sent-articles'] ?>">Artículos enviados</a>
                </li>
                <li class="nav__item">
                    <a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($user['username']) ?>"><?= utils::escape($user['username']) ?></a>
                </li>
                <li class="nav__item">
                    <span></span><a href="<?= NABU_ROUTES['logout'] ?>">Cerrar sesión</a>
                </li>
            <?php else: ?>
                <li class="nav__item">
                    <span></span><a href="<?= NABU_ROUTES['login'] ?>">Inicia sesión</a>
                </li>
                <li class="nav__item">
                    <span></span><a href="<?= NABU_ROUTES['signup'] ?>">Comienza a escribir</a>
                </li>
            <?php endif ?>
        </ul>
</nav>
