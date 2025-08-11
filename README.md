# E-Office Laravel Template

🏢 **Sistem E-Office berbasis Laravel untuk Manajemen Administrasi Organisasi**

Template aplikasi web yang siap pakai untuk berbagai jenis organisasi seperti instansi pemerintah, perusahaan, universitas, dan organisasi non-profit.

## 📋 Fitur Utama

### 🔐 Authentication & Authorization
- Role-based access control (RBAC)
- Spatie Laravel Permission
- Multi-level user hierarchy
- IP-based login restriction

### 📄 Manajemen Surat
- **Surat Masuk**: Pencatatan dan pengarsipan surat masuk
- **Surat Keluar**: Workflow approval untuk surat keluar
- **Arsip Digital**: Sistem penyimpanan dokumen terstruktur
- **Verifikasi**: Multi-level approval system

### 🏛️ Manajemen Rapat
- Penjadwalan rapat dengan kalendar
- Sistem presensi peserta
- Manajemen undangan
- Auto-generate ID rapat

### ✈️ Perjalanan Dinas (SPPD)
- Pembuatan SPPD
- Tracking perjalanan dinas
- Laporan perjalanan dinas
- Sistem verifikasi laporan

### 📋 Manajemen Tugas
- Assignment tugas dengan bobot
- Tracking progress tugas
- Submit hasil kerja (luaran tugas)
- Workflow verifikasi

### ⏰ Sistem Presensi
- Presensi harian berbasis IP
- Presensi rapat
- Manajemen hari libur
- Dashboard kehadiran

### 📊 Logging & Audit Trail
- Activity logging
- Bobot kegiatan
- Audit trail lengkap

## 🛠️ Tech Stack

- **Framework**: Laravel 11
- **PHP**: 8.2+
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Sanctum
- **Permissions**: Spatie Laravel Permission
- **Frontend**: Blade Templates + Bootstrap
- **Build Tool**: Vite
- **File Processing**: PHPOffice/PHPWord

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- MySQL/MariaDB
- Node.js & NPM

### Installation

1. **Clone Repository**
```bash
git clone https://github.com/your-username/eoffice-laravel-template.git
cd eoffice-laravel-template
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
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Database Setup**
```bash
php artisan migrate --seed
```

6. **Storage Link**
```bash
php artisan storage:link
```

7. **Run Application**
```bash
php artisan serve
```

Visit: `http://127.0.0.1:8000`

### Default Login
```
Email: supervisorak@gmail.com
Password: password
```

## 🏗️ Architecture

### Database Schema
- **Users & Roles**: Sistem user dengan hierarki dan role
- **Documents**: Surat masuk, surat keluar dengan workflow
- **Meetings**: Rapat dengan sistem presensi
- **Travel**: Perjalanan dinas dan laporan
- **Tasks**: Manajemen tugas dan luaran
- **Attendance**: Presensi harian dan rapat
- **Logs**: Audit trail dan activity logging

### Key Models
- `User` - Users with roles and hierarchy
- `SuratMasuk/SuratKeluar` - Document management
- `Rapat` - Meeting management
- `PerjalananDinas` - Business travel
- `LuaranTugas` - Task outputs
- `PresensiHarian` - Daily attendance

### Permissions
- `revisi` - Approval/revision rights
- `buat rapat` - Create meetings
- `buat sppd` - Create travel orders
- `buat surat` - Create documents
- `lihat surat` - View documents
- `buat arsip surat` - Archive documents

## 🎯 Use Cases

### Ideal for:
- **Government Agencies** - Digital transformation
- **Universities** - Academic administration
- **Corporations** - Internal document management
- **Hospitals** - Administrative workflows
- **NGOs** - Program management

### Industry Examples:
- **Education**: Student affairs, academic records
- **Healthcare**: Patient administration, staff management
- **Finance**: Loan processing, document approval
- **Government**: Public service administration
- **Manufacturing**: Quality control, compliance

## 🔧 Customization

### Environment Templates
Create specific `.env` templates for different use cases:
- `.env.government` - Government agencies
- `.env.corporate` - Private companies
- `.env.university` - Educational institutions
- `.env.hospital` - Healthcare facilities

### Modular Design
Enable/disable modules based on requirements:
```php
// config/modules.php
return [
    'surat' => true,
    'rapat' => true,
    'perjalanan_dinas' => true,
    'presensi' => false, // Disable if not needed
];
```

### Branding Customization
- Logo replacement
- Color scheme configuration
- Email templates
- Report templates

## 📖 Documentation

- [Installation Guide](docs/installation.md)
- [User Manual](docs/user-guide.md)
- [Admin Guide](docs/admin-guide.md)
- [API Documentation](docs/api.md)
- [Customization Guide](docs/customization.md)

## 🚗 Roadmap

### Phase 1: Core Enhancement
- [ ] Multi-tenant architecture
- [ ] Advanced dashboard with analytics
- [ ] Mobile responsive design
- [ ] PWA support

### Phase 2: Advanced Features
- [ ] Digital signature integration
- [ ] Real-time notifications
- [ ] Advanced reporting
- [ ] API development

### Phase 3: Enterprise
- [ ] SSO integration
- [ ] Mobile app
- [ ] Cloud deployment
- [ ] Advanced analytics

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 💬 Support

For support and questions:
- Create an [Issue](https://github.com/your-username/eoffice-laravel-template/issues)
- Check [Documentation](docs/)
- Contact: your-email@example.com

## 🏆 Credits

Built with ❤️ using Laravel Framework

- [Laravel](https://laravel.com)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Bootstrap](https://getbootstrap.com)
- [PHPOffice](https://phpoffice.github.io)

---
**Happy Coding!** 🚀
