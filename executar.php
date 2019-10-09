<?php 

require_once __DIR__ . '/bootstrap.php';

use Src\Banco;

$dataBases = $_REQUEST['databases'];
$query = $_REQUEST['query'];
$retorno = [
    'retorno' => false,
    'mensagem' => 'Ocorreu um erro'
];

foreach ($dataBases as $database) {
    $banco = new Banco($database);
    $result = $banco->query($query);
    if ($result) {
        $retorno['retorno'] = true;
        $retorno['mensagem'] = [];

        while($rs = $result->fetch(PDO::FETCH_ASSOC)){
            $retorno['mensagem'][] = $rs;
        }
    }
}

header('Content-Type: application/json');
echo json_encode($retorno);