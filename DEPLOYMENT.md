# 🚀 Deployment Guide - Allergy.tr

Bu dosya, projenizi Hostinger'a nasıl kolayca deploy edeceğinizi gösterir.

## 🎯 Seçenekler (Kolay → Zor)

### 1️⃣ Otomatik Deploy (GitHub Actions) - EN KOLAY ⭐

**Bir kez kurulum yapın, sonra her push otomatik deploy olsun!**

#### Kurulum:

**A. GitHub Secrets Ekleyin:**

1. GitHub repository → Settings → Secrets and variables → Actions
2. "New repository secret" butonuna tıklayın
3. Şu secret'ları ekleyin:

```
Name: HOSTINGER_HOST
Value: ssh.yourdomain.com (Hostinger'dan alın)

Name: HOSTINGER_USERNAME
Value: u123456789 (SSH kullanıcı adınız)

Name: HOSTINGER_PASSWORD
Value: your-ssh-password (SSH şifreniz)

Name: HOSTINGER_PATH
Value: /home/u123456789/domains/yourdomain.com
```

**B. İlk Deploy:**

```bash
git add .github/workflows/deploy.yml
git commit -m "feat: Add automatic deployment"
git push
```

**✅ TAMAM! Artık her push'da otomatik deploy olur.**

---

### 2️⃣ SSH Deploy Script - ÇOK KOLAY ⭐⭐

**Tek komutla deploy edin!**

#### İlk Kullanım:

```bash
# Script'i çalıştırılabilir yapın
chmod +x deploy.sh

# Deploy edin
./deploy.sh
```

Sorulacak bilgiler:
- SSH Host: `ssh.yourdomain.com`
- SSH Username: `u123456789`
- SSH Password: `*****`
- Remote Path: `/home/u123456789/domains/yourdomain.com`

**Credentials'ı kaydet** diyorsanız, sonraki deployment:

```bash
./deploy.sh --auto
```

**HEPSİ BU!** ✅

---

### 3️⃣ Manuel SSH + Git - KOLAY ⭐⭐⭐

**Hostinger'da SSH varsa en stabil yöntem.**

#### İlk Kurulum (Sadece Bir Kez):

```bash
# 1. SSH ile bağlanın
ssh u123456789@ssh.yourdomain.com

# 2. Projeye gidin
cd domains/yourdomain.com

# 3. Klasör yapısını hazırlayın
# Mevcut dosyaları yedekleyin
mv public_html public_html_backup
mkdir public_html

# 4. Git clone
git clone -b claude/allergy-portal-dashboard-011CUoRQwKL75DR6xs1K8yHJ \
    https://github.com/okansay/allergy.tr.git project

# 5. Dosyaları doğru yerlere taşıyın
cp -r project/public/* public_html/
cp -r project/api ./
cp -r project/database ./
cp -r project/shared ./
cp project/.htaccess public_html/

# 6. .git klasörünü sakla (updates için)
cp -r project/.git ./

# 7. Geçici klasörü sil
rm -rf project

# 8. Database migration
cd database
php migrate.php
cd ..
```

#### Bundan Sonra Güncelleme (10 saniye!):

```bash
# SSH'ye bağlan
ssh u123456789@ssh.yourdomain.com

# Pull yap
cd domains/yourdomain.com
git pull origin claude/allergy-portal-dashboard-011CUoRQwKL75DR6xs1K8yHJ

# TAMAM! ✅
```

---

### 4️⃣ FTP Manuel Yükleme - ESKI YÖNTEM (Önerilmez)

**Son çare olarak kullanın.**

1. GitHub'dan ZIP indir
2. Extract et
3. FileZilla/FTP ile yükle

❌ **Sorunlar:**
- Çok yavaş
- Hata yapmaya açık
- Her dosyayı manuel seçmek gerekir

---

## 🔍 Hostinger SSH Bilgilerini Nereden Bulabilirim?

### Yöntem 1: hPanel'den

1. Hostinger hPanel'e giriş yapın
2. **Advanced → SSH Access**
3. SSH bilgilerinizi görün:
   - Host: `ssh.yourdomain.com` veya `123.45.67.89`
   - Port: `22`
   - Username: `u123456789`
   - Password: hPanel şifreniz (veya SSH key)

### Yöntem 2: Hosting Details

1. Hosting → Manage
2. "SSH Access" bölümü

---

## 🧪 Test Etme

Deploy sonrası test edin:

```bash
# SSH'de
cd domains/yourdomain.com/public_html
php -v  # PHP version
ls -la  # Dosyaları kontrol

# Database test
cd ../database
php migrate.php
```

**Tarayıcıda:**
- https://yourdomain.com → Ana sayfa
- https://yourdomain.com/login.php → Login sayfası
- https://yourdomain.com/api/content.php?type=modules → API test

---

## ❓ Sık Sorulan Sorular

### Q: SSH şifremi nereden bulabilirim?
**A:** Hostinger hPanel şifreniz = SSH şifreniz (genelde)

### Q: SSH erişimim yok, ne yapmalıyım?
**A:** Hostinger planınızı kontrol edin. Premium+ planlarda SSH var.

### Q: GitHub Actions çalışmıyor?
**A:** Secret'ları kontrol edin. Tam olarak doğru girilmeli.

### Q: Her push'da deploy istemiyorum?
**A:** `.github/workflows/deploy.yml` dosyasındaki branch'leri düzenleyin.

### Q: Deploy başarısız oluyor?
**A:**
1. SSH bilgilerini kontrol edin
2. Path'i kontrol edin (`pwd` ile)
3. Git installed mı kontrol edin (`git --version`)

---

## 🎯 Önerilen Workflow

**Local Development:**
```bash
# Kod yaz
git add .
git commit -m "feat: yeni özellik"
git push
```

**Otomatik (GitHub Actions varsa):**
- ✅ Otomatik deploy olur!

**Manuel (SSH varsa):**
```bash
ssh u123456789@ssh.yourdomain.com
cd domains/yourdomain.com && git pull
```

---

## 📞 Yardım

Sorun mu var? Kontrol edin:

```bash
# SSH bağlantı testi
ssh u123456789@ssh.yourdomain.com "echo 'SSH works!'"

# Git testi
ssh u123456789@ssh.yourdomain.com "git --version"

# Path testi
ssh u123456789@ssh.yourdomain.com "pwd; ls -la"
```

Hala sorun varsa:
1. Hostinger support'a yazın
2. SSH access isteyin
3. Git installed mı kontrol ettirin

---

**Kolay gelsin! 🚀**
