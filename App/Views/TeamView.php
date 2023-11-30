<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "Head.php" ?>
    <title>Equip Directiu</title>
</head>
<body>
    <?php require "MenuAdmin.php" ?>

    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" id="orles" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                    <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Orles</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">
            <div id="pagina-users" class="pagina flex flex-wrap justify-center">
                <?php foreach ($orles as $orla) : ?>
                    <div class="w-full max-w-xs sm:w-full md:w-1/2 lg:w-1/3 xl:w-1/3 m-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <!-- Orla Details -->
                        <div class="flex flex-col items-center pb-10 py-4" >
                            <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="<?= $orla['link'] ?>" alt="Bonnie image"/>
                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?= $orla['visibility']?></h5>
                            <span class="text-sm text-gray-500 dark:text-gray-400"><?= $orla['email'] ?></span>
                            <div class="flex mt-4 md:mt-6">
                                <!-- Edit and Delete Buttons -->
                                <a href="#" type="button" data-edit-orla-id="<?= $orla['id']; ?>" data-modal-target="editOrlaModal" data-modal-show="editOrlaModal" class="editOrlaModal inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Editar</a>

                                <a href="#" type="button" data-delete-orla-id="<?= $orla['id']; ?>" data-modal-target="deleteOrlaModal" data-modal-show="deleteOrlaModal" class="deleteOrlaModal inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-red-600 border border-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-700 dark:border-red-700 dark:hover:bg-red-800 dark:focus:ring-red-800 ms-3">Eliminar</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>

    <?php require "Scripts.php" ?>
</body>
</html>