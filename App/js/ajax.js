import $ from "jquery";

// Función para abrir el modal de edición
function editUserModal() {
    $(document).off("click", ".editUserModal").on("click", ".editUserModal", function (event) {
        event.preventDefault();
        var $this = $(this);
        var userId = $this.data("edit-user-id");

        $.ajax({
            url: '/updateuserajax',
            method: 'POST',
            data: { userId: userId },
            dataType: "json",
            success: function (data) {
                var user = data['user'][0];
                var roles = data['roles'];

                $("#title").text(user.id);
                $("#id-edit").val(user.id);
                $("#name").val(user.name);
                $("#surname").val(user.surname);
                $("#password").val(user.password);
                $("#email").val(user.email);

                var roleSelect = $("#role");
                roleSelect.empty();

                roles.forEach(function (role) {
                    roleSelect.append($('<option>', { value: role.idRole, text: role.name, selected: (user.role == role.idRole) }));
                });

                // Mostrar el modal cambiando las clases de visibilidad
                $('#editUserModal').removeClass('hidden');
                $('body').addClass('overflow-hidden');
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX: ', error);
            }
        });
    });
}

// Función para abrir el modal de eliminación
function deleteUserModal() {
    $(document).off("click", ".deleteUserModal").on("click", ".deleteUserModal", function (event) {
        event.preventDefault();
        var $this = $(this);
        var userId = $this.data("delete-user-id");

        $.ajax({
            url: '/deleteuserajax',
            method: 'POST',
            data: { userId: userId },
            dataType: "json",
            success: function (data) {
                var user = data['user'][0];

                $("#id-delete").val(user.id);

                // Mostrar el modal cambiando las clases de visibilidad
                $('#deleteUserModal').removeClass('hidden');
                $('body').addClass('overflow-hidden');
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX: ', error);
            }
        });
    });
}


function searchUser() {
    $(document).ready(function () {
        var $searchInput = $('#table-search-users');
        var lastSearchQuery = ''; // Variable para almacenar la última búsqueda

        $searchInput.on('input', function () {
            var searchQuery = $searchInput.val();

            console.log(searchQuery);

            if (searchQuery.length >= 3 || searchQuery === '') {
                // Verificar si el texto de búsqueda ha cambiado
                if (searchQuery !== lastSearchQuery) {
                    lastSearchQuery = searchQuery; // Actualizar la última búsqueda

                    $.ajax({
                        url: '/searchuserajax',
                        method: 'POST',
                        data: { query: searchQuery },
                        dataType: "json",
                        success: function (data) {
                            console.log(data);

                            var users = data['users'];
                            var currentPage = data['currentPage'];
                            var totalPages = data['totalPages'];

                            console.log(currentPage);
                            console.log(totalPages);

                            // Limpiar el contenido actual antes de agregar nuevos resultados
                            var $paginaUsers = $('#pagina-users');
                            $paginaUsers.html('');

                            var usersContainer = $('<div class="flex flex-wrap justify-center"></div>');


                            // Iterar sobre los usuarios y agregarlos al contenedor
                            users.forEach(function (user) {
                                var userHtml = `
                                        <div class="w-full max-w-xs sm:w-full md:w-1/2 lg:w-1/3 xl:w-1/3 m-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                                            <!-- User Status Indicator -->
                                            <div class="flex justify-end px-4 pt-4">
                                                ${user.role === null ? `
                                                    <div class="py-4">
                                                        <div class="flex items-center">
                                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                                        </div>
                                                    </div>` :
                                                    `<div class="py-4">
                                                        <div class="flex items-center">
                                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                                        </div>
                                                    </div>`
                                                }
                                            </div>
                                            <div class="flex flex-col items-center pb-10">
                                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="../img/logo.png" alt="${user.name} ${user.surname} image"/>
                                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">${user.name} ${user.surname}</h5>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">${user.email}</span>
                                                <div class="flex mt-4 md:mt-6">
                                                    <!-- Edit and Delete Buttons -->
                                                    <a href="#" type="button" data-edit-user-id="${user.id}" data-modal-target="editUserModal" data-modal-show="editUserModal" class="editUserModal inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Editar</a>
    
                                                    <a href="#" type="button" data-delete-user-id="${user.id}" data-modal-target="deleteUserModal" data-modal-show="deleteUserModal" class="deleteUserModal inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-red-600 border border-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-700 dark:border-red-700 dark:hover:bg-red-800 dark:focus:ring-red-800 ms-3">Eliminar</a>
                                                </div>
                                            </div>
                                        </div>
                                `;
    
                                usersContainer.append(userHtml);

                            });
                            $paginaUsers.append(usersContainer);


                            var paginationHtml = `
                            <div class="flex items-center justify-center mt-4">
                                <nav aria-label="Page navigation example">
                                    <ul class="flex items-center -space-x-px h-8 text-sm">
                                        <li>
                                            ${
                                                currentPage > 1 ? 
                                                `<a href="#" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                    <span class="sr-only">Previous</span>
                                                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                                    </svg>
                                                </a>` : ''
                                            }
                                        </li>
                                        ${
                                            Array.from({ length: totalPages }, (_, i) => {
                                                const pageNumber = i + 1;
                                                return `
                                                    <li>
                                                        <a href="?page=${pageNumber}" class="${pageNumber === currentPage ? 'z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white' : 'flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'}">
                                                            ${pageNumber}
                                                        </a>
                                                    </li>
                                                `;
                                            }).join('')
                                        }
                                        <li>
                                            ${
                                                currentPage < totalPages ? 
                                                `<a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                                    <span class="sr-only">Next</span>
                                                    <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                                    </svg>
                                                </a>` : ''
                                            }
                                        </li>
                                    </ul>
                                </nav>
                            </div>`;

                            $paginaUsers.append(paginationHtml);


    
                            
                        },
                        error: function (error) {
                            console.error('Error en la solicitud AJAX: ', error);
                        }
                    });
                }
            }
        });
    });
}


export { searchUser };
export { deleteUserModal };
export { editUserModal };
