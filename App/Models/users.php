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


    public function register($name, $lastname, $username, $password, $email, $role)
    {
        $stm = $this->sql->prepare('INSERT INTO users (name, surname, username, password, email, role) VALUES (:name, :surname, :username, :password, :email, :role);');
        $stm->execute([':name' => $name, ':surname' => $lastname, ':username' => $username, ':password' => $password, ':email' => $email, ':role' => $role]);
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



    public function updateUser($id, $name, $surname, $hashPassword, $role)
    {
        $stm = $this->sql->prepare('UPDATE users SET name = :name, surname = :surname, password = :password, role = :role WHERE id = :id;');
        $stm->execute([':id' => $id, ':name' => $name, ':surname' => $surname, ':password' => $hashPassword, ':role' => $role]);
    }

    public function updatePassword($id, $hashPassword)
    {
        $stm = $this->sql->prepare('UPDATE users SET password = :password WHERE id = :id;');
        $stm->execute([':id' => $id, ':password' => $hashPassword]);
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

    public function setPorfilePhoto($idUser, $avatar)
    {
        $stm = $this->sql->prepare('update users set avatar=:avatar where id=:idUser;');
        $stm->execute([':idUser' => $idUser, ':avatar' => $avatar]);
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
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }


    public function getDefaultPhoto($idUser)
    {
        $stm = $this->sql->prepare('select * from photography where idUser=:idUser and defaultPhoto=1;');
        $stm->execute([':idUser' => $idUser]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        if (is_array($result)) {
            return $result;
        } else {
            return false;
        }
    }

    public function getClassGroups()
    {
        $stm = $this->sql->prepare('SELECT * FROM classgroup;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function insertReport($idPhoto)
    {
        $idUser = $_SESSION["user"]["id"];

        // Check if the report already exists
        $checkStm = $this->sql->prepare('SELECT id FROM reports WHERE idUser = :idUser AND idPhoto = :idPhoto');
        $checkStm->execute([':idUser' => $idUser, ':idPhoto' => $idPhoto]);

        if (!$checkStm->fetch()) {
            // The report doesn't exist, so insert it
            $insertStm = $this->sql->prepare('INSERT INTO reports (idUser, idPhoto) VALUES (:idUser, :idPhoto);');
            $insertStm->execute([':idUser' => $idUser, ':idPhoto' => $idPhoto]);
        }
    }


    public function getReportedImages()
    {
        $stm = $this->sql->prepare('
    SELECT
        r.id AS report_id,
        u.name AS user_name,
        p.link AS photography_link
    FROM
        reports r
    JOIN
        users u ON r.idUser = u.id
    JOIN
        photography p ON r.idPhoto = p.id;

    ');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteReport($reportId)
    {
        $stm = $this->sql->prepare('DELETE FROM reports WHERE id = :reportId');
        $stm->execute([':reportId' => $reportId]);
    }

    public function deleteReportAndPhoto($reportId)
    {
        // Retrieve idPhoto before deleting the report
        $stm = $this->sql->prepare('
        SELECT idPhoto
        FROM reports
        WHERE id = :reportId
    ');
        $stm->execute([':reportId' => $reportId]);
        $idPhoto = $stm->fetchColumn();

        // Delete the report
        $stm = $this->sql->prepare('
        DELETE FROM reports
        WHERE id = :reportId
    ');
        $stm->execute([':reportId' => $reportId]);

        // Delete the corresponding photo
        $stm = $this->sql->prepare('
        DELETE FROM photography
        WHERE id = :idPhoto
    ');
        $stm->execute([':idPhoto' => $idPhoto]);
    }

    public function insert($name, $surname, $username, $password, $email)
    {
        $stm = $this->sql->prepare('INSERT INTO users (name, surname, username, password, email) VALUES (:name, :surname, :username, :password, :email);');
        $stm->execute([':name' => $name, ':surname' => $surname, ':username' => $username, ':password' => $password, ':email' => $email]);
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


    public function getTokenExpiration($token)
    {
        $stm = $this->sql->prepare('SELECT token_expiration FROM users WHERE token = :token');
        $stm->execute([':token' => $token]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        return $result['token_expiration'];
    }


    public function updatePasswordByToken($password, $token)
    {
        $stm = $this->sql->prepare('UPDATE users SET password = :password WHERE token = :token');
        $stm->execute([':password' => $password, ':token' => $token]);
    }

    public function getAvatars()
    {
        $avatarPath = __DIR__ . "/../../public/avatars/";
        $avatars = [];

        $files = scandir($avatarPath);
        foreach ($files as $file) {
            if ($file !== "." && $file !== "..") {
                $avatars[] = $file;
            }
        }

        return $avatars;
    }

    public function getOrlaFromClassByUserId($idUser)
    {
        $query = <<<QUERY
            SELECT classGroup.className, users.name, orla.id, orla.visibility, orla.name FROM classGroup, users, users_classgroup, orla
            WHERE 
            classGroup.id = users_classgroup.idGroupClass
            AND
            users.id = users_classgroup.idUser
            AND 
            classgroup.id = orla.idClassGroup
            AND users.id=:idUser;
        QUERY;
        $stm = $this->sql->prepare($query);
        $stm->execute([':idUser' => $idUser]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insertCard($url, $idUser)
    {
        $stm = $this->sql->prepare('INSERT INTO studentcard (url, idStudent) VALUES (:url, :idUser);');
        $stm->execute([':url' => $url, ':idUser' => $idUser]);
    }

  
    public function getUsersClass() {
        $stm = $this->sql->prepare('SELECT * FROM users u 
                                    LEFT JOIN users_classgroup c ON u.id = c.idUser
                                    WHERE (u.role = 1 AND c.idUser IS NULL) OR u.role = 2;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function getStudent() {
        $stm = $this->sql->prepare('SELECT * FROM users u 
                                    LEFT JOIN users_classgroup c ON u.id = c.idUser
                                    WHERE (u.role = 1 AND c.idUser IS NULL);');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function getTeacher() {
        $stm = $this->sql->prepare('SELECT * FROM users u 
                                    LEFT JOIN users_classgroup c ON u.id = c.idUser
                                    WHERE u.role = 2;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
    


    public function insertGeneratedUser($name, $surname, $username, $password, $email, $role) {
        $stm = $this->sql->prepare('INSERT INTO users (name, surname, username, password, email, role) VALUES (:name, :surname, :username, :password, :email, :role);');
        $stm->execute([':name' => $name, ':surname' => $surname, ':username' => $username, ':password' => $password, ':email' => $email, ':role' => $role]);
    }
    
    


}