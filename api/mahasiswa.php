<?php

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/response.php";
require_once __DIR__ . "/auth.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    exit;
}

$currentUser = requireBearerToken($pdo);

$method = $_SERVER["REQUEST_METHOD"];
$id = $_GET["id"] ?? null;
$search = $_GET["search"] ?? null;

switch ($method) {
    case "GET":
        if ($id) {
            getMahasiswaById($pdo, $id);
        } elseif ($search) {
            searchMahasiswa($pdo, $search);
        } else {
            getAllMahasiswa($pdo);
        }
        break;

    case "POST":
        createMahasiswa($pdo);
        break;

    case "PUT":
        if (!$id) {
            jsonResponse(400, false, "Parameter id wajib dikirim");
        }

        updateMahasiswa($pdo, $id);
        break;

    case "DELETE":
        if (!$id) {
            jsonResponse(400, false, "Parameter id wajib dikirim");
        }

        deleteMahasiswa($pdo, $id);
        break;

    default:
        jsonResponse(405, false, "Method tidak diizinkan");
}

function getAllMahasiswa($pdo)
{
    $stmt = $pdo->query("SELECT * FROM mahasiswa ORDER BY id DESC");
    $data = $stmt->fetchAll();

    jsonResponse(200, true, "Data mahasiswa berhasil diambil", $data);
}

function searchMahasiswa($pdo, $keyword)
{
    $keyword = "%" . trim($keyword) . "%";

    $stmt = $pdo->prepare("
        SELECT * FROM mahasiswa
        WHERE nama LIKE ?
        OR nim LIKE ?
        OR prodi LIKE ?
        OR email LIKE ?
        ORDER BY id DESC
    ");

    $stmt->execute([$keyword, $keyword, $keyword, $keyword]);
    $data = $stmt->fetchAll();

    jsonResponse(200, true, "Hasil pencarian mahasiswa berhasil diambil", $data);
}

function getMahasiswaById($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM mahasiswa WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    if (!$data) {
        jsonResponse(404, false, "Data mahasiswa tidak ditemukan");
    }

    jsonResponse(200, true, "Detail mahasiswa berhasil diambil", $data);
}

function createMahasiswa($pdo)
{
    $input = json_decode(file_get_contents("php://input"), true);

    $nim = trim($input["nim"] ?? "");
    $nama = trim($input["nama"] ?? "");
    $prodi = trim($input["prodi"] ?? "");
    $angkatan = $input["angkatan"] ?? "";
    $email = trim($input["email"] ?? "");
    $alamat = trim($input["alamat"] ?? "");
    $noHp = trim($input["no_hp"] ?? "");

    validateMahasiswaInput($nim, $nama, $prodi, $angkatan, $email);

    try {
        $stmt = $pdo->prepare("
            INSERT INTO mahasiswa (nim, nama, prodi, angkatan, email, alamat, no_hp)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $nim,
            $nama,
            $prodi,
            $angkatan,
            $email,
            $alamat,
            $noHp
        ]);

        jsonResponse(201, true, "Mahasiswa berhasil ditambahkan", [
            "id" => (int) $pdo->lastInsertId(),
            "nim" => $nim,
            "nama" => $nama,
            "prodi" => $prodi,
            "angkatan" => (int) $angkatan,
            "email" => $email,
            "alamat" => $alamat,
            "no_hp" => $noHp
        ]);

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            jsonResponse(409, false, "NIM sudah digunakan");
        }

        jsonResponse(500, false, "Gagal menambahkan mahasiswa", $e->getMessage());
    }
}

function updateMahasiswa($pdo, $id)
{
    $input = json_decode(file_get_contents("php://input"), true);

    $nim = trim($input["nim"] ?? "");
    $nama = trim($input["nama"] ?? "");
    $prodi = trim($input["prodi"] ?? "");
    $angkatan = $input["angkatan"] ?? "";
    $email = trim($input["email"] ?? "");
    $alamat = trim($input["alamat"] ?? "");
    $noHp = trim($input["no_hp"] ?? "");

    validateMahasiswaInput($nim, $nama, $prodi, $angkatan, $email);

    $check = $pdo->prepare("SELECT id FROM mahasiswa WHERE id = ?");
    $check->execute([$id]);

    if (!$check->fetch()) {
        jsonResponse(404, false, "Data mahasiswa tidak ditemukan");
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE mahasiswa
            SET nim = ?, nama = ?, prodi = ?, angkatan = ?, email = ?, alamat = ?, no_hp = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $nim,
            $nama,
            $prodi,
            $angkatan,
            $email,
            $alamat,
            $noHp,
            $id
        ]);

        jsonResponse(200, true, "Mahasiswa berhasil diperbarui", [
            "id" => (int) $id,
            "nim" => $nim,
            "nama" => $nama,
            "prodi" => $prodi,
            "angkatan" => (int) $angkatan,
            "email" => $email,
            "alamat" => $alamat,
            "no_hp" => $noHp
        ]);

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            jsonResponse(409, false, "NIM sudah digunakan oleh mahasiswa lain");
        }

        jsonResponse(500, false, "Gagal memperbarui mahasiswa", $e->getMessage());
    }
}

function deleteMahasiswa($pdo, $id)
{
    $check = $pdo->prepare("SELECT id FROM mahasiswa WHERE id = ?");
    $check->execute([$id]);

    if (!$check->fetch()) {
        jsonResponse(404, false, "Data mahasiswa tidak ditemukan");
    }

    $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE id = ?");
    $stmt->execute([$id]);

    jsonResponse(200, true, "Mahasiswa berhasil dihapus", [
        "id" => (int) $id
    ]);
}

function validateMahasiswaInput($nim, $nama, $prodi, $angkatan, $email)
{
    if (!$nim || !$nama || !$prodi || !$angkatan || !$email) {
        jsonResponse(422, false, "NIM, nama, prodi, angkatan, dan email wajib diisi");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        jsonResponse(422, false, "Format email tidak valid");
    }

    if (!is_numeric($angkatan)) {
        jsonResponse(422, false, "Angkatan harus berupa angka");
    }

    if ((int) $angkatan < 2020 || (int) $angkatan > 2026) {
        jsonResponse(422, false, "Angkatan hanya boleh antara 2020 sampai 2026");
    }
}