<?php

require_once __DIR__ . '/bootstrap.php';

use Src\Banco;

$banco = new Banco();
$banco->searchDatabases();

$dataBases = $banco->getDatabases();

require_once __DIR__ . '/home.php';