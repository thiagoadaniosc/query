<?php 

require_once __DIR__ . '/bootstrap.php';

use Src\Banco;

$dataBases = $_REQUEST['databases'];
$query = $_REQUEST['query'];

var_dump($query, $dataBases);

foreach ($dataBases as $database) {
    $banco = new Banco($database);
    $result = $banco->query($query);
    while($rs = $result->fetch(PDO::FETCH_ASSOC)){
        var_dump($rs);
    }
}