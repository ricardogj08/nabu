<?php defined('NABU') || exit() ?>
<?php $head_title = 'Artículo' ?>
<!-- Estilos cargados -->
<?php $styles     = array(
    'components/navbar/navbar.css',
    'components/articles/articles.css',
    'components/footer/footer.css',
    'pages/article/article.css',
) ?>
<!-- Estilos para el responsive design -->
<?php $desktop_styles = array(
     array('components/navbar/navbar-desktop.css', 'attributes' => 'media="screen and (min-width: 650px)"'),
    array('pages/article/article-desktop.css', 'attributes' => 'media="screen and (min-width: 768px)"'),
) ?>
<!-- Archivos de JavaScript -->
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
            <?= $article['title'] ?>¿Cómo ser creativo en un ambiete de estudio cuadrado?
        </h1>
        <div class="post__details">
            <a class="post__author-link" href="<?= $author_profile ?>">
                <picture class="post__profile">
                    <img src="https://scontent-lax3-1.xx.fbcdn.net/v/t1.6435-9/103564332_100818335008500_4987535241959814468_n.jpg?_nc_cat=108&ccb=1-5&_nc_sid=174925&_nc_eui2=AeFLfQ6m44wh0nGXbCIoQp9rQi_G7p1L5IpCL8bunUvkipd7MyfqDBh6lvl5slEJxg2JfKqtfoJLLSFgbZBhQ1tV&_nc_ohc=2Ht3awmMIc0AX975ljD&_nc_ht=scontent-lax3-1.xx&oh=aa5254a401801cdf23a8e02ae0239237&oe=616EB288" alt="Foto de perfil del autor" class="post__img-author">
                </picture>
            </a>
            <div class="post__info">
                <p class="post__author-name">
                    <a href="<?= $author_profile ?>">
                        <?= $article['author-username'] ?>Juan Jose Ramirez Lopez
                    </a>
                </p>
                <p class="post__date">
                    <?= $article['date'] ?>18 de Octubre 2021
                </p>
            </div>
        </div>
    </div>
</header>

<svg aria-hidden="true" style="position: absolute; width: 0; height: 0; overflow: hidden;" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
  <defs>
    <symbol id="icon-heart" viewBox="0 0 32 32">
      <path d="M23.6 2c-3.363 0-6.258 2.736-7.599 5.594-1.342-2.858-4.237-5.594-7.601-5.594-4.637 0-8.4 3.764-8.4 8.401 0 9.433 9.516 11.906 16.001 21.232 6.13-9.268 15.999-12.1 15.999-21.232 0-4.637-3.763-8.401-8.4-8.401z" style=""></path>
    </symbol>
  </defs>
</svg>

<section class="post__body">
    <aside class='post__aside'>
        <svg class="icon icon-heart">
            <use xlink:href="#icon-heart"></use>
        </svg>
    </aside>

    <article class="post__copy">
        <p>
        <?= $article['content'] ?>
        A las personas que estudiamos una ingeniería, desde pequeño se nos dicen frases como "Eres bueno para los números, no para lo demás", "Desarrollaste más la parte izquierda del cerebro", "La creatividad no va con personas como tu" y cosas por el estilo. Afortunadamente a lo largo de la vida me he dado cuenta de que la creatividad está dentro de todos y aún la persona más cuadrada puede ser creativa en un punto excelso.
        </p>
        <p>
        El estudiar en un ambiente ingenieril puede reprimir nuestro sentido creativo demasiado, llegando a un punto en que pensamos que no nacimos para ser creativos, por eso hoy me permito compartir tres simples consejos que me han funcionado a lo largo de la carrera para no dejar de lado mi "Yo" artista, soñador y creativo.
        </p>
        <h3>Entender que la creatividad no está en contra del conocimiento.</h3>
        <p>
        Creatividad no es antítesis del saber, de hecho yo lo pondría como un complemento del mismo, ya que la definición de ser creativo es precisamente eso; resolver problemas de forma diferente y sobre todo crear. Sabiendo esto podemos darnos cuenta que no son bandos contrarios ni nada parecido, dentro de la ingeniería nos encontramos con problemas que normalmente los resolvemos de forma lineal, siguiendo una formula o un patrón establecido por quien nos enseña a resolverlo, pero si le damos la vuelta al problema, es decir, entender el problema por completo desde la raíz, nos podremos dar cuenta que en el problema está la solución y no solo una, sino que hay muchas formas de resolver un mismo problema, solo hay que pensar un poquito fuera de la caja.
        </p>
        <h3>Define tu "Yo" creativo.</h3>
        <p>
        Para despertar un poco más tu instinto creativo, no nos debemos quedar encerrados en hacer cosas similares siempre, a veces es bueno salir un poco de tu zona de confort y buscar algunas cosas que te puedan gustar además de tu ingeniería, bailar, pintar, escribir, crear contenido audiovisual e incluso meternos en temas de otras ingenierías.
        </p>
        <p>
        Todas esas cosas que parecen no estar relacionadas con nuestra carrera pueden estarlo más de lo que nos imaginamos, pues el pensar en cosas distintas y resolver problemas a los que nunca nos imaginamos que nos enfrentaríamos , puede ser de mucho apoyo para pensar diferente dentro de nuestra área y pensar mas allá, e incluso mezclar conceptos de distintas áreas para crear aplicaciones de interés dentro de nuestra carrea y darles ese valor agregado que todos necesitamos para destacar un poquito y alimentar nuestra marca personal.
        </p>
        <p>
            <em>
            ¡Sal de tu zona de confort, no sabes con lo que te puedes encontrar!
            </em>
        </p>
        <h3>Sé autodidacta</h3>
        <p>
        Si buscamos un hobbie que nos saque de la rutina de aprender siempre lo mismo, por lo menos hay que hacerlo bien, en nuestro escritorio o en nuestro bolsillo se encuentra una puerta a todo el conocimiento humano, aprende a escribir, tomar fotografía, física, pero aprende bien, vuélvete bueno en tu hobbie y ¿por qué no? aprende más cosas acerca de tu carrera, los cursos y blogs online son de las mejores cosas en las cuales podemos invertir el tiempo navegando por internet.
        </p>
        <p>
        Sin duda lo anterior me ha funcionado durante estos cuatro años y medio a salir muchas veces de la rutina y me llevó a descubrir talentos que ni siquiera sabía que tenía. Recuerda, la creatividad la tenemos todos y podemos ser capaces de desarrollarla, solo hace falta practicar y practicar mucho, no eres "Una persona de números" eres una persona creativa, con un potencial inmenso guardado dentro de ti.
        </p>
    </article>
</section>

<section class="popular-posts">
    <h2 class="popular-posts__title">También tenemos esto para ti</h2>
    <section class="popular-cards__container">
        <?php require 'views/components/articles.php' ?>
        <?php require 'views/components/articles.php' ?>
        <?php require 'views/components/articles.php' ?>
    </section>
</section>

<section class="author-info">
    <div class="author-info__container">
        <picture class="author-info__image">
            <img class="author__image" src="https://64.media.tumblr.com/ca2bffff55fb8d4e84f5686502813d78/b16ec16ee09df3f4-65/s128x128u_c1/8773c700858f518d93429ce71b3e90349ee009c7.jpg">
            <!-- <img class="author__image" src="<?= $article['author']['image'] ?>" alt="Author profile image"> -->
        </picture>
        <div class="author-info__text">
            <h3 class="author-info__title">
                <a href="<?= $author_profile ?>">
                    <?= $article['author'] ?>
                    Juan Jose Ramirez Lopez
                </a>
            </h3>
            <p class="author-info__description">
                <?= $article['author-description'] ?>
                Le ordené a mi fase REM que anotase todos mis sueños en cuadernos.
            </p>
        </div>
    </div>
</section>

<section class="comments">
    <div class="comments__container">
        <h2 class="comments__title">Deja tu opinión al autor</h2>
        <div class="comments__list">

        </div>
        <div class="comments__box">
            <picture class="author-info__image comment__user-image-container">
                <img class="author__image comment__user-image" src="https://64.media.tumblr.com/ca2bffff55fb8d4e84f5686502813d78/b16ec16ee09df3f4-65/s128x128u_c1/8773c700858f518d93429ce71b3e90349ee009c7.jpg">
                <!-- <img class="author__image" src="<?= $article['author']['image'] ?>" alt="Author profile image"> -->
            </picture>
            <form class="comments__form">
                <textarea class="comments__textarea" placeholder="Hazle saber que estuviste aqui"  maxlength="250" name="textarea"></textarea>
                <input type="submit" class="comments__button" value="Enviar">
            </form>
        </div>
    </div>
</section>

<!-- <h2>Datos del autor</h2>

<div>
    <a href="<?= $author_profile ?>">
        <img src="<?= $article['author-avatar'] ?>" alt="Foto de perfil del autor" width="8%">
    </a>
    <p>
        <a href="<?= $author_profile ?>">
            <?= $article['author'] ?>
        </a>
    </p>
    <p><?= $article['author-description'] ?></p>
</div> -->

<?php require_once 'views/components/messages.php' ?>
<?php require_once 'views/components/footer.php' ?>
