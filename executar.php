<?php 

require_once __DIR__ . '/bootstrap.php';

use Src\Banco;

if (!isset($_REQUEST['databases']) || empty($_REQUEST['databases'])) {
    responseJson([
        "retorno" => false,
        "mensagem" => "Banco de dados não informado!"
    ], 200);
}


if (!isset($_REQUEST['query']) || empty($_REQUEST['query'])) {
    responseJson([
        "retorno" => false,
        "mensagem" => "Consulta não informada!"
    ], 200);
}

$dataBases = is_array($_REQUEST['databases']) ? $_REQUEST['databases'] : [$_REQUEST['databases']];
$query = $_REQUEST['query'];

if (strpos(strtolower($query), 'select') !== false) {
    if (strpos(strtolower($query), 'limit') === false) {
        $query = str_replace(';', "", $query);
        $query = $query . " limit 20;";
    }
}

$retorno = [
    'retorno' => true,
    'mensagem' => [],
    'dbstatus' => []
];

foreach ($dataBases as $database) {
    try {
        $banco = new Banco($database);
        $result = $banco->query($query);
        if ($result) {
            $retorno['dbstatus'][$database] = true;
            $retorno['mensagem'][$database] = [];

            if (strpos(strtolower($query), 'select') === false) {
                $rowAfffected = $result->rowCount();
                if ($rowAfffected){
                    $retorno['mensagem'][$database][] = ["Resultado" => "<span class='fa fa-check'></span> Success: $rowAfffected row(s) affected."];
                } else {
                    $retorno['mensagem'][$database][] = ["Resultado" => "<span class='fa fa-exclamation-triangle'></span> Success: 0 rows were affected."];
                }
            } else {   
                while($rs = $result->fetch(PDO::FETCH_ASSOC)){
                    $retorno['mensagem'][$database][] = $rs;
                }
            }

        } else {
            $retorno['dbstatus'][$database] = false;
            $retorno['mensagem'][$database] = [$banco->errorInfo()[2]];
        }
    } catch (\Exception $e) {
        $retorno['dbstatus'][$database] = true;
        $retorno['mensagem'] = [
            $database => [
                $e->getMessage()
            ]
        ];
        continue;
    }
}

responseJson($retorno, 200);
