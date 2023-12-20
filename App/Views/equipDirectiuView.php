<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "Head.php" ?>
    <title>Panell d'equip directiu</title>
</head>
<body class="bg-background">
    <?php require "MenuAdmin.php" ?>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="#" id="classesEd"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                            <path d="M14.5 0A3.987 3.987 0 0 0 11 2.1a4.977 4.977 0 0 1 3.9 5.858A3.989 3.989 0 0 0 14.5 0ZM9 13h2a4 4 0 0 1 4 4v2H5v-2a4 4 0 0 1 4-4Z"/>
                            <path d="M5 19h10v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2ZM5 7a5.008 5.008 0 0 1 4-4.9 3.988 3.988 0 1 0-3.9 5.859A4.974 4.974 0 0 1 5 7Zm5 3a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5-1h-.424a5.016 5.016 0 0 1-1.942 2.232A6.007 6.007 0 0 1 17 17h2a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5ZM5.424 9H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h2a6.007 6.007 0 0 1 4.366-5.768A5.016 5.016 0 0 1 5.424 9Z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Classes</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="orlesEd"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Crear Orla</span>
                    </a>
                </li>
                <li>
                    <a href="#" id="reportsEd"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 21">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Reports</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>


    <div class="p-4 sm:ml-64">
        <div class="p-4 border-2 border-gray-200 rounded-lg dark:border-gray-700 mt-14 bg-white">
            


            <div id="pagina-classesEd" class="paginaEd">
                <div>
                    <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Classes assignades</h5>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                                <?php foreach ($classes as $class) : ?>
                                    <?php if ($class["state"] == 1) : ?>
                                        <li class="py-3 sm:py-4 flex items-center justify-between">
                                            <div class="flex items-center">
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    <?= $class["className"]; ?>
                                                </p>
                                            </div>
                                            <div class="inline-flex items-center">
                                                <a href="#" data-modal-target="datatableModal" data-modal-toggle="datatableModal" data-class-id="<?= $class['id']; ?>" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
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

            <div id="pagina-orlesEd" class="paginaEd">

                <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal"
                    class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-4"
                    type="button">
                    Crear Orla
                </button>

                <!-- Main modal -->
                <div id="authentication-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Nova Orla
                                </h3>
                                <button type="button"
                                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="authentication-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5">
                                <form class="space-y-4" method="POST" action="/equipDirectiu?action=createOrla">
                                    <div>
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom de
                                            l'orla</label>
                                        <input type="text" name="name" id="name"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="Nom" required>
                                    </div>
                                    <label for="group" class="block text-sm font-medium text-gray-700">Select a
                                        Group:</label>
                                    <div class="relative mt-1">
                                        <select id="group" name="group"
                                            class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline-blue focus:border-blue-300">
                                            <?php foreach ($groups as $group): ?>
                                                <option value="<?= $group['id']; ?>">
                                                    <?= $group['className']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <button type="submit"
                                        class="w-full flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Crear Orla
                                        <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- començament orla -->
                <div class="flex flex-wrap gap-4">
                    <?php foreach ($orles as $orla): ?>
                        <div
                            class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <?php
                            $classNameData = $classNames[$orla['id']];
                            $className = ($classNameData[0]['className']);
                            echo "<p class='mb-3 font-normal text-gray-700 dark:text-gray-400'>{$className}</p>";
                            ?>
                            <img src="/img/imatge_orles.png" alt="imatge_orles" width="100px" class="mx-auto">
                            <div class="flex items-center mb-2">
                                <div class="ml-auto">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="<?= $orla['id']; ?>" class="sr-only peer"
                                            onchange="toggleOrlaPublic(this)" <?= $orla['public'] == 1 ? 'checked' : ''; ?>>
                                        <div
                                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="flex items-end">
                                <p class="text-lg font-medium text-gray-900 dark:text-white">
                                    <?= $orla['name']; ?>
                                </p>
                                <div class="ml-16">
                                    <a href="/orla/edit?idOrla=<?= $orla['id'] ?>"
                                        class="edit-button text-white bg-gray-400 hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-700 font-medium rounded-lg text-sm inline-flex items-end px-5 py-2 text-center">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 21 21">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M7.418 17.861 1 20l2.139-6.418m4.279 4.279 10.7-10.7a3.027 3.027 0 0 0-2.14-5.165c-.802 0-1.571.319-2.139.886l-10.7 10.7m4.279 4.279-4.279-4.279m2.139 2.14 7.844-7.844m-1.426-2.853 4.279 4.279" />
                                        </svg>
                                    </a>
                                    <button data-modal-target="delete-modal-<?= $orla['id']; ?>"
                                        data-modal-toggle="delete-modal-<?= $orla['id']; ?>"
                                        class="delete-button text-white bg-gray-400 hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-end px-5 py-2 text-center">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                                            <path
                                                d="M17 4h-4V2a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v2H1a1 1 0 0 0 0 2h1v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1a1 1 0 1 0 0-2ZM7 2h4v2H7V2Zm1 14a1 1 0 1 1-2 0V8a1 1 0 0 1 2 0v8Zm4 0a1 1 0 0 1-2 0V8a1 1 0 0 1 2 0v8Z" />
                                        </svg>
                                    </button>

                                    <?php if ($orla['visibility'] == 0): ?>
                                        <a href="/equipDirectiu?action=activateOrla&idOrla=<?= $orla['id']; ?>"
                                            class="edit-button text-white bg-gray-400 hover:bg-blue-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-700 font-medium rounded-lg text-sm inline-flex items-end px-5 py-2 text-center">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 14">
                                                <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2">
                                                    <path d="M10 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                                    <path d="M10 13c4.97 0 9-2.686 9-6s-4.03-6-9-6-9 2.686-9 6 4.03 6 9 6Z" />
                                                </g>
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <a href="/equipDirectiu?action=deactivateOrla&idOrla=<?= $orla['id']; ?>"
                                            class="delete-button text-white bg-gray-400 hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-end px-5 py-2 text-center">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                                                <path
                                                    d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                                            </svg>
                                        </a>
                                    <?php endif ?>
                                    <div id="delete-modal-<?= $orla['id']; ?>" tabindex="-1"
                                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                        <div class="absolute inset-0 bg-black opacity-50"></div>

                                        <div class="relative p-4 w-full max-w-md max-h-full">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                <button type="button"
                                                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="delete-modal-<?= $orla['id']; ?>">
                                                    <svg class="w-3 h-3" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <div class="p-4 md:p-5 text-center">
                                                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 20 20">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                    </svg>
                                                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                                        Segur que vols borrar l'orla?</h3>
                                                    <div class="p-4 md:p-5 text-center">
                                                        <!-- Delete and cancel buttons -->
                                                        <div class="flex justify-center mt-2">
                                                            <a href="/equipDirectiu?action=deleteOrla&idOrla=<?= $orla['id']; ?>"
                                                                class="delete-button mr-2 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-3 text-center me-2">
                                                                Borrar
                                                            </a>
                                                            <button data-modal-hide="delete-modal-<?= $orla['id']; ?>"
                                                                type="button"
                                                                class="cancel-button text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                                Cancelar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="pagina-reportsEd" class="paginaEd hidden">
                <p class="text-lg font-medium text-gray-900 dark:text-white" style="margin-bottom: 15px">Imatges
                    Reportades</p>
                <div class="flex flex-wrap gap-4">
                    <?php foreach ($reportedImages as $image): ?>
                        <div
                            class="w-full max-w-md bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex flex-col justify-between p-4">
                                <p class="text-center text-lg font-semibold text-gray-800 dark:text-gray-200">
                                    <span class="text-red-600">
                                        <?php echo $image['user_name']; ?>
                                    </span>
                                    ha reportat aquesta imatge
                                </p>

                                <div class="flex items-center justify-center mt-4">
                                    <img src="<?php echo $image['photography_link']; ?>" alt="Reported Image"
                                        class="object-cover w-32 h-32 rounded-lg">
                                </div>

                                <div class="flex justify-center mt-4">
                                    <div class="mr-4">
                                        <button data-modal-target="delete-report-modal-<?php echo $image['report_id']; ?>"
                                            data-modal-toggle="delete-report-modal-<?php echo $image['report_id']; ?>"
                                            class="report-button text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2 text-center">
                                            Eliminar Report
                                        </button>
                                    </div>
                                    <div>
                                        <button data-modal-target="delete-image-modal-<?php echo $image['report_id']; ?>"
                                            data-modal-toggle="delete-image-modal-<?php echo $image['report_id']; ?>"
                                            class="report-button text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2 text-center">
                                            Eliminar Imatge
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Report -->
                        <div id="delete-report-modal-<?php echo $image['report_id']; ?>" tabindex="-1"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button"
                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="delete-report-modal-<?php echo $image['report_id']; ?>">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-4 md:p-5 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                            Segur que vols eliminar el report?</h3>
                                        <a href="/equipDirectiu?action=deleteReport&report_id=<?php echo $image['report_id']; ?>"
                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                            Si, estic segur
                                        </a>
                                        <button data-modal-hide="delete-report-modal-<?php echo $image['report_id']; ?>"
                                            type="button"
                                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            No, cancela
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Imatge -->
                        <div id="delete-image-modal-<?php echo $image['report_id']; ?>" tabindex="-1"
                            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <button type="button"
                                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="delete-image-modal-<?php echo $image['report_id']; ?>">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <div class="p-4 md:p-5 text-center">
                                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                            Segur que vols eliminar la imatge? també s'eliminarà el report</h3>
                                        <a href="/equipDirectiu?action=deleteReportedImage&report_id=<?php echo $image['report_id']; ?>"
                                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                            Si, estic segur
                                        </a>
                                        <button data-modal-hide="delete-image-modal-<?php echo $image['report_id']; ?>"
                                            type="button"
                                            class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            No, cancela
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
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