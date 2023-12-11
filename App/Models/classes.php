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

    public function getClass($id) {
        $stm = $this->sql->prepare('SELECT * FROM classgroup WHERE id = :id;');
        $stm->execute([':id' => $id]);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function editClass($id, $newState) {
        $stm = $this->sql->prepare('UPDATE classgroup SET state = :newState WHERE id = :id;');
        $stm->execute([':id' => $id, ':newState' => $newState]);
    }
    


}