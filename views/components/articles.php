<?php defined('NABU') || exit ?>

<article class="card">
    <picture class="banner">
        <img src="https://static.collectui.com/shots/4415922/lady-on-balcony-large" alt="Inspirandome en la ventana, con mi gato" class="banner__image">
    </picture>
    <div class="card__info">
        <div class="card__text">
            <h3 class="card__title">Lugares donde la inspiracion y las ideas pueden llegar</h3>
            <p class="card__copy">La creatividad a veces no llega en el momento deseado, pero puede alcanzarnos en el momento menos esperado...</p>
        </div>
        <div class="card__details">
            <picture class="profile">
                <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.6435-9/103564332_100818335008500_4987535241959814468_n.jpg?_nc_cat=108&ccb=1-5&_nc_sid=174925&_nc_eui2=AeFLfQ6m44wh0nGXbCIoQp9rQi_G7p1L5IpCL8bunUvkipd7MyfqDBh6lvl5slEJxg2JfKqtfoJLLSFgbZBhQ1tV&_nc_ohc=2Ht3awmMIc0AX975ljD&_nc_ht=scontent-lax3-1.xx&oh=aa5254a401801cdf23a8e02ae0239237&oe=616EB288" alt="" class="profile__image">
            </picture>
            <span class = "card__author">by Ricardo Adrian Gomez</span>
            <div class="card__stats">
                <span class = "card__stats-hearth"></span>
                <span class = "card__stats-numlike">12</span>
                <span class="card__stats-comment"></span>
                <span class="card__stats-numcom">2</span>
            </div>
        </div>
    </div>
</article>

<?php foreach ($articles as $article): ?>
<hr>
    <img src="<?= $article['cover'] ?>" alt="Portada del artículo">
    <p><b>Título:</b> <a href="<?= $article['url'] ?>"><?= $article['title'] ?></a></p>
    <p><b>Sinopisis:</b> <?= $article['synopsis'] ?></p>
    <p><b>Autor:</b> <?= $article['author'] ?></p>
    <p><b>Número de favoritos:</b> <?= $article['favorites'] ?></p>
    <p><b>Número de comentarios:</b> <?= $article['comments'] ?></p>
<div>
<?php endforeach ?>
