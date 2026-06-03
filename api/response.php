<?php

function jsonResponse($statusCode, $status, $message, $data = null)
{
    http_response_code($statusCode);
    header("Content-Type: application/json; charset=UTF-8");

    echo json_encode([
        "status" => $status,
        "message" => $message,
        "data" => $data
    ], JSON_PRETTY_PRINT);

    exit;
}