import $ from "jquery";

function adminPages() {
  $(document).ready(function () {
      // Recuperar el estado actual desde sessionStorage
      var currentPage = sessionStorage.getItem('currentPage');

      // Si no hay estado almacenado, mostrar la página por defecto
      if (!currentPage) {
          currentPage = 'pagina-users-edit';
      }

      // Ocultar todas las páginas y el navegador de búsqueda de usuarios
      $(".pagina").hide();
      $("#search-users-edit").hide();
      $("#search-class-teacher").hide();
      $("#search-class-student").hide();


      // Mostrar la página actual y el navegador correspondiente
      $("#" + currentPage).show();
      if (currentPage === 'pagina-users-edit') {
          $("#search-users-edit").show();
      } else if (currentPage === 'pagina-classes-add') {
          $("#search-class-teacher").show();          
          $("#search-class-student").show();


      }

      // Manejar los clics en los enlaces
      $("#users-edit").click(function (e) {
          e.preventDefault();
          $(".pagina").hide();
          $("#pagina-users-edit").show();
          $("#search-users-edit").show();
          window.history.pushState(null, null, '/admin');
          // Almacenar el estado actual en sessionStorage
          sessionStorage.setItem('currentPage', 'pagina-users-edit');
      });

      $("#users-add").click(function (e) {
          e.preventDefault();
          $(".pagina").hide();
          $("#pagina-users-add").show();
          $("#search-users-edit").hide();
          window.history.pushState(null, null, '/admin');
          sessionStorage.setItem('currentPage', 'pagina-users-add');
      });

      $("#classes-edit").click(function (e) {
          e.preventDefault();
          $(".pagina").hide();
          $("#pagina-classes-edit").show();
          $("#search-class-teacher").hide(); // Ocultar el navegador de búsqueda de usuarios para clases
          $("#search-class-student").hide(); // Ocultar el navegador de búsqueda de usuarios para clases
          window.history.pushState(null, null, '/admin');
          sessionStorage.setItem('currentPage', 'pagina-classes-edit');
      });

      $("#classes-add").click(function (e) {
          e.preventDefault();
          $(".pagina").hide();
          $("#pagina-classes-add").show();
          $("#search-class-teacher").show();
          $("#search-class-student").show(); // Ocultar el navegador de búsqueda de usuarios para clases
          window.history.pushState(null, null, '/admin');
          sessionStorage.setItem('currentPage', 'pagina-classes-add');
      });
  });
}




function equipDirectiuPages() {
  $(document).ready(function () {
    $("#pagina-classesEd").hide();
    $("#pagina-orlesEd").show();
    $("#pagina-reportsEd").hide();
  });

  $(document).ready(function () {
    $("#classesEd").click(function (e) {
      console.log("classes");
      e.preventDefault();
      $(".paginaEd").hide();
      $("#pagina-classesEd").show();
    });
  });

  $(document).ready(function () {
    $("#orlesEd").click(function (e) {
      e.preventDefault();
      console.log("orles");
      $(".paginaEd").hide();
      $("#pagina-orlesEd").show();
      window.history.pushState(null, null, "/equipDirectiu");
    });
  });

  $(document).ready(function () {
    $("#reportsEd").click(function (e) {
      e.preventDefault();
      console.log("reports");
      $(".paginaEd").hide();
      $("#pagina-reportsEd").show();
      window.history.pushState(null, null, "/equipDirectiu");
    });

    $(".avatar-item").on("click", function (e) {
      const selectedAvatarValue = this.id;
      document.getElementById("selectedAvatar").value = selectedAvatarValue;
      var form = document.getElementById("avatarForm");
      form.submit();
    });
  });
}

function recoverPages() {
  $(document).ready(function () {
    $("#recover").click(function (e) {
      e.preventDefault();
      $("#pagina-recover").hide();
      $("#pagina-missatge").show();
    });
  });
}

function teacherPages() {
  $(document).ready(function () {
    // Ocultar las secciones de grupos y orlas al inicio
    $("#new-pagina-users").show();
    $("#new-pagina-grups").hide();
    $("#new-pagina-orles").hide();
    $("#search-users-edit").show();

    $("#new-users").click(function (e) {
      e.preventDefault();
      $("#new-pagina-users").show();
      $("#new-pagina-grups").hide();
      $("#new-pagina-orles").hide();
      $("#search-users-edit").show();
    });

    $("#new-grups").click(function (e) {
      e.preventDefault();
      $("#new-pagina-users").hide();
      $("#new-pagina-grups").show();
      $("#new-pagina-orles").hide();
      $("#search-users-edit").hide();
    });

    $("#new-classes").click(function (e) {
      e.preventDefault();
      $("#new-pagina-users").hide();
      $("#new-pagina-grups").hide();
      $("#new-pagina-orles").show();
      $("#search-users-edit").hide();
    });
  });
}


function perfilPages() {
  document.addEventListener("DOMContentLoaded", function () {
    const modalButtons = document.querySelectorAll("[data-modal-toggle]");
    modalButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const targetModal = document.getElementById(
          this.getAttribute("data-modal-target")
        );
        if (targetModal) {
          targetModal.classList.toggle("hidden");
        }
      });
    });

    const modalHideButtons = document.querySelectorAll("[data-modal-hide]");
    modalHideButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const targetModal = document.getElementById(
          this.getAttribute("data-modal-hide")
        );
        if (targetModal) {
          targetModal.classList.add("hidden");
        }
      });
    });
  });
}
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

export {
  adminPages,
  equipDirectiuPages,
  recoverPages,
  perfilPages,
  toggleFormVisibility,
  teacherPages,
  showTab,
};
