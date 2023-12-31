<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "Head.php" ?>
    <title>Professor</title>
</head>
<body class="bg-background">
    <?php require "MenuAdmin.php" ?>

    <aside id="new-logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" id="new-users" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                            <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
                        </svg>
                        <span class="ms-3">Alumnes</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="new-grups" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                            <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                            <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
                        </svg>
                        <span class="ms-3">Classes</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="new-classes" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                            <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                            <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Orles</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64 h-screen">
        <div id="clear" class="p-4 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">

            <div id="search-users-edit" class="pagina flex items-center justify-center">
                <div class="flex items-center justify-between bg-white dark:bg-gray-900 rounded-lg">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="new-table-search-users" class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cercar alumnes">
                    </div>
                </div>
            </div>

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
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="<?= $user['photoLink'] ?>" alt="Bonnie image" />
                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white"><?= $user['name'] . ' ' . $user['surname'] ?></h5>
                                <span class="text-sm text-gray-500 dark:text-gray-400"><?= $user['email'] ?></span>
                                <div class="flex mt-4 md:mt-6">
                                    <a href="#" type="button" data-edit-user-id="<?= $user['id']; ?>" data-modal-target="editUserModal" data-modal-show="editUserModal" class="editUserModal inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Dades personals</a>
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
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
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
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                    </a>
                                <?php endif ?>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            
            <div id="new-pagina-grups" class="pagina">
                <div>
                    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Visualitzar Classes</h5>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <?php foreach ($classes as $class) : ?>
                                    <?php if ($class["state"] == 1) : ?>
                                        <li class="py-3 sm:py-4 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    <?= $class["className"]; ?>
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center">
                                                <a href="#" data-modal-target="datatableModal" data-modal-toggle="datatableModal" data-class-id="<?= $class['idGroupClass']; ?>" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    Visualitzar alumnes
                                                </a>
                                            </div>
                                        </li>
                                    <?php else : ?>
                                        <h5 class="text-xl leading-none text-gray-900 dark:text-white">No tens cap classe asignada</h5>
                                    <?php endif; ?>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>                
            </div>

            <div id="new-pagina-orles" class="pagina">
                <div>
                    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white mb-5">Visualitzar orles</h5>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <div class="flex flex-wrap gap-4">
                                    <?php $orlesVisibles = false; ?>
                                    <?php foreach ($userOrla as $orla) : ?>
                                        <?php if ($orla['visibility'] == 1) : ?>
                                            <div class="w-full max-w-md bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-8 mx-auto">
                                                <img src="/img/imatge_orles.png" alt="imatge_orles" width="100px" class="mx-auto mt-4">
                                                <div class="p-4 flex flex-wrap justify-center">
                                                    <a href="/orla/iframe?idOrla=<?= $orla['id'] ?>" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                        Veure
                                                        <?= $orla['name'] ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php $orlesVisibles = true; ?>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                    <?php if (!$orlesVisibles) : ?>
                                        <div class="flex flex-col items-center p-2 rounded">
                                            <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">
                                                No tens cap orla visible
                                            </h5>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="editUserModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 flex items-center justify-center hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-screen-lg mx-auto max-h-screen-3/4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-2 border-b rounded-t dark:border-gray-600">
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
                                    <input type="text" name="name-edit3" id="name-edit3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" readonly>
                                </div>
                                <div class="mb-5">
                                    <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cognoms</label>
                                    <input type="text" name="surname-edit3" id="surname-edit3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" readonly>
                                </div>
                            </div>
                            <div class="mb-5 grid grid-cols-2 gap-4">
                                <div class="mb-5">
                                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom d'usuari</label>
                                    <input type="text" name="username3" id="username3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" readonly>
                                </div>
                                <div class="mb-5">
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                    <input type="email" name="email-edit3" id="email-edit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="border-2 flex flex-col justify-between h-full p-4">
                            <form id="dropContainer" action="/doinsertphoto" method="POST" enctype="multipart/form-data">
                                <div class="mb-5 flex items-center justify-center">
                                    <a><img src="../img/logo.png" alt="Orlify" class="h-10"></a>
                                </div>
                                <div class="mb-5 flex items-center justify-center">
                                    <label namespace for="file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                            </svg>
                                            <p id="fileNames" class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click per afegir una foto</span> o arrossega</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or JPEG (MAX. 800x400px)</p>
                                        </div>
                                        <input id="file" type="file" name="file" accept=".png, .jpg, .jpeg" class="hidden" required />
                                    </label>
                                </div>
                                <input id="id-edit" name="id-edit" class="hidden" />
                                <div class="flex flex-col items-center">
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-24 mb-1">Puja foto</button>
                                </div>
                            </form>
                            <div class="flex flex-col items-center">
                                <p class="text-gray-500 dark:text-gray-400 mb-1">o</p>
                                <form action="/camera" method="POST" enctype="multipart/form-data">
                                    <input id="id-edit3" name="id-edit" class="hidden">
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-1.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-25">Afegir foto per càmera web</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            
    <div id="datatableModal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full overflow-auto scrollbar scrollbar-thumb-blue-500 scrollbar-thin">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Llistat d'alumnes
                    </h4>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="datatableModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4 overflow-auto scrollbar scrollbar-thumb-blue-500 scrollbar-thin max-h-full"></div>
            </div>
        </div>
    </div>

    <?php require "Scripts.php" ?>
</body>
</html>