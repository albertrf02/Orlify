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


    public function register($name, $lastname, $username, $password, $email)
    {
        $stm = $this->sql->prepare('INSERT INTO users (name, surname, username, password, email) VALUES (:name, :surname, :username, :password, :email);');
        $stm->execute([':name' => $name, ':surname' => $lastname, ':username' => $username, ':password' => $password, ':email' => $email]);
    }

    public function hashPassword($password)
    {
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

        if (isset($login) && $login['role'] !== NULL) {
            $hash = $login["password"];

            if (password_verify($password, $hash)) {
                $newHash = password_hash($password, PASSWORD_DEFAULT);

                $query = 'UPDATE users SET password=:hash WHERE email=:email;';
                $stm = $this->sql->prepare($query);
                $result = $stm->execute([
                    ':email' => $email,
                    ':hash' => $newHash,
                ]);

                $login["password"] = $newHash;
            } else {
                $login = false;
            }
        } else {
            $login = false;
        }

        return $login;
    }


    public function getAllUsers()
    {
        $stm = $this->sql->prepare('SELECT users.*, roles.name AS roleName FROM users LEFT JOIN roles ON users.role = roles.idRole;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function updateUser($id, $name, $surname, $username, $hashPassword, $email, $role)
    {
        $stm = $this->sql->prepare('UPDATE users SET name = :name, surname = :surname, username = :username, password = :password, email = :email, role = :role WHERE id = :id;');
        $stm->execute([':id' => $id, ':name' => $name, ':surname' => $surname, ':username' => $username, ':password' => $hashPassword, ':email' => $email, ':role' => $role]);
    }

    public function getPhotos($idUser)
    {
        $stm = $this->sql->prepare('select * from photography where idUser=:idUser;');
        $stm->execute([':idUser' => $idUser]);
        $result = $stm->fetchAll(\PDO::FETCH_ASSOC);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function setDefaultPhoto($idUser, $idPhoto)
    {
        $stm = $this->sql->prepare('update photography set defaultPhoto=0 where idUser=:idUser;');
        $stm->execute([':idUser' => $idUser]);
        $stm = $this->sql->prepare('update photography set defaultPhoto=1 where idUser=:idUser and id=:idPhoto;');
        $stm->execute([':idUser' => $idUser, ':idPhoto' => $idPhoto]);
    }
    public function getRoles()
    {
        $stm = $this->sql->prepare('SELECT * FROM roles;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);

    }


    public function deleteUser($id)
    {
        $stm = $this->sql->prepare('UPDATE users SET role = NULL WHERE id = :id;');
        $stm->execute([":id" => $id]);
    }


    public function searchUserAjax($query)
    {
        $stm = $this->sql->prepare('SELECT * FROM users WHERE name LIKE :query;');
        $query = "{$query}%";
        $stm->execute([':query' => $query]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }



    public function getUserById($id)
    {
        $stm = $this->sql->prepare('SELECT * FROM users WHERE id = :id;');
        $stm->execute([':id' => $id]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getUserByEmail($email)
    {
        $stm = $this->sql->prepare('SELECT * FROM users WHERE email = :email;');
        $stm->execute([':email' => $email]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function token($email, $token)
    {
    $stm = $this->sql->prepare('UPDATE users SET token = :token, token_expiration = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE email = :email');
    $stm->execute([':token' => $token, ':email' => $email]);
    }


    public function getUserByToken($token)
    {
        $stm = $this->sql->prepare('SELECT * FROM users WHERE token = :token;');
        $stm->execute([':token' => $token]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function isValidToken($token)
    {
    $stm = $this->sql->prepare('SELECT id FROM users WHERE token = :token');
    $stm->execute([':token' => $token]);
    $result = $stm->fetch(\PDO::FETCH_ASSOC);

    return ($result !== false);
    }


    public function CheckTime($token)
{
    $stm = $this->sql->prepare('SELECT IF(token_expiration < NOW(), "No", "Si") AS token_validity FROM users WHERE token = :token');
    $stm->execute([':token' => $token]);
    $result = $stm->fetch(\PDO::FETCH_ASSOC);
    return $result;
}



}