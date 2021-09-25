<?php defined('NABU') || exit ?>
<?php $username = $_SESSION['user']['username'] ?>

<header>
    <h1>Administración</h1>
    <nav>
        <ul>
            <li><a href="<?= NABU_ROUTES['admin'] ?>">Artículos envíados</a></li>
            <li><a href="<?= NABU_ROUTES['published-articles'] ?>">Artículos publicados</a></li>
            <li><a href="<?= NABU_ROUTES['users'] ?>">Usuarios registrados</a></li>
            <li><a href="<?= NABU_ROUTES['home'] ?>"><?= NABU_DEFAULT['website-name'] ?></a></li>
            <li><a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($username) ?>"><?= utils::escape($username) ?></a></li>
            <li><a href="<?= NABU_ROUTES['logout'] ?>">Cerrar sesión</a></li>
        </ul>
    </nav>
</header>
