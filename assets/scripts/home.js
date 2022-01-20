/*
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
*/

'use strict';
const controlMenu = document.querySelector('#control-menu');
const menu = document.querySelector('#menu');
const overlay = document.querySelector('.overlay');

controlMenu.addEventListener('click', () => {
    menu.classList.add('nav__menu-isactive');
    overlay.classList.add('overlay__is-active');
    document.body.classList.add('stop-scrolling');
});

overlay.addEventListener('click', () => {
    menu.classList.remove('nav__menu-isactive');
    overlay.classList.remove('overlay__is-active');
    document.body.classList.remove('stop-scrolling');
})

/*
    Home
        head.php
        home.php
        home.css
        home-desktop.css
        home.js

    menu.js
    normalize.css

    Articles
        articles.php
        articles.css
        articles-desktop.css
        articles.js
*/
