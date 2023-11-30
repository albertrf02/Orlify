import $ from "jquery";

function adminPages() {
  $(document).ready(function () {
    $("#pagina-users").show();
    $("#pagina-classes").hide();
  });

  $(document).ready(function () {
    $("#users").click(function (e) {
      e.preventDefault();
      $(".pagina").hide();
      $("#pagina-users").show();
    });
  });

  $(document).ready(function () {
    $("#classes").click(function (e) {
      e.preventDefault();
      $(".pagina").hide();
      $("#pagina-classes").show();
      window.history.pushState(null, null, "/admin");
    });
  });
}

//pagines de l'equip directiu
function equipDirectiuPages() {
  $(document).ready(function () {
    $("#pagina-classesEd").show();
    $("#pagina-orlesEd").hide();
  });

  $(document).ready(function () {
    $("#classesEd").click(function (e) {
      e.preventDefault();
      $(".paginaEd").hide();
      $("#pagina-classesEd").show();
    });
  });

  $(document).ready(function () {
    $("#orlesEd").click(function (e) {
      e.preventDefault();
      $(".paginaEd").hide();
      $("#pagina-orlesEd").show();
      window.history.pushState(null, null, "/equipDirectiu");
    });
  });
}

export { adminPages };
export { equipDirectiuPages };