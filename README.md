
# 📖 Judul Projek

Sistem Informasi Gaya Hidup Sehat Berbasis _Weather_ API untuk Masyarakat Perkotaan Berbasis _Website_
---

## 🌐 Demo

[Live Demo] https://mengsehat.free.nf/


## 🚀 Fitur Utama
__Sebagai User__ :
- Login dan Registrasi
- Deteksi lokasi otomatis menggunakan _Geolocation API_
- Menampilkan cuaca _real-time_ dengan _OpenWeather API_
- Rekomendasi kegiatan/aktivitas berdasarkan cuaca

**Sebagai Admin** :
- Manajemen rekomendasi kegiatan
- Manajemen user/pengguna


## 🛠️ Teknologi yang Digunakan

- Frontend: HTML, CSS, JavaScript
- Framework: Laravel + Blade
- Styling: Tailwind CSS
- API: OpenWeatherMap API & Geolocation API
- Deployment: InfinityFree


## 🚀 Cara Menjalankan Proyek

Ikuti langkah-langkah berikut untuk menjalankan proyek di lokal Anda:

### 1. Clone Repository

```
git clone https://github.com/Suryzw/SDG-3_Mengsehat.git
cd SDG-3_Mengsehat
```

### 2. Install Dependensi PHP

```
composer install
```

### 3. Install Dependensi Frontend

```
npm install && npm run build
```

### 4. Salin File Environment

```
cp .env.example .env
```

### 5. Konfigurasi File
Edit ```.env``` sesuai kebutuhan, terutama bagian koneksi database dan nama aplikasi.

### 6. Generate App Key
```php artisan key:generate```

### 7. Jalankan Migrasi Database (Optional)
```php artisan migrate --seed```

### 8. Jalankan Server
```composer run dev```

Aplikasi akan tersedia di http://localhost:8000

### 📦 Catatan
Folder berikut tidak termasuk dalam repository karena diabaikan oleh .gitignore:

```vendor/``` → Harus di-install dengan composer install

```node_modules/``` → Harus di-install dengan npm install

---
    
## ⚙️ Konfigurasi Tambahan
### Penggunaan API
Untuk menggunakan fitur cuaca, daftarkan API key di https://openweathermap.org/ dan tambahkan ke file ```.env```:
```
OPENWEATHER_API_KEY=your_api_key
```

### Penggunaan Database
Pada ```.env```, bagian ini diisi dengan database yang digunakan
```
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```
## 👤 Kontributor / Penulis

Dibuat oleh :
- Lily Fitri Hasanah 
- Febriansyah   
- Achmad Farhan Islamy 
- Muhammad Faqih Nefawan


## 📝Lisensi

Proyek ini dilisensikan dengan [MIT License](LICENSE) oleh [ITPLN](https://itpln.ac.id/).
