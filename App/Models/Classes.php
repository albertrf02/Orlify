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
class Classes
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
     * Obté les classes des de la base de dades.
     *
     * @return array Dades de les classes en forma d'array.
     */
    public function getClasses()
    {
        $stm = $this->sql->prepare('SELECT * FROM classgroup;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obté les classes actives des de la base de dades.
     *
     * @return array Dades de les classes actives en forma d'array.
     */
    public function getActiveClasses()
    {
        $stm = $this->sql->prepare('SELECT * FROM classgroup WHERE state = 1;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Obté les dades d'una classe específica a partir del seu identificador.
     *
     * @param int $id Identificador de la classe que es vol obtenir.
     *
     * @return array Dades de la classe en forma d'array.
     */
    public function getClass($id)
    {
        $stm = $this->sql->prepare('SELECT * FROM classgroup WHERE id = :id;');
        $stm->execute([':id' => $id]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Modifica l'estat d'una classe específica a partir del seu identificador.
     *
     * @param int $id Identificador de la classe que es vol modificar.
     * @param int $newState Nou estat que es vol assignar a la classe.
     *
     * @return void
     */
    public function editClass($id, $newState)
    {
        $stm = $this->sql->prepare('UPDATE classgroup SET state = :newState WHERE id = :id;');
        $stm->execute([':id' => $id, ':newState' => $newState]);
    }

    /**
     * Cerca professors a partir d'un fragment de nom mitjançant una crida AJAX.
     *
     * @param string $query Fragment de nom per a la cerca.
     *
     * @return array Dades dels professors trobats en forma d'array associatiu.
     */
    public function searchTeacherClassAjax($query)
    {
        $stm = $this->sql->prepare('SELECT * FROM users WHERE name LIKE :query AND role = 2;');
        $query = "{$query}%";
        $stm->execute([':query' => $query]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Cerca estudiants a partir d'un fragment de nom mitjançant una crida AJAX.
     *
     * @param string $query Fragment de nom per a la cerca.
     *
     * @return array Dades dels estudiants trobats en forma d'array.
     */
    public function searchStudentClassAjax($query)
    {
        $stm = $this->sql->prepare('SELECT * FROM users u 
    LEFT JOIN users_classgroup c ON u.id = c.idUser
    WHERE (u.role = 1 AND c.idUser IS NULL AND u.name LIKE :query);');
        $query = "{$query}%";
        $stm->execute([':query' => $query]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Afegeix usuaris a una classe específica mitjançant les seves identificacions d'usuari.
     *
     * @param array $userIds Array d'identificacions d'usuari que es volen afegir a la classe.
     * @param int $classId Identificació de la classe a la qual es volen afegir els usuaris.
     *
     * @return void
     */
    public function addUserClass($userIds, $classId)
    {
        $stmt = $this->sql->prepare('INSERT INTO users_classgroup (idUser, idGroupClass) VALUES (:userId, :classId);');

        foreach ($userIds as $userId) {
            $stmt->execute([':userId' => $userId, ':classId' => $classId]);
        }
    }

    /**
     * Elimina usuaris d'una classe específica mitjançant les seves identificacions d'usuari.
     *
     * @param array $userIds Array d'identificacions d'usuari que es volen eliminar de la classe.
     * @param int $classId Identificació de la classe de la qual es volen eliminar els usuaris.
     *
     * @return void
     */
    public function deleteUserClass($userIds, $classId)
    {
        $stmt = $this->sql->prepare('DELETE FROM users_classgroup WHERE idUser = :userId AND idGroupClass = :classId');

        foreach ($userIds as $userId) {
            $stmt->execute([':userId' => $userId, ':classId' => $classId]);
        }
    }

    /**
     * Obté les classes associades a un usuari a partir de la seva identificació.
     *
     * @param int $id Identificació de l'usuari per al qual es volen obtenir les classes associades.
     *
     * @return array Dades de les classes associades a l'usuari en forma d'array.
     */
    public function getClassByUser($id)
    {
        $stm = $this->sql->prepare("SELECT u.id, u.username, uc.idGroupClass, cg.className, cg.state FROM users u JOIN users_classgroup uc ON u.id = uc.idUser JOIN classgroup cg ON uc.idGroupClass = cg.id WHERE u.id = :userId;");
        $stm->execute([':userId' => $id]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Obté els usuaris associats a una classe específica a partir de la seva identificació.
     *
     * @param int $idClass Identificació de la classe per a la qual es volen obtenir els usuaris associats.
     *
     * @return array Dades dels usuaris associats a la classe en forma d'array.
     */
    public function getUsersByClass($idClass)
    {
        $stm = $this->sql->prepare("SELECT u.id, u.name, u.surname, u.username, u.email 
        FROM users u 
        JOIN users_classgroup uc ON u.id = uc.idUser 
        WHERE uc.idGroupClass = :idClass AND u.role != 2;
        ");
        $stm->execute([':idClass' => $idClass]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * Obté els usuaris associats a una classe específica a partir de la seva identificació de classe.
     *
     * @param int $classId Identificació de la classe per a la qual es volen obtenir els usuaris associats.
     *
     * @return array Dades dels usuaris associats a la classe en forma d'array.
     */
    public function getUsersByClassId($classId)
    {
        $stm = $this->sql->prepare('SELECT u.* FROM users u
                                JOIN users_classgroup uc ON u.id = uc.idUser
                                WHERE uc.idGroupClass = :classId;');
        $stm->execute([':classId' => $classId]);
        return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Afegeix una nova classe a la base de dades.
     *
     * @param string $className Nom de la nova classe a afegir.
     *
     * @return void
     */
    public function addClass($className)
    {
        $stmt = $this->sql->prepare('INSERT INTO classgroup (className) VALUES (:className);');

        $stmt->execute([':className' => $className]);

    }
}