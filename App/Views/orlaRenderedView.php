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
    <iframe src="/orla/iframe?idOrla=<?= $idOrla ?>" frameborder="0" width="100%" height="650px"></iframe>
    <form action="/orla/pdf" method="get">
        <label for="paperFormat">Tria el format del PDF:</label>
        <select id="paperFormat" name="paperFormat">
            <option value="A1">A1</option>
            <option value="A2">A2</option>
            <option value="A3">A3</option>
            <option value="A4">A4</option>
            <option value="A5">A5</option>
        </select>
        <input type="hidden" name="idOrla" value="<?= $idOrla ?>">
        <button type="submit">Generate PDF</button>
    </form>

    <a href="/orla/edit?idOrla=<?= $idOrla ?>">Editar</a>
    <a href="/equipDirectiu">Tornar</a>
</body>
<?php require "Scripts.php" ?>

</html>