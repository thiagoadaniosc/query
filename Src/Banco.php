<?php 

namespace Src;

use PDO;

class Banco extends PDO
{
    private $databases;

    public function __construct($dbname = DB_NAME)
    {
        $host = DB_HOST;
        parent::__construct("mysql:host={$host};dbname={$dbname}", DB_USER, DB_PASSWORD);   
    }

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