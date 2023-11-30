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


}