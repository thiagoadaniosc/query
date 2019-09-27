<?php 

namespace Src;

use PDO;

class Banco extends PDO
{
    private $databases;

    public function searchDatabases()
    {
        $result = $this->query('show schemas');

        while ( $rs = $result->fetch(PDO::FETCH_ASSOC)) {
            $this->databases[] = $rs['Database'];
        }
    }

    public function getDatabases()
    {
        return $this->databases;
    }

}