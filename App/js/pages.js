import $ from "jquery";

function adminPages() {
    $(document).ready(function () {
        $("#pagina-users-edit").show();
        $("#search-users-edit").show();
        $("#pagina-users-add").hide();
        $("#pagina-classes-edit").hide();
        $("#pagina-classes-add").hide();
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




export { adminPages, equipDirectiuPages, recoverPages };
