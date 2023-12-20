import $ from "jquery";
import Swal from "sweetalert2";

/**
 * Genera un usuari aleatori mitjançant l'API randomuser.me i l'insereix a la base de dades.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function generateUser() {
  $(document)
    .off("click", ".generateUser")
    .on("click", ".generateUser", function (event) {
      // Realitza una sol·licitud AJAX per obtenir un usuari aleatori de randomuser.me
      $.ajax({
        url: "https://randomuser.me/api/",
        dataType: "json",
        success: function (data) {
          // Funció per obtenir un rol aleatori (assumisc que els rols van de 1 a 4)
          const getRandomRole = () => Math.floor(Math.random() * 4) + 1;
          
          // Simplifica l'estructura de l'usuari obtingut
          const simplifiedUser = {
            name: data.results[0].name.first,
            surname: data.results[0].name.last,
            username: data.results[0].login.username,
            password: "testing10",
            email: data.results[0].email,
            role: getRandomRole(),
          };

          console.log(simplifiedUser);

          // Realitza una segona sol·licitud AJAX per inserir l'usuari generat a la base de dades
          $.ajax({
            url: "/insertgeneratdeuser", // Possiblement un error tipogràfic, hauria de ser "/insertgenerateduser"
            method: "POST",
            data: JSON.stringify(simplifiedUser),
            contentType: "application/json",
            dataType: "json",
            success: function (data) {
              console.log(data);

              var user = data["user"];
              var roles = data["roles"];

              // Funció per obtenir el nom d'un rol a partir del seu ID
              function getRoleName(roleId) {
                return roles[roleId]["name"];
              }

              // Gestionar la resposta del servidor després d'inserir l'usuari
              if (user) {
                // Mostra una notificació d'èxit utilitzant SweetAlert
                Swal.fire({
                  icon: "success",
                  title: "Usuari generat correctament",
                  html: `Nom: ${user.name}<br>Cognoms: ${
                    user.surname
                  }<br>Nom d'usuari: ${user.username}<br>Email: ${
                    user.email
                  }<br>Rol: ${getRoleName(user.role)}`,
                  confirmButtonText: "OK",
                }).then(() => {
                  window.location.href = "/admin";
                });
              } else {
                // Gestionar errors si no es reben dades vàlides
                console.error("Error en les dades rebudes");
                Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: "Error al processar la resposta del servidor",
                  confirmButtonText: "OK",
                });
              }
            },
            error: function (error) {
              console.error("Error en la sol·licitud AJAX: ", error);
            },
          });
        },
      });
    });
}

/**
 * Gestiona l'edició de la classe d'usuaris en resposta a un esdeveniment de clic.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function editUserClass() {
  // Assegura't de tenir una referència al contenidor d'usuaris
  var usersContainer = $("#users-container-class");

  $(document)
    .off("click", ".editUsersClass")
    .on("click", ".editUsersClass", function (event) {
      event.preventDefault();
      var $this = $(this);
      var userClassId = $this.data("edit-class-users-id");

      // Realitza una sol·licitud AJAX per obtenir les dades de la classe d'usuaris
      $.ajax({
        url: "/viewuserclass",
        method: "POST",
        data: { userClassId: userClassId },
        dataType: "json",
        success: function (data) {
          console.log(data);

          var users = data["usersClass"];

          // Netega el contenidor abans d'afegir nous elements
          usersContainer.empty();

          console.log("Número d'usuaris:", users);

          if (users === 0) {
            // Si no hi ha usuaris, mostra un missatge
            usersContainer.append(
              '<p class="text-gray-500">Aquesta classe no té alumnes</p>'
            );
          } else {
            users.forEach(function (user) {
              var userCardHtml = `
                    <div class="mb-4 flex items-center space-x-4">
                        <ul class="w-full">
                            <li class="flex items-center justify-between p-5 border border-gray-200 rounded-lg">
                                <input type="hidden" name="userClassId" value="${userClassId}">
                                <div class="flex-grow">
                                    <div class="text-lg font-semibold">${user.name} ${user.surname}</div>
                                    <div class="text-gray-500 dark:text-gray-400">${user.email}</div>
                                </div>
                                <div class="flex items-center">
                                    <input id="user-${user.id}" type="checkbox" name="selectedUsersClass[]" value="${user.id}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </div>
                            </li>
                        </ul>
                    </div>
              `;

              usersContainer.append(userCardHtml);
            });
          }
        },
        error: function (error) {
          console.error("Error en la sol·licitud AJAX: ", error);
        },
      });
    });
}

/**
 * Gestiona l'obertura del modal d'edició d'usuari en resposta a un esdeveniment de clic.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function editUserModal() {
  $(document)
    .off("click", ".editUserModal")
    .on("click", ".editUserModal", function (event) {
      event.preventDefault();
      var $this = $(this);
      var userId = $this.data("edit-user-id");

      // Realitza una sol·licitud AJAX per obtenir les dades de l'usuari a editar
      $.ajax({
        url: "/updateuserajax",
        method: "POST",
        data: { userId: userId },
        dataType: "json",
        success: function (data) {
          var user = data["user"];
          var roles = data["roles"];

          // Configura el títol del modal amb el nom complet de l'usuari
          $("#title").text(user.name + " " + user.surname);

          // Omple els camps del formulari amb les dades de l'usuari
          $("#id-edit").val(user.id);
          $("#name-edit").val("");
          $("#surname-edit").val("");
          $("#password-edit").val("");
          $("#email-edit").val(user.email);

          // Omple els camps del segon formulari amb les dades de l'usuari
          $("#title3").text(user.id);
          $("#id-edit3").val(user.id);
          $("#name-edit3").val(user.name);
          $("#surname-edit3").val(user.surname);
          $("#password-edit3").val(user.password);
          $("#email-edit3").val(user.email);
          $("#username3").val(user.username);

          // Configura la selecció del rol
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

          // Mostra el modal d'edició i bloqueja l'escorreguda del cos de la pàgina
          $("#editUserModal").removeClass("hidden");
          $("body").addClass("overflow-hidden");
        },
        error: function (error) {
          console.error("Error en la sol·licitud AJAX: ", error);
        },
      });
    });
}

/**
 * Gestiona l'obertura del modal de supressió d'usuari en resposta a un esdeveniment de clic.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function deleteUserModal() {
  $(document)
    .off("click", ".deleteUserModal")
    .on("click", ".deleteUserModal", function (event) {
      event.preventDefault();
      var $this = $(this);
      var userId = $this.data("delete-user-id");

      // Realitza una sol·licitud AJAX per obtenir les dades de l'usuari a eliminar
      $.ajax({
        url: "/deleteuserajax",
        method: "POST",
        data: { userId: userId },
        dataType: "json",
        success: function (data) {
          var user = data["user"];

          // Omple el camp d'identificador amb la informació de l'usuari
          $("#id-delete").val(user.id);

          // Mostrar el modal canviant les classes de visibilitat
          $("#deleteUserModal").removeClass("hidden");
          $("body").addClass("overflow-hidden");
        },
        error: function (error) {
          console.error("Error en la sol·licitud AJAX: ", error);
        },
      });
    });
}

/**
 * Gestiona l'obertura del modal de supressió de classe en resposta a un esdeveniment de clic.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function deleteClassModal() {
  $(document)
    .off("click", ".deleteClassModal")
    .on("click", ".deleteClassModal", function (event) {
      event.preventDefault();
      var $this = $(this);
      var classId = $this.data("delete-class-id");

      console.log(classId);

      // Realitza una sol·licitud AJAX per obtenir les dades de la classe a eliminar
      $.ajax({
        url: "/editclassajax",
        method: "POST",
        data: { classId: classId },
        dataType: "json",
        success: function (data) {
          console.log(data);

          var classroom = data["class"][0];

          // Omple el camp d'identificador amb la informació de la classe
          $("#id-delete-class").val(classroom.id);
        },
        error: function (error) {
          console.error("Error en la sol·licitud AJAX: ", error);
        },
      });
    });
}

/**
 * Gestiona la cerca d'usuaris en resposta a esdeveniments d'entrada d'usuari.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function searchUser() {
  $(document).ready(function () {
    var $searchInput = $("#table-search-users");
    var lastSearchQuery = "";

    $searchInput.on("input", function () {
      var searchQuery = $searchInput.val();

      console.log(searchQuery);

      if (searchQuery.length >= 3 || searchQuery === "") {
        // Verificar si el texto de búsqueda ha cambiado
        if (searchQuery !== lastSearchQuery) {
          lastSearchQuery = searchQuery; // Actualizar la última búsqueda

          // Realitza una sol·licitud AJAX per obtenir els usuaris que coincideixen amb la cerca
          $.ajax({
            url: "/searchuserajax",
            method: "POST",
            data: { query: searchQuery },
            dataType: "json",
            success: function (data) {
              console.log(data);

              var users = data["users"];
              var currentPage = data["currentPage"];
              var totalPages = data["totalPages"];

              console.log(currentPage);
              console.log(totalPages);

              // Netega el contingut actual abans d'afegir nous resultats
              var $paginaUsers = $("#pagina-users-edit");
              $paginaUsers.html("");

              var usersContainer = $(
                '<div class="flex flex-wrap justify-center"></div>'
              );

              // Itera sobre els usuaris i afegeix-los al contenidor
              users.forEach(function (user) {
                var userHtml = `
                  <div class="w-full max-w-xs sm:w-full md:w-1/2 lg:w-1/3 xl:w-1/4 m-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex justify-end px-4 pt-4">
                      ${
                        user.role === null
                          ? `
                            <div class="py-4">
                              <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                              </div>
                            </div>`
                          : `
                            <div class="py-4">
                              <div class="flex items-center">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                              </div>
                            </div>`
                      }
                    </div>
                    <div class="flex flex-col items-center pb-10">
                      <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="../avatars/${user.avatar}" alt="${user.name}" />
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
                          currentPage > 1
                            ? `<a href="#" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Anterior</span>
                                <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                </svg>
                              </a>`
                            : ""
                        }
                      </li>
                      ${Array.from(
                        { length: totalPages },
                        (_, i) => {
                          const pageNumber = i + 1;
                          return `
                            <li>
                              <a href="?page=${pageNumber}" class="${
                                pageNumber === currentPage
                                  ? "z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                                  : "flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                              }">
                                ${pageNumber}
                              </a>
                            </li>
                          `;
                        }
                      ).join("")}
                      <li>
                        ${
                          currentPage < totalPages
                            ? `<a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <span class="sr-only">Següent</span>
                                <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                              </a>`
                            : ""
                        }
                      </li>
                    </ul>
                  </nav>
                </div>`;

              $paginaUsers.append(paginationHtml);
            },
            error: function (error) {
              console.error("Error en la sol·licitud AJAX: ", error);
            },
          });
        }
      }
    });
  });
}

/**
 * Gestiona l'obertura del modal DataTables i la carrega de dades de la classe mitjançant una sol·licitud AJAX.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function DatatablesModal() {
  $(document)
    .off("click", "a[data-modal-target='datatableModal']")
    .on("click", "a[data-modal-target='datatableModal']", function (event) {
      event.preventDefault();
      var $this = $(this);
      var idClass = $this.data("class-id");

      // Realitza una sol·licitud AJAX per obtenir les dades de la classe
      $.ajax({
        url: "/getclassajax",
        method: "POST",
        data: { idClass: idClass },
        dataType: "json",
        success: function (data) {
          var users = data["users"];

          // Netega el modal
          var $modalBody = $(".p-4.md\\:p-5.space-y-4");
          $modalBody.empty();

          // Afegeix els títols al modal
          var titlesHTML = `
            <div class="overflow-x-auto">
              <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-center">Nom</th>
                    <th scope="col" class="px-6 py-3 text-center">Cognom</th>
                    <th scope="col" class="px-6 py-3 text-center">Correu electrònic</th>
                  </tr>
                </thead>
                <tbody>
              `;
          $modalBody.append(titlesHTML);

          // Recorre els usuaris i afegeix-los al modal
          users.forEach(function (currentUser) {
            var userHTML = `
              <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 text-center">${currentUser.name}</td>
                <td class="px-6 py-4 text-center">${currentUser.surname}</td>
                <td class="px-6 py-4 text-center">${currentUser.email}</td>
              </tr>`;
            $modalBody.find("tbody").append(userHTML);
          });

          // Tanca la taula
          var closingHTML = `</tbody></table></div>`;
          $modalBody.append(closingHTML);

          console.log(data);
        },
        error: function (error) {
          console.error("Error en la sol·licitud AJAX: ", error);
        },
      });
    });
}

/**
 * Gestiona la cerca d'usuaris amb la funció de selecció per a la classe del professor.
 * Carrega els usuaris mitjançant una sol·licitud AJAX i permet seleccionar-los mitjançant
 * caselles de selecció. L'ús d'una funció per gestionar els esdeveniments evita
 * duplicats i proporciona una millor experiència d'usuari.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function searchTeacherClass() {
  $(document).ready(function () {
    var $searchInput = $("#table-search-class-teacher");
    var lastSearchQuery = "";
    var $usersContainer = $(".users-container-teacher");
    var $submitButton = $("#submit-button");

    // Inicialitzar array per emmagatzemar IDs d'usuaris seleccionats
    var selectedUserIds = [];

    $usersContainer.off("change", 'input[type="checkbox"]');

    // Gestionar canvis en les caselles de selecció
    $usersContainer.on("change", 'input[type="checkbox"]', function () {
      var userId = $(this).val();
      if ($(this).is(":checked")) {
        selectedUserIds.push(userId);
      } else {
        selectedUserIds = selectedUserIds.filter((id) => id !== userId);
      }
    });

    $searchInput.on("input", function () {
      var searchQuery = $searchInput.val();

      console.log(searchQuery);

      if (searchQuery.length >= 3 || searchQuery === "") {
        if (searchQuery !== lastSearchQuery) {
          lastSearchQuery = searchQuery;

          // Sol·licitud AJAX per obtenir els usuaris
          $.ajax({
            url: "/searchteacherclassajax",
            method: "POST",
            data: { query: searchQuery },
            dataType: "json",
            success: function (data) {
              console.log(data);

              var users = data["users"];
              var roles = data["roles"];

              // Crear la secció de selecció d'usuaris
              var usersSectionHtml = "";

              function getRoleName(roleId) {
                return roles[roleId]["name"];
              }

              users.forEach(function (user) {
                var isChecked = selectedUserIds.includes(user.id);
                var userHtml = `
                  <div class="mb-4 flex items-center space-x-4">
                    <ul class="w-full">
                      <li class="flex items-center justify-between p-5 border border-gray-200 rounded-lg">
                        <div class="flex-grow">
                          <div class="text-lg font-semibold">${user.name} ${user.surname}</div>
                          <div class="text-gray-500 dark:text-gray-400">${user.email}</div>
                        </div>
                        <div class="flex items-center">
                          <input id="default-checkbox-${user.id}" type="checkbox" name="selectedUsers[]" value="${user.id}" ${
                  isChecked ? "checked" : ""
                } class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                      </li>
                    </ul>
                  </div>
                `;

                usersSectionHtml += userHtml;
              });

              // Actualitzar el contingut del contenidor d'usuaris
              $usersContainer.html(usersSectionHtml);

              $usersContainer.off("change", 'input[type="checkbox"]');

              // Gestionar canvis en les caselles de selecció
              $usersContainer.on("change", 'input[type="checkbox"]', function () {
                var userId = $(this).val();
                if ($(this).is(":checked")) {
                  selectedUserIds.push(userId);
                } else {
                  selectedUserIds = selectedUserIds.filter((id) => id !== userId);
                }
              });

              // Actualitzar l'estat de les caselles de selecció existents
              $('input[type="checkbox"]').each(function () {
                var userId = $(this).val();
                var isChecked = selectedUserIds.includes(userId);
                $(this).prop("checked", isChecked);
              });

              // Eliminar esdeveniments de canvi anteriors per evitar duplicats
              $submitButton.off("click");

              // Gestionar clic al botó
              $submitButton.on("click", function (e) {
                e.preventDefault();
                if (selectedUserIds.length > 0) {
                  // Només permetre enviar el formulari si hi ha usuaris seleccionats
                  console.log(
                    "Formulari enviat amb usuaris seleccionats: ",
                    selectedUserIds
                  );
                  // Afegir aquí la lògica per enviar el formulari si és necessari
                } else {
                  console.log(
                    "No hi ha usuaris seleccionats. No s'enviarà el formulari."
                  );
                }
              });
            },
            error: function (error) {
              console.error("Error en la sol·licitud AJAX: ", error);
            },
          });
        }
      }
    });
  });
}

/**
 * Gestiona la cerca d'estudiants amb la funció de selecció per a una classe.
 * Carrega els estudiants mitjançant una sol·licitud AJAX i permet seleccionar-los mitjançant
 * caselles de selecció. L'ús d'una funció per gestionar esdeveniments evita
 * duplicats i proporciona una millor experiència d'usuari.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function searchStudentClass() {
  $(document).ready(function () {
    var $searchInput = $("#table-search-class-student");
    var lastSearchQuery = "";
    var $usersContainer = $(".users-container-student");
    var $submitButton = $("#submit-button");

    // Inicialitzar array per emmagatzemar IDs d'estudiants seleccionats
    var selectedUserIds = [];

    $usersContainer.off("change", 'input[type="checkbox"]');

    // Gestionar canvis en les caselles de selecció
    $usersContainer.on("change", 'input[type="checkbox"]', function () {
      var userId = $(this).val();
      if ($(this).is(":checked")) {
        selectedUserIds.push(userId);
      } else {
        selectedUserIds = selectedUserIds.filter((id) => id !== userId);
      }
    });

    $searchInput.on("input", function () {
      var searchQuery = $searchInput.val();

      console.log(searchQuery);

      if (searchQuery.length >= 3 || searchQuery === "") {
        if (searchQuery !== lastSearchQuery) {
          lastSearchQuery = searchQuery;

          // Sol·licitud AJAX per obtenir els estudiants
          $.ajax({
            url: "/searchstudentclassajax",
            method: "POST",
            data: { query: searchQuery },
            dataType: "json",
            success: function (data) {
              console.log(data);

              var users = data["users"];
              var roles = data["roles"];

              // Crear la secció de selecció d'usuaris
              var usersSectionHtml = "";

              function getRoleName(roleId) {
                return roles[roleId]["name"];
              }

              users.forEach(function (user) {
                var isChecked = selectedUserIds.includes(user.id);
                var userHtml = `
                  <div class="mb-4 flex items-center space-x-4">
                    <ul class="w-full">
                      <li class="flex items-center justify-between p-5 border border-gray-200 rounded-lg">
                        <div class="flex-grow">
                          <div class="text-lg font-semibold">${user.name} ${user.surname}</div>
                          <div class="text-gray-500 dark:text-gray-400">${user.email}</div>
                        </div>
                        <div class="flex items-center">
                          <input id="default-checkbox-${user.id}" type="checkbox" name="selectedUsers[]" value="${user.id}" ${
                  isChecked ? "checked" : ""
                } class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                      </li>
                    </ul>
                  </div>
                `;

                usersSectionHtml += userHtml;
              });

              // Actualitzar el contingut del contenidor d'usuaris
              $usersContainer.html(usersSectionHtml);

              $usersContainer.off("change", 'input[type="checkbox"]');

              // Gestionar canvis en les caselles de selecció
              $usersContainer.on(
                "change",
                'input[type="checkbox"]',
                function () {
                  var userId = $(this).val();
                  if ($(this).is(":checked")) {
                    selectedUserIds.push(userId);
                  } else {
                    selectedUserIds = selectedUserIds.filter(
                      (id) => id !== userId
                    );
                  }
                }
              );

              // Actualitzar l'estat de les caselles de selecció existents
              $('input[type="checkbox"]').each(function () {
                var userId = $(this).val();
                var isChecked = selectedUserIds.includes(userId);
                $(this).prop("checked", isChecked);
              });

              // Eliminar esdeveniments de canvi anteriors per evitar duplicats
              $submitButton.off("click");

              // Gestionar clic al botó
              $submitButton.on("click", function (e) {
                e.preventDefault();
                if (selectedUserIds.length > 0) {
                  // Només permetre enviar el formulari si hi ha usuaris seleccionats
                  console.log(
                    "Formulari enviat amb usuaris seleccionats: ",
                    selectedUserIds
                  );
                  // Afegir aquí la lògica per enviar el formulari si és necessari
                } else {
                  console.log(
                    "No hi ha usuaris seleccionats. No s'enviarà el formulari."
                  );
                }
              });
            },
            error: function (error) {
              console.error("Error en la sol·licitud AJAX: ", error);
            },
          });
        }
      }
    });
  });
}

/**
 * Realitza una cerca d'usuaris (probablement professors) mitjançant l'entrada de l'usuari.
 * Utilitza AJAX per carregar resultats de cerca de manera dinàmica.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function searchUserTeacher() {
  $(document).ready(function () {
    var $searchInput = $("#new-table-search-users");
    var lastSearchQuery = ""; // Variable per emmagatzemar l'última cerca

    $searchInput.on("input", function () {
      var searchQuery = $searchInput.val();

      console.log(searchQuery);

      if (searchQuery.length >= 3 || searchQuery === "") {
        // Verificar si el text de cerca ha canviat
        if (searchQuery !== lastSearchQuery) {
          lastSearchQuery = searchQuery; // Actualitzar l'última cerca

          // Realitzar sol·licitud AJAX per obtenir els resultats de la cerca
          $.ajax({
            url: "/searchuserajax",
            method: "POST",
            data: { query: searchQuery },
            dataType: "json",
            success: function (data) {
              console.log(data);

              var users = data["student"];
              var currentPage = data["currentPage"];
              var totalPages = data["totalPages"];

              console.log(currentPage);
              console.log(totalPages);

              // Netegar el contingut actual abans d'afegir nous resultats
              var $paginaUsers = $("#new-pagina-users");

              $paginaUsers.html("");

              var usersContainer = $(
                '<div class="flex flex-wrap justify-center"></div>'
              );

              // Iterar sobre els usuaris i afegir-los al contenidor
              users.forEach(function (user) {
                console.log({ user });

                var userHtml = `
                  <div class="w-full max-w-xs sm:w-full md:w-1/2 lg:w-1/4 xl:w-1/4 m-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <!-- Indicador d'estat de l'usuari -->
                    <div class="flex justify-end px-4 pt-4">
                      ${
                        user.role === null
                          ? `
                          <div class="py-4">
                            <div class="flex items-center">
                              <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                            </div>
                          </div>`
                          : `<div class="py-4">
                            <div class="flex items-center">
                              <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                            </div>
                          </div>`
                      }
                    </div>
                    <div class="flex flex-col items-center pb-10">
                      <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="${user.photoLink}" alt="${user.surname} image"/>
                      <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">${user.name} ${user.surname}</h5>
                      <span class="text-sm text-gray-500 dark:text-gray-400">${user.email}</span>

                      <div class="flex mt-4 md:mt-6">
                        <a href="#" type="button" data-edit-user-id="${user.id}" data-modal-target="editUserModal" data-modal-show="editUserModal" class="editUserModal inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Dades</a>
                      </div>
                    </div>
                  </div>
                `;
                console.log("id d'usuari " + user.id);
                usersContainer.append(userHtml);
              });
              $paginaUsers.append(usersContainer);

              // Crear HTML per a la paginació
              var paginationHtml = `
                <div class="flex items-center justify-center mt-4">
                  <nav aria-label="Page navigation example">
                    <ul class="flex items-center -space-x-px h-8 text-sm">
                      <li>
                        ${
                          currentPage > 1
                            ? `<a href="#" class="flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                              <span class="sr-only">Anterior</span>
                              <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                              </svg>
                            </a>`
                            : ""
                        }
                      </li>
                      ${Array.from(
                        { length: totalPages },
                        (_, i) => {
                          const pageNumber = i + 1;
                          return `
                            <li>
                              <a href="?page=${pageNumber}" class="${
                                pageNumber === currentPage
                                  ? "z-10 flex items-center justify-center px-4 h-10 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
                                  : "flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                              }">
                                ${pageNumber}
                              </a>
                            </li>
                          `;
                        }
                      ).join("")}
                      <li>
                        ${
                          currentPage < totalPages
                            ? `<a href="#" class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                              <span class="sr-only">Següent</span>
                              <svg class="w-3 h-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                              </svg>
                            </a>`
                            : ""
                        }
                      </li>
                    </ul>
                  </nav>
                </div>`;

              $paginaUsers.append(paginationHtml);
            },

            error: function (error) {
              console.error("Error en la sol·licitud AJAX: ", error);
            },
          });
        }
      }
    });
  });
}

export {
  searchUser,
  searchTeacherClass,
  searchStudentClass,
  deleteUserModal,
  editUserModal,
  editUserClass,
  deleteClassModal,
  generateUser,
  DatatablesModal,
  searchUserTeacher
};