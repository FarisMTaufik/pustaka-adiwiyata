# 📚 Pustaka Adiwiyata

Sistem perpustakaan digital dengan tema lingkungan Adiwiyata yang mengintegrasikan manajemen buku, peminjaman, dan gamification literasi untuk mendukung pendidikan lingkungan berkelanjutan.

## 🎯 Tema & Studi Kasus

**Sistem Perpustakaan Adiwiyata** - Aplikasi perpustakaan digital yang dirancang khusus untuk mendukung program Adiwiyata di sekolah dengan fokus pada literasi lingkungan dan gamification sistem poin literasi.

### Fitur Khusus Adiwiyata:
- 📖 **Katalog Buku Lingkungan**: Kategori khusus buku bertema lingkungan
- 🌱 **Gamification Literasi**: Sistem poin untuk aktivitas literasi
- 📊 **Dashboard Lingkungan**: Statistik peminjaman buku bertema lingkungan
- 🏆 **Leaderboard Anggota**: Ranking berdasarkan poin literasi

## 🚀 Fitur Utama

### 👥 **Frontend (Akses Terbuka)**
- 🏠 **Beranda**: Informasi perpustakaan dan buku terbaru
- 📚 **Katalog Buku**: Pencarian dan filter buku
- 📖 **Detail Buku**: Informasi lengkap dan ulasan
- ℹ️ **Tentang Kami**: Informasi perpustakaan

### 🔐 **Member Area (Login Required)**
- 👤 **Profile Anggota**: Informasi pribadi dan statistik literasi
- 📚 **Peminjaman Buku**: Request peminjaman dan reservasi
- ⭐ **Sistem Poin**: Tracking aktivitas literasi
- 📝 **Ulasan Buku**: Memberikan rating dan komentar

### 👨‍💼 **Admin Panel (Role-based Access)**
- 📊 **Dashboard Admin**: Statistik dan laporan lengkap
- 📚 **Manajemen Buku**: CRUD buku dengan kategori Adiwiyata
- 👥 **Manajemen Anggota**: Kelola data anggota
- 📋 **Peminjaman**: Approve, return, dan cancel peminjaman
- 📅 **Reservasi**: Kelola reservasi buku
- 🏷️ **Kategori**: Manajemen kategori buku
- ⭐ **Poin Literasi**: Tambah poin manual dan tracking
- 📈 **Laporan**: Statistik dan analisis

## 🛠️ Teknologi yang Digunakan

### **Backend**
- **Framework**: Laravel 10.x
- **Database**: MySQL
- **Authentication**: Laravel Auth dengan Gates & Policies
- **Testing**: PHPUnit

### **Frontend**
- **CSS Framework**: Bootstrap 5.3.2
- **Icons**: Bootstrap Icons
- **Build Tool**: Vite
- **JavaScript**: Vanilla JS

### **Development Tools**
- **Package Manager**: Composer & npm
- **Version Control**: Git
- **IDE**: Laravel-friendly editors

## 📊 Struktur Database

### **Tabel Utama (Prefix: faris_)**
| Tabel | Deskripsi | Relasi |
|-------|-----------|---------|
| `faris_categories` | Kategori buku | - |
| `faris_books` | Data buku | ↔ categories |
| `faris_members` | Data anggota | ↔ users |
| `faris_borrowings` | Peminjaman | ↔ books, members |
| `faris_reservations` | Reservasi | ↔ books, members |
| `faris_literacy_points` | Poin literasi | ↔ members |
| `faris_reviews` | Ulasan buku | ↔ books, members |

### **Relasi Foreign Key**
- `faris_books.category_id` → `faris_categories.id`
- `faris_borrowings.book_id` → `faris_books.id`
- `faris_borrowings.member_id` → `faris_members.id`
- `faris_reservations.book_id` → `faris_books.id`
- `faris_reservations.member_id` → `faris_members.id`
- `faris_literacy_points.member_id` → `faris_members.id`
- `faris_reviews.book_id` → `faris_books.id`
- `faris_reviews.member_id` → `faris_members.id`

## 🔐 Sistem Keamanan & Authorization

### **Middleware Implementation**
```php
// Authentication Middleware
Route::middleware('auth')->group(function () {
    // Member routes
});

// Authorization Middleware
Route::middleware('can:admin')->group(function () {
    // Admin routes
});
```

### **Gates & Policies**
- **`admin` Gate**: Akses ke halaman admin
- **`borrow-book` Gate**: Izin meminjam buku
- **Role-based Access**: Member vs Admin

## 📦 Instalasi & Setup

### **Prerequisites**
- PHP >= 8.1
- Composer
- MySQL
- Node.js & npm

### **Step-by-Step Installation**

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd pustaka-adiwiyata
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   ```bash
   # Edit .env file
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pustaka_adiwiyata
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run Migrations & Seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build Assets**
   ```bash
   npm run build
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

### **Default Admin Account**
- **Email**: `admin@example.com`
- **Password**: `password`

## 🎮 Gamification System

### **Sistem Poin Literasi**
- **Peminjaman Buku**: +5 poin
- **Peminjaman Buku Adiwiyata**: +10 poin
- **Ulasan Buku**: +3 poin
- **Kegiatan Lingkungan**: +15 poin
- **Workshop Adiwiyata**: +20 poin

### **Level System**
- **Bronze**: 0-50 poin
- **Silver**: 51-100 poin
- **Gold**: 101-200 poin
- **Platinum**: 201+ poin

## 📱 Fitur Responsive

- **Mobile-First Design**: Bootstrap responsive grid
- **Cross-Browser Compatible**: Modern browser support
- **Progressive Web App**: PWA-ready features

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=BookTest
```

## 📈 Performance Optimization

- **Database Indexing**: Optimized queries
- **Lazy Loading**: Efficient relationship loading
- **Caching**: Route and view caching
- **Asset Optimization**: Minified CSS/JS

## 🔧 Maintenance

### **Regular Tasks**
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Update dependencies
composer update
npm update
```

### **Database Backup**
```bash
php artisan backup:run
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📞 Support

Untuk pertanyaan atau dukungan teknis, silakan hubungi:
- **Email**: support@pustaka-adiwiyata.com
- **Documentation**: [Wiki](https://github.com/username/pustaka-adiwiyata/wiki)

---

**Pustaka Adiwiyata** - Membangun Literasi Lingkungan untuk Masa Depan Berkelanjutan 🌱📚
