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

    public function getClasses() {
        $stm = $this->sql->prepare('SELECT * FROM classgroup;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getActiveClasses() {
        $stm = $this->sql->prepare('SELECT * FROM classgroup WHERE state = 1;');
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getClass($id) {
        $stm = $this->sql->prepare('SELECT * FROM classgroup WHERE id = :id;');
        $stm->execute([':id' => $id]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function editClass($id, $newState) {
        $stm = $this->sql->prepare('UPDATE classgroup SET state = :newState WHERE id = :id;');
        $stm->execute([':id' => $id, ':newState' => $newState]);
    }
    
    public function searchTeacherClassAjax($query)
{
    $stm = $this->sql->prepare('SELECT * FROM users WHERE name LIKE :query AND role = 2;');
    $query = "{$query}%";
    $stm->execute([':query' => $query]);
    return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
}

public function searchStudentClassAjax($query)
{
    $stm = $this->sql->prepare('SELECT * FROM users u 
    LEFT JOIN users_classgroup c ON u.id = c.idUser
    WHERE (u.role = 1 AND c.idUser IS NULL AND u.name LIKE :query);');
    $query = "{$query}%";
    $stm->execute([':query' => $query]);
    return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
}






public function addUserClass($userIds, $classId) {
    $stmt = $this->sql->prepare('INSERT INTO users_classgroup (idUser, idGroupClass) VALUES (:userId, :classId);');

    foreach ($userIds as $userId) {
        $stmt->execute([':userId' => $userId, ':classId' => $classId]);
    }
}

public function deleteUserClass($userIds, $classId) {
    $stmt = $this->sql->prepare('DELETE FROM users_classgroup WHERE idUser = :userId AND idGroupClass = :classId');

    foreach ($userIds as $userId) {
        $stmt->execute([':userId' => $userId, ':classId' => $classId]);
    }
}



public function getUsersByClassId($classId)
{
    $stm = $this->sql->prepare('SELECT u.* FROM users u
                                JOIN users_classgroup uc ON u.id = uc.idUser
                                WHERE uc.idGroupClass = :classId;');
    $stm->execute([':classId' => $classId]);
    return $results = $stm->fetchAll(\PDO::FETCH_ASSOC);
}

/**
 * [addClass description]
 *
 * @param   [type]  $className  [$className description]
 *
 * @return  [type]              [return description]
 */
public function addClass($className) {
    $stmt = $this->sql->prepare('INSERT INTO classgroup (className) VALUES (:className);');

    $stmt->execute([':className' => $className]);
    
}




}