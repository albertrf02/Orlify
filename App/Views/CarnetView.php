<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "Head.php" ?>
    <title>Carnet</title>
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
</body>

</html>