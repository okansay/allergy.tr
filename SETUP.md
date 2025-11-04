# Kurulum Rehberi - Hostinger

Bu rehber, Allergy.tr projesini Hostinger PHP hosting'e adım adım kurmanızı sağlar.

## 📋 Gereksinimler

- ✅ PHP 7.4 veya üzeri
- ✅ MySQL 5.7 veya üzeri
- ✅ Apache mod_rewrite
- ✅ PDO PHP extension
- ✅ JSON PHP extension

## 🔧 Adım 1: Dosya Yapısını Düzenleme

### Yerel bilgisayarınızda:

1. Bu projeyi ZIP olarak indirin
2. Aşağıdaki gibi düzenleyin:

```
allergy-tr-upload/
├── public_html/              (public/ içeriği)
│   ├── index.php
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   ├── .htaccess
│   └── modules/
└── private/                  (public dışındaki her şey)
    ├── api/
    ├── database/
    └── shared/
```

## 🚀 Adım 2: Hostinger File Manager ile Yükleme

### 2.1 Hostinger'a Giriş

1. Hostinger hPanel'e giriş yapın
2. "File Manager" açın

### 2.2 Klasör Yapısı Oluşturma

```
domains/
└── your-domain.com/          (veya allergy.tr)
    ├── public_html/          (web root)
    └── private_files/        (YENİ - oluşturun)
```

**Önemli:** `private_files` klasörünü `public_html` ile **aynı seviyede** oluşturun!

### 2.3 Dosyaları Yükleme

1. **public_html/ içine:**
   - `public/` klasöründeki tüm dosyalar

2. **private_files/ içine:**
   - `api/` klasörü
   - `database/` klasörü
   - `shared/` klasörü

## 🗄️ Adım 3: Database Kurulumu

### 3.1 Database Oluşturma

1. hPanel'den "MySQL Databases" açın
2. Şu bilgilerle database zaten var:
   - Database: `u647793141_allergytr`
   - User: `u647793141_allergytr`
   - Password: `Qw-3456789`

### 3.2 Migration Çalıştırma

**Yöntem 1: SSH ile (Önerilen)**

```bash
ssh username@your-server.com
cd domains/your-domain.com/private_files
php database/migrate.php
```

**Yöntem 2: phpMyAdmin ile**

1. hPanel'den "phpMyAdmin" açın
2. Database seçin: `u647793141_allergytr`
3. SQL sekmesine gidin
4. Sırayla şu dosyaları yükleyip çalıştırın:

```
database/migrations/001_create_users_table.sql
database/migrations/002_create_modules_table.sql
database/seeds/001_demo_users.sql
```

### 3.3 Database Bağlantısını Test Etme

Test script'i oluşturun: `public_html/test-db.php`

```php
<?php
require_once __DIR__ . '/../private_files/api/core/Database.php';

use App\Core\Database;

try {
    $db = Database::getConnection();
    echo "✅ Database bağlantısı başarılı!";

    $users = Database::query("SELECT COUNT(*) as count FROM users");
    echo "<br>Kullanıcı sayısı: " . $users[0]['count'];
} catch (Exception $e) {
    echo "❌ Hata: " . $e->getMessage();
}
?>
```

Tarayıcıda: `https://your-domain.com/test-db.php`

✅ Başarılı ise: "Database bağlantısı başarılı!" görmelisiniz
❌ Hata varsa: Database bilgilerini kontrol edin

**Güvenlik:** Test sonrası `test-db.php` dosyasını silin!

## 🔐 Adım 4: Path Düzeltmeleri

Hostinger'da klasör yapınıza göre path'leri düzeltmeniz gerekebilir.

### 4.1 Path Kontrol Script

`public_html/check-paths.php` oluşturun:

```php
<?php
$rootPath = dirname(__DIR__);
$apiPath = $rootPath . '/private_files/api';
$dbPath = $rootPath . '/private_files/database';
$sharedPath = $rootPath . '/private_files/shared';

echo "Root: " . $rootPath . "<br>";
echo "API exists: " . (file_exists($apiPath) ? '✅' : '❌') . "<br>";
echo "DB exists: " . (file_exists($dbPath) ? '✅' : '❌') . "<br>";
echo "Shared exists: " . (file_exists($sharedPath) ? '✅' : '❌') . "<br>";
?>
```

### 4.2 Path'leri Düzeltme

Eğer path'ler yanlışsa, şu dosyaları düzeltin:

**`public_html/index.php`**
```php
// Değiştir:
require_once __DIR__ . '/../api/core/Auth.php';

// Şununla:
require_once __DIR__ . '/../private_files/api/core/Auth.php';
```

**`public_html/login.php` ve `public_html/register.php`**
```php
// Değiştir:
include __DIR__ . '/../shared/components/header.php';

// Şununla:
include __DIR__ . '/../private_files/shared/components/header.php';
```

## ⚙️ Adım 5: .htaccess Ayarları

`public_html/.htaccess` dosyası zaten hazır, kontrol edin:

```apache
RewriteEngine On
RewriteBase /

# API yönlendirmesi - path'i düzeltin
RewriteRule ^api/(.*)$ ../private_files/api/$1 [L]

# ... (diğer kurallar)
```

## 🧪 Adım 6: Test

### 6.1 Ana Sayfa Testi
```
https://your-domain.com/
```
✅ Dashboard görünmeli

### 6.2 Login Testi
```
https://your-domain.com/login
```

Demo hesap:
- Email: `demo@allergy.tr`
- Password: `password123`

### 6.3 API Testi

Tarayıcıda:
```
https://your-domain.com/api/content.php?type=modules
```
✅ JSON response görmeli

## 🐛 Yaygın Hatalar ve Çözümleri

### Hata 1: "Database connection failed"

**Çözüm:**
```bash
# Database bilgilerini kontrol edin
cat private_files/api/config/database.php

# Hostinger'da doğru mu?
Host: localhost ✅
Database: u647793141_allergytr
User: u647793141_allergytr
Password: Qw-3456789
```

### Hata 2: "500 Internal Server Error"

**Çözüm:**
1. PHP error log'ları kontrol edin (hPanel > Error Logs)
2. Path'leri kontrol edin
3. Dosya izinlerini kontrol edin:
   ```bash
   chmod 755 public_html/
   chmod 644 public_html/*.php
   ```

### Hata 3: "404 Not Found" (API)

**Çözüm:**
```apache
# .htaccess'te mod_rewrite aktif mi?
<IfModule mod_rewrite.c>
  RewriteEngine On
  # ...
</IfModule>

# Eğer çalışmıyorsa, Apache mod_rewrite kapalı olabilir
# Hostinger support'a yazın
```

### Hata 4: "Headers already sent"

**Çözüm:**
```php
// PHP dosyalarında <?php'den önce boşluk/satır olmamalı
// UTF-8 BOM olmamalı
// Header fonksiyonlarından önce echo/print olmamalı
```

### Hata 5: Session çalışmıyor

**Çözüm:**
```bash
# Session klasörü yazılabilir mi?
chmod 777 /tmp  # veya session.save_path

# PHP session ayarları
session.save_handler = files
session.save_path = "/tmp"
```

## 📱 Adım 7: Mobil Test

1. Telefon/tabletten siteyi açın
2. Responsive görünümü kontrol edin
3. Mobil menü çalışıyor mu?

## 🔒 Adım 8: Production Ayarları

**Önemli:** Production'a geçmeden önce:

### 8.1 Debug Modunu Kapat

`private_files/api/config/app.php`:
```php
'environment' => 'production',
'debug' => false,
```

### 8.2 Error Display Kapat

`public_html/.htaccess` en üste ekle:
```apache
php_flag display_errors Off
php_flag log_errors On
```

### 8.3 HTTPS Aktif Et

`.htaccess` içinde uncomment:
```apache
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST%}/$1 [R=301,L]
```

### 8.4 Güvenlik Kontrol

- [ ] Test dosyalarını sil (`test-db.php`, `check-paths.php`)
- [ ] Demo hesap şifresini değiştir
- [ ] Database şifresini güçlendir
- [ ] CSRF protection ekle (TODO)

## ✅ Kurulum Kontrol Listesi

- [ ] Dosyalar yüklendi (`public_html/` ve `private_files/`)
- [ ] Database oluşturuldu
- [ ] Migration'lar çalıştırıldı
- [ ] Path'ler düzeltildi
- [ ] `.htaccess` çalışıyor
- [ ] Ana sayfa açılıyor
- [ ] Login/Register çalışıyor
- [ ] Demo hesap ile giriş yapıldı
- [ ] Modüller açılıyor
- [ ] API endpoint'leri çalışıyor
- [ ] Mobil görünüm test edildi
- [ ] Production ayarları yapıldı

## 🎉 Tamamlandı!

Artık projeniz hazır!

**Sonraki adımlar:**
1. Kendi içeriklerinizi ekleyin
2. Mevcut projelerinizi entegre edin
3. Yeni modüller geliştirin

**Yardıma mı ihtiyacınız var?**
- `README.md` dosyasına bakın
- Kod içindeki yorumları okuyun
- Test script'lerini çalıştırın

---

**Not:** Bu kurulum Hostinger Shared Hosting için optimize edilmiştir. VPS veya farklı hosting kullanıyorsanız path'ler değişebilir.
