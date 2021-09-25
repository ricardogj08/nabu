<?php defined('NABU') || exit ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Base CSS files -->
    <link rel="icon" href="<?= NABU_DIRECTORY['images'] ?>/buho.svg"  type="image/svg+xml" sizes="any">
    <link rel="stylesheet" href="<?= NABU_DIRECTORY['styles'] ?>/normalize.css">
    <!-- Mobile CSS files -->
    <?php foreach ($styles as $style): ?>
        <link rel="stylesheet" href="<?= NABU_DIRECTORY['styles'] . '/' . $style ?>">
    <?php endforeach ?>
    <!-- Desktop CSS files -->
    <?php foreach ($desktop_styles as $style): ?>
        <link rel="stylesheet" href="<?= NABU_DIRECTORY['styles'] . '/' . $style[0] ?>" <?= $style['attributes'] ?>>
    <?php endforeach ?>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- JS files -->
    <?php foreach ($scripts as $script): ?>
        <script src="<?= NABU_DIRECTORY['scripts'] . '/' . $script ?>" defer></script>
    <?php endforeach ?>
    <title><?= $head_title ?></title>
</head>
<body>
