✨ Alchemy — Agentic AI Skincare Assistant

Alchemy adalah platform AI berbasis web yang membantu menganalisis kebutuhan kulit, membaca informasi bahan aktif skincare, dan memberikan rekomendasi berbasis sains. Proyek ini dibangun menggunakan Laravel, JavaScript, dan terintegrasi dengan Flowise API atau model AI eksternal lainnya.

Website produksi: https://aichemy.my.id/

📘 1. Deskripsi Singkat Proyek

Alchemy bertujuan membantu pengguna memahami skincare melalui kecerdasan buatan.
Fitur utama:

Chatbot AI untuk percakapan umum.

Tanya AI (Scientific Mode) untuk jawaban berbasis sains.

Autentikasi (login & register).

Riwayat pertanyaan (history) — opsional.

Mendukung integrasi dengan model AI yang di-host via Flowise atau platform lain.

🛠 2. Petunjuk Setup Environment
A. Persyaratan Sistem

Pastikan perangkat Anda sudah terinstal:

PHP 8.1+

Composer

MySQL / MariaDB

Node.js & NPM

Laravel 10+

Git (opsional)

Laragon / XAMPP / WAMP (Windows)

B. Langkah Setup Environment
1️⃣ Clone atau ekstrak project
git clone <URL_REPOSITORY>
cd Aichemy-main


Atau jika menggunakan ZIP:

unzip aichemy.zip
cd Aichemy-main

2️⃣ Install dependency backend
composer install

3️⃣ Install dependency frontend
npm install

4️⃣ Buat file .env
cp .env.example .env


Isi konfigurasi penting:

APP_NAME=Alchemy
APP_ENV=local
APP_URL=http://localhost:8000

DB_DATABASE=aichemy
DB_USERNAME=root
DB_PASSWORD=

FLOWISE_API=http://localhost:3000/api/v1
FLOWISE_KEY=your_flowise_key_here

5️⃣ Generate application key
php artisan key:generate

6️⃣ Buat database

Buat database baru:

aichemy


Pastikan .env sesuai.

7️⃣ Migrasikan database
php artisan migrate


Jika memiliki seeder:

php artisan db:seed

🔗 3. Tautan Model Machine Learning (Jika Ada)

Proyek ini menggunakan AI dari Flowise sehingga tidak menyertakan model lokal.

📌 Model via Flowise

Endpoint model:

https://<flowise-server>/api/v1/prediction


Dokumentasi Flowise:
https://docs.flowiseai.com

📌 (Opsional) Model Lokal

Model dapat ditempatkan di:

/public/models/


Cara load model (contoh TensorFlow.js):

const model = await tf.loadLayersModel('/models/model.json');


Jika Anda ingin membuat model sendiri, tambahkan link download model di sini.

▶️ 4. Cara Menjalankan Aplikasi
A. Jalankan backend Laravel
php artisan serve


Aplikasi akan berjalan di:

http://localhost:8000

B. Jalankan frontend (development mode)
npm run dev

C. Build frontend untuk production
npm run build

D. Jalankan queue (jika menggunakan job AI)
php artisan queue:work

📖 5. Petunjuk Penggunaan
A. Autentikasi

Akses:

/login

/register

User harus login untuk menggunakan fitur AI.

B. Chatbot

Akses:

/chatbot


Fitur:

Chat langsung dengan AI

Jawaban cepat dan konteks umum

C. Tanya AI (Scientific Mode)

Akses:

/tanya-ai


Backend endpoint:

POST /querysains/ask


Fitur:

Jawaban ilmiah dan detail

Menggunakan model dari Flowise / LLM lain

D. Riwayat Pertanyaan (History)

Jika fitur diaktifkan:

Tabel: ai_histories

Endpoint simpan:

POST /history/store


User dapat melihat riwayat interaksi dengan AI.

🧩 6. Informasi Penting Lainnya
✔ Keamanan

Jangan commit file .env

Jangan unggah API key ke repo publik

✔ Permission Folder

Folder berikut harus writable:

storage/
bootstrap/cache/

✔ Optimasi Mode Production
php artisan config:cache
php artisan route:cache
php artisan optimize
npm run build

✔ Deployment

Dapat dideploy di:

VPS (Ubuntu + Nginx)

Railway

Render

cPanel / DirectAdmin

Cloud hosting Laravel

Website live:
https://aichemy.my.id/

📄 7. Lisensi

Proyek ini menggunakan MIT License.
