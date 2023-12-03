<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "Head.php" ?>
    <title>Login</title>
</head>
<body class="bg-background">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-5 rounded shadow-md w-full sm:w-96">
                <div class="mb-5 flex items-center justify-center">
                    <a href="/"> 
                        <img src="/img/logo.png" class="h-10" alt="orlify">
                    </a>
                </div>
                <p class="mb-4 text-sm font-medium text-grey-800 dark:text-white">Token invalido o el token ya ha caducado</p>
                <?= $time ?>
                <?= $time ?>
                <?= $time ?>
                <?= $time ?>

        </div>
    </div>
    <?php require "Scripts.php" ?>
</body>
</html>
