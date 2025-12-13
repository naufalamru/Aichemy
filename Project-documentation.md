<p align="center">
  <a href="https://aichemy.my.id/" target="_blank">
    <img src="public/images/logo2.png" width="400" alt="Aichemy Logo">
  </a>
</p>
<h1 align="center">Dokumentasi Proyek — Aichemy (Agentic AI Skincare Assistant)</h1>

<p align="center">
  Aichemy adalah aplikasi web berbasis Laravel yang menyediakan asisten skincare berbasis LLM melalui Flowise. 
  Dokumen ini menjelaskan arsitektur sistem, model AI yang digunakan, dataset (jika ada), dan limitasi sistem.
</p>

<hr>

<h2>1. Gambaran Umum</h2>
<p>
  Aichemy memungkinkan pengguna bertanya tentang skincare (umum & ilmiah). Alur umum:
  <em>Frontend</em> (Blade + JS) → <em>Backend</em> (Laravel) → <em>AI Layer</em> (Flowise → LLM provider).
</p>

<hr>

<h2>2. Arsitektur Sistem</h2>

<h3>2.1 Komponen Utama</h3>
<ul>
  <li><strong>Frontend</strong>: Blade templates, JavaScript (fetch), Vite, Tailwind/CSS.</li>
  <li><strong>Backend</strong>: Laravel 10+ — routing, autentikasi, validasi, proxy request ke Flowise, penyimpanan history (opsional).</li>
  <li><strong>AI Layer</strong>: Flowise pipeline yang memanggil LLM eksternal (OpenAI, HuggingFace, OpenRouter, dsb.).</li>
  <li><strong>Storage / DB</strong>: MySQL/MariaDB untuk user, session, dan tabel history (jika diaktifkan).</li>
</ul>

<h3>2.2 Diagram Arsitektur (ASCII)</h3>
<pre><code>
              +-------------+         HTTP/JSON         +-------------+
              |   Frontend  | ------------------------> |   Laravel   |
              | (Blade + JS)|                           |   Backend   |
              +------+------+                           +------+------+
                     |                                          |
                     |                                          |
                     |            HTTP/JSON                      |
                     |------------------------------------------>|
                     |                                          |
                     |                                  +-------v-------+
                     |                                  |    Flowise    |
                     |                                  | (LLM Pipeline)|
                     |                                  +-------+-------+
                     |                                          |
                     |              LLM Provider (OpenAI/...)   |
                     |<-----------------------------------------|
</code></pre>

<h3>2.3 Alur Request</h3>
<ol>
  <li>User mengirim pertanyaan via UI (/tanya-ai atau /chatbot).</li>
  <li>Laravel menerima request, melakukan validasi & menambahkan header/konfigurasi.</li>
  <li>Laravel mem-forward request ke endpoint Flowise (FLOWISE_API).</li>
  <li>Flowise menjalankan pipeline: context retrieval (jika ada KB), prompt engineering, pemanggilan LLM, lalu mengembalikan respons JSON.</li>
  <li>Laravel memformat respons dan mengirim balik ke frontend, serta menyimpan history bila diaktifkan.</li>
</ol>

<hr>

<h2>3. Arsitektur Model AI yang Digunakan</h2>

<p>
  <strong>Catatan Penting:</strong> Pada proyek <em>AI Skincare Discovery Agent</em>, seluruh inference dan orkestrasi model
  <strong>tidak dijalankan secara lokal</strong>. Semua proses dilakukan melalui
  <strong>Flowise</strong> sebagai <em>agent orchestration framework</em> yang
  mengoordinasikan berbagai Large Language Model (LLM), tools, dan knowledge base.
</p>

<p>
  Sistem ini mengombinasikan dua pendekatan utama:
</p>
<ul>
  <li><strong>Retrieval-Augmented Generation (RAG)</strong> untuk grounding berbasis data INCI</li>
  <li><strong>Agentic Deep Research Workflow</strong> dengan planner dan subagent iteratif</li>
</ul>

<hr>

<h3>3.1 Model AI yang Digunakan</h3>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>Komponen</th>
    <th>Model</th>
    <th>Temperature</th>
    <th>Peran</th>
  </tr>
  <tr>
    <td>RAG Agent</td>
    <td>GPT-4o-mini</td>
    <td>0.4</td>
    <td>Retrieval fakta berbasis dataset INCI dan properti kimia</td>
  </tr>
  <tr>
    <td>Planner Agent</td>
    <td>GPT-4.1</td>
    <td>0.5</td>
    <td>Memecah query pengguna menjadi task riset terstruktur</td>
  </tr>
  <tr>
    <td>Iteration Subagent</td>
    <td>GPT-4o</td>
    <td>0.4</td>
    <td>Analisis kimia, kompatibilitas bahan, dan re-formulasi konseptual</td>
  </tr>
  <tr>
    <td>Writer / Validator Agent</td>
    <td>GPT-4o-mini</td>
    <td>0.5</td>
    <td>Validasi ilmiah dan justifikasi sebagai ahli kimia skincare</td>
  </tr>
</table>

<p>
  Penggunaan temperatur relatif rendah bertujuan untuk
  <strong>menekan halusinasi</strong> dan menjaga konsistensi ilmiah dalam konteks kimia kosmetik.
</p>

<hr>

<h3>3.2 Tools yang Digunakan oleh Subagent</h3>

<p>
  Untuk mendukung mode <em>deep research</em>, Iteration Subagent memiliki akses ke beberapa tools eksternal:
</p>

<ul>
  <li><strong>Tavily API</strong> – pencarian literatur dan referensi ilmiah</li>
  <li><strong>Web Scraper</strong> – ekstraksi informasi dari sumber tepercaya</li>
  <li><strong>arXiv</strong> – referensi paper ilmiah terkait kimia dan dermatologi</li>
  <li><strong>Custom RDKit Tool</strong> – analisis struktur molekul dan SMILES (konseptual)</li>
</ul>

<p>
  Semua hasil tool digunakan sebagai <em>supporting evidence</em>,
  bukan sebagai dasar tunggal pengambilan keputusan.
</p>

<hr>

<h2>4. Dataset & Knowledge Base</h2>

<h3>4.1 Document Store Utama</h3>

<p>
  Sistem menggunakan satu sumber kebenaran utama berupa dataset:
</p>

<p>
  <strong>INCI Skincare Ingredients + Properti Kimia</strong>
</p>

<p>
  Dataset ini disimpan sebagai <em>document store</em> dan diindeks dalam
  <strong>Vector Database (Pinecone)</strong> untuk keperluan retrieval.
</p>

<h3>4.2 Isi Dataset</h3>

<ul>
  <li>Nama bahan (INCI name)</li>
  <li>Fungsi kosmetik (brightening, anti-acne, soothing, dll)</li>
  <li>Properti kimia (logP, pKa, kelarutan, stabilitas)</li>
  <li>Ionization state pada pH 7.4</li>
  <li>Functional groups (ringkas dan detail)</li>
  <li>Jumlah cincin aromatik dan kompleksitas struktur</li>
  <li>Tautomerism indicators</li>
  <li>SMILES (jika tersedia)</li>
</ul>

<p>
  Dataset ini berfungsi sebagai <strong>ground truth</strong> untuk seluruh agent
  dan menjadi mekanisme utama untuk mengurangi halusinasi model.
</p>

<hr>

<h3>4.3 Pipeline Persiapan Dataset</h3>

<ol>
  <li>Kompilasi data INCI dan properti kimia dalam format CSV</li>
  <li>Pembersihan dan normalisasi data</li>
  <li>Embedding teks menggunakan model embedding</li>
  <li>Penyimpanan embedding ke Pinecone</li>
  <li>Integrasi Pinecone ke Flowise sebagai document store</li>
</ol>

<p>
  Seluruh agent hanya diperbolehkan menarik informasi dari dataset ini atau
  dari sumber ilmiah yang tervalidasi melalui tools.
</p>

<hr>


<h2>5. Limitasi Sistem</h2>

<p>Berikut ringkasan keterbatasan Aichemy saat ini:</p>

<h3>5.1 Ketergantungan Pada Flowise & LLM Provider</h3>
<ul>
  <li>Jika Flowise down atau API key invalid, fitur AI tidak bekerja.</li>
  <li>Latency dan biaya bergantung pada provider LLM (OpenAI, HF, dsb.).</li>
</ul>

<h3>5.2 Potensi Halusinasi (Hallucination)</h3>
<ul>
  <li>LLM dapat mengarang informasi jika knowledge base tidak lengkap atau prompt tidak spesifik.</li>
  <li>Solusi mitigasi: kurangi temperature, inject konteks dokumentasi, tambahkan verifikasi sumber.</li>
</ul>

<h3>5.3 Bukan Pengganti Konsultasi Medis</h3>
<ul>
  <li>Rekomendasi skincare sebaiknya divalidasi oleh profesional kesehatan/dermatolog apabila dipakai untuk keputusan medis.</li>
</ul>

<h3>5.4 Keamanan & Privasi</h3>
<ul>
  <li>Pertimbangkan enkripsi data sensitif dan retention policy untuk riwayat pertanyaan.</li>
  <li>Jangan simpan API keys di repo; gunakan env vars dan secret manager di produksi.</li>
</ul>

<h3>5.5 Skalabilitas</h3>
<ul>
  <li>Persiapan untuk beban tinggi: caching, queue worker untuk pemanggilan LLM, rate limiting terhadap user.</li>
  <li>Jika banyak pengguna, pindahkan vector DB & Flowise ke infra yang lebih besar atau gunakan managed services.</li>
</ul>

<hr>

<h2>6. Rekomendasi Pengembangan Lanjutan</h2>
<ul>
  <li>Implementasikan <strong>vector DB</strong> terpisah (Pinecone/Weaviate) untuk knowledge base yang besar.</li>
  <li>Tambahkan <strong>sumber referensi di jawaban</strong> (source citation) untuk transparansi.</li>
  <li>Bangun pipeline data ingestion terjadwal untuk memperbarui bahan referensi (cron jobs).</li>
  <li>Tambahkan <strong>monitoring</strong> (Sentry, Prometheus) untuk error dan latency.</li>
</ul>

<hr>

<p style="text-align:center;">
  Dokumentasi ini dibuat berdasarkan struktur proyek yang Anda kirim. 
  Jika mau saya tambahkan diagram arsitektur gambar (SVG/PNG), contoh konfigurasi Flowise pipeline, atau dokumentasi endpoint API (OpenAPI/Swagger) — beri tahu, saya buatkan.
</p>

<hr>

<p align="center">
  © 2025 Alchemy. All rights reserved.
</p>
