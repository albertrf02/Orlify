import $ from "jquery";

// Importa SweetAlert
import Swal from 'sweetalert2';

function generateUser() {
    $(document).off("click", ".generateUser").on("click", ".generateUser", function (event) {
        $.ajax({
            url: 'https://randomuser.me/api/',
            dataType: 'json',
            success: function (data) {

                const getRandomRole = () => Math.floor(Math.random() * 4) + 1;
                const simplifiedUser = {
                    name: data.results[0].name.first,
                    surname: data.results[0].name.last,
                    username: data.results[0].login.username,
                    password: 'testing10',
                    email: data.results[0].email,
                    role: getRandomRole()
                };

                console.log(simplifiedUser);

                $.ajax({
                    url: '/insertgeneratdeuser',
                    method: 'POST',
                    data: JSON.stringify(simplifiedUser), 
                    contentType: 'application/json',
                    dataType: "json",
                    success: function (data) {

                        console.log(data);

                        var user = data['user'];
                        var roles = data['roles'];

                        function getRoleName(roleId) {
                            return roles[roleId]['name'];
                        }


                        if (user) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Usuari generat correctament',
                                html: `Nom: ${user.name}<br>Cognoms: ${user.surname}<br>Nom d'usuari: ${user.username}<br>Email: ${user.email}<br>Rol: ${getRoleName(user.role)}`,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/admin';
                            });
                        } else {
                            // Manejo de errores si no se reciben datos válidos
                            console.error('Error en los datos recibidos');
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al procesar la respuesta del servidor',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function (error) {
                        console.error("Error en la solicitud AJAX: ", error);
                    },
                });
            }
        });
    });
}


function editUserClass() {
    // Asegúrate de tener una referencia al contenedor de usuarios
    var usersContainer = $("#users-container-class");

    $(document).off("click", ".editUsersClass").on("click", ".editUsersClass", function (event) {
        event.preventDefault();
        var $this = $(this);
        var userClassId = $this.data("edit-class-users-id");


        $.ajax({
            url: '/viewuserclass',
            method: 'POST',
            data: { userClassId: userClassId },
            dataType: "json",
            success: function (data) {
                console.log(data);

                var users = data['usersClass'];


                // Limpiar el contenedor antes de agregar nuevos elementos
                usersContainer.empty();

                users.forEach(function (user) {
                    var userHtml = `
                    <div class="flex flex-wrap items-center mb-4">
                    <input id="user-${user.id}" type="checkbox" name="selectedUsersClass[]" value="${user.id}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="user-${user.id}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">${user.name} ${user.surname}</label>
                    <input type="hidden" name="userClassId" value="${userClassId}">
                </div>
                    `;

                    // Agregar el HTML del usuario al contenedor
                    usersContainer.append(userHtml);
                });
            },
            error: function (error) {
                console.error("Error en la solicitud AJAX: ", error);
            },
        });
    });
}


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

          $("#title").text(user.name + " " + user.surname);

          $("#id-edit").val(user.id);
          $("#name-edit").val("");
          $("#surname-edit").val("");
          $("#password-edit").val("");
          $("#email-edit").val(user.email);

          var roleSelect = $("#role-edit");
          roleSelect.empty();

          roles.forEach(function (role) {
            roleSelect.append(
              $("<option>", {
                value: role.idRole,
                text: role.name,
                selected: user.role == role.idRole,
              })
            );
          });

          // Mostrar el modal cambiando las clases de visibilidad
          $("#editUserModal").removeClass("hidden");
          $("body").addClass("overflow-hidden");
        },
        error: function (error) {
          console.error("Error en la solicitud AJAX: ", error);
        },
      });
    });
}

// Función para abrir el modal de eliminación
function deleteUserModal() {
  $(document)
    .off("click", ".deleteUserModal")
    .on("click", ".deleteUserModal", function (event) {
      event.preventDefault();
      var $this = $(this);
      var userId = $this.data("delete-user-id");

      $.ajax({
        url: "/deleteuserajax",
        method: "POST",
        data: { userId: userId },
        dataType: "json",
        success: function (data) {
          var user = data["user"][0];

          $("#id-delete").val(user.id);

          // Mostrar el modal cambiando las clases de visibilidad
          $("#deleteUserModal").removeClass("hidden");
          $("body").addClass("overflow-hidden");
        },
        error: function (error) {
          console.error("Error en la solicitud AJAX: ", error);
        },
      });
    });
}

function deleteClassModal() {
    $(document)
    .off("click", ".deleteClassModal")
    .on("click", ".deleteClassModal", function (event) {
        event.preventDefault();
        var $this = $(this);
        var classId = $this.data("delete-class-id");

        console.log(classId);

        $.ajax({
        url: "/editclassajax",
        method: "POST",
        data: { classId: classId },
        dataType: "json",
        success: function (data) {

            console.log(data);

            var classroom = data["class"][0];

            
            $("#id-delete-class").val(classroom.id);




        },
        error: function (error) {
            console.error("Error en la solicitud AJAX: ", error);
        },
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
                            var $paginaUsers = $('#pagina-users-edit');
                            $paginaUsers.html('');

                            var usersContainer = $('<div class="flex flex-wrap justify-center"></div>');


                            // Iterar sobre los usuarios y agregarlos al contenedor
                            users.forEach(function (user) {
                                var userHtml = `
                                <div class="w-full max-w-xs sm:w-full md:w-1/2 lg:w-1/3 xl:w-1/4 m-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                            <div class="flex justify-end px-4 pt-4">
                            ${user.role === null ? `
                                    <div class="py-4">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                                        </div>
                                    </div> ` :
                                    `<div class="py-4">
                                        <div class="flex items-center">
                                            <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                                        </div>
                                    </div>`
                                }
                            </div>
                            <div class="flex flex-col items-center pb-10">
                                <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="<?= '../avatars/${user.avatar}" alt="${user.name}"/>
                                <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">${user.name} ${user.surname}</h5>
                                <span class="text-sm text-gray-500 dark:text-gray-400">${user.email}</span>
                                <div class="flex mt-4 md:mt-6">
                                    <div class="mr-4">
                                        <button data-edit-user-id="${user.id}" data-modal-target="editUserModal" data-modal-show="editUserModal" class="editUserModal block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z"/>
                                                <path d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div>
                                        <button data-delete-user-id="${user.id}" data-modal-target="deleteUserModal" data-modal-show="deleteUserModal" class="deleteUserModal block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" type="button">
                                            <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                                            </svg>
                                        </button>
                                    </div>
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


function searchUserClass() {
    $(document).ready(function () {
        var $searchInput = $('#table-search-class-user');
        var lastSearchQuery = '';
        var $usersContainer = $('#users-container');
        var $submitButton = $('#submit-button');

        // Inicializar array para almacenar IDs de usuarios seleccionados
        var selectedUserIds = [];
        
        $usersContainer.off('change', 'input[type="checkbox"]');

        // Manejar cambios en los checkboxes
        $usersContainer.on('change', 'input[type="checkbox"]', function () {
            var userId = $(this).val();
            if ($(this).is(':checked')) {
                selectedUserIds.push(userId);
            } else {
                selectedUserIds = selectedUserIds.filter(id => id !== userId);
            }
        });

        $searchInput.on('input', function () {
            var searchQuery = $searchInput.val();

            console.log(searchQuery);

            if (searchQuery.length >= 3 || searchQuery === '') {

                if (searchQuery !== lastSearchQuery) {
                    lastSearchQuery = searchQuery;

                    $.ajax({
                        url: '/searchuserclassajax',
                        method: 'POST',
                        data: { query: searchQuery },
                        dataType: "json",
                        success: function (data) {
                            console.log(data);

                            var users = data['users'];
                            var roles = data['roles'];

                            // Crear la sección de selección de usuarios
                            var usersSectionHtml = '';

                            function getRoleName(roleId) {
                                return roles[roleId]['name'];
                            }

                            users.forEach(function (user) {
                                var isChecked = selectedUserIds.includes(user.id);
                                var userHtml = `
                                    <div class="flex items-center mb-4">
                                        <input id="default-checkbox-${user.id}" type="checkbox" name="user_ids[]" value="${user.id}" ${isChecked ? 'checked' : ''} class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-checkbox-${user.id}" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            ${user.name}  - <span class="role-name">${getRoleName(user.role)}</span>
                                        </label>
                                    </div>
                                `;

                                usersSectionHtml += userHtml;
                            });

                            // Actualizar el contenido del contenedor de usuarios
                            $usersContainer.html(usersSectionHtml);

                            $usersContainer.off('change', 'input[type="checkbox"]');

                            // Manejar cambios en los checkboxes
                            $usersContainer.on('change', 'input[type="checkbox"]', function () {
                                var userId = $(this).val();
                                if ($(this).is(':checked')) {
                                    selectedUserIds.push(userId);
                                } else {
                                    selectedUserIds = selectedUserIds.filter(id => id !== userId);
                                }
                            });

                            // Actualizar el estado de los checkboxes existentes
                            $('input[type="checkbox"]').each(function () {
                                var userId = $(this).val();
                                var isChecked = selectedUserIds.includes(userId);
                                $(this).prop('checked', isChecked);
                            });

                            // Eliminar eventos de cambio anteriores para evitar duplicados
                            $submitButton.off('click');

                            // Manejar clic en el botón
                            $submitButton.on('click', function (e) {
                                e.preventDefault();
                                if (selectedUserIds.length > 0) {
                                    // Solo permitir enviar el formulario si hay usuarios seleccionados
                                    console.log("Formulario enviado con usuarios seleccionados: ", selectedUserIds);
                                    // Agregar aquí la lógica para enviar el formulario si es necesario
                                } else {
                                    console.log("No hay usuarios seleccionados. No se enviará el formulario.");
                                }
                            });
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


export { searchUser, searchUserClass };
export { deleteUserModal };
export { editUserModal };
export { editUserClass };
export { deleteClassModal };
export { generateUser };