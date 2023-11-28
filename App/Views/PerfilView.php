<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "Head.php" ?>
    <title>Perfil</title>
</head>

<body>

    <?php require "MenuView.php" ?>

    <div class="container mx-auto my-10 p-4">
        <div class="flex flex-col items-center">

            <!-- User Information Column -->
            <div
                class="w-full max-w-md bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-8 mx-auto">
                <div class="flex flex-col items-center pb-10">
                    <img class="w-24 h-24 mb-3 mt-12 rounded-full shadow-lg" src="<?php echo $defaultPhoto['link']; ?>"
                        alt="<?= $_SESSION["user"]["name"] ?>" />
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                        <?= $_SESSION["user"]["name"] ?>
                    </h5>
                    <span class=" mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <?= $_SESSION["user"]["email"] ?>
                    </span>
                </div>
            </div>
            <!-- Tailwind Tab with Options -->
            <div class="w-full max-w-screen-md p-4 rounded">
                <ul class="hidden text-sm font-medium text-center rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400 border border-grey mb-4">
                    <li class="w-full">
                        <a href="#"
                            class="tab-link inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 rounded-s-lg"
                            onclick="showTab('images')">Imatges</a>
                    </li>
                    <li class="w-full">
                        <a href="#"
                            class="tab-link inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                            onclick="showTab('orles')">Orles</a>
                    </li>
                    <li class="w-full">
                        <a href="#"
                            class="tab-link inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700 rounded-e-lg"
                            onclick="showTab('carnet')">Carnet</a>
                    </li>
                </ul>

                <div class="p-4">
                    <!-- Content for the selected tab goes here -->
                    <div id="imagesTabContent">
                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-3 gap-2">
                            <?php foreach ($userPhotos as $photo): ?>
                                <div class="relative flex flex-col items-center p-2 rounded">
                                    <form method="POST" action="/perfil?action=setDefaultPhoto">
                                        <button type="submit" name="idPhoto" value="<?= $photo['id']; ?>"
                                            class="img-button relative">
                                            <?php if ($photo["defaultPhoto"] == 1): ?>
                                                <div class="absolute top-0 right-0 mt-2 mr-3 text-2xl">
                                                    <img src="../img/bookmark.png" alt="Star" class="w-6 h-6">
                                                </div>
                                            <?php endif ?>
                                            <img src="<?= $photo["link"] ?>" alt="photo"
                                                class="h-48 w-48 object-cover rounded cursor-pointer">
                                        </button>
                                    </form>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div id="orlesTabContent" style="display: none;">
                    <p>This is the content for the "Orles" tab.</p>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php require "Scripts.php" ?>

    <script>
        function showTab(tabName) {
            document.getElementById('imagesTabContent').style.display = (tabName === 'images') ? 'block' : 'none';
            document.getElementById('orlesTabContent').style.display = (tabName === 'orles') ? 'block' : 'none';
            document.getElementById('carnetTabContent').style.display = (tabName === 'carnet') ? 'block' : 'none';
        }
    </script>
</body>

</html>