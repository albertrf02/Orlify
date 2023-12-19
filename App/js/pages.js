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
