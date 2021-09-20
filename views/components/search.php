<?php defined('NABU') || exit ?>

<form method="POST" action="<?= NABU['home'] ?>">
    <input type="hidden" name="csrf" value="<?= $token ?>">
    <span>
        <input type="text" name="q" minlength="1" maxlength="246" required>
    </span>
    <span>
        <input type="submit" name="search-submit" value="&#x1F50E">
    </span>
</form>
