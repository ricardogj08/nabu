<?php defined('NABU') || exit() ?>

<div class="search__container">
    <form class="form" method="POST" action="<?= NABU_ROUTES['home'] ?>">
        <input type="hidden" name="csrf" value="<?= $token ?>">
        <div class="search__content">
            <input class = "search__input" type="text" name="q" minlength="1" placeholder="Buscar un blogpost" maxlength="246" required>
            <span class="glass__icon"></span>
        </div>
        <!-- <span>
            <input type="submit" name="search-submit" value="&#x1F50E">
        </span> -->
    </form>
</div>
