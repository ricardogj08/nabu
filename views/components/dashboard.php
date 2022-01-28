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
<?php $user = $_SESSION['user'] ?>

<!-- Estilos cargados -->
<?php $styles = array(
    'components/dashboard/dashboard.css',
) ?>

<?php require_once 'views/components/head.php' ?>

<header>
<h1>Administración</h1>
<nav>
    <ul>
        <li><a href="<?= NABU_ROUTES['approve-articles'] ?>">Aprobar artículos</a></li>
        <li><a href="<?= NABU_ROUTES['published-articles'] ?>">Artículos publicados</a></li>
        <li><a href="<?= NABU_ROUTES['registered-users'] ?>">Usuarios registrados</a></li>
        <li><a href="<?= NABU_ROUTES['home'] ?>"><?= NABU_DEFAULT['website-name'] ?></a></li>
        <li><a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($user['username']) ?>"><?= utils::escape($user['username']) ?></a></li>
        <li><a href="<?= NABU_ROUTES['logout'] ?>">Cerrar sesión</a></li>
    </ul>
</nav>
</header>

<?php require_once 'views/components/messages.php' ?>
