<?php

require_once __DIR__ . '/bootstrap.php';

use Src\Banco;

$banco = new Banco("mysql:host=18.228.87.193;dbname=mysql", 'root', 'root');
$banco->searchDatabases();

$dataBases = $banco->getDatabases();

require_once __DIR__ . '/home.php';