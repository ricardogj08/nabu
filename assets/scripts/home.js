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