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

    /**
     * Crea una nova orla amb la informació proporcionada.
     *
     * @param string $name Nom de l'orla.
     * @param int $group Identificador del grup de classe associat.
     * @param int $idCreator Identificador de l'usuari creador de l'orla.
     *
     * @return int Identificador de l'orla creada.
     */
    public function createOrla($name, $group, $idCreator)
    {
        $stm = $this->sql->prepare('INSERT INTO orla (name, visibility, public, idCreator, idClassGroup) VALUES (:name, :visibility, :public, :idCreator, :idClassGroup);');
        $stm->execute([':name' => $name, ':visibility' => 0, ':public' => 0, ':idCreator' => $idCreator, ':idClassGroup' => $group]);
        return $this->sql->lastInsertId();
    }

    /**
     * Obté totes les orles disponibles de la base de dades.
     *
     * @return array Un array amb la informació de totes les orles.
     */

    public function getOrles()
    {
        $stm = $this->sql->prepare('SELECT * FROM orla;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obté informació detallada dels usuaris associats a un grup d'una orla específica.
     *
     * @param int $idOrla L'identificador de la orla.
     * @return array Un array associatiu amb la informació dels usuaris.
     */
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
        INNER JOIN users_classgroup ucg ON u.id = ucg.idUser
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

    /**
     * Elimina les associacions d'usuaris amb una orla específica.
     *
     * @param int $idOrla L'identificador de la orla.
     */
    public function deleteUsersFromOrla($idOrla)
    {
        $stm = $this->sql->prepare('DELETE FROM user_orla WHERE idOrla = :idOrla;');
        $stm->execute([':idOrla' => $idOrla]);
    }

    /**
     * Afegeix usuaris a una orla específica.
     *
     * @param int   $idOrla    L'identificador de la orla.
     * @param array $usersOrla Un array d'identificadors d'usuaris per afegir a la orla.
     */
    public function addUsersToOrla($idOrla, $usersOrla)
    {
        $stm = $this->sql->prepare('INSERT INTO user_orla (idUser, idOrla) VALUES (:idUser, :idOrla);');
        foreach ($usersOrla as $userOrla) {
            $stm->execute([':idUser' => $userOrla, ':idOrla' => $idOrla]);
        }
    }

    /**
     * Obté les dades d'usuaris que pertanyen a una orla específica, incloent el nom, el cognom, el rol i el vincle a la fotografia.
     *
     * @param int $idOrla L'identificador de la orla.
     *
     * @return array Un array associatiu amb les dades dels usuaris.
     */
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

    /**
     * Elimina les dades relacionades amb una orla específica de les taules user_orla i orla.
     *
     * @param int $idOrla L'identificador de la orla a eliminar.
     */
    public function deleteOrla($idOrla)
    {
        $deleteUserOrla = $this->sql->prepare('DELETE FROM user_orla WHERE idOrla = :idOrla;');
        $deleteUserOrla->execute([':idOrla' => $idOrla]);

        $deleteOrla = $this->sql->prepare('DELETE FROM orla WHERE id = :idOrla;');
        $deleteOrla->execute([':idOrla' => $idOrla]);
    }

    /**
     * Obté el nom de la classe associada a una orla específica.
     *
     * @param int $idOrla L'identificador de la orla.
     * @return array Retorna un array amb les dades de la classe associada a la orla.
     */
    public function getClassByOrlaId($idOrla)
    {
        $query = <<<QUERY
        SELECT classgroup.className FROM classgroup, orla
        WHERE 
        classgroup.id = orla.idClassGroup
        AND orla.id=:idOrla;
        QUERY;
        $stm = $this->sql->prepare($query);
        $stm->execute([':idOrla' => $idOrla]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obté les orles associades a una classe específica.
     *
     * @param int $idClass L'identificador de la classe.
     * @return array Retorna un array amb les orles associades a la classe.
     */
    public function getOrlaByClassId($idClass)
    {
        $query = <<<QUERY
        SELECT orla.id, orla.name, orla.visibility, orla.idCreator, orla.idClassGroup FROM orla, classgroup
        WHERE 
        classgroup.id = orla.idClassGroup
        AND classgroup.id=:idClass;
        QUERY;
        $stm = $this->sql->prepare($query);
        $stm->execute([':idClass' => $idClass]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Activa la visibilitat pública d'una orla específica.
     *
     * @param int $idOrla L'identificador de l'orla.
     */
    public function setOrlaPublicOn($idOrla)
    {
        $stm = $this->sql->prepare('UPDATE orla SET public = 1 WHERE id = :idOrla;');
        $stm->execute([":idOrla" => $idOrla]);
    }

    /**
     * Desactiva la publicació d'una orla específica.
     *
     * @param int $idOrla L'identificador de l'orla.
     */
    public function setOrlaPublicOff($idOrla)
    {
        $stm = $this->sql->prepare('UPDATE orla SET public = 0 WHERE id = :idOrla;');
        $stm->execute([":idOrla" => $idOrla]);
    }

    /**
     * Obté totes les orles públiques juntament amb la informació de les classes associades.
     *
     * @return array Les dades de les orles públiques amb informació de les classes.
     */
    public function getPublicOrlesAndClass()
    {
        $stm = $this->sql->prepare('SELECT * FROM orla, classgroup WHERE orla.idClassGroup = classgroup.id AND public = 1;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Activa la visibilitat d'una orla específica.
     *
     * @param int $idOrla L'identificador de l'orla.
     */
    public function setOrlaVisibilityOn($idOrla)
    {
        $stm = $this->sql->prepare('UPDATE orla SET visibility = 1 WHERE id = :idOrla;');
        $stm->execute([":idOrla" => $idOrla]);
    }

    /**
     * Desactiva la visibilitat d'una orla específica.
     *
     * @param int $idOrla L'identificador de l'orla.
     */
    public function setOrlaVisibilityOff($idOrla)
    {
        $stm = $this->sql->prepare('UPDATE orla SET visibility = 0 WHERE id = :idOrla;');
        $stm->execute([":idOrla" => $idOrla]);
    }

}