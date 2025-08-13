# E-Office Laravel

🏢 **Sistem E-Office berbasis Laravel untuk Manajemen Administrasi Organisasi**

Template aplikasi web yang siap pakai untuk berbagai jenis organisasi seperti instansi pemerintah, perusahaan, universitas, dan organisasi non-profit.

## 🚀 Status Pengembangan

**⚠️ PROYEK DALAM PENGEMBANGAN AKTIF**

Proyek ini sedang dalam tahap modernisasi UI dan pengembangan fitur baru. Beberapa modul telah diperbarui dengan desain modern, sementara yang lain masih dalam proses.

### ✅ Modul yang Telah Dimodernisasi
- **Surat Keluar**: Index, Verifikasi, dan Arsip dengan UI modern
- **Dashboard**: Layout responsif dengan navigasi yang diperbaiki
- **Authentication**: Sistem permission yang disederhanakan

### 🔄 Dalam Proses
- Modernisasi UI untuk modul lainnya
- Responsive design improvement
- Component standardization

## 📋 Fitur Utama

### 🔐 Authentication & Authorization
- Role-based access control (RBAC)
- Spatie Laravel Permission
- Multi-level user hierarchy
- IP-based login restriction

### 📄 Manajemen Surat
- **Surat Masuk**: Pencatatan dan pengarsipan surat masuk
- **Surat Keluar**: Workflow approval untuk surat keluar ✨ **NEW UI**
- **Arsip Digital**: Sistem penyimpanan dokumen terstruktur ✨ **NEW UI**
- **Verifikasi**: Multi-level approval system ✨ **NEW UI**

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
- **Frontend**: Blade Templates + Tailwind CSS ✨ **UPDATED**
- **Components**: Alpine.js for interactivity ✨ **NEW**
- **Build Tool**: Vite
- **File Processing**: PHPOffice/PHPWord

## 🎨 Modern UI Features

### Design System
- ✅ **Consistent Color Scheme**: Primary blue theme dengan status colors
- ✅ **Responsive Design**: Mobile-first approach
- ✅ **Component Library**: Reusable modern components
- ✅ **Interactive Elements**: Smooth animations dan hover effects
- ✅ **Search Interface**: Real-time search dengan filtering
- ✅ **Modern Tables**: Clean data display dengan sorting
- ✅ **Status Indicators**: Visual badges untuk status tracking
- ✅ **Modal System**: Modern confirmation dialogs

### Surat Keluar Module (Recently Updated)
- **Modern Index Page**: Clean table design dengan search dan filtering
- **Verification Interface**: Tab-based navigation untuk pending/completed
- **Archive Management**: Dual-file display untuk original dan archived documents
- **Status Management**: Visual status indicators dengan color coding
- **Responsive Layout**: Optimal viewing pada semua device sizes

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
Supervisor:
Email: supervisorak@gmail.com
Password: password

Sekretaris:
Email: sekretaris@gmail.com  
Password: password

Pengelola Keuangan:
Email: pengelolakeuangan@gmail.com
Password: password

Pengadministrasi Persuratan:
Email: pengadministrasipersuratan@gmail.com
Password: password
```

**Note**: Semua user default menggunakan password yang sama untuk testing purposes.

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

## 🚗 Roadmap

### Phase 1: UI Modernization (In Progress)
- ✅ **Surat Keluar Module**: Complete UI overhaul
- 🔄 **Surat Masuk Module**: Planned for next update
- 🔄 **Rapat Module**: UI improvement planning
- 🔄 **SPPD Module**: Modern interface design
- 🔄 **Dashboard Analytics**: Enhanced data visualization

### Phase 2: Core Enhancement
- [ ] Multi-tenant architecture
- [ ] Advanced dashboard with analytics
- [ ] Mobile responsive design improvement
- [ ] PWA support
- [ ] Real-time notifications

### Phase 3: Advanced Features
- [ ] Digital signature integration
- [ ] Advanced reporting engine
- [ ] API development untuk mobile app
- [ ] Workflow automation

### Phase 4: Enterprise
- [ ] SSO integration
- [ ] Mobile app companion
- [ ] Cloud deployment options
- [ ] Advanced analytics dan business intelligence

## 🐛 Known Issues & Limitations

- **Mixed UI Styles**: Beberapa modul masih menggunakan Bootstrap lama
- **LuaranTugasSeeder**: Memerlukan koneksi ke external API (anjab-abk.test)
- **Mobile Responsiveness**: Beberapa halaman lama perlu penyempurnaan
- **Permission System**: Sedang dalam penyederhanaan untuk UX yang lebih baik

## 🔄 Recent Updates (Version 2.0-dev)

### UI/UX Improvements
- ✅ Migrated from Bootstrap to Tailwind CSS untuk design consistency
- ✅ Implemented modern component library
- ✅ Added Alpine.js for better interactivity
- ✅ Enhanced permission system dengan role defaults
- ✅ Improved navigation dan sidebar design
- ✅ Added search functionality dengan real-time filtering
- ✅ Modern modal system untuk confirmations

### Technical Improvements  
- ✅ Route middleware optimization
- ✅ Permission seeder improvements
- ✅ Cache management enhancements
- ✅ Component reusability improvements

## 🤝 Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open Pull Request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.


## 🏆 Credits

Built with ❤️ using Laravel Framework

- [Laravel](https://laravel.com)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [Bootstrap](https://getbootstrap.com)
- [PHPOffice](https://phpoffice.github.io)

---
**Happy Coding!** 🚀
