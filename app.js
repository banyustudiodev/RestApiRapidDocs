const codeText = `POST /api/login.php
Content-Type: application/json

{
  "email": "admin@kampus.test",
  "password": "123456"
}

Response:
{
  "status": true,
  "message": "Login berhasil",
  "data": {
    "token_type": "Bearer",
    "access_token": "praktikum-token-123"
  }
}`;

const typingTarget = document.getElementById("typing-code");
let index = 0;

function typeCode() {
    if (!typingTarget) {
        return;
    }

    if (index < codeText.length) {
        typingTarget.textContent += codeText.charAt(index);
        index++;
        setTimeout(typeCode, 18);
    }
}

typeCode();

const fadeElements = document.querySelectorAll(".fade-up");

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("show");
        }
    });
}, {
    threshold: 0.2
});

fadeElements.forEach((element) => observer.observe(element));

const btnFetch = document.getElementById("btnFetch");
const btnLogin = document.getElementById("btnLogin");
const apiResult = document.getElementById("apiResult");

if (btnLogin) {
    btnLogin.addEventListener("click", async () => {
        apiResult.textContent = "Mengirim request login...";

        try {
            const response = await fetch("api/login.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    email: "admin@kampus.test",
                    password: "123456"
                })
            });

            const data = await response.json();
            apiResult.textContent = JSON.stringify(data, null, 2);

        } catch (error) {
            apiResult.textContent = "Gagal login. Pastikan XAMPP dan MySQL aktif.\n\n" + error;
        }
    });
}

if (btnFetch) {
    btnFetch.addEventListener("click", async () => {
        apiResult.textContent = "Mengirim request ke API...";

        try {
            const response = await fetch("api/mahasiswa.php", {
                method: "GET",
                headers: {
                    "Authorization": "Bearer praktikum-token-123",
                    "Accept": "application/json"
                }
            });

            const data = await response.json();
            apiResult.textContent = JSON.stringify(data, null, 2);

        } catch (error) {
            apiResult.textContent = "Gagal mengambil data. Pastikan XAMPP dan MySQL aktif.\n\n" + error;
        }
    });
}