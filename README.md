# Praktikum REST API PHP MySQL dengan RapiDoc

Repository ini berisi materi praktikum untuk mempelajari pembuatan REST API sederhana menggunakan PHP dan MySQL, kemudian mendokumentasikannya menggunakan OpenAPI Specification dan RapiDoc.

Materi ini dirancang untuk pembelajaran mahasiswa pada topik Web Service, REST API, HTTP Request, CRUD, Bearer Token, dan dokumentasi API interaktif.

## Fitur Praktikum

Aplikasi praktikum ini memiliki beberapa fitur utama:

1. Materi pengantar HTTP Request.
2. REST API sederhana menggunakan PHP native.
3. Database MySQL untuk menyimpan data mahasiswa.
4. Operasi CRUD data mahasiswa.
5. Endpoint login sederhana.
6. Autentikasi menggunakan Bearer Token.
7. Dokumentasi API menggunakan file `openapi.json`.
8. Tampilan dokumentasi interaktif menggunakan RapiDoc.
9. Halaman pembelajaran HTML CSS yang responsif dan akademik.
10. Pengujian API langsung dari browser menggunakan Fetch API.

## Teknologi yang Digunakan

- HTML
- CSS
- JavaScript
- PHP Native
- MySQL
- PDO
- OpenAPI 3.0
- RapiDoc
- XAMPP atau Laragon

## Struktur Folder

```text
rapidoc-praktikum/
│
├── index.html
├── style.css
├── app.js
├── openapi.json
│
└── api/
    ├── config.php
    ├── response.php
    ├── auth.php
    ├── login.php
    └── mahasiswa.php
```

## Tujuan Pembelajaran

Setelah mengikuti praktikum ini, mahasiswa diharapkan mampu:

1. Menjelaskan konsep dasar HTTP Request dan HTTP Response.
2. Membedakan fungsi method GET, POST, PUT, dan DELETE.
3. Membuat endpoint REST API sederhana menggunakan PHP.
4. Menghubungkan PHP dengan database MySQL menggunakan PDO.
5. Membuat operasi CRUD pada data mahasiswa.
6. Mengamankan endpoint API menggunakan Bearer Token.
7. Menulis dokumentasi API menggunakan format OpenAPI.
8. Menampilkan dokumentasi API menggunakan RapiDoc.
9. Menguji endpoint API melalui dokumentasi interaktif.

## Persyaratan Sistem

Sebelum menjalankan project ini, pastikan perangkat sudah memiliki:

1. XAMPP atau Laragon.
2. PHP versi 7.4 atau lebih baru.
3. MySQL atau MariaDB.
4. Browser modern seperti Chrome, Edge, atau Firefox.
5. Text editor seperti Visual Studio Code.

## Cara Instalasi

### 1. Clone Repository

Clone repository ini ke folder lokal.

```bash
git clone https://github.com/username/rapidoc-praktikum.git
```

Ganti `username` dengan username GitHub Anda.

### 2. Pindahkan Folder ke Web Server Lokal

Jika menggunakan XAMPP, letakkan folder project di:

```text
C:/xampp/htdocs/rapidoc-praktikum
```

Jika menggunakan Laragon, letakkan folder project di:

```text
C:/laragon/www/rapidoc-praktikum
```

### 3. Aktifkan Apache dan MySQL

Buka XAMPP Control Panel atau Laragon, lalu aktifkan:

```text
Apache
MySQL
```

### 4. Buat Database

Buka phpMyAdmin melalui browser:

```text
http://localhost/phpmyadmin
```

Buat database baru dengan nama:

```text
praktikum_rapidoc
```

Kemudian jalankan SQL berikut:

```sql
CREATE DATABASE IF NOT EXISTS praktikum_rapidoc
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE praktikum_rapidoc;

DROP TABLE IF EXISTS mahasiswa;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    token VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(30) NOT NULL UNIQUE,
    nama VARCHAR(120) NOT NULL,
    prodi VARCHAR(100) NOT NULL,
    angkatan INT NOT NULL,
    email VARCHAR(120) NOT NULL,
    alamat TEXT NULL,
    no_hp VARCHAR(30) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (name, email, password, token)
VALUES (
    'Admin Praktikum',
    'admin@kampus.test',
    '123456',
    'praktikum-token-123'
);

INSERT INTO mahasiswa (nim, nama, prodi, angkatan, email, alamat, no_hp)
VALUES
('230101001', 'Andi Pratama', 'Informatika', 2023, 'andi@kampus.test', 'Purwokerto', '081234567001'),
('230101002', 'Siti Aminah', 'Sistem Informasi', 2023, 'siti@kampus.test', 'Banyumas', '081234567002'),
('230101003', 'Budi Santoso', 'Teknologi Informasi', 2024, 'budi@kampus.test', 'Purbalingga', '081234567003');
```

### 5. Sesuaikan Konfigurasi Database

Buka file:

```text
api/config.php
```

Pastikan konfigurasi database sesuai dengan server lokal Anda.

```php
$host = "localhost";
$dbname = "praktikum_rapidoc";
$username = "root";
$password = "";
```

Jika menggunakan password MySQL, isi variabel `$password`.

### 6. Jalankan Project

Buka browser dan akses:

```text
http://localhost/rapidoc-praktikum/
```

Jika menggunakan Laragon, URL dapat menyesuaikan konfigurasi virtual host.

## Akun Login Praktikum

Gunakan akun berikut untuk mencoba endpoint login.

```json
{
  "email": "admin@kampus.test",
  "password": "123456"
}
```

Jika login berhasil, API akan mengembalikan token berikut:

```text
praktikum-token-123
```

Token tersebut digunakan untuk mengakses endpoint mahasiswa.

## Cara Menggunakan Bearer Token

Endpoint mahasiswa membutuhkan header Authorization.

Format header:

```text
Authorization: Bearer praktikum-token-123
```

Contoh penggunaan pada Fetch API:

```javascript
fetch("api/mahasiswa.php", {
    method: "GET",
    headers: {
        "Authorization": "Bearer praktikum-token-123",
        "Accept": "application/json"
    }
});
```

## Daftar Endpoint API

| Method | Endpoint | Fungsi | Token |
|---|---|---|---|
| POST | `/api/login.php` | Login dan mendapatkan token | Tidak |
| GET | `/api/mahasiswa.php` | Mengambil semua data mahasiswa | Ya |
| GET | `/api/mahasiswa.php?search=andi` | Mencari data mahasiswa | Ya |
| GET | `/api/mahasiswa.php?id=1` | Mengambil detail mahasiswa | Ya |
| POST | `/api/mahasiswa.php` | Menambahkan data mahasiswa | Ya |
| PUT | `/api/mahasiswa.php?id=1` | Memperbarui data mahasiswa | Ya |
| DELETE | `/api/mahasiswa.php?id=1` | Menghapus data mahasiswa | Ya |

## Contoh Request Login

```http
POST /api/login.php
Content-Type: application/json
```

Body:

```json
{
  "email": "admin@kampus.test",
  "password": "123456"
}
```

Contoh response:

```json
{
  "status": true,
  "message": "Login berhasil",
  "data": {
    "user": {
      "id": 1,
      "name": "Admin Praktikum",
      "email": "admin@kampus.test"
    },
    "token_type": "Bearer",
    "access_token": "praktikum-token-123"
  }
}
```

## Contoh Request Tambah Mahasiswa

```http
POST /api/mahasiswa.php
Content-Type: application/json
Authorization: Bearer praktikum-token-123
```

Body:

```json
{
  "nim": "230101004",
  "nama": "Dewi Lestari",
  "prodi": "Informatika",
  "angkatan": 2024,
  "email": "dewi@kampus.test",
  "alamat": "Banjarnegara",
  "no_hp": "081234567004"
}
```

## Dokumentasi API dengan RapiDoc

Project ini menggunakan RapiDoc untuk menampilkan dokumentasi API secara interaktif.

File dokumentasi API berada pada:

```text
openapi.json
```

RapiDoc akan membaca file tersebut dan menampilkan daftar endpoint, parameter, request body, response, serta fitur Try API.

Untuk mencoba endpoint melalui RapiDoc:

1. Buka halaman utama project.
2. Masuk ke bagian Dokumentasi API dengan RapiDoc.
3. Klik tombol Authorize.
4. Masukkan token:

```text
praktikum-token-123
```

5. Pilih endpoint yang ingin diuji.
6. Klik Try.
7. Jalankan request.

## Materi HTTP Request

Pada halaman utama, mahasiswa juga mempelajari struktur dasar HTTP Request, yaitu:

1. Method.
2. Endpoint URL.
3. Header.
4. Body.
5. Response.
6. Status code.

Contoh struktur HTTP Request:

```http
POST /api/mahasiswa.php HTTP/1.1
Host: localhost
Content-Type: application/json
Authorization: Bearer praktikum-token-123

{
  "nim": "230101004",
  "nama": "Dewi Lestari",
  "prodi": "Informatika",
  "angkatan": 2024,
  "email": "dewi@kampus.test"
}
```

## HTTP Status Code yang Digunakan

| Status Code | Arti |
|---|---|
| 200 | Request berhasil diproses |
| 201 | Data baru berhasil dibuat |
| 400 | Request tidak lengkap |
| 401 | Token tidak dikirim atau tidak valid |
| 404 | Data tidak ditemukan |
| 405 | Method tidak diizinkan |
| 409 | Data duplikat |
| 422 | Validasi gagal |
| 500 | Kesalahan server atau database |

## Catatan Keamanan

Project ini dibuat untuk tujuan pembelajaran. Beberapa bagian masih disederhanakan, misalnya:

1. Password masih disimpan dalam bentuk plain text.
2. Token masih bersifat statis.
3. Belum menggunakan JWT.
4. Belum terdapat refresh token.
5. Belum terdapat role-based access control.

Pada sistem produksi, gunakan:

1. `password_hash()` dan `password_verify()` untuk password.
2. Token dinamis atau JWT.
3. HTTPS.
4. Validasi input yang lebih ketat.
5. Rate limiting.
6. Sanitasi dan logging.
7. Manajemen konfigurasi menggunakan `.env`.

## Ide Pengembangan Lanjutan

Mahasiswa dapat mengembangkan project ini dengan beberapa fitur berikut:

1. Mengubah token statis menjadi token dinamis.
2. Menggunakan JWT untuk autentikasi.
3. Menambahkan fitur pagination.
4. Menambahkan fitur upload foto mahasiswa.
5. Menambahkan validasi nomor HP.
6. Menambahkan tabel program studi.
7. Menambahkan relasi antara mahasiswa dan program studi.
8. Menambahkan role admin dan operator.
9. Menambahkan dokumentasi response schema yang lebih lengkap.
10. Mengubah endpoint menjadi lebih RESTful, misalnya `/api/mahasiswa/1`.

## Lisensi

Project ini dapat digunakan untuk pembelajaran, praktikum, dan pengembangan materi kuliah.

## Penulis

Materi praktikum ini dibuat untuk pembelajaran REST API, HTTP Request, PHP MySQL, Bearer Token, OpenAPI, dan RapiDoc.
