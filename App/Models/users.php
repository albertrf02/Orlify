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
        $stm = $this->sql->prepare('SELECT * FROM users WHERE email = :email;');
        $stm->execute([':email' => $email]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        if (is_array($result) && $result["password"] == $password) {
            return $result;
        } else {
            return false;
        }
    }

    public function register($name, $lastname, $username, $password, $email) {
        $stm = $this->sql->prepare('INSERT INTO users (name, surname, username, password, email) VALUES (:name, :surname, :username, :password, :email);');
        $stm->execute([':name' => $name, ':surname' => $lastname, ':username' => $username, ':password' => $password, ':email' => $email]);
    }

    public function hashPassword($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT, $this->options);
    
        return $hash;
    }


    public function getUser($email)
    {
        $query = 'select * from users where email=:email;';
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
                if (password_needs_rehash($hash, PASSWORD_DEFAULT, $this->options)) {
                    $newHash = password_hash($password, PASSWORD_DEFAULT, $this->options);
                    $query = 'update users set password=:hash where email=:email;';
                    $stm = $this->sql->prepare($query);
                    $result = $stm->execute([
                        ':email' => $email,
                        ':hash' => $newHash,
                    ]);
                }
            } else {
                $login = false;
            }
        }

        return $login;
    }




    

}