flow :
# Aplikasi Pengganti Uang Karyawan (Reimbursement)

Ini aplikasi buat ngurusin duit pengganti pengeluaran karyawan. Jadi karyawan bisa masukin pengajuan, terus manajer bisa setuju atau nolak. Ada juga fitur buat batasin pengeluaran per bulan sama notifikasi email otomatis.

## Daftar Isi
1.  [Fitur-fitur Penting](#fitur-fitur-penting)
2.  [Gimana Cara Kerja Sistemnya (Arsitektur)](#gimana-cara-kerja-sistemnya-arsitektur)
3.  [Kenapa Dibuat Kayak Gini (Penjelasan Desain)](#kenapa-dibuat-kayak-gini-penjelasan-desain)
4.  [Cara Pasang & Jalanin di Komputer Kamu](#cara-pasang--jalanin-di-komputer-kamu)
5.  [Susahnya Bikin Ini & Solusinya](#susahnya-bikin-ini--solusinya)

## 1. Fitur-fitur Penting

* **Ngurus Penggantian Uang:**
    * Bisa masukin pengajuan dengan judul, deskripsi, nominal, kategori, status, tanggal diajuin, sama tanggal disetujuin.
    * Bisa upload bukti transaksi (PDF/JPG/PNG, maksimal 2MB).
* **Alur Pengguna:**
    * **Karyawan:** Bikin sama lihat pengajuan sendiri.
    * **Manajer:** Bisa setujuin (`approve`) atau nolak (`reject`) pengajuan.
    * **Admin:** Bisa lihat semua pengajuan yang ada.
* **Pembatasan Uang Bulanan:**
    * Tiap kategori penggantian uang ada batas maksimal per bulannya (misalnya buat transportasi, kesehatan, makanan, dll).
    * Pas karyawan ngajuin, sistem otomatis cek biar nggak ngelewatin batas bulanan itu.
* **Notifikasi Email Otomatis:**
    * Manajer bakal dapat email otomatis pas ada pengajuan baru, ini pakai fitur antrian Laravel biar nggak lemot.

## 2. Gimana Cara Kerja Sistemnya (Arsitektur)

Aplikasi ini dibikin pakai **Laravel** (PHP) buat bagian belakangnya (server) dan pakai Blade buat tampilan depannya.

* **Bagian Belakang (Laravel):**
    * **Kontroler (`Reimbursement.php`):** Di sini semua logika inti jalan, kayak ngecek data yang masuk, nyimpen data pengajuan, upload bukti transaksi ke folder `storage/app/public/reimbursement_attachments`, ngitung-itung batas pengeluaran, sampai ngirim email notifikasi.
    * **Model:**
        * `ReimbursementEmployee.php`: Ini ibarat jembatan ke tabel `reimburse_employee` di database. Dia ngerti hubungan sama tabel `User` dan `ReimbursementCategory`, terus juga otomatis ngubah kolom `submitted_at` jadi format tanggal yang gampang diproses.
        * `ReimbursementCategory.php`: Ini buat ngatur tabel kategori sama batas bulanannya.
        * `User.php`: Buat ngurus data-data pengguna.
    * **Database:** Buat nyimpen semua data pengajuan, kategori, sama pengguna.
    * **Antrian (Queues):** Ini penting banget. Pas ngirim email notifikasi, emailnya nggak langsung dikirim, tapi dimasukkin ke "antrian" dulu. Jadi aplikasi kita nggak jadi lemot nungguin email ke kirim. Ada "tukang" khusus (queue worker) yang nanti ngirimin emailnya di belakang layar.
    * **Penyimpanan File (Storage):** Buat nyimpen file bukti transaksi yang diupload. File-nya masuk ke `storage/app/public/reimbursement_attachments`, terus ada "jalan pintas" di `public/storage` biar bisa diakses lewat web.
* **Bagian Depan (Blade & HTML/CSS/JS):**
    * Tampilan aplikasinya dibikin pakai sistem template Blade di Laravel.
    * Email notifikasinya juga pakai Blade Markdown (misalnya `new_submission.blade.php`) biar tampilannya rapi. Gambar bukti transaksi bahkan langsung dimasukkin ke dalam emailnya (di-embed) biar lebih aman dan pasti kelihatan.

## 3. Kenapa Dibuat Kayak Gini (Penjelasan Desain)

* **Pengaturan Duit Pengganti (Limit Bulanan):**
    * Tiap kategori pengajuan punya jatah `limit_per_month`.
    * Nah, pas karyawan ngajuin baru (`ReimbursementController@store`), sistem langsung ngecek total pengajuan si karyawan itu buat kategori yang sama di bulan yang sama.
    * Kalau `(total_pengajuan_sekarang + nominal_pengajuan_baru)` ngelewatin `limit_per_month`, pengajuan langsung ditolak dan dikasih tahu kenapa.
    * Cara ini dipilih biar pengeluaran terkontrol dan sesuai aturan perusahaan.

* **Notifikasi Email Otomatis (Asinkron):**
    * Begitu pengajuan berhasil dibuat, aplikasi bikin "surat" email (`NewReimbursementNotification`) dan langsung masukkin ke antrian.
    * Karena "surat" ini punya tanda `ShouldQueue`, dia nggak langsung dikirim. Dia nunggu di antrian database.
    * Si "tukang" antrian (`php artisan queue:work`) nanti yang bakal ngirim emailnya di balik layar, jadi aplikasi kita nggak lambat.
    * Data-data penting kayak informasi karyawan dan kategori buat di email itu juga udah disiapin duluan di "surat"nya pas dimasukkin antrian.

## 4. Cara Pasang & Jalanin di Komputer Kamu

Ikutin langkah-langkah ini biar aplikasinya bisa jalan di komputer kamu:

1.  **Ambil Kode Programnya:**
    ```bash
    git clone <URL_REPOSITORI_KAMU>
    cd nama_folder_proyek_kamu
    ```

2.  **Pasang Kebutuhan Program:**
    ```bash
    composer install
    ```

3.  **Siapin File Pengaturan (`.env`):**
    * Copy file `.env.example` jadi `.env`:
        ```bash
        cp .env.example .env
        ```
    * Bikin kode unik aplikasi (APP_KEY):
        ```bash
        php artisan key:generate
        ```
    * Buka file `.env` dan atur koneksi ke database kamu (pakai MySQL, PostgreSQL, dll.). Contoh buat MySQL:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=nama_database_kamu
        DB_USERNAME=username_database_kamu
        DB_PASSWORD=password_database_kamu
        ```
    * **Atur Mailtrap (buat ngetes kirim email):**
        ```env
        MAIL_MAILER=smtp
        MAIL_HOST=smtp.mailtrap.io # Atau host Mailtrap kamu
        MAIL_PORT=2525 # Atau port Mailtrap kamu
        MAIL_USERNAME=username_mailtrap_kamu # Ambil dari akun Mailtrap kamu
        MAIL_PASSWORD=password_mailtrap_kamu # Ambil dari akun Mailtrap kamu
        MAIL_ENCRYPTION=tls # Biasanya 'tls' atau 'ssl', atau 'null' kalo nggak pakai
        MAIL_FROM_ADDRESS="halo@contoh.com"
        MAIL_FROM_NAME="${APP_NAME}"
        ```
    * **Atur Koneksi Antrian (Queue Driver):**
        ```env
        QUEUE_CONNECTION=database # Pakai database buat nyimpen antrian
        ```

4.  **Siapin Database (dan Isi Data Awal kalau Ada):**
    * Jalankan ini buat bikin tabel-tabel di database:
        ```bash
        php artisan migrate
        ```
    * Kalau kamu punya data awal (misalnya peran pengguna, kategori reimbursement), jalankan ini:
        ```bash
        php artisan db:seed
        ```

5.  **Bikin "Jalan Pintas" Buat File yang Diupload (Penting!):**
    * Ini harus dilakukan biar file bukti transaksi yang kamu upload bisa diakses lewat web.
    ```bash
    php artisan storage:link
    ```

6.  **Jalanin Tukang Antrian (Di terminal lain, biarin aja):**
    * Ini buat nanganin kirim email otomatis di belakang layar. Biarin terminal ini jalan terus.
    ```bash
    php artisan queue:work
    ```

7.  **Jalanin Aplikasi:**
    ```bash
    php artisan serve
    ```

8.  Buka aplikasi di browser kamu (biasanya `http://127.0.0.1:8000`).

## 5. Susahnya Bikin Ini & Solusinya

* **Susah 1: Kirim Email Otomatis & Data Nggak Ikut (Serialisasi)**
    * **Masalah:** Pas data pengajuan dikirim ke antrian buat email, data pendukungnya (kayak nama karyawan, kategori) kadang "hilang" atau nggak kebawa, jadi error.
    * **Solusi:** Kita paksa data pentingnya (`user`, `category`) buat ikut ke dalam "paket" emailnya pas Mailable (`NewReimbursementNotification`) dibikin. Jadi, pas "tukang" antrian ngirim email, semua datanya udah lengkap.

* **Susah 2: Tanggal Nggak Mau Diformat**
    * **Masalah:** Pas mau nampilin tanggal di email (`{{ $reimbursement->submitted_at->format(...) }}`), eh malah error "format() on string". Padahal itu kan kolom tanggal. Ternyata Laravel ngambilnya sebagai teks biasa.
    * **Solusi:** Kita kasih tahu model `ReimbursementEmployee.php` kalau kolom `submitted_at` itu beneran tanggal. Caranya pakai `protected $casts = ['submitted_at' => 'datetime'];`. Otomatis nanti pas diambil, dia udah jadi objek tanggal yang bisa diformat.

* **Susah 3: Nama Karyawan Nggak Muncul (Salah Kolom)**
    * **Masalah:** Kita pakai `$user->name` di email, tapi di database nama kolomnya `full_name`. Jadi nama karyawan nggak kelihatan.
    * **Solusi:** Ganti semua `$user->name` jadi `$user->full_name` di file email `NewReimbursementNotification.php` dan `new_submission.blade.php`.

* **Susah 4: Link Nggak Ditemukan (Nama Link Salah)**
    * **Masalah:** Pas di email ada tombol yang link-nya `reimbursement-menu`, tapi Laravel bilang "Route not defined". Artinya, nama link itu nggak terdaftar atau salah ketik.
    * **Solusi:** Pastikan nama link yang dipanggil di email (`route('nama_link_kamu')`) sama persis dengan nama yang didaftarin di `routes/web.php` (`->name('nama_link_kamu')`). Terus, pastiin juga controller-nya udah benar. Abis ganti link, jangan lupa jalanin `php artisan route:clear` sama `php artisan config:clear` ya.

* **Susah 5: Ngurus File Upload**
    * **Masalah:** Gimana caranya biar file bukti transaksi yang diupload bisa kesimpen rapi dan nanti bisa ditampilin di email atau diunduh.
    * **Solusi:** Kita pakai `Storage::disk('public')->store()` di controller buat nyimpen file di folder khusus `reimbursement_attachments`. Terus, jalanin `php artisan storage:link` biar ada "jalan pintas" dari web ke folder itu. Di email, kita pakai `$message->embed()` biar gambarnya langsung nempel di email, dan `Storage::url()` buat bikin tombol unduh.


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
