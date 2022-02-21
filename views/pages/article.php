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

<?php $head_title = 'Artículo' ?>

<!-- Estilos a cargar -->
<?php $styles = array(
    'components/navbar/navbar.css',
    'components/articles/articles.css',
    'components/footer/footer.css',
    'pages/article/article.css'
) ?>

<!-- Estilos a cargar para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'components/navbar/navbar-desktop.css', 'attributes' => 'media="screen and (min-width: 768px)"'),
    array('file' => 'pages/article/article-desktop.css',    'attributes' => 'media="screen and (min-width: 768px)"')
) ?>

<!-- Archivos de javascript a cargar -->
<?php $scripts = array(
    'home.js',
    'article/article.js',
) ?>

<!-- HTML head -->
<?php require_once 'views/components/head.php' ?>
<!-- HTML body -->
<header>
    <!-- Nav bar -->
    <?php require_once 'views/components/navbar.php' ?>
    <div class="post__head">
        <h1 class="post__title">
            <?= $article['title'] ?>
        </h1>
        <div class="post__details">
            <a class="post__author-link" href="<?= $article['profile'] ?>">
                <picture class="post__profile">
                    <img src="<?= $article['avatar'] ?>" alt="Foto de perfil del autor" class="post__img-author">
                </picture>
            </a>
            <div class="post__info">
                <p class="post__author-name">
                    <a href="<?= $article['profile'] ?>">
                        <?= $article['author'] ?>
                    </a>
                </p>
                <p class="post__date">
                    <?= $article['date'] ?>
                </p>
            </div>
        </div>
    </div>
</header>

<section class="post__body">
    <aside class='post__aside'>
        <div class="heart">
            <input type="checkbox" id='toggle__heart'>
            <label for="toggle__heart">❤</label>
        </div>
    </aside>

    <article class="post__copy">
        <?= $article['body'] ?>
    </article>
</section>

<section class="popular-posts">
    <h2 class="popular-posts__title">También tenemos esto para ti</h2>
    <section class="popular-cards__container">
        <?php require 'views/components/articles.php' ?>
    </section>
</section>

<section class="author-info">
    <div class="author-info__container">
        <picture class="author-info__image">
            <img class="author__image" src="<?= $article['avatar'] ?>">
        </picture>
        <div class="author-info__text">
            <h3 class="author-info__title">
                <a href="<?= $article['profile'] ?>">
                    <?= $article['author'] ?>
                </a>
            </h3>
            <p class="author-info__description">
                <?= $article['description'] ?>
            </p>
        </div>
    </div>
</section>

<?php require_once 'views/components/messages.php' ?>

<section class="comments">
    <div class="comments__container">
        <h2 class="comments__title">Deja tu opinión al autor</h2>
        <div class="comments__list">

        </div>
        <div class="comments__box">
            <picture class="author-info__image comment__user-image-container">
                <img class="author__image comment__user-image" src="<?= $login['avatar'] ?>">
            </picture>
            <form class="comments__form" method="POST" action="<?= $view ?>">
                <input type="hidden" name="csrf" value="<?= $token ?>">
                <textarea class="comments__textarea" placeholder="Hazle saber que estuviste aqui"  maxlength="255" name="textarea"></textarea>
                <input type="submit" name="comments-form" class="comments__button" value="Enviar">
            </form>
        </div>
    </div>
</section>

<?php require_once 'views/components/footer.php' ?>
