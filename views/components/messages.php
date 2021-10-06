<?php defined('NABU') || exit() ?>

<!-- Muestra mensajes sobre advertencias o avisos. -->
<?php if (!empty($messages)): ?>
<div>
    <?php foreach ($messages as $message): ?>
        <p><mark><?= $message ?>.</mark></p>
    <?php endforeach ?>
</div>
<?php endif ?>
