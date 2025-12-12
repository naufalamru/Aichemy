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

<h2>3. Model AI Yang Digunakan</h2>

<p>
  <strong>Catatan:</strong> Pada implementasi Aichemy yang dikirimkan, inference <em>tidak</em> dijalankan secara lokal — seluruh pemanggilan model berlangsung melalui Flowise. Flowise adalah orchestrator yang dapat memanggil banyak LLM provider.
</p>

<h3>3.1 Jenis Model yang Umum Dipakai di Flowise</h3>
<ul>
  <li><strong>OpenAI (GPT-4 / GPT-4o / GPT-3.5)</strong> — kualitas terbaik, cocok untuk jawaban ilmiah & berdasar konteks.</li>
  <li><strong>OpenRouter / Open Source Models</strong> — Qwen, Mixtral, Llama 2/3 (via penyedia pihak ketiga).</li>
  <li><strong>Hugging Face Inference API</strong> — untuk model-model komunitas yang mendukung text-generation.</li>
</ul>

<h3>3.2 Rekomendasi Konfigurasi Model untuk Mode "Scientific"</h3>
<ul>
  <li><strong>Temperature</strong>: 0.0 – 0.3 (membatasi kebebasan kreatif, kurangi halusinasi).</li>
  <li><strong>Top-p</strong>: 0.8 atau lebih rendah bila butuh determinisme.</li>
  <li><strong>Max tokens</strong>: Sesuaikan (mis. 512–1024) untuk respons lengkap tanpa terlalu panjang.</li>
  <li><strong>System prompt / Instruction</strong>: Berikan prompt yang jelas untuk sumber-sumber ilmiah, konteks, dan gaya bahasa.</li>
</ul>

<h3>3.3 Contoh Endpoint Flowise (ENV)</h3>
<pre><code>
FLOWISE_API=https://your-flowise.example/api/v1
FLOWISE_KEY=xxxxx
</code></pre>

<hr>

<h2>4. Dataset</h2>

<p>
  Versi default Aichemy tidak menyertakan dataset ML lokal. Namun jika kamu menambahkan knowledge base di Flowise, berikut praktik yang umum:
</p>

<h3>4.1 Jenis Data yang Direkomendasikan</h3>
<ul>
  <li>Artikel dermatologi (journal review, guideline).</li>
  <li>Dokumen bahan aktif (INCI, mekanisme kerja, safety data).</li>
  <li>Sumber regulasi (FDA, EMA, BPOM regional bila relevan).</li>
  <li>Manual bahan produk (safety, konsentrasi rekomendasi).</li>
</ul>

<h3>4.2 Format Penyimpanan di Flowise</h3>
<ul>
  <li>PDF / TXT / HTML — di-parsing & di-chunk.</li>
  <li>Embedding vector store (Chroma, Pinecone, Weaviate, atau milik Flowise).</li>
  <li>Sumber metadata: title, sumber, tanggal, confidence score.</li>
</ul>

<h3>4.3 Contoh Proses Persiapan Dataset</h3>
<ol>
  <li>Kumpulkan dokumen (PDF / HTML / CSV).</li>
  <li>Preprocess: hapus noise, normalisasi teks.</li>
  <li>Chunking & embedding (menggunakan embedding model seperti text-embedding-3-small).</li>
  <li>Masukkan ke vector DB dan sambungkan ke Flowise untuk retrieval.</li>
</ol>

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
