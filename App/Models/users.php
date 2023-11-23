<?php

/**
 * Exemple per a M07.
 * @author: Dani Prados dprados@cendrassos.net
 *
 * Model pels usuaris.
 *
 **/

namespace App\Models;

/**
 * Imatges
 */
class Users
{

    private $sql;
    private $options = [];

    /**
     * __construct:  Crear el model tasques
     *
     * Model adaptat per PDO
     *
     * @param \App\Models\Db $conn connexió a la base de dades
     *
     **/
    public function __construct($conn, $options = ['cost' => 12])
    {
        $this->sql = $conn;
        $this->options = $options;
    }


    public function login($email, $password)
{
    $login = $this->validateUser($email, $password);

    if ($login) {
        return $login; // Si las credenciales son válidas, devuelve los detalles del usuario
    } else {
        return false; // Si las credenciales no son válidas, devuelve false
    }
}


    public function register($name, $lastname, $username, $password, $email) {
        $stm = $this->sql->prepare('INSERT INTO users (name, surname, username, password, email) VALUES (:name, :surname, :username, :password, :email);');
        $stm->execute([':name' => $name, ':surname' => $lastname, ':username' => $username, ':password' => $password, ':email' => $email]);
    }

    public function getUser($email)
    {
        $query = 'select id, email, password from users where email=:email;';
        $stm = $this->sql->prepare($query);
        $result = $stm->execute([':email' => $email]);

        if ($stm->errorCode() !== '00000') {
            $err = $stm->errorInfo();
            $code = $stm->errorCode();
            die("Error.   {$err[0]} - {$err[1]}\n{$err[2]} $query");
        }
        
        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    public function validateUser($email, $password)
{
    $login = $this->getUser($email);

    if ($login) {
        $hash = $login["password"];
        if (password_verify($password, $hash)) {
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $query = 'UPDATE users SET password=:hash WHERE email=:email;';
            $stm = $this->sql->prepare($query);
            $result = $stm->execute([
                ':email' => $email,
                ':hash' => $newHash,
            ]);
            // Actualizar el hash en la variable $login para devolver el usuario actualizado
            $login["password"] = $newHash;
        } else {
            $login = false;
        }
    }

    return $login;
}


    

}