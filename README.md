# Allergy.tr - Alerji & İmmünoloji Portalı

Modern, modüler yapıda alerji ve immünoloji uzmanları için geliştirilmiş web portalı.

## 🎯 Özellikler

- ✅ Modüler mimari (her modül bağımsız çalışabilir)
- ✅ Alpine.js ile SPA-like navigasyon
- ✅ Responsive tasarım (mobil, tablet, desktop)
- ✅ Kullanıcı yönetimi (kayıt, giriş, oturum)
- ✅ RESTful API yapısı
- ✅ MySQL veritabanı
- ✅ Dark mode desteği
- ✅ Güvenli auth sistemi

## 📁 Proje Yapısı

```
allergy.tr/
├── api/                       # Backend API
│   ├── config/               # Konfigürasyon dosyaları
│   │   ├── app.php          # Uygulama ayarları
│   │   └── database.php     # Veritabanı ayarları
│   ├── core/                # Temel sınıflar
│   │   ├── Database.php     # Veritabanı bağlantısı
│   │   ├── Auth.php         # Kimlik doğrulama
│   │   └── Response.php     # API response helper
│   ├── modules/             # Modül API'leri
│   │   ├── desensitization/
│   │   ├── immune_deficiencies/
│   │   └── laboratory/
│   ├── auth.php            # Auth endpoints
│   └── content.php         # İçerik endpoints
├── public/                  # Web root (public_html'e yüklenecek)
│   ├── index.php           # Ana sayfa
│   ├── login.php           # Giriş sayfası
│   ├── register.php        # Kayıt sayfası
│   ├── dashboard.php       # Dashboard content
│   ├── modules/            # Modül sayfaları
│   │   ├── desensitization.php
│   │   ├── immune-deficiencies.php
│   │   ├── laboratory.php
│   │   └── guides.php
│   ├── assets/             # Statik dosyalar
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── .htaccess          # Apache yapılandırması
├── database/               # Veritabanı
│   ├── migrations/        # Tablo oluşturma script'leri
│   ├── seeds/            # Örnek veri
│   └── migrate.php       # Migration runner
└── shared/                # Paylaşılan componentler
    ├── components/       # UI componentleri
    │   ├── header.php
    │   ├── sidebar.php
    │   └── footer.php
    └── styles/          # Ortak stiller
```

## 🚀 Otomatik Deployment (GitHub Actions)

Proje, GitHub Actions ile Hostinger'e otomatik olarak deploy edilir.

### GitHub Secrets Ayarlama

GitHub repository ayarlarından **Settings > Secrets and variables > Actions** bölümüne gidin ve şu secrets'ları ekleyin:

| Secret İsmi | Açıklama | Örnek |
|------------|----------|-------|
| `HOSTINGER_HOST` | Hostinger SSH host adresi | `srv123.hostinger.com` |
| `HOSTINGER_USERNAME` | SSH kullanıcı adı | `u647793141` |
| `HOSTINGER_PASSWORD` | SSH şifresi | `your-password` |
| `HOSTINGER_PORT` | SSH port (genellikle 22) | `22` |
| `HOSTINGER_PATH` | Deployment path (public_html'in üst dizini) | `/home/u647793141/domains/allergy.tr` |

### Deployment Nasıl Çalışır?

1. **Otomatik Tetikleme:** `main`, `master` veya `claude/*` branch'lerine push yapıldığında otomatik deploy edilir
2. **SSH Bağlantısı:** GitHub Actions, Hostinger'e SSH ile bağlanır
3. **Git Pull:** Son değişiklikler Hostinger'a çekilir
4. **Dosya Senkronizasyonu:** `public/`, `api/`, `shared/`, `database/` klasörleri `public_html` yapısına kopyalanır
5. **İzin Ayarlama:** Gerekli dosya izinleri otomatik ayarlanır

### Manuel Deployment

SSH ile Hostinger'e bağlanıp manuel deployment yapmak için:

```bash
ssh u647793141@srv123.hostinger.com
cd /home/u647793141/domains/allergy.tr
git pull origin main
# Deployment script otomatik çalışacak
```

## 🚀 Kurulum

### 1. Dosyaları Yükleme

Hostinger'da `public_html` klasörüne yükleyin:

```
public_html/                 (public/ klasörünün içeriği buraya)
├── index.php
├── login.php
├── .htaccess
└── ...

api/                        (public_html dışında, bir üst dizinde)
database/                   (public_html dışında)
shared/                     (public_html dışında)
```

**ÖNEMLİ:** Güvenlik için `api/`, `database/` ve `shared/` klasörlerini `public_html` **DIŞINDA** tutun!

### 2. Veritabanı Kurulumu

SSH veya terminal erişimi ile:

```bash
cd /path/to/allergy.tr
php database/migrate.php
```

Veya manuel olarak:
1. phpMyAdmin'e girin
2. `database/migrations/` klasöründeki SQL dosyalarını sırayla çalıştırın
3. `database/seeds/` klasöründeki SQL dosyalarını çalıştırın

### 3. Konfigürasyon

`api/config/database.php` dosyasını kontrol edin (zaten ayarlanmış):

```php
'host' => 'localhost',
'database' => 'u647793141_allergytr',
'username' => 'u647793141_allergytr',
'password' => 'Qw-3456789',
```

### 4. Test

Demo hesap ile giriş yapın:
- **E-posta:** demo@allergy.tr
- **Şifre:** password123

## 📦 Modül Ekleme

Yeni bir modül eklemek için:

1. **Modül sayfası oluştur:**
```bash
public/modules/yeni-modul.php
```

2. **Modülü database'e ekle:**
```sql
INSERT INTO modules (name, title, description, icon, route, is_active, sort_order)
VALUES ('yeni-modul', 'Yeni Modül', 'Açıklama', 'icon_name', '/module/yeni-modul', TRUE, 6);
```

3. **Sidebar'a ekle** (`shared/components/sidebar.php`):
```html
<a @click.prevent="navigateTo('yeni-modul')" href="#yeni-modul">
    <span class="material-symbols-outlined">icon_name</span>
    <span>Yeni Modül</span>
</a>
```

## 🔌 Mevcut Projeleri Entegre Etme

İlaç desensitizasyonu gibi mevcut projelerinizi entegre etmek için:

### Yöntem 1: İframe (Hızlı)
```php
<!-- public/modules/desensitization.php -->
<iframe src="https://eski-sistem.com/desensitization"
        class="w-full h-screen border-0"></iframe>
```

### Yöntem 2: Full Entegrasyon (Önerilen)
```php
// public/modules/desensitization.php içine mevcut projenizin kodlarını kopyalayın
// API'leri api/modules/desensitization/ klasörüne taşıyın
```

## 🔐 Güvenlik

- ✅ Tüm şifreler bcrypt ile hash'leniyor
- ✅ PDO prepared statements (SQL injection koruması)
- ✅ CSRF token'ları (yakında eklenecek)
- ✅ XSS koruması
- ✅ Session güvenliği

**Önemli:** Production'da:
1. `api/config/app.php` içinde `debug => false` yapın
2. HTTPS kullanın
3. `.env` dosyası ile environment variables kullanın

## 🎨 Tema Özelleştirme

Renkleri değiştirmek için `shared/components/header.php` içindeki Tailwind config'i düzenleyin:

```javascript
tailwind.config = {
    theme: {
        extend: {
            colors: {
                "primary": "#135bec",  // Ana renk
                // ...
            }
        }
    }
}
```

## 📱 Mobil App için Hazırlık

API'ler zaten mobile-ready:
- RESTful endpoints
- JSON responses
- Token-based auth

React Native / Flutter app için API endpoints:
```
POST /api/auth.php?action=login
GET  /api/auth.php?action=me
GET  /api/content.php?type=recent
```

## 🐛 Hata Ayıklama

**Database bağlantı hatası:**
```bash
# Database bilgilerini kontrol edin
cat api/config/database.php
```

**404 Hatası:**
```bash
# .htaccess dosyasının yüklendiğinden emin olun
# Apache mod_rewrite aktif mi kontrol edin
```

**Login çalışmıyor:**
```bash
# Session klasörü yazılabilir mi?
# PHP session ayarları doğru mu?
```

## 📚 API Dokümantasyonu

### Auth Endpoints

**Login**
```http
POST /api/auth.php?action=login
Content-Type: application/json

{
    "email": "demo@allergy.tr",
    "password": "password123"
}
```

**Register**
```http
POST /api/auth.php?action=register
Content-Type: application/json

{
    "email": "new@example.com",
    "password": "password123",
    "full_name": "Dr. Ahmet Yılmaz",
    "title": "Dr.",
    "hospital": "İstanbul Tıp Fakültesi"
}
```

**Get Current User**
```http
GET /api/auth.php?action=me
Authorization: Bearer {token}
```

### Content Endpoints

**Get Recent Content**
```http
GET /api/content.php?type=recent
```

**Get Modules**
```http
GET /api/content.php?type=modules
```

## 🤝 Katkıda Bulunma

1. Yeni modül ekleyin
2. Bug rapor edin
3. Özellik önerisi yapın

## 📄 Lisans

Bu proje size özeldir.

## 👨‍💻 Geliştirici

Claude AI ile geliştirilmiştir.

---

**İlk Kurulum Kontrol Listesi:**
- [ ] Dosyaları yükle
- [ ] Database'i oluştur
- [ ] Migration'ları çalıştır
- [ ] Demo hesap ile giriş yap
- [ ] Modülleri test et
- [ ] Mevcut projeleri entegre et

**Sorularınız için:** Bu README'yi referans alın veya kod içindeki yorumları okuyun.
