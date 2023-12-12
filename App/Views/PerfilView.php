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
            <div
                class="w-full max-w-md bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-8 mx-auto">
                <div class="flex flex-col items-center pb-10">
                    <form method="post" action="/perfil?action=setPorfilePhoto" id="avatarForm" style="display: none;">
                        <input type="hidden" name="action" value="setPorfilePhoto">
                        <input type="hidden" id="selectedAvatar" name="avatar" value="<?= $avatar ?>">
                        <div class="avatar-list" style="margin-bottom:-30px; margin-top:20px">
                            <?php foreach ($avatars as $avatar): ?>
                                <label>
                                    <a href="#" class="avatar-item" id="<?= $avatar ?>">
                                        <img class="avatar-img" src="<?= '../avatars/' . $avatar ?>" alt="avatar"></a>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </form>
                    <img class="w-24 h-24 mb-3 mt-12 rounded-full shadow-lg"
                        src="<?= '../avatars/' . $user["avatar"] ?>" alt="Alternative Text"
                        onerror="this.onerror=null; this.src='../avatars/avatar-nen1.png';" id="avatarImage"
                        onclick="toggleFormVisibility()">
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                        <?= $user["name"] ?>
                        <?= $user["surname"] ?>
                    </h5>
                    <span class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                        <?= $user["email"] ?>
                    </span>
                </div>
            </div>
            <!-- Tailwind Tab with Options -->
            <div class="w-full max-w-screen-md p-4 rounded">
                <ul
                    class="hidden text-sm font-medium text-center rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400 border border-grey mb-4">
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

                                    <!-- Report button -->
                                    <?php if ($photo["defaultPhoto"] !== 1): ?>
                                        <div class="absolute top-0 right-0 mt-2 mr-5 text-2xl">
                                            <button data-modal-target="popup-modal-<?= $photo['id']; ?>"
                                                data-modal-toggle="popup-modal"
                                                class="block text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                                type="button">
                                                <svg class="w-6 h-6 text-red-800 dark:text-red-500" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z" />
                                                </svg>
                                            </button>
                                        </div>
                                    <?php endif ?>

                                    <!-- Modal for reporting image -->
                                    <div id="popup-modal-<?= $photo['id']; ?>" tabindex="-1"
                                        class="hidden fixed inset-0 z-50 overflow-hidden">
                                        <div class="absolute inset-0 bg-black opacity-50"></div>
                                        <div class="flex items-center justify-center h-full">
                                            <div class="relative p-4 w-full max-w-md">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <button type="button"
                                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                        data-modal-hide="popup-modal-<?= $photo['id']; ?>">
                                                        <svg class="w-3 h-3" aria-hidden="true"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                    <div class="p-4 md:p-5 text-center">
                                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 20 20">
                                                            <path stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2"
                                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                        </svg>
                                                        <h3
                                                            class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                            Segur que vols reportar aquesta imatge</h3>
                                                        <div class="p-4 md:p-5 text-center">
                                                            <!-- ... (other content) ... -->

                                                            <!-- Buttons displayed side by side -->
                                                            <div class="flex justify-center mt-2">
                                                                <form method="POST" action="/report-image">
                                                                    <button type="submit" name="idPhoto"
                                                                        value="<?= $photo['id']; ?>"
                                                                        class="report-button mr-2 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-3 text-center me-2">Report
                                                                    </button>
                                                                </form>

                                                                <button data-modal-hide="popup-modal-<?= $photo['id']; ?>"
                                                                    type="button"
                                                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                                    No, cancel
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <div id="orlesTabContent" style="display: none;">
                    <p>This is the content for the "orles" tab.</p>
                </div>
                <div id="carnetTabContent" style="display: none;">
                    <div
                        class="w-full max-w-md bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-8 mx-auto">
                        <div class="flex items-start p-5">
                            <img class="w-24 h-24 mr-4 rounded-lg shadow-lg" src="<?php echo $defaultPhoto['link']; ?>"
                                alt="<?= $_SESSION["user"]["name"] ?>" />
                            <div>
                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                    <?= $_SESSION["user"]["name"] ?>
                                    <?= $_SESSION["user"]["surname"] ?>
                                </h5>
                                <span class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    <?= $_SESSION["user"]["email"] ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php require "Scripts.php" ?>

    <script>
        function toggleFormVisibility() {
            var form = document.getElementById("avatarForm");
            form.style.display = form.style.display === "none" ? "block" : "none";
        }

        function showTab(tabName) {
            document.getElementById("imagesTabContent").style.display =
                tabName === "images" ? "block" : "none";
            document.getElementById("orlesTabContent").style.display =
                tabName === "orles" ? "block" : "none";
            document.getElementById("carnetTabContent").style.display =
                tabName === "carnet" ? "block" : "none";
        }
    </script>
</body>

</html>