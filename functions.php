<?php

function responseJson($reponse = [], $statusCode = 200) {
    header('Content-Type: application/json');
    http_response_code($statusCode);
    echo json_encode($reponse);
    exit;
}