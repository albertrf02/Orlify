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
class Orles
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

    public function createOrla($name, $group, $idCreator)
    {
        $stm = $this->sql->prepare('INSERT INTO orla (name, visibility, public, idCreator, idClassGroup) VALUES (:name, :visibility, :public, :idCreator, :idClassGroup);');
        $stm->execute([':name' => $name, ':visibility' => 0, ':public' => 0, ':idCreator' => $idCreator, ':idClassGroup' => $group]);
        return $this->sql->lastInsertId();
    }

    public function getOrles()
    {
        $stm = $this->sql->prepare('SELECT * FROM orla;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserFromGroupInOrla($idOrla)
    {
        $query = <<<QUERY
        SELECT 
        u.id, 
        u.name, 
        u.surname, 
        u.username, 
        u.email, 
        u.avatar, 
        u.role,
        p.link AS defaultPicture,
        CASE 
            WHEN uo.idUser IS NOT NULL THEN TRUE
            ELSE FALSE
        END AS isInOrla
        FROM users u
        INNER JOIN users_classGroup ucg ON u.id = ucg.idUser
        LEFT JOIN user_orla uo ON u.id = uo.idUser AND uo.idOrla = :idOrla
        INNER JOIN orla o ON ucg.idGroupClass = o.idClassGroup
        LEFT JOIN photography p ON u.id = p.idUser AND p.defaultPhoto = TRUE
        WHERE u.role IN (1,2) AND o.id = :idOrla
        ORDER BY u.surname ASC;
        QUERY;
        $stm = $this->sql->prepare($query);
        $stm->execute([':idOrla' => $idOrla]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function deleteUsersFromOrla($idOrla)
    {
        $stm = $this->sql->prepare('DELETE FROM user_orla WHERE idOrla = :idOrla;');
        $stm->execute([':idOrla' => $idOrla]);
    }

    public function addUsersToOrla($idOrla, $usersOrla)
    {
        $stm = $this->sql->prepare('INSERT INTO user_orla (idUser, idOrla) VALUES (:idUser, :idOrla);');
        foreach ($usersOrla as $userOrla) {
            $stm->execute([':idUser' => $userOrla, ':idOrla' => $idOrla]);
        }
    }

    public function getOrlaById($idOrla)
    {
        $query = <<<QUERY
        SELECT users.name,users.surname,users.role, photography.link  FROM users, user_orla, photography
        WHERE 
        users.id = user_orla.idUser
        AND photography.idUser = users.id
        AND photography.defaultPhoto =1
        AND user_orla.idOrla=:idOrla;
        QUERY;
        $stm = $this->sql->prepare($query);
        $stm->execute([':idOrla' => $idOrla]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function deleteOrla($idOrla)
    {
        $deleteUserOrla = $this->sql->prepare('DELETE FROM user_orla WHERE idOrla = :idOrla;');
        $deleteUserOrla->execute([':idOrla' => $idOrla]);

        $deleteOrla = $this->sql->prepare('DELETE FROM orla WHERE id = :idOrla;');
        $deleteOrla->execute([':idOrla' => $idOrla]);
    }

    public function getClassByOrlaId($idOrla)
    {
        $query = <<<QUERY
        SELECT classGroup.className FROM classGroup, orla
        WHERE 
        classGroup.id = orla.idClassGroup
        AND orla.id=:idOrla;
        QUERY;
        $stm = $this->sql->prepare($query);
        $stm->execute([':idOrla' => $idOrla]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOrlaByClassId($idClass)
    {
        $query = <<<QUERY
        SELECT orla.id, orla.name, orla.visibility, orla.idCreator, orla.idClassGroup FROM orla, classGroup
        WHERE 
        classGroup.id = orla.idClassGroup
        AND classGroup.id=:idClass;
        QUERY;
        $stm = $this->sql->prepare($query);
        $stm->execute([':idClass' => $idClass]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function setOrlaPublicOn($idOrla)
    {
        $stm = $this->sql->prepare('UPDATE orla SET public = 1 WHERE id = :idOrla;');
        $stm->execute([":idOrla" => $idOrla]);
    }

    public function setOrlaPublicOff($idOrla)
    {
        $stm = $this->sql->prepare('UPDATE orla SET public = 0 WHERE id = :idOrla;');
        $stm->execute([":idOrla" => $idOrla]);
    }

    public function getPublicOrlesAndClass()
    {
        $stm = $this->sql->prepare('SELECT * FROM orla, classgroup WHERE orla.idClassGroup = classgroup.id AND public = 1;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function setOrlaVisibilityOn($idOrla)
    {
        $stm = $this->sql->prepare('UPDATE orla SET visibility = 1 WHERE id = :idOrla;');
        $stm->execute([":idOrla" => $idOrla]);
    }

    public function setOrlaVisibilityOff($idOrla)
    {
        $stm = $this->sql->prepare('UPDATE orla SET visibility = 0 WHERE id = :idOrla;');
        $stm->execute([":idOrla" => $idOrla]);
    }

}