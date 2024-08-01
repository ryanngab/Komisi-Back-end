# Sistem Komisi dan Pembayaran

Selamat datang di proyek Sistem Komisi dan Pembayaran! Proyek ini adalah aplikasi Laravel yang dirancang untuk menghitung komisi marketing dan mengelola pembayaran secara kredit berdasarkan data penjualan.

## Daftar Isi
- [Pengenalan](#pengenalan)
- [Fitur](#fitur)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Instalasi](#instalasi)
- [Penggunaan](#penggunaan)
- [API](#api)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

## Pengenalan
Proyek ini adalah aplikasi Laravel yang mencakup API untuk menghitung komisi marketing berdasarkan omzet bulanan dan mengelola pembayaran secara kredit. Sistem ini juga dilengkapi dengan API untuk melakukan dan memantau pembayaran.

## Fitur
1. **Perhitungan Komisi Marketing**:
   - Menghitung komisi marketing berdasarkan omzet dengan ketentuan:
     - 0 - 100.000.000: 0%
     - 100.000.000 - 200.000.000: 2.5%
     - 200.000.000 - 500.000.000: 5%
     - >= 500.000.000: 10%
   - Menampilkan hasil perhitungan komisi per bulan untuk setiap marketing.

2. **Manajemen Pembayaran**:
   - Membuat tabel pembayaran untuk melakukan pembayaran secara kredit.
   - API untuk melakukan dan memantau pembayaran.

## Teknologi yang Digunakan
- Laravel: Framework PHP untuk membangun aplikasi web yang robust.
- MySQL: Sistem manajemen basis data untuk menyimpan data marketing dan penjualan.
- Blade: Mesin template Laravel untuk membuat tampilan web.
- HTML5 & CSS3: Bahasa markup dan styling untuk membangun halaman web.
- JavaScript: Bahasa pemrograman untuk menambahkan interaktivitas pada aplikasi web.
- Git: Sistem kontrol versi untuk melacak perubahan dan berkolaborasi dalam proyek.
- GitHub Pages: Platform untuk hosting dan menerbitkan aplikasi web.

## Instalasi
Untuk menjalankan proyek ini secara lokal, ikuti langkah-langkah berikut:

1. Clone repositori: `git clone https://github.com/username/repository-name.git`
2. Masuk ke direktori proyek: `cd repository-name`
3. Instal dependensi: `composer install`
4. Salin file konfigurasi lingkungan: `cp .env.example .env`
5. Buat kunci aplikasi: `php artisan key:generate`
6. Jalankan migrasi dan seeder database: `php artisan migrate --seed`
7. Mulai server pengembangan: `php artisan serve`
8. Buka browser Anda dan kunjungi: `http://localhost:8000`

## Penggunaan
Setelah menginstal dan menjalankan proyek secara lokal, Anda dapat mengakses API dan melihat hasil perhitungan komisi serta mengelola pembayaran secara kredit. Berikut adalah cara menggunakan fitur utama:

1. **Perhitungan Komisi**:
   - Akses endpoint API untuk menghitung dan menampilkan komisi marketing berdasarkan omzet bulanan.
   - Format URL: `http://localhost:8000/api/komisi`

2. **Manajemen Pembayaran**:
   - Akses endpoint API untuk membuat dan memantau pembayaran.
   - Format URL: `http://localhost:8000/api/pembayaran`

## API
Berikut adalah dokumentasi API yang tersedia:

### Perhitungan Komisi
- **Endpoint**: `GET /api/komisi`
- **Deskripsi**: Menampilkan komisi marketing berdasarkan omzet bulanan.
- **Response**:
  ```json
  [
    {
      "marketing": "Alfandy",
      "bulan": "Mei",
      "omzet": 138000000,
      "komisi_persen": 2.5,
      "komisi_nominal": 3450000
    },
    {
      "marketing": "Mery",
      "bulan": "Mei",
      "omzet": 80000000,
      "komisi_persen": 0,
      "komisi_nominal": 0
    }
    ...
  ]

## Kontribusi
Kontribusi sangat diterima! Jika Anda ingin berkontribusi pada Portofolio Saya, silakan ikuti langkah-langkah berikut:

1. Fork repositori.
2. Buat cabang baru untuk fitur atau perbaikan bug Anda: `git checkout -b my-feature`
3. Commit perubahan Anda: `git commit -m 'Menambahkan fitur baru'`
4. Push ke cabang: `git push origin my-feature`
5. Buka pull request.

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

Terima kasih telah mengunjungi portofolio saya! Jika ada pertanyaan atau masukan, jangan ragu untuk menghubungi saya.
