<?php

namespace App\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RecoverController
{
    /**
     * Gestiona el procés de recuperació de contrasenya per correu electrònic.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb l'adreça de correu electrònic per a la recuperació.
     * @param \Emeset\Http\Response $response Resposta HTTP per gestionar el redirigiment després de la recuperació.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP que redirigeix a la pàgina d'inici després de la recuperació.
     */
    function recover($request, $response, $container)
    {
        $email = $request->get(INPUT_POST, "email");

        $bytes = random_bytes(30);
        $token = bin2hex($bytes);

        $model = $container->get("users");
        $recover = $model->token($email, $token);

        $mail = new PHPMailer(true);
        try {
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

        $response->redirect("Location: /home");
        return $response;
    }

    /**
     * Gestiona el procés de canvi de contrasenya després de la recuperació.
     *
     * @param \Emeset\Http\Request $request Petició HTTP amb les noves contrasenyes i el token de recuperació.
     * @param \Emeset\Http\Response $response Resposta HTTP per gestionar el redirigiment després del canvi de contrasenya.
     * @param \Emeset\Container $container
     *
     * @return \Emeset\Http\Response Resposta HTTP que redirigeix a la pàgina d'inici després del canvi de contrasenya.
     */
    function password($request, $response, $container)
    {
        $new_passowrd = $request->get(INPUT_POST, "new_password");
        $repeat_password = $request->get(INPUT_POST, "repeat_password");
        $token = $request->get(INPUT_POST, "token");

        $model = $container->get("users");


        if ($new_passowrd == $repeat_password) {

            $hashPassword = $model->hashPassword($new_passowrd);             //hash password
            $recover = $model->updatePasswordByToken($hashPassword, $token);
            $response->redirect("Location: /");
            return $response;

        } else {
            $response->setSession("errorpass", "Les contrasenyes no coincideixen");
            $response->redirect("Location: /recoverpassword/$token");
            return $response;
        }
    }
}