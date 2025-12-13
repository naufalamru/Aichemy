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

<h2>3. Arsitektur Agentic AI</h2>

<p>
  Bab ini menjelaskan arsitektur dan desain <strong>Agentic AI</strong> yang digunakan
  dalam proyek <em>AI Skincare Discovery Agent</em>. Sistem dibangun menggunakan
  <strong>Flowise</strong> sebagai <em>agent orchestration framework</em> dan
  mengombinasikan dua workflow utama:
</p>

<ul>
  <li><strong>Retrieval-Augmented Generation (RAG)</strong> sebagai lapisan grounding berbasis fakta</li>
  <li><strong>Deep Research with Subagents</strong> sebagai mesin reasoning dan eksplorasi solusi</li>
</ul>

<p>
  Seluruh inference model <strong>tidak dijalankan secara lokal</strong>.
  Flowise bertugas mengoordinasikan LLM, tools eksternal, dan knowledge base
  dalam satu alur agentic yang terkontrol.
</p>

<hr>

<h3>3.1 Workflow RAG (Retrieval-Augmented Generation)</h3>

<img width="1142" height="464" alt="image" src="https://github.com/user-attachments/assets/0b4e977d-46c9-4801-9a5a-6585b4c04ed6" />


<h4>Tujuan dan Peran</h4>
<p>
  Workflow RAG berfungsi sebagai <strong>knowledge grounding layer</strong>.
  Workflow ini memastikan bahwa seluruh jawaban dasar sistem
  <strong>berasal dari dataset INCI yang tervalidasi</strong>, bukan dari asumsi model.
</p>

<p>
  RAG digunakan untuk menjawab pertanyaan faktual seperti:
</p>
<ul>
  <li>Fungsi kosmetik suatu bahan</li>
  <li>Properti kimia dasar (logP, pKa, ionisasi)</li>
  <li>Kesesuaian umum terhadap tujuan skincare tertentu</li>
</ul>

<p>
  RAG <strong>tidak melakukan reasoning kompleks</strong> dan
  <strong>tidak menghasilkan reformulasi baru</strong>.
</p>

<h4>Konfigurasi Teknis</h4>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>Komponen</th>
    <th>Detail</th>
  </tr>
  <tr>
    <td>Model</td>
    <td>GPT-4o-mini</td>
  </tr>
  <tr>
    <td>Temperature</td>
    <td>0.0 – 0.4 (minim halusinasi)</td>
  </tr>
  <tr>
    <td>Embedding Model</td>
    <td>text-embedding-3-small</td>
  </tr>
  <tr>
    <td>Vector Database</td>
    <td>Pinecone</td>
  </tr>
  <tr>
    <td>Knowledge Source</td>
    <td>Dataset INCI Skincare + Properti Kimia</td>
  </tr>
</table>

<h4>Alur Kerja RAG</h4>
<ol>
  <li>User mengirimkan query</li>
  <li>Flowise melakukan similarity search ke Pinecone</li>
  <li>Chunk dokumen relevan dikirim ke LLM</li>
  <li>LLM menyusun jawaban <strong>hanya berdasarkan konteks retrieved</strong></li>
</ol>

<h4>Output Workflow RAG</h4>
<ul>
  <li>Jawaban faktual</li>
  <li>Ringkasan properti bahan</li>
  <li>Tanpa spekulasi atau desain molekul baru</li>
</ul>



<hr>

<h3>3.2 Workflow Deep Research with Subagents</h3>

<img width="2248" height="972" alt="image" src="https://github.com/user-attachments/assets/d7aaa947-f305-43a9-9e3a-fd3d3d4f504f" />


<h4>Tujuan dan Filosofi</h4>
<p>
  Workflow <strong>Deep Research</strong> merupakan inti dari sistem agentic AI.
  Workflow ini digunakan ketika permasalahan membutuhkan:
</p>

<ul>
  <li>Reasoning bertahap</li>
  <li>Analisis lintas sumber</li>
  <li>Evaluasi kompatibilitas dan reformulasi konseptual bahan skincare</li>
</ul>

<p>
  Berbeda dengan RAG, workflow ini <strong>bersifat iteratif</strong>,
  menggunakan <em>planner</em> dan beberapa <em>subagent</em>
  yang bekerja secara terkoordinasi.
</p>

<hr>

<h4>3.2.1 Planner Agent</h4>

<p>
  Planner Agent bertanggung jawab untuk <strong>memahami intent pengguna</strong>
  dan <strong>memecah masalah menjadi task riset terstruktur</strong>.
</p>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>Aspek</th>
    <th>Detail</th>
  </tr>
  <tr>
    <td>Model</td>
    <td>GPT-4.1</td>
  </tr>
  <tr>
    <td>Temperature</td>
    <td>0.5</td>
  </tr>
  <tr>
    <td>Tools</td>
    <td>Tidak menggunakan tools eksternal</td>
  </tr>
</table>

<p>
  Output Planner berupa daftar task seperti:
</p>
<ul>
  <li>Pencarian kandidat bahan aktif</li>
  <li>Analisis kompatibilitas kimia</li>
  <li>Evaluasi potensi risiko formulasi</li>
</ul>

<hr>

<h4>3.2.2 Iteration Subagents</h4>

<p>
  Iteration Subagent mengeksekusi task dari Planner dan
  dapat melakukan iterasi hingga hasil dianggap memadai.
</p>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>Aspek</th>
    <th>Detail</th>
  </tr>
  <tr>
    <td>Model</td>
    <td>GPT-4o</td>
  </tr>
  <tr>
    <td>Temperature</td>
    <td>0.4</td>
  </tr>
  <tr>
    <td>Tools</td>
    <td>Tavily API, Web Scraper, arXiv, Custom RDKit (konseptual)</td>
  </tr>
  <tr>
    <td>Knowledge Base</td>
    <td>Dataset INCI sebagai ground truth</td>
  </tr>
</table>

<p>
  Subagent melakukan:
</p>
<ul>
  <li>Analisis gugus fungsi</li>
  <li>Deteksi konflik kimia</li>
  <li>Evaluasi kelayakan reformulasi konseptual</li>
</ul>

<hr>

<h4>3.2.3 Writer / Validator Agent</h4>

<p>
  Writer / Validator Agent berperan sebagai <strong>gatekeeper ilmiah</strong>
  yang menggabungkan seluruh hasil subagent dan melakukan validasi akhir.
</p>

<table border="1" cellpadding="8" cellspacing="0">
  <tr>
    <th>Aspek</th>
    <th>Detail</th>
  </tr>
  <tr>
    <td>Model</td>
    <td>GPT-4o-mini</td>
  </tr>
  <tr>
    <td>Temperature</td>
    <td>0.5</td>
  </tr>
</table>

<p>
  Agent ini memastikan bahwa rekomendasi:
</p>
<ul>
  <li>Konsisten secara kimia</li>
  <li>Aman secara konseptual</li>
  <li>Diberi justifikasi ilmiah yang jelas</li>
</ul>


<hr>

<h2>4. Dataset & Knowledge Base</h2>

<h3>4.1 Dataset Utama</h3>

<p>
  Sistem menggunakan satu dataset utama sebagai
  <strong>single source of truth</strong>:
</p>

<p><strong>INCI Skincare Ingredients + Properti Kimia</strong></p>

<p>
  Dataset ini disimpan sebagai document store dan diindeks
  menggunakan <strong>Pinecone Vector Database</strong>.
</p>

<hr>

<h3>4.2 Isi Dataset</h3>

<ul>
  <li>Nama bahan (INCI name)</li>
  <li>Fungsi kosmetik</li>
  <li>Properti kimia (logP, pKa, solubility, stability)</li>
  <li>Ionization state (pH 7.4)</li>
  <li>Functional groups</li>
  <li>Aromatic ring count & structural complexity</li>
  <li>Tautomerism indicators</li>
  <li>SMILES (jika tersedia)</li>
</ul>

<hr>

<h3>4.3 Pipeline Persiapan Dataset</h3>

<ol>
  <li>Kompilasi data INCI dalam format CSV</li>
  <li>Pembersihan dan normalisasi data</li>
  <li>Chunking dan embedding teks</li>
  <li>Penyimpanan embedding ke Pinecone</li>
  <li>Integrasi Pinecone ke Flowise sebagai document store</li>
</ol>

<p>
  Seluruh agent <strong>dibatasi</strong> untuk hanya menggunakan dataset ini
  atau sumber ilmiah tervalidasi melalui tools,
  sehingga risiko halusinasi dapat ditekan secara signifikan.
</p>


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
