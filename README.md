# Aplikasi Kasir Joy Risolasido

Aplikasi kasir Joy Risolasido dikembangkan dengan tujuan utama untuk memberikan dukungan dalam pengelolaan barang selama proses transaksi. Aplikasi ini dirancang dengan empat fitur utama, yaitu Dashboard, Pembayaran, Inventori, dan Laporan.

## Deskripsi Proyek

Aplikasi kasir Joy Risolasido merupakan solusi pengelolaan transaksi yang dirancang untuk memudahkan proses pembayaran dan pengelolaan inventori. Dengan fokus pada keempat fitur utama, aplikasi ini memberikan kemudahan bagi pengguna dalam melacak informasi, melakukan pembayaran, mengelola stok barang, dan menghasilkan laporan transaksi.


## Rancangan Arsitektur
Berikut merupakan monolitik diagram 1 tier aplikasi joy risolasido:

![Arsitektur Monolitik](https://github.com/RioFarhan14/Website-kasir-joyrisolasido-with-laravel/blob/main/public/img/Screenshot%202024-01-22%20112323.png)


### Antarmuka Pengguna (UI)

Modul ini bertanggung jawab untuk menangani tampilan dan interaksi pengguna. Semua elemen UI, seperti halaman, formulir, dan elemen lainnya, terkandung dalam modul ini. Pengguna berinteraksi dengan aplikasi melalui antarmuka pengguna ini untuk menjalankan berbagai fungsi, termasuk melakukan pembayaran, manajemen inventori, dan melihat laporan.

### Pembayaran

Modul pembayaran menangani semua aspek terkait proses pembayaran dalam aplikasi. Ini mencakup logika bisnis terkait transaksi keuangan.

### Inventori

Modul inventori berfokus pada manajemen stok barang. Di dalamnya, terdapat logika bisnis untuk menambah, menghapus, atau memperbarui informasi barang dalam database. Pengelolaan inventori termasuk kontrol stok dan pembaruan status.

### Laporan

Modul ini menyediakan fungsionalitas untuk menghasilkan laporan terkait aktivitas transaksi dan status inventori. Informasi ini diambil dari database dan diformat sesuai kebutuhan.

## Struktur Navigasi

![Struktur Navigasi](https://github.com/RioFarhan14/Website-kasir-joyrisolasido-with-laravel/blob/main/public/img/WhatsApp%20Image%202024-01-16%20at%2000.49.24.jpeg)

## Diagram Alir Data (DFD)

### Level 0 DFD

![Level 0 DFD](https://github.com/RioFarhan14/Website-kasir-joyrisolasido-with-laravel/blob/main/public/img/Screenshot%202024-01-22%20105744.png)

## Fitur Aplikasi

1. **Dashboard**

    - Menyediakan tampilan visual komprehensif terkait dengan status keseluruhan sistem.
    - Memungkinkan pengguna melacak informasi penting dan mengakses ringkasan transaksi.

2. **Pembayaran**

    - Dirancang untuk menyederhanakan proses pembayaran.
    - Memastikan transaksi dilakukan dengan mudah dan aman melalui antarmuka yang intuitif.

3. **Inventori**

    - Memungkinkan pengguna untuk mengelola stok barang secara efisien.
    - Termasuk penambahan, penghapusan, dan pembaruan informasi inventori.

4. **Laporan**
    - Memberikan kemampuan untuk menghasilkan laporan terperinci mengenai aktivitas transaksi dan status inventori.
    - Menyediakan informasi yang berguna untuk analisis dan pengambilan keputusan.

## Ringkasan Keseluruhan

Aplikasi Kasir Joy Risolasido menyatukan keempat fitur utamanya untuk meningkatkan efisiensi pengelolaan barang dalam konteks transaksi. Dengan memberikan pengguna akses cepat dan informatif, diharapkan aplikasi ini dapat mempermudah pengguna dalam proses transaksi sehari-hari dan meningkatkan efisiensi operasional.

## Cara instalasi

Pastikan sebelumnya Anda telah menginstal perangkat lunak berikut:

 - PHP 8 keatas
 - Composer
 - Web server(Apache)
 - Mysql
 - Git
   
### Langkah-langkah Instalasi

    1. Clone Repositori
    
       git clone https://github.com/RioFarhan14/Website-kasir-joyrisolasido-with-laravel.git
       
    2. Pindah ke Direktori Proyek
    
        cd Website-kasir-joyrisolasido-with-laravel
    
    3. Salin File .env
        Duplikat file .env.example dan ganti namanya menjadi .env. Sesuaikan konfigurasi database dan konfigurasi lainnya sesuai kebutuhan Anda.

        cp .env.example .env

    4. Install Dependencies Composer

        composer install

    5. Generate App Key

        php artisan key:generate

    6. Jalankan Migrasi Database dan seeder

        php artisan migrate --seed

    7. Jalankan Server Lokal

        php artisan serve

        

