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

<?php foreach ($articles as $post): ?>
<article class="card">
    <picture class="banner skeleton">
        <img src="<?= utils::url_image('cover', $post['cover']) ?>" alt="Portada del artículo" class="banner__image">
    </picture>
    <div class="card__info">
        <div class="card__text">
            <h3 class="card__title">
                <a href="<?= NABU_ROUTES['article'] . '&slug=' . $post['slug'] ?>" class="card__title-link">
                    <?= utils::escape($post['title']) ?>
                </a>
            </h3>
            <p class="card__copy"><?= utils::escape($post['synopsis']) ?></p>
        </div>
        <div class="card__details">
            <picture class="profile">
                <img src="<?= utils::url_image('avatar', $post['avatar']) ?>" alt="Foto del autor" class="profile__image">
            </picture>
            <a class="card__author" href="<?= NABU_ROUTES['profile'] . '&user=' . urlencode($post['author']) ?>"><?= utils::escape($post['author']) ?></a>
            <div class="card__stats">
                <span class = "card__stats-hearth"></span>
                <span class = "card__stats-numlike"><?= $post['likes'] ?></span>
                <span class="card__stats-comment"></span>
                <span class="card__stats-numcom"><?= $post['comments'] ?></span>
            </div>
        </div>
    </div>
</article>
<?php endforeach ?>
