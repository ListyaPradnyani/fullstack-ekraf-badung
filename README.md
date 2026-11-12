# Ekraf Badung — versi Laravel

Konversi website HTML/CSS/JS (https://listyapradnyani.github.io/ekraf-badung/) ke Laravel.
Landing page **tampilannya sama persis** (CSS & JS asli dipakai apa adanya), ditambah UMKM Directory yang
terhubung ke database, form pendaftaran yang bisa diedit, serta login **user** dan **admin**.

## Persyaratan
PHP 8.3+, Composer, MySQL/MariaDB (XAMPP/Laragon boleh). Ekstensi PHP: pdo_mysql, mbstring, fileinfo, intl.

## Instalasi
```bash
composer install
cp .env.example .env          # lalu isi DB_USERNAME / DB_PASSWORD, dan ADMIN_EMAIL / ADMIN_PASSWORD
php artisan key:generate
# buat database kosong bernama: ekraf_badung
php artisan migrate --seed    # buat tabel + akun + data contoh + impor Excel
php artisan storage:link      # agar foto produk bisa tampil
php artisan serve             # buka http://localhost:8000
```
Akun hasil seeding:

| Role  | Email                        | Password                       |
|-------|------------------------------|--------------------------------|
| Admin | `ADMIN_EMAIL` di `.env`      | `ADMIN_PASSWORD` di `.env`     |
| User  | `user@ekrafbadung.test`      | `password123` (hapus untuk produksi) |

Upload foto: naikkan `upload_max_filesize` (mis. 8M) dan `post_max_size` (mis. 32M) di `php.ini`.

## Sudah punya database dari versi sebelumnya?
```bash
git pull / timpa file project, lalu:
php artisan migrate                          # menambah tabel agendas
php artisan db:seed --class=AgendaSeeder     # mengisi agenda contoh (hanya jika tabel masih kosong)
php artisan optimize:clear
```

## Fitur
- **Landing page** (`/`): tampilan asli dipertahankan. Tombol **Masuk** ada di navbar (berubah jadi *Akun Saya* /
  *Panel Admin* setelah login). Section **UMKM Directory** berisi kartu UMKM dari DB (hanya status *Disetujui*, lengkap
  dengan foto) dan, di bawahnya, **form pendaftaran** sesuai slide. Saat form terkirim, akun user otomatis dibuat dan
  langsung login; user hanya melihat & mengedit data miliknya sendiri.
- **Kalender** di landing page dibaca dari tabel `agendas`; hanya admin yang bisa menambah/ubah/hapus di `/admin/agenda`.
- **Pelaku usaha** (`/daftar`, `/login`): daftar akun → isi form UMKM → edit kapan saja di "UMKM Saya".
  Edit dari pelaku usaha mengembalikan status ke *Menunggu kurasi*.
- **Admin** (`/admin`): dashboard, **CRUD agenda kalender**, tabel data UMKM (foto, cari/filter, tambah/edit/hapus), kurasi
  setuju/tolak massal, ekspor CSV, atur role pengguna.
- **Form UMKM** sesuai slide "Struktur Website": nama pelaku usaha, nama brand, kecamatan (6 pilihan Badung),
  No. WA, alamat, foto KTP, foto NIB, foto produk (maks. 5), media sosial, cerita usaha,
  foto legalitas lain (HKI, HACCP, Halal, lainnya). Ditambah dari Excel: produk yang diajukan,
  kesiapan stand & komitmen, persetujuan data.

## Database
- `users` (+ kolom `role`: `user` / `admin`)
- `umkms` — satu baris per usaha (kolom sama dengan form di atas, plus `status` kurasi)
- `umkm_files` — foto KTP/NIB/produk/legalitas: `path` (diunggah) atau `url` (tautan Google Drive dari Excel)

KTP, NIB, dan legalitas disimpan privat (`storage/app/private`) dan hanya bisa dibuka pemilik & admin.
Nomor WA hanya tampil di website jika pelaku usaha mencentang izin.

## Data Excel
`database/seeders/data/kurasi_fesyen_kriya.csv` adalah hasil konversi sheet "Form Responses 1" (36 UMKM).
Data masuk dengan status *Menunggu kurasi*; setujui lewat `/admin/umkm` agar tampil di website.
Berkas dari Drive disimpan sebagai tautan. Impor ulang / data baru:
```bash
php artisan umkm:import path/ke/file.csv --status=pending
```
Kolom CSV: `timestamp,nama_brand,nama_pelaku,no_wa,kecamatan,alamat,media_sosial,produk,nib_url,foto_produk_urls,hki,ktp_url,kesiapan,setuju`
(nilai ganda dipisah `||`). Data dengan nama brand + No. WA yang sama diperbarui, tidak digandakan.

**Privasi:** CSV berisi data pribadi (nama, WA, tautan KTP). File ini sudah masuk `.gitignore`;
jangan di-push ke GitHub publik.

## Foto
Foto produk yang diunggah disimpan di `storage/app/public` dan disajikan lewat `public/storage` (wajib `php artisan storage:link`).
Alamat foto dibuat relatif terhadap host yang sedang dibuka, jadi tetap tampil di `127.0.0.1:8000`, `localhost`, maupun domain produksi.
Foto dari Google Drive (hasil Excel) hanya tampil jika file Drive-nya dibagikan publik; jika tidak, kartu tampil tanpa foto
sampai foto diunggah ulang lewat form edit.

## Konten statis
Subsektor, komunitas, program, event, dan struktur organisasi ada di `config/ekraf.php`
(diambil dari `js/data.js`). Ubah di sana.

## Struktur penting
```
app/Http/Controllers   Landing, Auth, Umkm (form), Admin, File
app/Http/Requests      UmkmRequest (validasi form)
app/Models             User, Umkm, UmkmFile
app/Support            UmkmCsvImporter
resources/views        landing.blade.php (UI asli), auth/, umkm/, admin/, layouts/app.blade.php (Bootstrap 5)
public/css/style.css   CSS asli landing | public/css/app.css  gaya halaman login/form/admin
public/js/main.js      JS asli landing (data kini disuntik dari DB)
```
Landing page sengaja **tidak** memuat Bootstrap karena class `.navbar`, `.modal`, `.btn`, `.container`
di CSS aslinya bentrok dengan Bootstrap dan akan mengubah tampilan. Halaman login, form, dan admin memakai Bootstrap 5.
