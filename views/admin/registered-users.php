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

<!-- Estilos a cargar -->
<?php $styles = array(
    'components/messages/messages.css',
    'components/search/search.css',
    'components/pagination/pagination.css',
    'components/footer/footer.css',
) ?>

<!-- Estilos a cargar para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'components/footer/footer-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
    array('file' => 'components/search/search-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
    array('file' => 'components/pagination/pagination-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
) ?>

<!-- Componente head -->
<?php require_once 'views/components/head.php' ?>

<!-- Body -->


<?php require_once 'views/components/dashboard.php' ?>

<h1>Usuarios registrados</h1>

<?php require_once 'views/components/search.php' ?>

<table>
    <tr>
        <th>Nombre</th>
        <th>Apodo</th>
        <th>Correo institucional</th>
        <th>Eliminar</th>
        <th>Cambiar rol</th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
      <td><a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($user['username']) ?>"><?= utils::escape($user['name']) ?></a></td>
      <td><?= utils::escape($user['username']) ?></td>
      <td><?= utils::escape($user['email']) ?></td>
      <td><a href="<?= NABU_ROUTES['delete-user'] . '&user=' . urlencode($user['username']) ?>">Eliminar</a></td>
      <td>
        <form method="POST" action="<?= NABU_ROUTES['change-role'] . '&user=' . utils::escape($user['username']) ?>" >
          <select name="role" id="role">
            <option value="<?= $user['roleId'] ?>"><?= $user['role'] ?></option>
            <?php foreach($roles as $role): ?>
              <?php if($role['id'] != $user['roleId']): ?>
                <option value="<?= $role['id'] ?>"><?= $role['name'] ?></option>
              <?php endif ?>
            <?php endforeach ?>
          </select>
          <input type="hidden" name="csrf" value="<?= $token ?>">
          <input type="submit" name="change-role-form" value="Guardar">
        </form>
      </td>
    </tr>
    <?php endforeach ?>
</table>

<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
