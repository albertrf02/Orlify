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

    /**
     * Intenta iniciar sessió amb les credencials proporcionades.
     *
     * @param string $email    El correu electrònic de l'usuari.
     * @param string $password La contrasenya de l'usuari.
     *
     * @return array|false Retorna un array amb els detalls de l'usuari si les credencials són vàlides, o false si no ho són.
     */

    public function login($email, $password)
    {
        $login = $this->validateUser($email, $password);

        if ($login) {
            return $login; // Si las credenciales son válidas, devuelve los detalles del usuario
        } else {
            return false; // Si las credenciales no son válidas, devuelve false
        }
    }

    /**
     * Registra un nou usuari amb les dades proporcionades.
     *
     * @param string $name     El nom de l'usuari.
     * @param string $lastname El cognom de l'usuari.
     * @param string $username El nom d'usuari de l'usuari.
     * @param string $password La contrasenya de l'usuari.
     * @param string $email    El correu electrònic de l'usuari.
     * @param string $role     El rol de l'usuari.
     *
     * @return void
     */
    public function register($name, $lastname, $username, $password, $email, $role)
    {
        $stm = $this->sql->prepare('INSERT INTO users (name, surname, username, password, email, avatar, role) VALUES (:name, :surname, :username, :password, :email, :avatar, :role);');
        $stm->execute([':name' => $name, ':surname' => $lastname, ':username' => $username, ':password' => $password, ':email' => $email, 'avatar' => "avatar-nen1.png", ':role' => $role]);
    }

    /**
     * Genera el hash de contrasenya per la contrasenya proporcionada.
     *
     * @param string $password La contrasenya per generar el hash.
     *
     * @return string El hash de la contrasenya.
     */
    public function hashPassword($password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT, $this->options);

        return $hash;
    }

    /**
     * Obté les dades de l'usuari amb l'adreça de correu electrònic proporcionada.
     *
     * @param string $email L'adreça de correu electrònic de l'usuari.
     *
     * @return array|false Retorna les dades de l'usuari com a array associatiu o false si no es troba cap usuari amb aquest correu electrònic.
     */
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


    /**
     * Valida les credencials de l'usuari.
     *
     * @param string $email    L'adreça de correu electrònic de l'usuari.
     * @param string $password La contrasenya de l'usuari.
     *
     * @return array|false Retorna les dades de l'usuari com a array si les credencials són vàlides, o false si no ho són.
     */
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

    /**
     * Obté totes les dades dels usuaris.
     *
     * @return array Un array associatiu amb les dades de tots els usuaris.
     */
    public function getAllUsers()
    {
        $stm = $this->sql->prepare('SELECT users.*, roles.name AS roleName, photography.link AS photoLink 
        FROM users 
        LEFT JOIN roles ON users.role = roles.idRole 
        LEFT JOIN photography ON users.id = photography.idUser AND photography.defaultPhoto = 1
        ;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obté totes les dades dels estudiants.
     *
     * @return array Un array associatiu amb les dades de tots els estudiants.
     */

    public function getAllStudents()
    {
        $stm = $this->sql->prepare('SELECT users.*, roles.name AS roleName, photography.link AS photoLink 
        FROM users 
        LEFT JOIN roles ON users.role = roles.idRole 
        LEFT JOIN photography ON users.id = photography.idUser AND photography.defaultPhoto = 1
        WHERE users.role = 1;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Actualitza les dades d'un usuari, incloent el nom, cognom, contrasenya i rol.
     *
     * @param int    $id           Identificador de l'usuari.
     * @param string $name         Nou nom de l'usuari.
     * @param string $surname      Nou cognom de l'usuari.
     * @param string $hashPassword Nova contrasenya (ja encriptada) de l'usuari.
     * @param int    $role         Nou rol de l'usuari.
     */
    public function updateUser($id, $name, $surname, $hashPassword, $role)
    {
        $stm = $this->sql->prepare('UPDATE users SET name = :name, surname = :surname, password = :password, role = :role WHERE id = :id;');
        $stm->execute([':id' => $id, ':name' => $name, ':surname' => $surname, ':password' => $hashPassword, ':role' => $role]);
    }

    /**
     * Actualitza la contrasenya d'un usuari.
     *
     * @param int    $id           Identificador de l'usuari.
     * @param string $hashPassword Nova contrasenya (ja encriptada) de l'usuari.
     */
    public function updatePassword($id, $hashPassword)
    {
        $stm = $this->sql->prepare('UPDATE users SET password = :password WHERE id = :id;');
        $stm->execute([':id' => $id, ':password' => $hashPassword]);
    }

    /**
     * Obté totes les fotos d'un usuari.
     *
     * @param int $idUser Identificador de l'usuari.
     *
     * @return array|false Retorna un array de fotos si hi ha fotos, altrament false.
     */
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

    /**
     * Estableix una foto com a foto per defecte d'un usuari.
     *
     * @param int $idUser  Identificador de l'usuari.
     * @param int $idPhoto Identificador de la foto.
     */
    public function setDefaultPhoto($idUser, $idPhoto)
    {
        $stm = $this->sql->prepare('update photography set defaultPhoto=0 where idUser=:idUser;');
        $stm->execute([':idUser' => $idUser]);
        $stm = $this->sql->prepare('update photography set defaultPhoto=1 where idUser=:idUser and id=:idPhoto;');
        $stm->execute([':idUser' => $idUser, ':idPhoto' => $idPhoto]);
    }

    /**
     * Estableix una foto com a foto de perfil d'un usuari.
     *
     * @param int    $idUser Identificador de l'usuari.
     * @param string $avatar Nom de l'arxiu d'avatar.
     */
    public function setPorfilePhoto($idUser, $avatar)
    {
        $stm = $this->sql->prepare('update users set avatar=:avatar where id=:idUser;');
        $stm->execute([':idUser' => $idUser, ':avatar' => $avatar]);
    }

    /**
     * Obté tots els rols disponibles.
     *
     * @return array Retorna un array amb la informació dels rols.
     */
    public function getRoles()
    {
        $stm = $this->sql->prepare('SELECT * FROM roles;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);

    }

    /**
     * Elimina un usuari establint el rol com a NULL.
     *
     * @param int $id Identificador de l'usuari.
     */
    public function deleteUser($id)
    {
        $stm = $this->sql->prepare('UPDATE users SET role = NULL WHERE id = :id;');
        $stm->execute([":id" => $id]);
    }

    /**
     * Cerca d'usuaris a través d'Ajax.
     *
     * @param string $query Termini de cerca per nom d'usuari.
     *
     * @return array Retorna un array amb la informació dels usuaris que coincideixen amb la cerca.
     */
    public function searchUserAjax($query)
    {
        $stm = $this->sql->prepare('SELECT users.*, photography.link AS photoLink 
        FROM users 
        LEFT JOIN photography ON users.id = photography.idUser AND photography.defaultPhoto = 1
        WHERE users.name LIKE :query
        ');
        $query = "{$query}%";
        $stm->execute([':query' => $query]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Cerca d'estudiants a través d'Ajax.
     *
     * @param string $query Termini de cerca per nom d'estudiant.
     *
     * @return array Retorna un array amb la informació dels estudiants que coincideixen amb la cerca.
     */
    public function searchUserStudentAjax($query)
    {
        $stm = $this->sql->prepare('SELECT users.*, photography.link AS photoLink 
    FROM users 
    LEFT JOIN photography ON users.id = photography.idUser AND photography.defaultPhoto = 1
    WHERE users.name LIKE :query AND users.role = 1
    ');
        $query = "{$query}%";
        $stm->execute([':query' => $query]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obté la informació d'un usuari per identificador.
     *
     * @param int $id Identificador de l'usuari.
     *
     * @return array|false Retorna un array amb la informació de l'usuari si existeix, en cas contrari retorna false.
     */
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

    /**
     * Obté la foto per defecte d'un usuari.
     *
     * @param int $idUser Identificador de l'usuari.
     *
     * @return array|false Retorna un array amb la informació de la foto per defecte si existeix, en cas contrari retorna false.
     */
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

    /**
     * Obté els grups de classe disponibles.
     *
     * @return array Retorna un array amb la informació dels grups de classe disponibles.
     */
    public function getClassGroups()
    {
        $stm = $this->sql->prepare('SELECT * FROM classgroup;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Insereix un nou informe relacionat amb una foto.
     *
     * @param int $idPhoto Identificador de la foto.
     */
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

    /**
     * Obté les imatges denunciades amb informació associada.
     *
     * @return array Retorna un array amb la informació de les imatges denunciades.
     */
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

    /**
     * Elimina un informe específic pel seu identificador.
     *
     * @param int $reportId Identificador de l'informe a eliminar.
     */
    public function deleteReport($reportId)
    {
        $stm = $this->sql->prepare('DELETE FROM reports WHERE id = :reportId');
        $stm->execute([':reportId' => $reportId]);
    }

    /**
     * Elimina un informe i la foto associada pel seu identificador.
     *
     * @param int $reportId Identificador de l'informe a eliminar.
     */
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

    /**
     * Insereix un nou usuari a la base de dades.
     *
     * @param string $name Nom de l'usuari.
     * @param string $surname Cognom de l'usuari.
     * @param string $username Nom d'usuari de l'usuari.
     * @param string $password Contrasenya de l'usuari.
     * @param string $email Correu electrònic de l'usuari.
     */
    public function insert($name, $surname, $username, $password, $email)
    {
        $stm = $this->sql->prepare('INSERT INTO users (name, surname, username, password, email) VALUES (:name, :surname, :username, :password, :email);');
        $stm->execute([':name' => $name, ':surname' => $surname, ':username' => $username, ':password' => $password, ':email' => $email]);
    }

    /**
     * Obté un usuari a partir del correu electrònic.
     *
     * @param string $email Correu electrònic de l'usuari.
     *
     * @return array|false Retorna un array amb les dades de l'usuari si existeix, sinó retorna false.
     */

    public function getUserByEmail($email)
    {
        $stm = $this->sql->prepare('SELECT * FROM users WHERE email = :email;');
        $stm->execute([':email' => $email]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Actualitza el token i el temps d'expiració del token d'un usuari.
     *
     * @param string $email Correu electrònic de l'usuari.
     * @param string $token Token a actualitzar.
     */
    public function token($email, $token)
    {
        $stm = $this->sql->prepare('UPDATE users SET token = :token, token_expiration = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE email = :email');
        $stm->execute([':token' => $token, ':email' => $email]);
    }

    /**
     * Obté un usuari a partir del token.
     *
     * @param string $token Token de l'usuari.
     *
     * @return array|false Retorna un array amb les dades de l'usuari si existeix, sinó retorna false.
     */
    public function getUserByToken($token)
    {
        $stm = $this->sql->prepare('SELECT * FROM users WHERE token = :token;');
        $stm->execute([':token' => $token]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si un token és vàlid.
     *
     * @param string $token Token a validar.
     *
     * @return bool Retorna true si el token és vàlid, false altrament.
     */
    public function isValidToken($token)
    {
        $stm = $this->sql->prepare('SELECT id FROM users WHERE token = :token');
        $stm->execute([':token' => $token]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        return ($result !== false);
    }

    /**
     * Obté la data d'expiració d'un token.
     *
     * @param string $token Token del qual es vol obtenir la data d'expiració.
     *
     * @return string Retorna la data d'expiració del token.
     */
    public function getTokenExpiration($token)
    {
        $stm = $this->sql->prepare('SELECT token_expiration FROM users WHERE token = :token');
        $stm->execute([':token' => $token]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        return $result['token_expiration'];
    }

    /**
     * Actualitza la contrasenya d'un usuari utilitzant el token de restabliment de contrasenya.
     *
     * @param string $password Nova contrasenya de l'usuari.
     * @param string $token    Token de restabliment de contrasenya.
     */
    public function updatePasswordByToken($password, $token)
    {
        $stm = $this->sql->prepare('UPDATE users SET password = :password WHERE token = :token');
        $stm->execute([':password' => $password, ':token' => $token]);
    }

    /**
     * Insereix una nova foto per a un usuari identificat per ID.
     *
     * @param string $link   Enllaç de la nova fotografia.
     * @param int    $idUser Identificador de l'usuari al qual pertany la fotografia.
     */
    public function insertPhotoByID($link, $idUser)
    {
        $stm = $this->sql->prepare('INSERT INTO photography(link, idUser) VALUES (:link, :idUser);');
        $stm->execute([':link' => $link, ':idUser' => $idUser]);
    }

    /**
     * Obté la llista d'avatars disponibles.
     *
     * @return array Llista d'avatars disponibles.
     */
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

    /**
     * Obté les orles associades a un usuari a partir del seu ID.
     *
     * @param int $idUser ID de l'usuari.
     *
     * @return array Llista d'orles associades a l'usuari.
     */
    public function getOrlaFromClassByUserId($idUser)
    {
        $query = <<<QUERY
            SELECT classgroup.className, users.name, orla.id, orla.visibility, orla.name FROM classgroup, users, users_classgroup, orla
            WHERE 
            classgroup.id = users_classgroup.idGroupClass
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

    /**
     * Insereix una targeta d'estudiant amb una URL associada a un usuari.
     *
     * @param string $url   URL de la targeta d'estudiant.
     * @param int    $idUser ID de l'usuari associat a la targeta d'estudiant.
     */
    public function insertCard($url, $idUser)
    {
        $stm = $this->sql->prepare('INSERT INTO studentcard (url, idStudent) VALUES (:url, :idUser);');
        $stm->execute([':url' => $url, ':idUser' => $idUser]);
    }

    /**
     * Obté els usuaris de la classe, incloent estudiants sense classe i professors.
     *
     * @return array Llista d'usuaris de la classe.
     */
    public function getUsersClass()
    {
        $stm = $this->sql->prepare('SELECT * FROM users u 
                                    LEFT JOIN users_classgroup c ON u.id = c.idUser
                                    WHERE (u.role = 1 AND c.idUser IS NULL) OR u.role = 2;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obté els estudiants que no estan assignats a cap classe.
     *
     * @return array Llista d'estudiants sense classe assignada.
     */
    public function getStudent()
    {
        $stm = $this->sql->prepare('SELECT * FROM users u 
                                    LEFT JOIN users_classgroup c ON u.id = c.idUser
                                    WHERE (u.role = 1 AND c.idUser IS NULL);');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obté els professors de la classe.
     *
     * @return array Llista de professors de la classe.
     */

    public function getTeacher()
    {
        $stm = $this->sql->prepare('SELECT * FROM users u 
                                    LEFT JOIN users_classgroup c ON u.id = c.idUser
                                    WHERE u.role = 2;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Insereix un usuari generat amb les dades proporcionades a la base de dades.
     *
     * @param string $name     Nom de l'usuari generat.
     * @param string $surname  Cognom de l'usuari generat.
     * @param string $username Nom d'usuari de l'usuari generat.
     * @param string $password Contrasenya de l'usuari generat.
     * @param string $email    Adreça de correu electrònic de l'usuari generat.
     * @param int    $role     Rol de l'usuari generat.
     */
    public function insertGeneratedUser($name, $surname, $username, $password, $email, $role)
    {
        $stm = $this->sql->prepare('INSERT INTO users (name, surname, username, password, email, role) VALUES (:name, :surname, :username, :password, :email, :role);');
        $stm->execute([':name' => $name, ':surname' => $surname, ':username' => $username, ':password' => $password, ':email' => $email, ':role' => $role]);
    }


    /**
     * Obté el token de carnet de l'usuari amb l'ID proporcionat. Si l'usuari no té un token de carnet, se'n genera un nou.
     *
     * @param int $idUser ID de l'usuari.
     *
     * @return string Token de carnet de l'usuari.
     */

    public function getTokenCarnet($idUser)
    {
        $stm = $this->sql->prepare('SELECT token_carnet FROM users WHERE id = :idUser;');
        $stm->execute([':idUser' => $idUser]);
        $getToken = $stm->fetch(\PDO::FETCH_ASSOC);
        $token_carnet = $getToken["token_carnet"];

        if (empty($token_carnet)) {
            $token_carnet = $this->generateRandomToken();
            $updateToken = $this->sql->prepare('UPDATE users SET token_carnet = :token_carnet WHERE id = :idUser;');
            $updateToken->execute([':idUser' => $idUser, ':token_carnet' => $token_carnet]);
        }

        return $token_carnet;

    }

    /**
     * Obté l'usuari amb el token de carnet proporcionat.
     *
     * @param string $tokenCarnet Token de carnet de l'usuari.
     *
     * @return array|false Dades de l'usuari si existeix, o false si no existeix cap usuari amb aquest token de carnet.
     */
    public function getUserByTokenCarnet($token_carnet)
    {
        $stm = $this->sql->prepare('SELECT * FROM users WHERE token_carnet = :token_carnet;');
        $stm->execute([':token_carnet' => $token_carnet]);
        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Genera un string aleatori amb caràcters alfanumèrics.
     *
     * @return string String aleatori generat.
     */
    private function generateRandomToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < 10; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}