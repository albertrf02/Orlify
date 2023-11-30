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
class Orla
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

    public function getAllOrles()
    {
    $stm = $this->sql->prepare('SELECT * FROM orla');
    $stm->execute();
    return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateOrla($id, $link, $visibility, $format, $creationDate)
    {
    $stm = $this->sql->prepare('UPDATE orla SET link = :link, visibility = :visibility, format = :format, creation_date = :creationDate WHERE id = :id;');
    $stm->execute([
        ':id' => $id,
        ':link' => $link,
        ':visibility' => $visibility,
        ':format' => $format,
        ':creationDate' => $creationDate
    ]);
    }

}