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

# Memahami dan Membuat openapi.json

Bagian ini menjelaskan fungsi, struktur, dan cara membuat file `openapi.json` pada praktikum REST API PHP MySQL dengan RapiDoc.

## 1. Apa itu openapi.json?

File `openapi.json` adalah file dokumentasi API yang ditulis menggunakan standar OpenAPI Specification.

File ini bukan file PHP, bukan database, dan bukan logic program. File ini berfungsi untuk menjelaskan API yang sudah dibuat agar dapat dibaca oleh manusia dan oleh tools dokumentasi seperti RapiDoc.

Secara sederhana:

```text
PHP API        = tempat logic program berjalan
MySQL          = tempat data disimpan
openapi.json   = tempat dokumentasi API ditulis
RapiDoc        = alat untuk menampilkan openapi.json menjadi dokumentasi interaktif
```

Dengan kata lain, `openapi.json` adalah peta API. Jika backend memiliki endpoint `/api/mahasiswa.php`, maka endpoint tersebut harus dijelaskan di dalam `openapi.json`.

## 2. Mengapa openapi.json Dibutuhkan?

Tanpa dokumentasi, pengguna API harus menebak beberapa hal berikut:

1. Endpoint apa saja yang tersedia.
2. Method apa yang harus digunakan.
3. Parameter apa yang perlu dikirim.
4. Apakah endpoint membutuhkan token.
5. Bentuk request body seperti apa.
6. Bentuk response seperti apa.
7. Status code apa yang mungkin dikembalikan.

Dengan `openapi.json`, semua informasi tersebut ditulis secara rapi dan terstruktur.

## 3. Hubungan openapi.json dengan RapiDoc

Pada file `index.html`, terdapat kode berikut:

```html
<rapi-doc
    spec-url="openapi.json"
    render-style="read"
    theme="light"
    layout="row"
    allow-authentication="true"
    allow-try="true">
</rapi-doc>
```

Bagian yang paling penting adalah:

```html
spec-url="openapi.json"
```

Artinya, RapiDoc diperintahkan untuk membaca file `openapi.json`.

Setelah file tersebut dibaca, RapiDoc akan menampilkan:

1. Judul API.
2. Deskripsi API.
3. Daftar endpoint.
4. HTTP method.
5. Parameter.
6. Request body.
7. Response.
8. Skema autentikasi.
9. Tombol untuk mencoba request API.

## 4. Struktur Dasar openapi.json

Struktur dasar file `openapi.json` adalah sebagai berikut:

```json
{
  "openapi": "3.0.3",
  "info": {},
  "servers": [],
  "tags": [],
  "paths": {},
  "components": {}
}
```

Setiap bagian memiliki fungsi berbeda.

| Bagian | Fungsi |
|---|---|
| `openapi` | Menentukan versi OpenAPI yang digunakan |
| `info` | Menjelaskan informasi umum API |
| `servers` | Menentukan alamat dasar server API |
| `tags` | Mengelompokkan endpoint |
| `paths` | Menjelaskan daftar endpoint API |
| `components` | Menyimpan schema, security, dan komponen yang dipakai berulang |

## 5. Bagian openapi

```json
"openapi": "3.0.3"
```

Bagian ini menunjukkan versi OpenAPI yang digunakan.

Pada praktikum ini digunakan versi `3.0.3`.

## 6. Bagian info

```json
"info": {
  "title": "Praktikum REST API Mahasiswa",
  "description": "Dokumentasi REST API sederhana menggunakan PHP, MySQL, Bearer Token, dan RapiDoc.",
  "version": "1.0.0"
}
```

Bagian `info` berisi informasi umum tentang API.

| Properti | Fungsi |
|---|---|
| `title` | Judul dokumentasi API |
| `description` | Deskripsi singkat API |
| `version` | Versi dokumentasi API |

Bagian ini akan tampil di bagian atas dokumentasi RapiDoc.

## 7. Bagian servers

```json
"servers": [
  {
    "url": "http://localhost/rapidoc-praktikum/api",
    "description": "Local XAMPP Server"
  }
]
```

Bagian `servers` menunjukkan alamat dasar API.

Pada project ini, API berada di folder:

```text
http://localhost/rapidoc-praktikum/api
```

Jika di bagian `paths` ada endpoint:

```json
"/mahasiswa.php"
```

Maka URL lengkapnya menjadi:

```text
http://localhost/rapidoc-praktikum/api/mahasiswa.php
```

Rumusnya:

```text
server url + path endpoint = URL API lengkap
```

Contoh:

```text
http://localhost/rapidoc-praktikum/api + /mahasiswa.php
=
http://localhost/rapidoc-praktikum/api/mahasiswa.php
```

Kesalahan umum pada bagian ini adalah menulis `/api` dua kali.

Contoh yang salah:

```json
"servers": [
  {
    "url": "http://localhost/rapidoc-praktikum/api"
  }
],
"paths": {
  "/api/mahasiswa.php": {}
}
```

Jika `servers.url` sudah berisi `/api`, maka `paths` cukup menulis:

```json
"/mahasiswa.php"
```

## 8. Bagian tags

```json
"tags": [
  {
    "name": "Authentication",
    "description": "Endpoint untuk login dan mendapatkan token"
  },
  {
    "name": "Mahasiswa",
    "description": "Endpoint CRUD data mahasiswa"
  }
]
```

Bagian `tags` digunakan untuk mengelompokkan endpoint.

Pada praktikum ini endpoint dibagi menjadi dua kelompok:

| Tag | Isi |
|---|---|
| `Authentication` | Endpoint login |
| `Mahasiswa` | Endpoint CRUD mahasiswa |

Di tampilan RapiDoc, `tags` membantu dokumentasi terlihat lebih rapi.

## 9. Bagian paths

Bagian `paths` adalah bagian paling penting karena bagian ini menjelaskan endpoint apa saja yang tersedia.

Contoh:

```json
"paths": {
  "/login.php": {
    "post": {
      "tags": ["Authentication"],
      "summary": "Login pengguna"
    }
  },
  "/mahasiswa.php": {
    "get": {
      "tags": ["Mahasiswa"],
      "summary": "Mengambil semua data mahasiswa"
    },
    "post": {
      "tags": ["Mahasiswa"],
      "summary": "Menambahkan data mahasiswa"
    }
  }
}
```

Kode berikut:

```json
"/login.php"
```

berarti ada endpoint:

```text
http://localhost/rapidoc-praktikum/api/login.php
```

Kode berikut:

```json
"post"
```

berarti endpoint tersebut menggunakan HTTP method `POST`.

Jadi:

```json
"/login.php": {
  "post": {}
}
```

dibaca sebagai:

```text
POST /login.php
```

## 10. Cara Menulis Endpoint GET

Misalnya backend PHP memiliki endpoint:

```text
GET /api/mahasiswa.php
```

Maka di `openapi.json`, endpoint tersebut ditulis seperti ini:

```json
"/mahasiswa.php": {
  "get": {
    "tags": ["Mahasiswa"],
    "summary": "Mengambil semua data mahasiswa",
    "description": "Endpoint ini digunakan untuk mengambil semua data mahasiswa.",
    "security": [
      {
        "bearerAuth": []
      }
    ],
    "responses": {
      "200": {
        "description": "Data mahasiswa berhasil diambil"
      },
      "401": {
        "description": "Token tidak valid atau tidak dikirim"
      }
    }
  }
}
```

Penjelasan:

| Bagian | Fungsi |
|---|---|
| `/mahasiswa.php` | Nama endpoint |
| `get` | HTTP method |
| `tags` | Kelompok endpoint |
| `summary` | Ringkasan fungsi endpoint |
| `description` | Penjelasan endpoint |
| `security` | Menandakan endpoint butuh token |
| `responses` | Daftar kemungkinan response |

## 11. Cara Menulis Endpoint dengan Query Parameter

Misalnya endpoint detail mahasiswa menggunakan parameter:

```text
GET /api/mahasiswa.php?id=1
```

Maka OpenAPI-nya ditulis seperti ini:

```json
"/mahasiswa.php": {
  "get": {
    "tags": ["Mahasiswa"],
    "summary": "Mengambil data mahasiswa",
    "parameters": [
      {
        "name": "id",
        "in": "query",
        "required": false,
        "description": "ID mahasiswa",
        "schema": {
          "type": "integer"
        },
        "example": 1
      }
    ],
    "responses": {
      "200": {
        "description": "Data berhasil diambil"
      },
      "404": {
        "description": "Data tidak ditemukan"
      }
    }
  }
}
```

Penjelasan parameter:

| Properti | Fungsi |
|---|---|
| `name` | Nama parameter |
| `in` | Lokasi parameter |
| `required` | Apakah wajib dikirim |
| `description` | Penjelasan parameter |
| `schema` | Tipe data parameter |
| `example` | Contoh nilai parameter |

Bagian:

```json
"in": "query"
```

artinya parameter dikirim melalui URL setelah tanda tanya.

Contoh:

```text
/mahasiswa.php?id=1
```

Parameter `id` disebut query parameter.

## 12. Cara Menulis Request Body

Request body digunakan ketika client mengirim data ke server. Biasanya digunakan pada method:

```text
POST
PUT
PATCH
```

Contoh endpoint tambah mahasiswa:

```text
POST /api/mahasiswa.php
```

Client perlu mengirim data mahasiswa dalam format JSON:

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

Maka di OpenAPI ditulis:

```json
"requestBody": {
  "required": true,
  "content": {
    "application/json": {
      "schema": {
        "$ref": "#/components/schemas/MahasiswaRequest"
      },
      "example": {
        "nim": "230101004",
        "nama": "Dewi Lestari",
        "prodi": "Informatika",
        "angkatan": 2024,
        "email": "dewi@kampus.test",
        "alamat": "Banjarnegara",
        "no_hp": "081234567004"
      }
    }
  }
}
```

Penjelasan:

| Bagian | Fungsi |
|---|---|
| `requestBody` | Menjelaskan data yang dikirim client |
| `required: true` | Body wajib dikirim |
| `content` | Format data request |
| `application/json` | Data dikirim dalam format JSON |
| `schema` | Struktur data yang harus dikirim |
| `example` | Contoh data request |

## 13. Apa Maksud $ref?

Pada OpenAPI, sering muncul kode seperti ini:

```json
"$ref": "#/components/schemas/MahasiswaRequest"
```

Maksudnya adalah menggunakan schema yang sudah didefinisikan di bagian `components`.

Daripada menulis struktur data mahasiswa berulang-ulang di banyak endpoint, kita cukup membuat satu schema:

```json
"components": {
  "schemas": {
    "MahasiswaRequest": {
      "type": "object",
      "required": ["nim", "nama", "prodi", "angkatan", "email"],
      "properties": {
        "nim": {
          "type": "string",
          "example": "230101004"
        },
        "nama": {
          "type": "string",
          "example": "Dewi Lestari"
        },
        "prodi": {
          "type": "string",
          "example": "Informatika"
        },
        "angkatan": {
          "type": "integer",
          "example": 2024
        },
        "email": {
          "type": "string",
          "example": "dewi@kampus.test"
        }
      }
    }
  }
}
```

Lalu schema tersebut dipanggil menggunakan:

```json
"$ref": "#/components/schemas/MahasiswaRequest"
```

Analogi sederhananya:

```text
components/schemas = tempat membuat template data
$ref               = cara memanggil template data
```

## 14. Bagian components

Bagian `components` digunakan untuk menyimpan bagian yang akan dipakai berulang.

Contohnya:

1. Schema request.
2. Schema response.
3. Security scheme.
4. Parameter umum.
5. Header umum.

Pada praktikum ini, bagian `components` digunakan untuk dua hal:

```json
"components": {
  "securitySchemes": {},
  "schemas": {}
}
```

## 15. Bagian securitySchemes

Karena API mahasiswa menggunakan Bearer Token, maka kita perlu menjelaskan sistem autentikasinya di OpenAPI.

```json
"securitySchemes": {
  "bearerAuth": {
    "type": "http",
    "scheme": "bearer",
    "bearerFormat": "Token",
    "description": "Masukkan token: praktikum-token-123"
  }
}
```

Penjelasan:

| Properti | Fungsi |
|---|---|
| `bearerAuth` | Nama skema autentikasi |
| `type: http` | Autentikasi berbasis HTTP |
| `scheme: bearer` | Menggunakan Bearer Token |
| `bearerFormat` | Format token |
| `description` | Petunjuk untuk pengguna |

Setelah skema ini dibuat, endpoint yang membutuhkan token dapat diberi kode:

```json
"security": [
  {
    "bearerAuth": []
  }
]
```

Artinya endpoint tersebut harus diakses dengan header:

```text
Authorization: Bearer praktikum-token-123
```

## 16. Cara Membaca security pada Endpoint

Contoh:

```json
"/mahasiswa.php": {
  "get": {
    "security": [
      {
        "bearerAuth": []
      }
    ]
  }
}
```

Artinya:

```text
Endpoint GET /mahasiswa.php membutuhkan Bearer Token.
```

Jika bagian `security` tidak ditulis, maka endpoint tersebut dianggap tidak membutuhkan autentikasi.

Endpoint login tidak perlu Bearer Token karena endpoint login justru digunakan untuk mendapatkan token.

## 17. Cara Menulis Response

Setiap endpoint sebaiknya menjelaskan kemungkinan response.

Contoh:

```json
"responses": {
  "200": {
    "description": "Data mahasiswa berhasil diambil"
  },
  "401": {
    "description": "Token tidak valid atau tidak dikirim"
  },
  "404": {
    "description": "Data tidak ditemukan"
  }
}
```

Penjelasan:

| Status Code | Arti |
|---|---|
| `200` | Request berhasil |
| `201` | Data berhasil dibuat |
| `401` | Token salah atau tidak dikirim |
| `404` | Data tidak ditemukan |
| `422` | Validasi gagal |
| `500` | Kesalahan server |

Response ini tidak otomatis membuat logic PHP. Response hanya mendokumentasikan kemungkinan hasil yang dikembalikan oleh backend.

## 18. Alur Membuat openapi.json

Urutan paling mudah dalam membuat `openapi.json` adalah sebagai berikut.

### Langkah 1: Catat semua endpoint PHP

Contoh:

```text
POST   /api/login.php
GET    /api/mahasiswa.php
GET    /api/mahasiswa.php?id=1
POST   /api/mahasiswa.php
PUT    /api/mahasiswa.php?id=1
DELETE /api/mahasiswa.php?id=1
```

### Langkah 2: Tentukan base URL

Contoh:

```text
http://localhost/rapidoc-praktikum/api
```

Masukkan ke bagian:

```json
"servers": [
  {
    "url": "http://localhost/rapidoc-praktikum/api"
  }
]
```

### Langkah 3: Kelompokkan endpoint dengan tags

Contoh:

```text
Authentication
Mahasiswa
```

### Langkah 4: Tulis paths

Untuk setiap endpoint, tulis:

1. Path.
2. Method.
3. Summary.
4. Description.
5. Parameter jika ada.
6. Request body jika ada.
7. Security jika butuh token.
8. Response.

### Langkah 5: Buat schema data

Jika endpoint menerima body JSON, buat schema di:

```json
"components": {
  "schemas": {}
}
```

Contoh schema:

```json
"MahasiswaRequest": {
  "type": "object",
  "required": ["nim", "nama", "prodi", "angkatan", "email"],
  "properties": {
    "nim": {
      "type": "string"
    },
    "nama": {
      "type": "string"
    },
    "prodi": {
      "type": "string"
    },
    "angkatan": {
      "type": "integer"
    },
    "email": {
      "type": "string"
    }
  }
}
```

### Langkah 6: Buat securitySchemes jika API memakai token

```json
"securitySchemes": {
  "bearerAuth": {
    "type": "http",
    "scheme": "bearer"
  }
}
```

### Langkah 7: Hubungkan ke RapiDoc

Pastikan `index.html` memiliki:

```html
<rapi-doc spec-url="openapi.json"></rapi-doc>
```

## 19. Pola Berpikir Saat Membuat openapi.json

Gunakan pertanyaan berikut untuk setiap endpoint:

1. Endpoint-nya apa?
2. Method-nya apa?
3. Endpoint ini untuk apa?
4. Apakah endpoint ini butuh token?
5. Apakah endpoint ini punya parameter?
6. Apakah endpoint ini punya request body?
7. Format data yang dikirim apa?
8. Response suksesnya apa?
9. Response gagalnya apa?
10. Contoh request-nya seperti apa?

Contoh untuk endpoint tambah mahasiswa:

| Pertanyaan | Jawaban |
|---|---|
| Endpoint-nya apa? | `/mahasiswa.php` |
| Method-nya apa? | `POST` |
| Fungsinya apa? | Menambahkan data mahasiswa |
| Butuh token? | Ya |
| Punya parameter? | Tidak |
| Punya body? | Ya |
| Format body? | JSON |
| Response sukses? | `201 Created` |
| Response gagal? | `401`, `409`, `422`, `500` |

Dari jawaban tersebut, barulah ditulis menjadi format OpenAPI.

## 20. Contoh Minimal openapi.json

Berikut contoh paling sederhana:

```json
{
  "openapi": "3.0.3",
  "info": {
    "title": "API Mahasiswa",
    "version": "1.0.0"
  },
  "servers": [
    {
      "url": "http://localhost/rapidoc-praktikum/api"
    }
  ],
  "paths": {
    "/mahasiswa.php": {
      "get": {
        "summary": "Mengambil data mahasiswa",
        "responses": {
          "200": {
            "description": "Data berhasil diambil"
          }
        }
      }
    }
  }
}
```

Contoh di atas hanya mendokumentasikan satu endpoint:

```text
GET http://localhost/rapidoc-praktikum/api/mahasiswa.php
```

## 21. Contoh OpenAPI dengan Bearer Token

Jika endpoint membutuhkan token, tambahkan `components.securitySchemes`:

```json
{
  "openapi": "3.0.3",
  "info": {
    "title": "API Mahasiswa",
    "version": "1.0.0"
  },
  "servers": [
    {
      "url": "http://localhost/rapidoc-praktikum/api"
    }
  ],
  "paths": {
    "/mahasiswa.php": {
      "get": {
        "summary": "Mengambil data mahasiswa",
        "security": [
          {
            "bearerAuth": []
          }
        ],
        "responses": {
          "200": {
            "description": "Data berhasil diambil"
          },
          "401": {
            "description": "Token tidak valid"
          }
        }
      }
    }
  },
  "components": {
    "securitySchemes": {
      "bearerAuth": {
        "type": "http",
        "scheme": "bearer"
      }
    }
  }
}
```

## 22. Kesalahan Umum Saat Membuat openapi.json

Beberapa kesalahan yang sering terjadi:

1. Lupa memberi koma antar properti JSON.
2. Salah menulis path, misalnya `/api/mahasiswa.php` padahal `servers.url` sudah berisi `/api`.
3. Menulis method dengan huruf besar, misalnya `"GET"`, padahal sebaiknya ditulis `"get"`.
4. Lupa mendefinisikan `bearerAuth` di `components.securitySchemes`.
5. Menulis `$ref` ke schema yang belum dibuat.
6. Struktur kurung kurawal tidak seimbang.
7. File `openapi.json` tidak berada satu folder dengan `index.html`.
8. URL di `servers` tidak sesuai dengan folder project.
9. Request body tidak diberi `content.application/json`.
10. Parameter query tidak diberi `"in": "query"`.

## 23. Tips Validasi openapi.json

Sebelum digunakan di RapiDoc, pastikan:

1. File JSON valid.
2. Semua tanda koma benar.
3. Semua tanda kurung kurawal lengkap.
4. Semua `$ref` mengarah ke schema yang benar.
5. URL server sesuai dengan lokasi project.
6. Endpoint benar-benar ada di file PHP.
7. Method di dokumentasi sama dengan method di backend.

Jika RapiDoc tidak menampilkan dokumentasi, biasanya penyebabnya adalah:

1. File `openapi.json` tidak ditemukan.
2. Format JSON tidak valid.
3. Ada path atau schema yang salah.
4. RapiDoc tidak bisa membaca file karena URL salah.
5. Project tidak dijalankan melalui server lokal.

## 24. Kesimpulan tentang openapi.json

File `openapi.json` adalah dokumentasi formal untuk REST API.

Backend PHP tetap bertugas menjalankan logic program. Database MySQL tetap bertugas menyimpan data. OpenAPI hanya bertugas menjelaskan API. RapiDoc bertugas membaca OpenAPI dan menampilkannya menjadi dokumentasi interaktif.

Rumus sederhananya:

```text
API dibuat di PHP
API dijelaskan di openapi.json
openapi.json ditampilkan oleh RapiDoc
Mahasiswa mencoba API melalui dokumentasi RapiDoc
```

Catatan penting untuk mahasiswa: `openapi.json` harus selalu mengikuti kondisi backend. Jika endpoint di PHP berubah, maka dokumentasi di `openapi.json` juga harus diperbarui.

## Lisensi

Project ini dapat digunakan untuk pembelajaran, praktikum, dan pengembangan materi kuliah.

## Penulis

Materi praktikum ini dibuat untuk pembelajaran REST API, HTTP Request, PHP MySQL, Bearer Token, OpenAPI, dan RapiDoc.

---
