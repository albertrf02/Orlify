<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "Head.php" ?>
    <title>Document</title>
</head>

<?php require "MenuView.php" ?>

<body>
    <iframe src="/orla/iframe?idOrla=<?= $idOrla ?>" frameborder="0" width="100%" height="650px">
    </iframe>
    <a href="/orla/edit?idOrla=<?= $idOrla ?>">Editar</a>
    <a href="/orla/pdf?idOrla=<?= $idOrla ?>">PDF</a>
    <a href="/equipDirectiu">Tornar</a>
</body>
<?php require "Scripts.php" ?>

</html>