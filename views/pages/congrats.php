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

<?php $head_title = '¡Felicidades!' ?>

<!-- Estilos cargados -->
<?php $styles = array(
    'pages/congrats/congrats.css'
) ?>

<!-- Estilos para el responsive design -->
<?php $desktop_styles = array(
    array('file' => 'pages/congrats/congrats-desktop.css', 'attributes' => ''),
) ?>

<!-- Archivos de javascript -->
<?php $scripts = array(
    'congrats/congrats.js',
) ?>

<!-- Componente head -->
<?php require_once 'views/components/head.php' ?>

<!-- HTML body -->
<canvas class="congrats__canvas"></canvas>
<div class="congrats__wrapper">
    <main class="congrats">
        <h1 class="congrats__title">¡Felicidades!</h1>
        <p class="congrats__text">&#x1F680; Pronto tendrás noticias acerca de tu post, gracias por compartir lo que sabes &#x1F49C;</p>
        <a href="<?= NABU_ROUTES['all-articles'] ?>" class="congrats__btn">Ir al muro</a>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
</body>
</html>