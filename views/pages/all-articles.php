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

<?php $head_title = 'Muro' ?>

<!-- Estilos cargados -->
<?php $styles = array(
    'components/navbar/navbar.css',
    'components/search/search.css',
    'pages/all-articles/all-articles.css',
    'components/articles/articles.css',
    'components/footer/footer.css',
    'components/pagination/pagination.css',
) ?>

<!-- Estilos para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'components/navbar/navbar-desktop.css',        'attributes' => 'media="screen and (min-width: 650px)"'),
    array('file' => 'components/footer/footer-desktop.css',        'attributes' => 'media="screen and (min-width: 650px)"'),
    array('file' => 'components/search/search-desktop.css',        'attributes' => 'media="screen and (min-width: 650px)"'),
    array('file' => 'pages/all-articles/all-articles-tablet.css',  'attributes' => 'media="screen and (min-width: 650px)"'),
    array('file' => 'pages/all-articles/all-articles-desktop.css', 'attributes' => 'media="screen and (min-width: 1024px)"'),
    array('file' => 'components/pagination/pagination-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
) ?>

<!-- Archivos de javascript -->
<?php $scripts = array(
    'home.js',
) ?>

<!-- Componente head -->
<?php require_once 'views/components/head.php' ?>

<header class="header">
    <?php require_once 'views/components/navbar.php' ?>
</header>

<main>
    <section class="searcher">
        <div class="searcher__content">
            <span class="searcher__image"></span>
            <?php require_once 'views/components/search.php' ?>
        </div>
    </section>
    
    <section class="articles">
        <div class="articles__data">
            <h1 class = "articles__title">Muro</h1>
            <span class="articles__icon"></span>
        </div>
        <div class="articles__cards">
            <?php require 'views/components/articles.php' ?>
        </div>
    </section>

    <?php require_once 'views/components/pagination.php' ?>

    <section class="CTA">
        <div class="CTA__container">
            <div class="CTA__text">
                <h2 class="CTA__title">Interesante, ¿No? 🤔</h2>
                <p class="CTA__description">Déjanos tu e-mail y te compartiremos los posts más recientes, además de recursos para mejorar tu escritura en medios digitales. 😉</p>
                <div class="CTA__mail">
                    <form class="CTA__form" method="POST" action="">
                        <input class = "form__input-mail" type="text" minlength="1" placeholder="Tu e-mail" maxlength="246" required>
                        <input class = "form__join" type="submit" name="mail-submit" value="Unirme">
                    </form>
                </div>
            </div>
            <span class="CTA__image"></span>
        </div>
    </section>
</main>

<?php require_once 'views/components/footer.php' ?>
