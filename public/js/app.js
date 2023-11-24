$(document).ready(function () {
    $("#registerForm").submit(function (event) {
      // Obtener el valor de la contraseña introducida
      const contrasenya = $("#password").val();

      // Validar la contraseña
      const esValida = validarContrasenya(contrasenya);

      // Si la contraseña no es válida, prevenir el envío del formulario y mostrar un mensaje de error
      if (!esValida) {
        event.preventDefault(); // Prevenir el envío del formulario
        alert("La contraseña debe tener entre 6 y 13 caracteres, incluyendo al menos una letra y un número.");
      }
      // Si la contraseña es válida, el formulario se enviará normalmente
    });
  });


  function validarContrasenya(contrasenya) {
    // La expresión regular para validar la contraseña
    const regex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d-]{6,13}$/;

    return regex.test(contrasenya);
}



$(document).ready(function () {
  $("#pagina-users, #pagina-classes").hide();
});


$(document).ready(function() {
  $("#users").click(function(e) {
      e.preventDefault();
      $(".pagina").hide();
      $("#pagina-users").show();
  });
});

$(document).ready(function() {
  $("#classes").click(function(e) {
      e.preventDefault();
      $(".pagina").hide();
      $("#pagina-classes").show();
  });
});