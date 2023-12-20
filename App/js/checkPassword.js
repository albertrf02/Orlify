import $ from "jquery";

/**
 * Comprova la contrasenya abans d'enviar el formulari.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function checkPassword() {
  $(document).ready(function () {
    // S'afegeix un esdeveniment 'submit' al formulari amb l'id "registerForm"
    $("#registerForm").submit(function (event) {
      // Obté el valor del camp de contrasenya
      const contrasenya = $("#password").val();

      // Validació de la contrasenya amb la funció validarContrasenya
      const esValida = validarContrasenya(contrasenya);

      // Si la contrasenya no és vàlida, s'atura l'enviament del formulari i es mostra un alert
      if (!esValida) {
        event.preventDefault();
        alert(
          "La contraseña debe tener entre 6 y 13 caracteres, incluyendo al menos una letra y un número."
        );
      }
    });
  });

  /**
   * Validació de la contrasenya mitjançant una expressió regular.
   *
   * @param   {string}  contrasenya  La contrasenya a validar.
   * @return  {boolean}              Retorna true si la contrasenya és vàlida, sinó false.
   */
  function validarContrasenya(contrasenya) {
    // Expressió regular que requereix almenys una lletra, un número i té una longitud entre 6 i 13 caràcters
    const regex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d-]{6,13}$/;

    // Comprova si la contrasenya compleix la condició de l'expressió regular
    return regex.test(contrasenya);
  }
}

/**
 * Gestiona el canvi de contrasenya en un formulari utilitzant jQuery.
 *
 * @return  {void}  No retorna cap valor explícit.
 */
function changePassword() {
  $(document).ready(function () {
    // Funció per mostrar un missatge d'error en un div específic
    function showErrorMessage(divId, errorMessage) {
      var errorDiv = $("#" + divId);

      if (errorMessage !== "") {
        errorDiv.text(errorMessage);
        errorDiv.show(); // Mostra el div d'error
      } else {
        errorDiv.hide(); // Amaga el div d'error si no hi ha cap missatge d'error
      }
    }

    // Funció per comprovar si la nova contrasenya coincideix amb la confirmació de contrasenya
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

    // Funció per comprovar si la nova contrasenya no està buida
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

    // Funció per comprovar el format de la nova contrasenya
    function checkNewPasswordFormat() {
      var newPassword = $("#newPassword").val();

      // Comprova si la contrasenya no està buida abans de validar el format
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
        // La contrasenya està buida, amaga l'error de format
        showErrorMessage("newPasswordFormatError", "");
      }
    }

    // Inicialitza els missatges d'error
    showErrorMessage("passwordMatchError", "");
    showErrorMessage("newPasswordEmptyError", "");
    showErrorMessage("newPasswordFormatError", "");

    // Associa la funció checkPasswordMatch als esdeveniments d'entrada dels camps de contrasenya
    $("#newPassword, #confirmPassword").keyup(checkPasswordMatch);

    // Associa la funció checkNewPasswordNotEmpty als esdeveniments d'entrada del camp de nova contrasenya
    $("#newPassword").keyup(checkNewPasswordNotEmpty);

    // Associa la funció checkNewPasswordFormat als esdeveniments d'entrada del camp de nova contrasenya
    $("#newPassword").keyup(checkNewPasswordFormat);

    // Gestor de l'enviament del formulari
    $("form").submit(function (event) {
      var newPassword = $("#newPassword").val();
      var confirmPassword = $("#confirmPassword").val();

      // Comprova si les contrasenyes coincideixen abans d'enviar el formulari
      if (newPassword !== confirmPassword) {
        showErrorMessage(
          "passwordMatchError",
          "Les contrasenyes no coincideixen"
        );
        event.preventDefault(); // Evita l'enviament del formulari
      }

      // Comprova si la nova contrasenya no està buida abans d'enviar el formulari
      if (newPassword === "") {
        showErrorMessage(
          "newPasswordEmptyError",
          "La nova contrasenya no pot estar buida"
        );
        event.preventDefault(); // Evita l'enviament del formulari
      }

      // Funció per validar el format de la nova contrasenya
      function validarContrasenya(contrasenya) {
        const regex = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d-]{6,13}$/;
        return regex.test(contrasenya);
      }

      // Comprova si el format de la nova contrasenya és vàlid
      var isValidFormat = validarContrasenya(newPassword);
      if (!isValidFormat) {
        showErrorMessage(
          "newPasswordFormatError",
          "La nova contrasenya no compleix el format requerit"
        );
        event.preventDefault(); // Evita l'enviament del formulari
      }
    });
  });
}

export { 
  checkPassword, 
  changePassword 
};