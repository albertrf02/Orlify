import $ from "jquery";

function adminPages() {
    $(document).ready(function () {
        $("#pagina-users-edit").show();
        $("#search-users-edit").show();
        $("#pagina-users-add").hide();
        $("#pagina-classes-edit").hide();
        $("#pagina-classes-add").hide();
        $("#search-class-user").hide();
        
    });

    $(document).ready(function () {
        $("#users-edit").click(function (e) {
            e.preventDefault();
            $(".pagina").hide();
            $("#pagina-users-edit").show();
            $("#search-users-edit").show();
            window.history.pushState(null, null, '/admin');
        });
    });

    $(document).ready(function () {
      $("#users-add").click(function (e) {
          e.preventDefault();
          $(".pagina").hide();
          $("#pagina-users-add").show();
      });
  });

  $(document).ready(function () {
    $("#classes-edit").click(function (e) {
        e.preventDefault();
        $(".pagina").hide();
        $("#pagina-classes-edit").show();
    });

    $(document).ready(function () {
      $("#classes-add").click(function (e) {
          e.preventDefault();
          $(".pagina").hide();
          $("#pagina-classes-add").show();
          $("#search-class-user").show();
      });
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

export { adminPages, equipDirectiuPages, recoverPages, perfilPages };
