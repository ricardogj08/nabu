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

<?php $head_title = 'Aprobar artículos' ?>

<?php require_once 'views/components/dashboard.php' ?>
<h1>Aprobar artículos</h1>

<table>
    <tr>
        <th>Título</th>
        <th>Autor</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    <?php foreach($articles as $article): ?>
    <tr>
      <td><?= utils::escape($article['title']) ?></td>
      <td><a href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($article['author']) ?>"><?= utils::escape($article['author']) ?></a></td>
      <td><a href="<?= NABU_ROUTES['review-article'] . '&slug=' . $article['slug'] ?>">Editar</a></td>
      <td><a href="<?= NABU_ROUTES['delete-article'] . '&slug=' . $article['slug'] ?>">Eliminar</a></td>
      <td><a href="<?= NABU_ROUTES['authorize-article'] . '&slug=' . $article['slug'] ?>">Publicar</a></td>
    </tr>
    <?php endforeach ?>
</table>

<?php require_once 'views/components/footer.php' ?>
