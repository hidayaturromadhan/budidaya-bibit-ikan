# 📖 Panduan Lengkap Instalasi & Penggunaan Sistem
## Sistem Penjualan Budidaya Bibit Ikan Air Tawar (Gopal Fish)

> Dokumen ini disusun dengan bahasa yang sederhana agar mudah dipahami dan dipraktikkan oleh siapa saja, termasuk yang baru pertama kali menjalankan proyek website Laravel.

---

## 📑 Daftar Isi
1. [Mengenal Sistem Ini](#1-mengenal-sistem-ini)
2. [Persiapan Awal (Software yang Dibutuhkan)](#2-persiapan-awal-software-yang-dibutuhkan)
3. [Panduan Instalasi Langkah Demi Langkah](#3-panduan-instalasi-langkah-demi-langkah)
4. [Panduan Penggunaan untuk Pembeli (Pelanggan)](#4-panduan-penggunaan-untuk-pembeli-pelanggan)
5. [Panduan Penggunaan untuk Admin (Pemilik Usaha)](#5-panduan-penggunaan-untuk-admin-pemilik-usaha)
6. [Kredensial Akun Pengujian](#6-kredensial-akun-pengujian)
7. [Solusi Kendala Umum (Troubleshooting)](#7-solusi-kendala-umum-troubleshooting)

---

## 1. Mengenal Sistem Ini

Website ini adalah **toko online (e-commerce) untuk budidaya bibit ikan air tawar**. Sistem ini dirancang untuk memudahkan:
* **Pembeli / Petani Ikan:** Memilih bibit ikan berdasarkan jenis dan ukurannya (misal: 2-3 cm, 3-5 cm), mengecek stok yang masih ready, menghitung ongkos kirim otomatis, serta membayar dengan pembayaran digital otomatis via **QRIS / Midtrans**.
* **Pemilik Usaha (Admin):** Mencatat stok masuk dan keluar secara otomatis, memantau pesanan masuk, memasukkan nomor resi ekspedisi, serta melihat laporan keuangan/penjualan tanpa repot mencatat di buku manual.

---

## 2. Persiapan Awal (Software yang Dibutuhkan)

Sebelum menjalankan sistem ini di komputer/laptop Anda, pastikan sudah memasang 3 aplikasi gratis berikut:

| Nama Software | Fungsi Sederhana | Cara Cek di Komputer |
|---|---|---|
| **XAMPP** | Menjalankan database MySQL dan server lokal | Buka aplikasi **XAMPP Control Panel** |
| **Composer** | Pengunduh pustaka/mesin utama bahasa pemrograman PHP | Ketik `composer -v` di Terminal |
| **Node.js** | Pengolah tampilan desain website (Tailwind CSS & Vite) | Ketik `node -v` di Terminal |

---

## 3. Panduan Instalasi Langkah Demi Langkah

Ikuti langkah-langkah berikut secara berurutan:

### Langkah 1: Tempatkan Folder Proyek
Pastikan folder proyek diletakkan pada folder web server lokal Anda:
```text
C:\xampp\htdocs\budidaya-bibit
```

---

### Langkah 2: Nyalakan Database di XAMPP
1. Buka aplikasi **XAMPP Control Panel**.
2. Pada baris **Apache**, klik tombol **Start**.
3. Pada baris **MySQL**, klik tombol **Start**.
*(Pastikan kedua modul tersebut berwarna hijau).*

---

### Langkah 3: Buat Database Baru di phpMyAdmin
1. Buka browser (Google Chrome / Edge).
2. Buka alamat: **`http://localhost/phpmyadmin`**
3. Klik menu **Basis Data** (atau **Databases**) di kiri atas.
4. Pada kolom nama basis data, ketik: **`budidaya_bibit`**
5. Klik tombol **Buat** (atau **Create**).

---

### Langkah 4: Buka Terminal di Folder Proyek
Buka aplikasi **Terminal** / **PowerShell** / **Command Prompt**, lalu arahkan ke folder proyek dengan mengetik:
```bash
cd C:\xampp\htdocs\budidaya-bibit
```

---

### Langkah 5: Siapkan File Pengaturan (`.env`)
Di dalam folder proyek terdapat file bernama `.env.example`. File ini perlu disalin menjadi `.env`:
```bash
copy .env.example .env
```
*Catatan: File `.env` sudah otomatis terhubung dengan database `budidaya_bibit` dan kunci simulasi pembayaran Midtrans.*

---

### Langkah 6: Pasang Paket Program
Jalankan dua perintah berikut di terminal satu per satu (tunggu sampai proses unduh selesai):

```bash
composer install
npm install
```

---

### Langkah 7: Siapkan Kunci Aplikasi & Isi Data Awal Database
Jalankan perintah berikut untuk membuat kunci keamanan dan otomatis mengisi database dengan data awal (contoh bibit ikan, stok awal, dan akun demo):

```bash
php artisan key:generate
php artisan migrate --seed
```

---

### Langkah 8: Hubungkan Folder Gambar Produk
Agar foto-foto bibit ikan bisa tampil di halaman website, jalankan perintah:
```bash
php artisan storage:link
```

---

### Langkah 9: Kompilasi Tampilan Desain Website
Jalankan perintah ini agar semua warna dan tata letak tombol tampil sempurna:
```bash
npm run build
```

---

### Langkah 10: Jalankan Website!
Jalankan server aplikasi dengan perintah:
```bash
php artisan serve
```
Setelah muncul tulisan `Server running on [http://127.0.0.1:8000]`, buka browser Anda dan ketik alamat:
👉 **`http://localhost:8000`**

---

## 4. Panduan Penggunaan untuk Pembeli (Pelanggan)

Berikut alur belanja dari awal hingga pembayaran selesai:

### 1. Melihat Katalog & Stok Bibit Ikan
* Di halaman utama, pembeli dapat melihat jenis bibit ikan (Nila Merah, Lele Sangkuriang, Gurame Soang, Patin Siam, Mas Punten).
* **Melihat Stok:** Di setiap kartu terdapat label hijau yang jelas bertuliskan stok yang ready (contoh: **`Ready 10.258`**).
* **Jika Stok Habis:** Foto ikan akan redup dan di tengah kartu terdapat tanda merah tegas **`HABIS`**.

### 2. Memilih Ukuran & Jumlah Pembelian
* Klik salah satu bibit ikan untuk melihat detailnya.
* Pilih variasi ukuran bibit yang diinginkan (contoh: **2-3 cm**, **3-5 cm**, atau **5-7 cm**). Harga akan otomatis berubah sesuai ukuran.
* Masukkan jumlah ekor yang ingin dibeli (minimal 500 ekor).
* Klik tombol **`+ Keranjang`** atau **`Beli Langsung`**.

### 3. Masuk / Login Akun
Jika belum login saat ingin checkout, pembeli dapat memilih:
* **Cara Cepat (Google SSO):** Klik tombol **"Lanjutkan dengan Google"** untuk login instan tanpa ribet mengingat password.
* **Cara Cepat Demo:** Klik tombol **"🛒 Pelanggan"** di bagian Akses Cepat Demo &rarr; lalu klik **Masuk**.

### 4. Melakukan Checkout & Cek Ongkos Kirim
Pada halaman Checkout:
1. Isi **Nama Penerima**, **Nomor WhatsApp**, dan **Alamat Lengkap**.
2. Pilih **Provinsi Tujuan** (misal: *Riau*).
3. Pilih **Kota/Kabupaten Tujuan** (misal: *Kab. Bengkalis*).
4. Pilih **Kurir** (tersedia opsi: *TIKI*, *JNE*, *POS Indonesia*, atau *Kurir Khusus Bibit Beroksigen*).
5. Pilih **Layanan Pengiriman** yang muncul (misal: *TIKI REG - Rp 17.000*). Ongkos kirim dan total tagihan akan otomatis terkalkulasi.
6. Klik tombol **"Buat Pesanan & Bayar"**.

### 5. Melakukan Pembayaran (Midtrans Snap)
1. Pembeli akan diarahkan ke halaman pembayaran dan muncul tombol **"Bayar Sekarang"**.
2. Klik tombol tersebut &rarr; jendela popup pembayaran Midtrans akan terbuka.
3. Pilih metode pembayaran:
   * **QRIS / GoPay:** Scan kode QR yang tampil di layar.
   * **Virtual Account Bank (BCA / BNI / BRI / Mandiri):** Salin nomor VA yang muncul.
4. **Cara Simulasi Bayar di Localhost:**
   * Buka simulator resmi Midtrans di tab baru: [https://simulator.sandbox.midtrans.com/](https://simulator.sandbox.midtrans.com/)
   * Masukkan nomor VA Anda &rarr; klik **Inquire** &rarr; klik **Pay**.
5. Kembali ke website Anda, klik tombol **"Cek / Perbarui Status Pembayaran"** (atau refresh halaman). Status otomatis berubah menjadi **"Pembayaran Berhasil!"** dan stok ikan otomatis berkurang secara sistem.

### 6. Memantau Pesanan di Dashboard Pembeli
* Klik menu **Dashboard** di pojok kanan atas.
* Pembeli dapat melihat riwayat semua pesanannya, tanggal transaksi, total biaya, status pemrosesan (Diproses / Dikirim / Selesai), dan nomor resi kurir setelah barang dikirim.

---

## 5. Panduan Penggunaan untuk Admin (Pemilik Usaha)

Admin memiliki akses penuh untuk mengontrol seluruh isi toko dan data keuangan.

### 1. Masuk ke Halaman Admin
1. Buka halaman login: `http://localhost:8000/login`
2. Klik tombol **"👑 Admin"** di bagian Akses Cepat Demo (otomatis mengisi `admin@admin.com` & `password`).
3. Klik tombol **Masuk** &rarr; Anda akan langsung diarahkan ke **Dashboard Admin** (`/admin/dashboard`).

---

### 2. Memahami Menu Dashboard Admin
Di dashboard utama, pemilik usaha dapat langsung melihat:
* **Statistik Utama:** Total pendapatan penjualan, jumlah pesanan lunas, total pesanan pending, dan peringatan stok bibit yang menipis.
* **Grafik Penjualan:** Grafik visual tren penjualan per bulan untuk membantu analisa bisnis.

---

### 3. Mengelola Data Bibit Ikan (Menu: Data Bibit)
* **Menambah Ikan Baru:** Klik tombol *Tambah Bibit Ikan*, isi nama jenis ikan, pilih kategori, tulis deskripsi perawatan bibit, dan unggah foto ikan.
* **Mengedit / Menghapus Ikan:** Admin dapat memperbarui foto atau deskripsi kapan saja, serta menonaktifkan bibit jika tidak lagi dibudidayakan.

---

### 4. Mengatur Ukuran & Harga Bibit (Menu: Ukuran Bibit)
Bibit ikan dijual berdasarkan panjang tubuhnya. Di menu ini:
* Hubungkan variasi ukuran ke jenis ikan (contoh: *Ikan Nila Merah* &rarr; ukuran *2-3 cm* seharga *Rp 200/ekor*, ukuran *3-5 cm* seharga *Rp 300/ekor*).
* Harga ini yang akan otomatis dihitung saat pembeli memilih ukuran di website.

---

### 5. Mengontrol Stok Masuk & Keluar (Menu: Manajemen Stok)
* **Melihat Stok:** Menampilkan jumlah total ekor ikan yang tersedia per varian ukuran secara *real-time*.
* **Menambah Stok Panen:** Jika ada bibit baru hasil panen dari kolam budidaya, klik *Tambah Stok Masuk* &rarr; masukkan jumlah ekor dan catatan (misal: *"Panen Kolam A"*).
* **Pengurangan Stok Otomatis:** Setiap kali ada pembeli yang sukses membayar pesanan, sistem secara otomatis mengurangi stok dan mencatat riwayat mutasinya.

---

### 6. Memproses Pesanan & Memasukkan Resi (Menu: Pesanan)
1. Buka menu **Pesanan**. Admin akan melihat daftar pesanan dari pembeli lengkap dengan nama, nomor telepon, alamat tujuan, dan kurir yang dipilih.
2. Klik tombol **Detail** pada salah satu pesanan.
3. Setelah paket ikan dikemas dan dikirim ke ekspedisi/kurir:
   * Ubah status pesanan menjadi **Dikirim**.
   * Masukkan **Nomor Resi Pengiriman** (contoh: `TIKI-8829103948`).
   * Klik Simpan. Pembeli di dashboard-nya dapat langsung melihat nomor resi tersebut.
4. Jika ikan sudah sampai ke kolam pembeli, status dapat diperbarui menjadi **Selesai**.

---

### 7. Melihat Laporan Penjualan & Stok (Menu: Laporan)
* Pemilik usaha dapat memfilter rekapan laporan berdasarkan rentang tanggal tertentu (misal: 1 bulan terakhir atau 1 minggu terakhir).
* Laporan menampilkan ringkasan uang masuk, produk paling laris, dan rekap mutasi keluar-masuk bibit ikan.

---

## 6. Kredensial Akun Pengujian

Sistem sudah dilengkapi akun uji coba bawaan:

| Peran | Email | Kata Sandi | Kegunaan |
|---|---|---|---|
| **Administrator** | `admin@admin.com` | `password` | Masuk ke Panel Kontrol Admin (`/admin/dashboard`) |
| **Pelanggan** | `user@user.com` | `password` | Melakukan simulasi belanja dan checkout (`/`) |
| **Pelanggan SSO** | *Akun Google Anda* | *-* | Login mandiri menggunakan tombol *Login with Google* |

---

## 7. Solusi Kendala Umum (Troubleshooting)

### Q: Foto ikan tidak muncul (tampil kotak kosong)?
> **Solusi:** Jalankan perintah `php artisan storage:link` di terminal untuk menghubungkan folder penyimpanan gambar ke web publik.

### Q: Tampilan website terasa berantakan atau warna belum berubah?
> **Solusi:** Jalankan `npm run build` di terminal, lalu buka kembali browser dan tekan **`Ctrl + Shift + R`** (Hard Refresh) untuk membersihkan cache browser lama.

### Q: Tidak bisa menyimpan data / muncul pesan "SQLSTATE Connection Refused"?
> **Solusi:** Pastikan aplikasi **MySQL** di XAMPP Control Panel sudah dalam posisi **Start** (berwarna hijau).

### Q: Muncul pesan error saat menghitung ongkos kirim?
> **Solusi:** Sistem sudah dilengkapi tarif pengiriman dummy otomatis (TIKI, JNE, POS, Kurir Khusus). Cukup pilih kota tujuan dan kurir, tarif akan langsung muncul instan tanpa perlu koneksi API eksternal yang lambat.
