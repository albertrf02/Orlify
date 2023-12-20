import $ from "jquery";

/**
 * Funció que gestiona la navegació entre les pàgines de l'administrador.
 *
 * @return  {[type]}  [No hi ha cap valor de retorn.]
 */
function adminPages() {
  $(document).ready(function () {
    // Mostra la pàgina d'edició d'usuaris per defecte
    $("#pagina-users-edit").show();
    $("#search-users-edit").show();
    
    // Event listener per al clic a "Edició d'Usuaris"
    $("#users-edit").click(function (e) {
        e.preventDefault();
        // Amaga totes les altres pàgines i mostra l'edició d'usuaris
        $(".pagina").hide();
        $("#pagina-users-edit").show();
        $("#search-users-edit").show();
        // Canvia l'URL sense recarregar la pàgina
        window.history.pushState(null, null, '/admin');
        // Potencialment, pots emmagatzemar l'estat actual en sessionStorage
    });

    // Event listener per al clic a "Afegir Usuaris"
    $("#users-add").click(function (e) {
        e.preventDefault();
        // Amaga totes les altres pàgines i mostra l'afegir usuaris
        $(".pagina").hide();
        $("#pagina-users-add").show();
        $("#search-users-edit").hide();
        // Canvia l'URL sense recarregar la pàgina
        window.history.pushState(null, null, '/admin');
    });

    // Event listener per al clic a "Edició de Classes"
    $("#classes-edit").click(function (e) {
        e.preventDefault();
        // Amaga totes les altres pàgines i mostra l'edició de classes
        $(".pagina").hide();
        $("#pagina-classes-edit").show();
        $("#search-class-teacher").hide();
        $("#search-class-student").hide();
        $("#search-users-edit").hide();
        // Canvia l'URL sense recarregar la pàgina
        window.history.pushState(null, null, '/admin');
    });

    // Event listener per al clic a "Afegir Classes"
    $("#classes-add").click(function (e) {
        e.preventDefault();
        // Amaga totes les altres pàgines i mostra l'afegir classes
        $(".pagina").hide();
        $("#pagina-classes-add").show();
        $("#search-class-teacher").show();
        $("#search-class-student").show();
        $("#search-users-edit").hide();
        // Canvia l'URL sense recarregar la pàgina
        window.history.pushState(null, null, '/admin');
    });

    // Event listener per al clic a "Edició d'Orles"
    $("#orles-edit").click(function (e) {
      e.preventDefault();
      // Amaga totes les altres pàgines i mostra l'edició d'orles
      $(".pagina").hide();
      $("#pagina-orles-edit").show();
      $("#search-class-teacher").hide();
      $("#search-class-student").hide();
      $("#search-users-edit").hide();
      // Canvia l'URL sense recarregar la pàgina
      window.history.pushState(null, null, '/admin');
    });
  });
}

/**
 * Funció que gestiona la navegació entre les pàgines de l'equip directiu.
 *
 * @return  {[type]}  [No hi ha cap valor de retorn.]
 */
function equipDirectiuPages() {
  $(document).ready(function () {
    // Amaga la pàgina de classes i mostra la pàgina d'orles per defecte
    $("#pagina-classesEd").hide();
    $("#pagina-orlesEd").show();
    $("#pagina-reportsEd").hide();
  });

  $(document).ready(function () {
    // Event listener per al clic a "Classes"
    $("#classesEd").click(function (e) {
      console.log("classes");
      e.preventDefault();
      // Amaga totes les altres pàgines i mostra la pàgina de classes
      $(".paginaEd").hide();
      $("#pagina-classesEd").show();
    });
  });

  $(document).ready(function () {
    // Event listener per al clic a "Orles"
    $("#orlesEd").click(function (e) {
      e.preventDefault();
      console.log("orles");
      // Amaga totes les altres pàgines i mostra la pàgina d'orles
      $(".paginaEd").hide();
      $("#pagina-orlesEd").show();
      // Canvia l'URL sense recarregar la pàgina
      window.history.pushState(null, null, "/equipDirectiu");
    });
  });

  $(document).ready(function () {
    // Event listener per al clic a "Informes"
    $("#reportsEd").click(function (e) {
      e.preventDefault();
      console.log("reports");
      // Amaga totes les altres pàgines i mostra la pàgina d'informes
      $(".paginaEd").hide();
      $("#pagina-reportsEd").show();
      // Canvia l'URL sense recarregar la pàgina
      window.history.pushState(null, null, "/equipDirectiu");
    });

    // Event listener per al clic a un element d'avatar
    $(".avatar-item").on("click", function (e) {
      // Obtenir el valor de l'avatar seleccionat
      const selectedAvatarValue = this.id;
      document.getElementById("selectedAvatar").value = selectedAvatarValue;
      // Enviar el formulari d'avatar
      var form = document.getElementById("avatarForm");
      form.submit();
    });
  });
}

/**
 * Funció que gestiona la navegació entre les pàgines de recuperació.
 *
 * @return  {[type]}  [No hi ha cap valor de retorn.]
 */
function recoverPages() {
  $(document).ready(function () {
    // Event listener per al clic a "Recuperar"
    $("#recover").click(function (e) {
      e.preventDefault();
      // Amaga la pàgina de recuperació i mostra la pàgina de missatge
      $("#pagina-recover").hide();
      $("#pagina-missatge").show();
    });
  });
}

/**
 * Funció que gestiona la navegació entre les diferents pàgines per als professors.
 *
 * @return  {[type]}  [No hi ha cap valor de retorn.]
 */
function teacherPages() {
  $(document).ready(function () {
    // Oculta les seccions de grups i orles inicialment
    $("#new-pagina-users").show();
    $("#new-pagina-grups").hide();
    $("#new-pagina-orles").hide();
    $("#search-users-edit").show();

    // Event listener per al clic a "Usuaris"
    $("#new-users").click(function (e) {
      e.preventDefault();
      // Mostra la pàgina d'usuaris i amaga les altres
      $("#new-pagina-users").show();
      $("#new-pagina-grups").hide();
      $("#new-pagina-orles").hide();
      $("#search-users-edit").show();
    });

    // Event listener per al clic a "Grups"
    $("#new-grups").click(function (e) {
      e.preventDefault();
      // Mostra la pàgina de grups i amaga les altres
      $("#new-pagina-users").hide();
      $("#new-pagina-grups").show();
      $("#new-pagina-orles").hide();
      $("#search-users-edit").hide();
    });

    // Event listener per al clic a "Classes"
    $("#new-classes").click(function (e) {
      e.preventDefault();
      // Mostra la pàgina d'orles i amaga les altres
      $("#new-pagina-users").hide();
      $("#new-pagina-grups").hide();
      $("#new-pagina-orles").show();
      $("#search-users-edit").hide();
    });
  });
}

/**
 * Funció que gestiona les pàgines de perfil.
 */
function perfilPages() {
  document.addEventListener("DOMContentLoaded", function () {
    // Obtenir tots els botons que activen els modals
    const modalButtons = document.querySelectorAll("[data-modal-toggle]");
    modalButtons.forEach((button) => {
      // Afegir un esdeveniment de clic a cada botó d'activació del modal
      button.addEventListener("click", function () {
        // Obtenir l'element modal destinat
        const targetModal = document.getElementById(
          this.getAttribute("data-modal-target")
        );
        if (targetModal) {
          // Alternar la classe "hidden" per mostrar o amagar el modal
          targetModal.classList.toggle("hidden");
        }
      });
    });

    // Obtenir tots els botons que amaguen els modals
    const modalHideButtons = document.querySelectorAll("[data-modal-hide]");
    modalHideButtons.forEach((button) => {
      // Afegir un esdeveniment de clic a cada botó d'amagat del modal
      button.addEventListener("click", function () {
        // Obtenir l'element modal destinat
        const targetModal = document.getElementById(
          this.getAttribute("data-modal-hide")
        );
        if (targetModal) {
          // Afegir la classe "hidden" per amagar el modal
          targetModal.classList.add("hidden");
        }
      });
    });
  });
}

/**
 * Funció per alternar la visibilitat d'un formulari.
 */
function toggleFormVisibility() {
  // Obtenir l'element del formulari pel seu ID
  var form = document.getElementById("avatarForm");
  // Alternar la propietat de visualització del formulari
  form.style.display = form.style.display === "none" ? "block" : "none";
}

/**
 * Funció per mostrar la pestanya seleccionada.
 *
 * @param {string} tabName - Nom de la pestanya que es vol mostrar.
 */
function showTab(tabName) {
  // Mostrar o amagar el contingut de la pestanya d'imatges
  document.getElementById("imagesTabContent").style.display =
    tabName === "images" ? "block" : "none";
  // Mostrar o amagar el contingut de la pestanya d'orles
  document.getElementById("orlesTabContent").style.display =
    tabName === "orles" ? "block" : "none";
  // Mostrar o amagar el contingut de la pestanya de carnet
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
