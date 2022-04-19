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

<?php $head_title = 'Usuarios registrados' ?>

<?php require_once 'views/components/dashboard.php' ?>

<h1>Usuarios registrados</h1>

<?php require_once 'views/components/search.php' ?>

<table>
    <tr>
        <th>Nombre</th>
        <th>Apodo</th>
        <th>Correo institucional</th>
        <th>Rol</th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
      <td><a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($user['username']) ?>"><?= utils::escape($user['name']) ?></a></td>
      <td><?= utils::escape($user['username']) ?></td>
      <td><?= utils::escape($user['email']) ?></td>
      <td><?= $user['role'] ?></td>
      <td><a href="<?= NABU_ROUTES['delete-user'] . '&user=' . urlencode($user['username']) ?>">Eliminar</a></td>
      <td>Cambiar rol</td>
    </tr>
    <?php endforeach ?>
</table>

<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
