<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Controller for handling password recovery
 */
class RecoverController
{
    /**
     * Handles the password recovery request
     *
     * @param  mixed $request
     * @param  mixed $response
     * @param  mixed $container
     * @return mixed
     */
    function recover($request, $response, $container)
    {
        // Gets the email from the request
        $email = $request->get(INPUT_POST, "email");

        // Generates a random token
        $bytes = random_bytes(30);
        $token = bin2hex($bytes);

        // Gets the users model and sets the token for the user
        $model = $container->get("users");
        $recover = $model->token($email, $token);

        // Sends an email to the user with the recovery link
        $mail = new PHPMailer(true);
        try {
            // Mail configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'orlify.team@gmail.com';
            $mail->Password = 'yggy avmr lowm njzg';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->setFrom('orlify.team@gmail.com');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Sol·licitud de restabliment de contrasenya: Orlify';
            $mail->Body = "S'ha sol·licitat un restabliment de contrasenya per al compte de $email al lloc Orlify.<br><br>"
                . "Per confirmar aquesta petició, i establir una contrasenya nova per al compte, feu clic a l'enllaç següent:<br><br>"
                . "<a href='http://localhost:8080/recoverpassword/$token'>http://localhost:8080/recoverpassword/$token</a><br>"
                . "(Aquest enllaç és vàlid durant 15 minuts des del moment en què es va sol·licitar per primera vegada aquest reajustament)<br><br>"
                . "Si no heu sol·licitat aquest restabliment de contrasenya, no es necessita cap acció.";
            $mail->send();

        } catch (Exception $e) {
            echo "El correo electrónico no pudo ser enviado. Error: {$mail->ErrorInfo}";
        }

        // Redirects the user to the home page
        $response->redirect("Location: /home");
        return $response;
    }

    /**
     * Handles the password reset request
     *
     * @param  mixed $request
     * @param  mixed $response
     * @param  mixed $container
     * @return mixed
     */
    function password($request, $response, $container)
    {
        // Gets the new password, repeated password and token from the request
        $new_passowrd = $request->get(INPUT_POST, "new_password");
        $repeat_password = $request->get(INPUT_POST, "repeat_password");
        $token = $request->get(INPUT_POST, "token");

        // Gets the users model
        $model = $container->get("users");

        // Checks if the new password and repeated password match
        if ($new_passowrd == $repeat_password) {

            // Hashes the new password
            $hashPassword = $model->hashPassword($new_passowrd);
            // Updates the password for the user with the token
            $recover = $model->updatePasswordByToken($hashPassword, $token);
            // Redirects the user to the home page
            $response->redirect("Location: /");
            return $response;

        } else {
            // Sets an error message in the session
            $response->setSession("errorpass", "Les contrasenyes no coincideixen");
            // Redirects the user back to the password recovery page
            $response->redirect("Location: /recoverpassword/$token");
            return $response;
        }
    }
}
