<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="stylesheet" href="/main.css">

  <title>Orlify</title>
</head>

<?php var_dump($_SESSION); ?>





<body>
  <?php require "MenuView.php" ?>



  <div id="cookie-notification" class="fixed bottom-0 left-0 right-0 p-4 bg-gray-800 text-white flex items-center justify-center transform translate-y-full transition-transform duration-500 ease-in-out">
    <div class="flex flex-col items-center justify-center w-full text-center rounded">
        <div class="flex items-center"> <!-- Añade 'flex items-center' -->
            <p class="text-sm my-4 mr-8">Aquest lloc web utilitza cookies per garantir que obtingueu la millor experiència en el nostre lloc web.</p> <!-- Añade 'mr-4' -->
            <button id="accept-cookies" class="mx-2 px-4 py-2 bg-gray-700 text-white rounded shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200 ease-in-out">
                Acceptar
            </button>
        </div>
    </div>
</div>











  <script src="/js/bundle.js"></script>
  <script src="/js/flowbite.js"></script>
</body>

</html>