<?php defined('NABU') || exit ?>
<?php $head_title    = 'Usuarios registrados' ?>
<?php $styles        = array(
    'admin/users/users.css',
) ?>
<?php $desktop_styles = array(
    array('admin/users/users-desktop.css', 'attributes' => ''),
) ?>
<?php $scripts = array() ?>
<?php require_once 'views/components/head.php' ?>
<?php require_once 'views/components/admin-navbar.php' ?>

<h1>Usuarios registrados</h1>

<?php require_once 'views/components/messages.php' ?>

<form method="POST" action="#">
    <input type="hidden" name="csrf" value="<?= $token ?>">
    <span>
        <input type="text" name="q" minlength="1" maxlength="255" required>
    </span>
    <span>
        <input type="submit" name="users-submit" value="&#x1F50E">
    </span>
</form>

<?php if (!empty($users)): ?>
    <table>
        <tr>
            <th>Nombre completo</th>
            <th>Apodo</th>
            <th>Estatus</th>
            <th></th>
            <th></th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['name'] ?></td>
                <td><?= $user['username'] ?></td>
                <td><?= $user['status'] ?></td>
                <?php if ($user['role'] == 'user'): ?>
                    <td><a href="#">Cambiar a usuario</a></td>
                <?php else: ?>
                    <td><a href="#">Cambiar a moderador</a></td>
                <?php endif ?>
                <td><a href="#">Eliminar</a></td>
            </tr>
        <?php endforeach ?>
        </table>
<?php endif ?>

<?php require_once 'views/components/pagination.php' ?>
<?php require_once 'views/components/footer.php' ?>
