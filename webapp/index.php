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

<body class="min-h-screen flex items-center justify-center bg-gray-400 backdrop-blur">
  <?php
  $tokenCarnet = isset($_GET['token_carnet']) ? $_GET['token_carnet'] : null;

  if ($tokenCarnet) {
    $iframeSrc = "/carnet?token_carnet=" . urlencode($tokenCarnet);
  } else {
    echo "Token not provided";
    exit;
  }
  ?>

  <iframe src="<?php echo $iframeSrc; ?>" class="w-full h-full border-none"></iframe>
  <script src="js/main.js"></script>
</body>

</body>

</html>