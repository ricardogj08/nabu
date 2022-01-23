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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Base CSS files -->
    <link rel="icon" href="<?= NABU_DIRECTORY['images'] ?>/buho.svg"  type="image/svg+xml" sizes="any">
    <link rel="stylesheet" href="<?= NABU_DIRECTORY['styles'] ?>/normalize.css">
    <!-- Mobile CSS files -->
    <?php $styles = isset($styles) ? $styles : array() ?>
    <?php foreach ($styles as $style): ?>
        <link rel="stylesheet" href="<?= NABU_DIRECTORY['styles'] . '/' . $style ?>">
    <?php endforeach ?>
    <!-- Desktop CSS files -->
    <?php $desktop_styles = isset($desktop_styles) ? $desktop_styles : array() ?>
    <?php foreach ($desktop_styles as $style): ?>
        <link rel="stylesheet" href="<?= NABU_DIRECTORY['styles'] . '/' . $style['file'] ?>" <?= $style['attributes'] ?>>
    <?php endforeach ?>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- JS files -->
    <?php $scripts = isset($scripts) ? $scripts : array() ?>
    <?php foreach ($scripts as $script): ?>
        <script src="<?= NABU_DIRECTORY['scripts'] . '/' . $script ?>" defer></script>
    <?php endforeach ?>
    <title><?= isset($head_title) ? $head_title . ' | ' . NABU_DEFAULT['website-name'] : NABU_DEFAULT['website-name'] ?></title>
</head>
<body>
