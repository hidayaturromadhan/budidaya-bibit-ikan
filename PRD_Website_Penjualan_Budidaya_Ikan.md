# Product Requirements Document (PRD)
## Perancangan Website Penjualan Budidaya Ikan Menggunakan Keamanan Sistem Autentikasi Single Sign-On (SSO)

| Atribut | Keterangan |
|---|---|
| Versi Dokumen | 1.0 |
| Status | Draft |
| Framework | Laravel 12 |
| Database | MySQL |
| Metode Autentikasi | Single Sign-On (SSO) via Google OAuth 2.0 / OpenID Connect |
| Metode Pembayaran | QRIS |

---

## 1. Ringkasan Eksekutif

Produk ini adalah **website penjualan hasil budidaya ikan** yang mengintegrasikan tiga hal utama:

1. Pengelolaan data budidaya (bibit, ukuran, stok) dan transaksi penjualan dalam satu sistem terpusat.
2. Kanal penjualan online (katalog, pencarian, pemesanan) bagi pelanggan.
3. Pembayaran digital via **QRIS** dan autentikasi terpusat via **Single Sign-On (Google)** untuk keamanan dan kemudahan akses.

Sistem dibangun di atas **Laravel 12** dengan basis data **MySQL**, menggantikan proses pencatatan manual yang selama ini menyebabkan kesalahan data, keterlambatan update stok, dan sulitnya penyusunan laporan.

---

## 2. Latar Belakang & Masalah yang Diselesaikan

Merujuk pada Bab 1 proposal, masalah yang ada saat ini:

| Area | Kondisi Saat Ini | Dampak |
|---|---|---|
| Data bibit, ukuran, stok | Dicatat manual, tidak terintegrasi | Salah catat, stok telat update, laporan sulit disusun |
| Informasi produk untuk pelanggan | Tidak tersedia media online real-time | Pelanggan harus datang/telepon langsung, jangkauan pasar terbatas |
| Pembayaran | Tunai / transfer manual | Konfirmasi lambat, tidak terintegrasi ke sistem penjualan |
| Keamanan akun | Akun terpisah per layanan | Password berbeda-beda, akses tidak sah, sulit kelola hak akses |

---

## 3. Tujuan Produk

1. Mengelola data bibit ikan, ukuran, stok, dan transaksi penjualan secara terintegrasi.
2. Memudahkan pelanggan mencari informasi produk dan memesan secara online.
3. Mengintegrasikan pembayaran digital QRIS ke alur transaksi.
4. Menerapkan SSO (Google, protokol OAuth 2.0 / OpenID Connect) untuk keamanan & kemudahan login.
5. Menyediakan laporan penjualan dan stok sebagai dasar pengambilan keputusan pemilik usaha.

---

## 4. Ruang Lingkup

### 4.1 In-Scope
- Aplikasi berbasis website (Laravel 12 + MySQL).
- Modul: manajemen bibit ikan, ukuran, stok, katalog, pencarian, keranjang/pemesanan, transaksi, alamat pengiriman, status pesanan, laporan penjualan & stok.
- Pembayaran QRIS.
- Login SSO via Google (OAuth 2.0/OpenID Connect) untuk pelanggan (dan opsional admin).
- Dua role: **Administrator** (pemilik usaha) dan **Pelanggan**.

### 4.2 Out of Scope
- Integrasi API jasa ekspedisi / perhitungan ongkos kirim otomatis (ongkir & ekspedisi ditentukan manual oleh pemilik usaha).
- Analisis keamanan jaringan mendalam (pengujian difokuskan pada fungsi sistem, autentikasi, dan integrasi pembayaran).
- Aplikasi mobile native (fase awal hanya web).
- Multi-tenant (fase awal untuk satu usaha budidaya).

---

## 5. Pengguna & Peran (Roles)

| Role | Deskripsi | Akses Utama |
|---|---|---|
| **Administrator** (Pemilik Usaha) | Mengelola data master, stok, pesanan, laporan | CRUD bibit/ukuran/stok, kelola pesanan & status, lihat laporan, kelola user |
| **Pelanggan** | Melakukan pembelian | Login (SSO Google), lihat katalog, cari produk, pesan, isi alamat kirim, bayar QRIS, lihat riwayat pesanan |

---

## 6. Functional Requirements (User Stories)

### 6.1 Autentikasi & SSO (Google)
- **FR-1**: Sebagai pelanggan, saya dapat login/register menggunakan akun Google (SSO), tanpa perlu membuat password baru.
- **FR-2**: Sistem melakukan autentikasi menggunakan protokol OAuth 2.0/OpenID Connect terhadap Google sebagai Identity Provider (IdP).
- **FR-3**: Saat pertama kali login via Google, sistem otomatis membuat akun pelanggan baru (mapping `google_id`, email, nama) jika belum terdaftar.
- **FR-4**: Admin login menggunakan akun terpisah (email & password internal, dengan opsi login Google untuk admin jika didaftarkan sebagai super admin).
- **FR-5**: Sistem mendukung logout yang menghapus sesi lokal (dan mengarahkan ke Google logout bila diperlukan).
- **FR-6**: Sistem menyimpan token OAuth secara aman (terenkripsi) dan menangani refresh token/expiry.

### 6.2 Manajemen Data Budidaya (Admin)
- **FR-7**: Admin dapat menambah, mengubah, menghapus data **bibit ikan** (jenis, deskripsi, harga, foto).
- **FR-8**: Admin dapat mengelola **ukuran bibit** (misal: 2-3cm, 3-5cm, dst) yang terhubung ke satu jenis bibit dengan harga berbeda per ukuran.
- **FR-9**: Admin dapat mengelola **stok** per kombinasi bibit-ukuran (tambah stok masuk, kurangi otomatis saat transaksi berhasil).
- **FR-10**: Sistem memberi notifikasi/flag saat stok mendekati habis (low-stock alert).

### 6.3 Katalog & Pemesanan (Pelanggan)
- **FR-11**: Pelanggan dapat melihat katalog produk dengan info jenis, ukuran, harga, dan ketersediaan stok real-time.
- **FR-12**: Pelanggan dapat mencari & memfilter produk (nama, jenis, ukuran, rentang harga).
- **FR-13**: Pelanggan dapat menambahkan produk ke keranjang dan mengatur jumlah pesanan.
- **FR-14**: Pelanggan dapat melakukan checkout dan mengisi/menyimpan **alamat pengiriman**.
- **FR-15**: Pelanggan memilih jasa ekspedisi dari daftar yang ditentukan pemilik usaha (tanpa perhitungan ongkir otomatis / tanpa API ekspedisi).
- **FR-16**: Pelanggan dapat melihat riwayat pesanan beserta status terkini.

### 6.4 Pembayaran (QRIS)
- **FR-17**: Sistem membuatkan kode QRIS untuk setiap transaksi checkout.
- **FR-18**: Sistem menerima notifikasi status pembayaran (callback/webhook dari payment gateway QRIS) dan memperbarui status transaksi secara otomatis.
- **FR-19**: Sistem menampilkan status pembayaran (menunggu, berhasil, kedaluwarsa/gagal) kepada pelanggan.
- **FR-20**: Stok otomatis berkurang hanya setelah pembayaran dikonfirmasi berhasil.

### 6.5 Manajemen Pesanan (Admin)
- **FR-21**: Admin dapat melihat seluruh daftar pesanan beserta detail pelanggan, produk, dan status pembayaran.
- **FR-22**: Admin dapat memperbarui **status pesanan** (diproses, dikemas, dikirim, selesai, dibatalkan).
- **FR-23**: Admin dapat mencatat nomor resi pengiriman secara manual.

### 6.6 Laporan
- **FR-24**: Sistem menghasilkan **laporan penjualan** (per periode, per produk) yang dapat difilter tanggal.
- **FR-25**: Sistem menghasilkan **laporan stok** (stok masuk, keluar, sisa stok saat ini).
- **FR-26**: Laporan dapat diekspor (PDF/Excel) — *opsional fase lanjutan*.

---

## 7. Non-Functional Requirements

| Kategori | Kebutuhan |
|---|---|
| **Keamanan** | Autentikasi via SSO OAuth 2.0/OpenID Connect, password admin di-hash (bcrypt/argon2), HTTPS wajib, proteksi CSRF/XSS/SQL Injection bawaan Laravel, validasi input di semua form |
| **Performa** | Waktu load halaman katalog < 3 detik pada koneksi standar |
| **Skalabilitas** | Struktur database dinormalisasi agar mudah dikembangkan (multi-produk, multi-gudang di masa depan) |
| **Usability** | UI responsif (mobile-friendly), alur checkout maksimal 3-4 langkah |
| **Reliabilitas** | Status pembayaran QRIS harus konsisten dengan status di payment gateway (idempotent webhook handling) |
| **Maintainability** | Mengikuti konvensi Laravel (MVC, Eloquent, Form Request Validation, Service/Repository pattern) |
| **Audit** | Log aktivitas penting: login SSO, perubahan stok, perubahan status pesanan |

---

## 8. Arsitektur Sistem (High-Level)

```
[Browser Pelanggan/Admin]
        |
        v
 [Laravel 12 App] --(Blade/Livewire atau API)--> [Frontend]
        |
        |-- Auth: Laravel Socialite --> [Google OAuth 2.0 / OpenID Connect]
        |
        |-- Payment: HTTP Client --> [Payment Gateway QRIS] (mis. Midtrans/Xendit)
        |
        v
   [MySQL Database]
```

**Komponen utama:**
- **Laravel 12** sebagai backend & routing utama (MVC).
- **Laravel Socialite** untuk integrasi login SSO Google (OAuth 2.0/OpenID Connect).
- **MySQL** sebagai database relasional utama.
- **Payment Gateway pihak ketiga** yang mendukung QRIS (mis. Midtrans, Xendit, atau provider lain) diakses via HTTP Client Laravel, dengan endpoint webhook untuk callback status pembayaran.
- **Queue/Job** (opsional) untuk proses async seperti pengiriman notifikasi email/status.

---

## 9. Model Data (Ringkas)

Entitas utama:

- **users** — id, name, email, google_id (nullable), password (nullable untuk akun SSO), role (admin/pelanggan), timestamps
- **fish_seeds** (bibit_ikan) — id, name, description, image, category, is_active
- **fish_seed_sizes** (ukuran_bibit) — id, fish_seed_id, size_label, price
- **stocks** — id, fish_seed_size_id, quantity, updated_at
- **stock_movements** — id, fish_seed_size_id, type (in/out), quantity, note, created_at
- **orders** — id, user_id, status, total_amount, shipping_address_id, expedition_name, tracking_number, created_at
- **order_items** — id, order_id, fish_seed_size_id, quantity, price
- **payments** — id, order_id, method (QRIS), qris_reference, status, paid_at
- **addresses** — id, user_id, recipient_name, phone, full_address, postal_code

*(Diagram ER detail dapat dikembangkan pada dokumen desain teknis terpisah.)*

---

## 10. Alur Autentikasi SSO (Google)

1. Pelanggan klik **"Login dengan Google"**.
2. Laravel (via Socialite) redirect ke Google OAuth consent screen.
3. Pengguna menyetujui akses (email, profil).
4. Google redirect kembali ke callback URL Laravel dengan authorization code.
5. Laravel menukar code dengan access token & mengambil data profil (email, nama, google_id).
6. Sistem cek: jika `google_id`/email sudah terdaftar → login; jika belum → buat akun baru otomatis.
7. Sesi Laravel dibuat (session-based auth), pengguna diarahkan ke dashboard/katalog.

---

## 11. Alur Pembayaran QRIS

1. Pelanggan checkout → sistem membuat `order` berstatus *pending*.
2. Sistem memanggil API payment gateway untuk generate kode QRIS.
3. QRIS ditampilkan ke pelanggan untuk dipindai & dibayar.
4. Payment gateway mengirim **webhook** ke Laravel saat status pembayaran berubah.
5. Laravel memverifikasi signature webhook, update status `payment` & `order`.
6. Jika berhasil → stok otomatis dikurangi, notifikasi ke pelanggan & admin.
7. Jika kedaluwarsa/gagal → order dibatalkan/stok tidak berkurang.

---

## 12. Metrik Keberhasilan (Success Metrics)

- Berkurangnya kesalahan pencatatan stok dibanding sistem manual (target: mendekati 0% selisih stok).
- Waktu konfirmasi pembayaran QRIS < 1 menit setelah pembayaran berhasil.
- Tingkat keberhasilan login SSO Google > 99% (tanpa gagal autentikasi karena bug sistem).
- Laporan penjualan & stok dapat dihasilkan admin dalam < 5 klik.

---

## 13. Asumsi & Batasan

- Fokus SSO pada implementasi user-facing sesuai instruksi: **login Google** sebagai Identity Provider (selaras dengan pendekatan OAuth 2.0/OpenID Connect pada proposal; jika di kemudian hari dibutuhkan SSO terpusat multi-IdP, dapat dikembangkan menggunakan Keycloak dengan Google sebagai salah satu federated identity provider).
- Ongkos kirim & pemilihan ekspedisi bersifat manual (tidak ada API rate ongkir otomatis).
- Pengujian sistem difokuskan pada fungsi aplikasi, proses autentikasi, dan integrasi pembayaran — bukan audit keamanan jaringan mendalam.
- Provider QRIS spesifik (Midtrans/Xendit/lainnya) perlu ditentukan sebelum implementasi teknis dimulai.

---

## 14. Tech Stack Ringkas

| Layer | Teknologi |
|---|---|
| Backend Framework | Laravel 12 (PHP) |
| Database | MySQL |
| Autentikasi SSO | Laravel Socialite + Google OAuth 2.0 / OpenID Connect |
| Payment | QRIS via payment gateway pihak ketiga (HTTP Client + Webhook) |
| Frontend | Blade + Tailwind (atau Livewire/Vue sesuai preferensi tim) |
| Queue/Job (opsional) | Laravel Queue (database/redis driver) |

---

## 15. Roadmap Implementasi (Saran Fase)

| Fase | Cakupan |
|---|---|
| 1 | Setup Laravel 12 + MySQL, struktur DB, autentikasi SSO Google |
| 2 | Modul admin: bibit, ukuran, stok |
| 3 | Modul pelanggan: katalog, pencarian, keranjang, checkout, alamat |
| 4 | Integrasi QRIS (generate kode, webhook status) |
| 5 | Manajemen pesanan & status pengiriman |
| 6 | Laporan penjualan & stok |
| 7 | Testing (fungsi, autentikasi, pembayaran) & deployment |

---

*Dokumen ini disusun berdasarkan Bab 1 Proposal "Perancangan Website Penjualan Budidaya Ikan Menggunakan Keamanan Sistem Autentikasi Single Sign-On (SSO)" dan dapat disesuaikan lebih lanjut sesuai kebutuhan teknis tim pengembang.*
