$(document).ready(function () {
    $("#registerForm").submit(function (event) {

      const contrasenya = $("#password").val();
      const esValida = validarContrasenya(contrasenya);

      if (!esValida) {
        event.preventDefault(); // Prevenir el envío del formulario
        alert("La contraseña debe tener entre 6 y 13 caracteres, incluyendo al menos una letra y un número.");
      }
    });
  });

  function validarContrasenya(contrasenya) {

    const regex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d-]{6,13}$/;
    return regex.test(contrasenya);
}



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
    window.history.pushState(null, null, '/admin');
  });
});


$(document).ready(function () {
    $('#table-search-users').on('input', function () {

      var searchQuery = $(this).val();

      console.log(searchQuery);

        if (searchQuery.length >= 3) {

            $.ajax({
                url: '/searchuser', 
                method: 'POST',
                data: { query: searchQuery },
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (data) {

                  console.log(data);
                    // $('.pagina:visible').html(data);
                },
                error: function (error) {
                    console.error('Error en la solicitud AJAX: ', error);
                }
            });
        }
    });
});
