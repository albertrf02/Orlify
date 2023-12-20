<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="/main.css">

  <title>Orlify</title>
</head>

<body class="bg-cover bg-center bg-no-repeat bg-fixed" style="background-image: url(img/classeIndex.jpg);">
  <?php require "MenuView.php" ?>
  <div class="container mx-auto my-8">
    <?php $orlesPubliques = false; ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
      <?php foreach ($orles as $orla): ?>

        <?php if ($orla['public'] == 1): ?>
          <div class="bg-white p-4 rounded-lg shadow-md">
            <a href="/orla/iframe?idOrla=<?= $orla['id'] ?>" class="block text-center mb-2">
              <img src="/img/imatge_orles.png" alt="<?= $orla['name'] ?>" class="w-full h-36 object-cover rounded-md">
            </a>
            <h3 class="text-lg font-medium mb-2">
              <?= $orla['name'] ?>
            </h3>
            <p class="text-gray-600">
              <?= $orla['className'] ?>
            </p>
          </div>
          <?php $orlesPubliques = true; ?>
        <?php endif ?>
      <?php endforeach ?>
    </div>
    <?php if (!$orlesPubliques): ?>
      <div class="flex flex-col items-center p-2 rounded mt-40">
        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
          Actualment no hi ha cap orla pública
        </h5>
      </div>
    <?php endif ?>

    <div id="cookie-notification"
      class="fixed bottom-0 left-0 right-0 p-4 bg-gray-800 text-white flex items-center justify-center transform translate-y-full transition-transform duration-500 ease-in-out">
      <div class="flex flex-col items-center justify-center w-full text-center rounded">
        <div class="flex items-center"> <!-- Añade 'flex items-center' -->
          <p class="text-sm my-4 mr-8">Aquest lloc web utilitza cookies per garantir que obtingueu la millor experiència
            en el nostre lloc web.</p> <!-- Añade 'mr-4' -->
          <button id="accept-cookies"
            class="mx-2 px-4 py-2 bg-gray-700 text-white rounded shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200 ease-in-out">
            Acceptar
          </button>
        </div>
      </div>
    </div>











    <script src="/js/bundle.js"></script>
    <script src="/js/flowbite.js"></script>
</body>
<?php require "Scripts.php" ?>

</html>