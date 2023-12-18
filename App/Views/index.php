<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="/main.css">

  <title>Orlify</title>
</head>

<body>
  <?php require "MenuView.php" ?>
  <?php $orlesPubliques = false; ?>
  <?php foreach ($orles as $orla): ?>
    <?php if ($orla['public'] == 1): ?>
      <a href="/orla/iframe?idOrla=<?= $orla['id'] ?>"
        class="edit-button text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-700 font-medium rounded-lg text-sm inline-flex items-end px-5 py-2 text-center">
        Veure orla:
        <?= $orla['name'] ?>
        <?= $orla['className'] ?>
      </a>
      <?php $orlesPubliques = true; ?>
    <?php endif ?>
  <?php endforeach ?>
  <?php if (!$orlesPubliques): ?>
    <div class="flex flex-col items-center p-2 rounded mt-40">
      <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
        Actualment no hi ha cap orla pública
      </h5>
    </div>
  <?php endif ?>
</body>
<?php require "Scripts.php" ?>

</html>