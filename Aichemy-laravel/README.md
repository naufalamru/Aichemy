<p align="center">
  <a href="https://aichemy.my.id/" target="_blank">
    <img src="public/images/logo2.png" width="400" alt="Aichemy Logo">
  </a>
</p>

<h1 align="center">Alchemy — Agentic AI Skincare Assistant</h1>

<p align="center">
  Alchemy adalah platform AI berbasis web yang menganalisis kebutuhan kulit, membaca informasi bahan aktif skincare, 
  dan memberikan rekomendasi berbasis sains. Dibangun menggunakan <strong>Laravel</strong>, 
  <strong>JavaScript</strong>, dan terintegrasi dengan <strong>Flowise API</strong>.
</p>

<p align="center">
  <strong>Website produksi:</strong> <a href="https://aichemy.my.id">https://aichemy.my.id</a>
</p>

<hr>

<h2>1. Deskripsi Singkat Proyek</h2>
<p>
  Alchemy membantu pengguna memahami skincare menggunakan kecerdasan buatan. 
  Fitur meliputi:
</p>

<ul>
  <li><strong>Chatbot AI</strong> untuk percakapan umum.</li>
  <li><strong>Tanya AI (Scientific Mode)</strong> untuk jawaban berbasis sains.</li>
  <li><strong>Autentikasi pengguna</strong> (login & register).</li>
  <li><strong>Riwayat pertanyaan</strong> (opsional).</li>
  <li>Integrasi dengan berbagai model AI melalui Flowise.</li>
</ul>

<hr>

<h2>2. Petunjuk Setup Environment</h2>

<h3>A. Persyaratan Sistem</h3>
<ul>
  <li>PHP 8.1+</li>
  <li>Composer</li>
  <li>MySQL / MariaDB</li>
  <li>Node.js & NPM</li>
  <li>Laravel 10+</li>
  <li>Git (opsional)</li>
  <li>Laragon / XAMPP / WAMP (opsional)</li>
</ul>

<h3>B. Langkah Setup</h3>

<h4>1️.Clone atau ekstrak project</h4>
<pre><code>git clone &lt;URL_REPOSITORY&gt;
cd Aichemy-main
</code></pre>

Jika ZIP:
<pre><code>unzip aichemy.zip
cd Aichemy-main
</code></pre>

<h4>2️.Install dependency backend</h4>
<pre><code>composer install</code></pre>

<h4>3️.Install dependency frontend</h4>
<pre><code>npm install</code></pre>

<h4>4️.Buat file .env</h4>
<pre><code>cp .env.example .env</code></pre>

Isi konfigurasi utama:
<pre><code>
APP_NAME=Alchemy
APP_ENV=local
APP_URL=http://localhost:8000

DB_DATABASE=aichemy
DB_USERNAME=root
DB_PASSWORD=

FLOWISE_API=http://localhost:3000/api/v1
FLOWISE_KEY=your_flowise_key_here
</code></pre>

<h4>5️.Generate key</h4>
<pre><code>php artisan key:generate</code></pre>

<h4>6️.Migrasikan database</h4>
<pre><code>php artisan migrate
php artisan db:seed (jika ada)
</code></pre>

<hr>

<h2>3. Tautan Model Machine Learning</h2>

<p>Proyek ini tidak menyertakan model ML lokal, tetapi menggunakan Flowise.</p>

<h3>Flowise Model</h3>
<ul>
  <li>Endpoint model: <code>https://&lt;flowise-server&gt;/api/v1/prediction</code></li>
  <li>Dokumentasi: <a href="https://docs.flowiseai.com">https://docs.flowiseai.com</a></li>
</ul>

<h3>(Opsional) Model Lokal</h3>
<p>Jika ingin menambahkan model ML sendiri:</p>
<pre><code>/public/models/model.json</code></pre>

Cara load (TensorFlow.js):
<pre><code>const model = await tf.loadLayersModel('/models/model.json');</code></pre>

<hr>

<h2>4. Cara Menjalankan Aplikasi</h2>

<h3>A. Menjalankan backend Laravel</h3>
<pre><code>php artisan serve</code></pre>

<h3>B. Menjalankan frontend (dev)</h3>
<pre><code>npm run dev</code></pre>

<h3>C. Build untuk production</h3>
<pre><code>npm run build</code></pre>

<h3>D. Menjalankan queue (jika diperlukan)</h3>
<pre><code>php artisan queue:work</code></pre>

<hr>

<h2>5. Petunjuk Penggunaan</h2>

<h3>Autentikasi</h3>
<ul>
  <li><code>/login</code></li>
  <li><code>/register</code></li>
</ul>

<h3>Chatbot</h3>
Akses:
<pre><code>/chatbot</code></pre>

<h3>Tanya AI (Scientific Mode)</h3>
Akses:
<pre><code>/tanya-ai</code></pre>

Endpoint backend:
<pre><code>POST /querysains/ask</code></pre>

<h3>Riwayat Pertanyaan (History)</h3>
Jika diaktifkan:
<pre><code>POST /history/store</code></pre>

<hr>

<h2>6. Informasi Penting</h2>

<h3>✔ Keamanan</h3>
<ul>
  <li>Jangan commit file <code>.env</code></li>
  <li>Jangan unggah API key ke repository publik</li>
</ul>

<h3>✔ Permission Folder</h3>
<pre><code>
storage/
bootstrap/cache/
</code></pre>

<h3>✔ Optimasi Production</h3>
<pre><code>php artisan config:cache
php artisan route:cache
php artisan optimize
npm run build
</code></pre>

<h3>✔ Deployment</h3>
Cocok untuk:
<ul>
  <li>VPS (Ubuntu + Nginx)</li>
  <li>Railway</li>
  <li>Render</li>
  <li>cPanel / DirectAdmin</li>
  <li>Hosting laravel modern</li>
</ul>

<p><strong>Live Website:</strong> <a href="https://aichemy.my.id">https://aichemy.my.id</a></p>

<hr>

<h2>7. Lisensi</h2>

<p>Proyek ini menggunakan <strong>MIT License</strong>.</p>

<hr>

<p align="center">
  © 2025 Alchemy. All rights reserved.
</p>
