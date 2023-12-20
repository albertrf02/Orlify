<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Hello World</title>
  <link rel="manifest" href="manifest.json" />
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link rel="apple-touch-icon" href="images/hello-icon-152.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="theme-color" content="white" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <meta name="apple-mobile-web-app-title" content="Hello World" />
  <meta name="msapplication-TileImage" content="images/hello-icon-144.png" />
  <meta name="msapplication-TileColor" content="#FFFFFF" />
</head>

<body class="flowbite h-screen flex items-center justify-center bg-gray-400 backdrop-blur">
  <div
    class="w-full max-w-md bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-8">
    <div class="flex items-start p-5">
      <img class="w-24 h-24 mr-4 rounded-lg shadow-lg" src="<?= '../avatars/' . $user["avatar"] ?>"
        alt="<?= $user["name"] ?>" />
      <div>
        <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
          <?= $user["name"] ?>
          <?= $user["surname"] ?>
        </h5>
        <span class="mb-2 text-sm text-gray-500 dark:text-gray-400">
          <?= $user["email"] ?>
        </span>
      </div>
    </div>
  </div>
  <script src="js/main.js"></script>
</body>

</html>