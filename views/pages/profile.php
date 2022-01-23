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

<?php $head_title = $profile['username'] ?>

<!-- Estilos cargados -->
<?php $styles = array(
    'pages/profile/profile.css',
    'components/articles/articles.css',
) ?>

<!-- Estilos para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'pages/profile/profile-desktop.css', 'attributes' => ''),
) ?>

<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/navbar.php' ?>

<h1>Perfil</h1>

<?php if ($isMyProfile): ?>
    <a href="<?= NABU_ROUTES['edit-profile'] ?>">Editar perfil</a>
<?php endif ?>

<div>
    <img src="<?= $profile['background'] ?>" alt="Fondo de perfil" width="20%">
</div>

<ul>
    <li>Nombre completo: <?= $profile['name'] ?></li>
    <li>Apodo: <?= $profile['username'] ?></li>
    <li>Descripción: <?= $profile['description'] ?></li>
</ul>

<div>
    <img src="<?= $profile['avatar'] ?>" alt="Foto de perfil" width="8%">
</div>

<h2>Artículos publicados</h2>

<?php require_once 'views/components/articles.php' ?>
<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
