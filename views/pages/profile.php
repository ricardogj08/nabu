<?php defined('NABU') || exit ?>
<?php $head_title = 'Perfil' ?>
<?php $styles     = array(
    'pages/profile/profile.css',
    'components/articles/articles.css',
) ?>
<?php $desktop_styles = array(
    array('pages/profile/profile-desktop.css', 'attributes' => ''),
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Perfil</h1>

<?php if (true): ?>
    <a href="<?= NABU_ROUTES['edit-profile'] ?>">Editar perfil</a>
<?php endif ?>

<div>
    <img src="<?= $user['background'] ?>" alt="Fondo de perfil" width="20%">
</div>

<ul>
    <li>Nombre completo: <?= $user['name'] ?></li>
    <li>Apodo: <?= $user['username'] ?></li>
    <li>Descripción: <?= $user['description'] ?></li>
</ul>

<div>
    <img src="<?= $user['avatar'] ?>" alt="Foto de perfil" width="8%">
</div>

<h2>Artículos publicados</h2>

<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
