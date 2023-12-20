<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Carnet</title>
  <link rel="manifest" href="manifest.json" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link rel="apple-touch-icon" href="images/hello-icon-152.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="white" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <meta name="apple-mobile-web-app-title" content="Carnet" />
  <meta name="msapplication-TileImage" content="images/hello-icon-144.png" />
  <meta name="msapplication-TileColor" content="#FFFFFF" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flowbite h-screen flex items-center justify-center bg-gray-400 backdrop-blur">
  <div class="bg-white p-5 rounded shadow-md w-full sm:w-96">
    <form action="/carnet" method="GET" class="max-w-sm mx-auto">
      <label for="token" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Token:</label>
      <input type="text" id="token" name="token_carnet"
        class="rounded-none rounded-e-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        required>
      <button type="submit"
        class="mt-4 w-full text-white bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:focus:ring-blue-800">Submit</button>
    </form>

    <?php
    $tokenCarnet = isset($_GET['token_carnet']) ? $_GET['token_carnet'] : null;

    if ($tokenCarnet) {
      $iframeSrc = "/carnet?token_carnet=" . urlencode($tokenCarnet);
    } else {
      "Token not provided";
      exit;
    }
    ?>

    <div class="flex flex-col items-center">
      <iframe src="<?php echo $iframeSrc; ?>" class="w-full h-full border-none"></iframe>
    </div>
  </div>
  <?php require "Scripts.php" ?>
  <script src="js/main.js"></script>
</body>

</html>