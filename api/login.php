<?php

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/response.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    jsonResponse(405, false, "Method tidak diizinkan");
}

$input = json_decode(file_get_contents("php://input"), true);

$email = trim($input["email"] ?? "");
$password = trim($input["password"] ?? "");

if (!$email || !$password) {
    jsonResponse(422, false, "Email dan password wajib diisi");
}

$stmt = $pdo->prepare("SELECT id, name, email, password, token FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || $user["password"] !== $password) {
    jsonResponse(401, false, "Email atau password salah");
}

jsonResponse(200, true, "Login berhasil", [
    "user" => [
        "id" => (int) $user["id"],
        "name" => $user["name"],
        "email" => $user["email"]
    ],
    "token_type" => "Bearer",
    "access_token" => $user["token"]
]);