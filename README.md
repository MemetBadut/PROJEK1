<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## [ℹ️]About This Project 

Project Libray mister John ini merupakan project lanjutan dari project lama yang pernah aku buat. Dalam project kali ini, aku membuat website sederhana untuk perpustakaan milik Pak John karena dia memiliki perpustakaan pribadi. Project ini 


## 📃Cara menggunakan project Library 📃
1. Siapkan folder baru dan lakukan "clone" dengan command "git clone" pada folder (agar bisa mengakses git repository)
    ```bash
    git clone https://github.com/MemetBadut/PROJEK1.git

2. Jika sudah, install package dengan "composer install dan npm install"
     1. composer install (code dibawah sebagai contoh) : 
    ```bash
    PS C:\laragon\www\library>composer install
    ```
    2. npm install (code dibawah sebagai contoh) :
    ```bash
    PS C:\laragon\www\library>npm install
    ```
3. Salin .env.example untuk konfigurasi file .env :
   ```bash
   PS C:\laragon\www\library>cp .env.example .env
   ```
    Dan lakukan konfigurasi pada bagian :
   ```
   DB_CONNECTION=sqlite  => ubah jadi Mysql
   # DB_HOST=127.0.0.1   => biarkan 
   # DB_PORT=3306        => ini default, bisa disesuaikan 
   # DB_DATABASE=laravel => ganti sebagai laravel_tokobuku
   # DB_USERNAME=root    => bisa dihapus/biarkan
   # DB_PASSWORD=        => bisa titambahkan/biarkan
   ```
4. Jalankan artisan untuk generate key baru
   ```bash
    PS C:\laragon\www\library>php artisan key:generate
   --------------------------------------------------------
   Ini digunakan untuk membuat Application Key pada project
   ```
5. Jalankan command artisan untuk generate tabel pada migration
   ```bash
   PS C:\laragon\www\library>php artisan migrate
   ```
   atau langsung seeding database
   ```bash
   PS C:\laragon\www\library>php artisan migrate:fresh --seed
   ```
6. Untuk mengakses fitur Input Rating dan Auhtor, perlu melakukan login :<br>
   → Admin : bagindaadmin@gmail.com   | adminmin
   <br>
   → User  : (bisa ambil email bebas) | userser
7. Dan Project bisa siap digunakan





