<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "Head.php" ?>
    <title>Professor</title>
</head>
<body>
    <?php require "MenuAdmin.php" ?>

    <aside id="new-logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" id="new-users" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                        </svg>
                        <span class="ms-3">Users</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="new-grups" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <!-- SVG Path -->
                        </svg>
                        <span class="ms-3">Grups</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="new-classes" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                            <!-- SVG Path -->
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Orles</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64 h-screen">
    
        <div class="p-4 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

            <div id="new-pagina-users" class="pagina flex flex-col">
                <div class="flex flex-wrap justify-center">
                    <?php foreach ($users as $user) : ?>
                        <div class="w-full max-w-xs sm:w-full md:w-1/2 lg:w-1/4 xl:w-1/4 m-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex justify-end px-4 pt-4">
                                <?php if (!isset($user['role']) && $user['role'] === NULL) : ?>
                                    <div class="py-4">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="py-4">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                            <div class="flex flex-col items-center pb-10">
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="../img/logo.png" alt="Bonnie image"/>
                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?= $user['name'] . ' ' . $user['surname'] ?></h5>
                                <span class="text-sm text-gray-500 dark:text-gray-400"><?= $user['email'] ?></span>
                                <div class="flex mt-4 md:mt-6">
                                    <a href="#" type="button" data-edit-user-id="<?= $user['id']; ?>" data-modal-target="editUserModal" data-modal-show="editUserModal" class="editUserModal inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Editar</a>
                                    <a href="#" type="button" data-delete-user-id="<?= $user['id']; ?>" data-modal-target="deleteUserModal" data-modal-show="deleteUserModal" class="deleteUserModal inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-red-600 border border-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-700 dark:border-red-700 dark:hover:bg-red-800 dark:focus:ring-red-800 ms-3">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

                <div class="flex items-center justify-center mt-8">
                    <nav aria-label="Page navigation example">
                        <ul class="flex items-center -space-x-px h-10 text-base">
                            <li>
                                <?php if ($currentPage > 1) : ?>
                                    <a href="?page=<?= $currentPage - 1 ?>" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <span class="sr-only">Previous</span>
                                        <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                    </a>
                                <?php endif ?>
                            </li>

                            <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li>
                                    <a href="?page=<?= $i ?>" class="<?= $i == $currentPage ? 'z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor ?>
                            <li>
                                <?php if ($currentPage < $totalPages) : ?>
                                    <a href="?page=<?= $currentPage + 1 ?>" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <span class="sr-only">Next</span>
                                        <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                    </a>
                                <?php endif ?>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div id="editUserModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-screen-lg mx-auto max-h-screen-3/4">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <div class="flex items-center justify-between p-2 border-b rounded-t dark:border-gray-600">
                                <!-- Close button -->
                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editUserModal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                    <div class="border-2 mb-8 lg:mb-0 p-4">
                                        <div class="mb-5 flex items-center justify-center">
                                            <a><img src="../img/logo.png" alt="Orlify" class="h-10"></a>
                                        </div>                                         
                                        <input type="hidden" name="formType" value="adminRegistration">
                                        <div class="mb-5 grid grid-cols-2 gap-4">
                                            <div class="mb-5">
                                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                                                <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" readonly>
                                            </div>
                                            <div class="mb-5">
                                                <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cognoms</label>
                                                <input type="text" name="surname" id="surname" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" readonly>
                                            </div>
                                        </div>
                                        <div class="mb-5 grid grid-cols-2 gap-4">
                                            <div class="mb-5">
                                                <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom d'usuari</label>
                                                <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" readonly>
                                            </div>
                                            <div class="mb-5">
                                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" readonly></div>
                                        </div>
                                        
                                    </div>
                                    
                    <!-- Drag and Drop, Camera Web -->
                                    <div class="border-2 flex flex-col justify-between h-full p-4">
                                        <form id="dropContainer" action="/doinsertphoto" method="POST" enctype="multipart/form-data"> 
                                            <div class="mb-5 flex items-center justify-center">
                                                <a><img src="../img/logo.png" alt="Orlify" class="h-10"></a>
                                            </div>
                                            <div class="mb-5 flex items-center justify-center">
                                                <label namespace for="file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                    </svg>
                                                        <p id="fileNames" class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click per afegir una foto</span> o arrossega</p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or JPEG (MAX. 800x400px)</p>
                                                    </div>
                                                    <input id="file" type="file" name="file" accept=".png, .jpg, .jpeg" class="hidden" required/>
                                                </label>
                                            </div>
                                            <input id="id-edit" name="id-edit" class="hidden"/>
                                            <div class="flex flex-col items-center">
                                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-24 mb-1">Puja foto</button>
                                            </div>
                                        </form>
                                            
                                        <div class="flex flex-col items-center">
                                            <p class="text-gray-500 dark:text-gray-400 mb-1">o</p>
                                            <form action="/camera" method="POST" enctype="multipart/form-data"> 
                                                <input id="id-edit2" name="id-edit" class="hidden">
                                                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-25">Afegir foto per càmera web</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="new-pagina-grups" class="pagina">
                <h2>Contenido de Grupos</h2>
                <p>Esta es la información de la página "Grupos".</p>
            </div>

            <div id="new-pagina-orles" class="pagina">
                <h2>Contenido de Orles</h2>
                <p>Esta es la información de la página "Orles".</p>
            </div>

        </div>
    </div>

    <?php require "Scripts.php" ?>

</body>
</html>

        



