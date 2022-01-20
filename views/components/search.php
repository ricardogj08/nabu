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

<div class="search__container">
    <form class="form" method="POST" action="<?= NABU_ROUTES['home'] ?>">
        <input type="hidden" name="csrf" value="<?= $token ?>">
        <div class="search__content">
            <input class="search__input" type="text" name="q" minlength="1" placeholder="Buscar un blogpost" maxlength="246" required>
            <span class="glass__icon"></span>
        </div>
        <!-- <span>
            <input type="submit" name="search-submit" value="&#x1F50E">
        </span> -->
    </form>
</div>
