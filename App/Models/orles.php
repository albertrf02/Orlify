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
        $stm = $this->sql->prepare('INSERT INTO orla (name, visibility, idCreator, idClassGroup) VALUES (:name, :visibility, :idCreator, :idClassGroup);');
        $stm->execute([':name' => $name, ':visibility' => 0, ':idCreator' => $idCreator, ':idClassGroup' => $group]);

    }

    public function getOrles()
    {
        $stm = $this->sql->prepare('SELECT * FROM orla;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getUserFromGroupInOrla($idOrla, $idGroup)
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
            FROM 
                users u
            JOIN 
                users_classGroup ucg ON u.id = ucg.idUser
            LEFT JOIN 
                user_orla uo ON u.id = uo.idUser AND uo.idOrla = :idOrla
            LEFT JOIN 
                photography p ON u.id = p.idUser AND p.defaultPhoto = TRUE
            WHERE 
                ucg.idGroupClass = :idGroup AND u.role IN (1,2);
        QUERY;
        $stm = $this->sql->prepare($query);
        $stm->execute([':idOrla' => $idOrla, ':idGroup' => $idGroup]);
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

}