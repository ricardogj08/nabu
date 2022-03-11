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

// ---------------------- Init the hightlight functionality ------------------
hljs.highlightAll();

// ---------------------- Animation heart ------------------
const post = document.querySelector('.post__copy');
const heart = document.querySelector('.icon');

post.addEventListener("click", () => {
    heart.classList.add("beat");
    // countEl.innerHTML = count;
    setTimeout(() => {
        heart.classList.remove("beat");
    }, 1200);
});

// ---------------------- Fix images for the content post ------------------
const imagesPost = document.querySelectorAll('.post__copy img');

// Get the media query
const mediaQuery = window.matchMedia('(min-width: 768px)');
mediaQuery.addEventListener('change',handleDeviceChange);

//handle the event when changes the size and get the media query 
function handleDeviceChange(e){
    imagesPost.forEach(image => {
        image.parentElement.classList.toggle('post__container-img')    
    });
}

// execute for the fisrt time when the page load and apply the changes
handleDeviceChange();

