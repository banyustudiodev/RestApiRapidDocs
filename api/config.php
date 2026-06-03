<?php

$host = "localhost";
$dbname = "praktikum_rapidoc";
$username = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    http_response_code(500);
    header("Content-Type: application/json; charset=UTF-8");

    echo json_encode([
        "status" => false,
        "message" => "Koneksi database gagal",
        "error" => $e->getMessage()
    ], JSON_PRETTY_PRINT);

    exit;
}