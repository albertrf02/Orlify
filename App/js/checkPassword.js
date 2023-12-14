import $ from "jquery";

function checkPassword() {
  $(document).ready(function () {
    $("#registerForm").submit(function (event) {
      const contrasenya = $("#password").val();
      const esValida = validarContrasenya(contrasenya);

      if (!esValida) {
        event.preventDefault();
        alert(
          "La contraseña debe tener entre 6 y 13 caracteres, incluyendo al menos una letra y un número."
        );
      }
    });
  });

  function validarContrasenya(contrasenya) {
    const regex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d-]{6,13}$/;
    return regex.test(contrasenya);
  }
}

function changePassword() {
  $(document).ready(function () {
    function showErrorMessage(divId, errorMessage) {
      var errorDiv = $("#" + divId);

      if (errorMessage !== "") {
        errorDiv.text(errorMessage);
        errorDiv.show(); // Show the error div
      } else {
        errorDiv.hide(); // Hide the error div if there's no error message
      }
    }

    // Function to check if the new password matches the confirmation password
    function checkPasswordMatch() {
      var newPassword = $("#newPassword").val();
      var confirmPassword = $("#confirmPassword").val();

      if (newPassword !== confirmPassword) {
        showErrorMessage(
          "passwordMatchError",
          "Les contrasenyes no coincideixen"
        );
      } else {
        showErrorMessage("passwordMatchError", "");
      }
    }

    // Function to check if the new password is empty
    function checkNewPasswordNotEmpty() {
      var newPassword = $("#newPassword").val();

      if (newPassword === "") {
        showErrorMessage(
          "newPasswordEmptyError",
          "La nova contrasenya no pot estar buida"
        );
      } else {
        showErrorMessage("newPasswordEmptyError", "");
      }
    }

    function checkNewPasswordFormat() {
      var newPassword = $("#newPassword").val();

      // Check if the password is not empty before validating format
      if (newPassword !== "") {
        var isValid = validarContrasenya(newPassword);

        if (!isValid) {
          showErrorMessage(
            "newPasswordFormatError",
            "La nova contrasenya no compleix el format requerit"
          );
        } else {
          showErrorMessage("newPasswordFormatError", "");
        }
      } else {
        // Password is empty, hide the format error
        showErrorMessage("newPasswordFormatError", "");
      }
    }

    showErrorMessage("passwordMatchError", "");
    showErrorMessage("newPasswordEmptyError", "");
    showErrorMessage("newPasswordFormatError", "");

    // Bind the checkPasswordMatch function to the input events
    $("#newPassword, #confirmPassword").keyup(checkPasswordMatch);

    // Bind the checkNewPasswordNotEmpty function to the input events
    $("#newPassword").keyup(checkNewPasswordNotEmpty);

    // Bind the checkNewPasswordFormat function to the input events
    $("#newPassword").keyup(checkNewPasswordFormat);

    // Submit handler for the form
    $("form").submit(function (event) {
      var newPassword = $("#newPassword").val();
      var confirmPassword = $("#confirmPassword").val();

      // Check if the passwords match before submitting the form
      if (newPassword !== confirmPassword) {
        showErrorMessage(
          "passwordMatchError",
          "Les contrasenyes no coincideixen"
        );
        event.preventDefault(); // Prevent form submission
      }

      // Check if the new password is not empty
      if (newPassword === "") {
        showErrorMessage(
          "newPasswordEmptyError",
          "La nova contrasenya no pot estar buida"
        );
        event.preventDefault(); // Prevent form submission
      }

      function validarContrasenya(contrasenya) {
        const regex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d-]{6,13}$/;
        return regex.test(contrasenya);
      }

      // Check if the new password format is valid
      var isValidFormat = validarContrasenya(newPassword);
      if (!isValidFormat) {
        showErrorMessage(
          "newPasswordFormatError",
          "La nova contrasenya no compleix el format requerit"
        );
        event.preventDefault(); // Prevent form submission
      }
    });
  });
}
export { checkPassword, changePassword };
