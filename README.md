### Deskripsi
Proyek sistem gudang ini diinisiasi dengan framework laravel untuk kebutuhan technical test menggunakan konsep rest api. Metode login menerapkan sistem token menggunakan laravel sanctum

### Role
terbagi menjadi 2 role, yaitu admin dan user. admin memiliki hak istimewa lain untuk manajemen user seperti memblokir user, restore user, promote user, add user.

### Fitur Proyek
1. CRUD Category
2. CRUD Product
3. CRUD Mutation
4. User Management
5. Authentication dan Authorization
6. Pagination dan searching
7. Soft Delete (Trashed dan Restore)
8. Audit Trail (Data product dan category)
9. Validation Form
10. Upload File (data product dan update profile)
11. Penerapan UUID (attribute code pada table products)

### Persiapan file .env 
1. setelah download proyek ke local, copas file .env.example
2. tambahkan APP_TIMEZONE=Asia/Jakarta
3. tambahkan SCOUT_DRIVER=database
4. ubah APP_URL=http://localhost:8000 atau value lain (harus sesuai dengan base url ketika running)
5. ubah APP_FAKER_LOCALE=id_ID (optional)
6. ubah FILESYSTEM_DISK=public
7. ubah konfigurasi database, rekomendasi gunakan mysql >=8
8. ubah APP_NAME=Sistem_Gudang (optional)

### Installasi di terminal
1. composer install
2. php artisan key:generate
3. php artisan storage:link
4. php artisan migrate --seed (untuk pertama kali migrate)
5. php artisan migrate:fresh --seed (untuk refresh dan migrate ulang)
6. php artisan serve 

### Link
1. postman [https://documenter.getpostman.com/view/19885257/2sB2j4gBTV]
2. github [https://github.com/ganden16/clavata-sistem-gudang]