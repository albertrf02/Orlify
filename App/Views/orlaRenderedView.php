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
    <iframe src="/orla/iframe" frameborder="0" width="100%" height="100%">
    </iframe>
    <a href="/orla/edit?idOrla=<?= $idOrla ?>">Editar</a>
    <a href="/orla/pdf?idOrla=<?= $idOrla ?>">PDF</a>
</body>

</html>