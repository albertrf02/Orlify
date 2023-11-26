$(document).ready(function () {
  $("#registerForm").submit(function (event) {
    const contrasenya = $("#password").val();
    const esValida = validarContrasenya(contrasenya);

    if (!esValida) {
      event.preventDefault();
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
  $(".editUserModal").off("click").on('click', function () {
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

        // Update user information
        $("#title").text(user.id);
        $("#id").val(user.id);
        $("#name").val(user.name);
        $("#surname").val(user.surname);
        $("#username").val(user.username);
        $("#password").val(user.password);
        $("#email").val(user.email);

        // Populate roles in the select dropdown
        var roleSelect = $("#role");
        roleSelect.empty(); // Clear existing options

        roles.forEach(function (role) {
          roleSelect.append(
            $('<option>', {
              value: role.idRole,
              text: role.name,
              selected: (user.role == role.idRole)
            })
          );
        });
      },
      error: function (error) {
        console.error('Error en la solicitud AJAX: ', error);
      }
    });
  });


  $('#table-search-users').on('input', function () {
    var searchQuery = $(this).val();
    
    console.log(searchQuery);

    if (searchQuery.length >= 3) {
        $.ajax({
            url: '/searchuserajax', 
            method: 'POST',
            data: { query: searchQuery },
            success: function (data) {
              console.log(data);

              
              
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX: ', error);
            }
        });
    }
  });


});


