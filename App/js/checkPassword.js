import $ from "jquery";

function checkPassword() {
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
}


   
    
export{checkPassword };