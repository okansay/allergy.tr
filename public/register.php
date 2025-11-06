<?php
$pageTitle = 'Kayıt Ol - Allergy.tr';
?>
<?php include __DIR__ . '/../shared/components/simple-header.php'; ?>

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md" x-data="registerForm()">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary text-5xl">health_and_safety</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Allergy.tr</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Alerji & İmmünoloji Portalı</p>
        </div>

        <!-- Register Form -->
        <div class="bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-800 rounded-xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Kayıt Ol</h2>

            <!-- Error Message -->
            <div x-show="error" x-text="error"
                 class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-lg text-sm">
            </div>

            <!-- Success Message -->
            <div x-show="success" x-text="success"
                 class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg text-sm">
            </div>

            <form @submit.prevent="handleRegister">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Ad Soyad *
                        </label>
                        <input type="text"
                               x-model="form.full_name"
                               required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="Dr. Ahmet Yılmaz">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Unvan
                            </label>
                            <select x-model="form.title"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="">Seçin</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Uzm. Dr.">Uzm. Dr.</option>
                                <option value="Doç. Dr.">Doç. Dr.</option>
                                <option value="Prof. Dr.">Prof. Dr.</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Telefon
                            </label>
                            <input type="tel"
                                   x-model="form.phone"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                                   placeholder="05XX XXX XX XX">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            E-posta *
                        </label>
                        <input type="email"
                               x-model="form.email"
                               required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="doktor@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Hastane/Kurum
                        </label>
                        <input type="text"
                               x-model="form.hospital"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="İstanbul Tıp Fakültesi">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Şifre *
                        </label>
                        <input type="password"
                               x-model="form.password"
                               required
                               minlength="6"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="••••••••">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">En az 6 karakter</p>
                    </div>

                    <button type="submit"
                            :disabled="loading"
                            class="w-full py-3 px-4 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 focus:ring-4 focus:ring-primary/20 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                            x-text="loading ? 'Kayıt yapılıyor...' : 'Kayıt Ol'">
                        Kayıt Ol
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Zaten hesabınız var mı?
                    <a href="/login.php" class="text-primary font-medium hover:underline">Giriş Yapın</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Define registerForm before Alpine loads
    document.addEventListener('alpine:init', () => {
        Alpine.data('registerForm', () => ({
            form: {
                full_name: '',
                title: '',
                email: '',
                phone: '',
                hospital: '',
                password: ''
            },
            loading: false,
            error: '',
            success: '',

            async handleRegister() {
                this.error = '';
                this.success = '';
                this.loading = true;

                try {
                    const response = await fetch('/api/auth.php?action=register', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.form)
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.success = data.message;
                        setTimeout(() => {
                            window.location.href = '/login.php';
                        }, 2000);
                    } else {
                        this.error = data.message;
                    }
                } catch (error) {
                    console.error('Register error:', error);
                    this.error = 'Kayıt olurken bir hata oluştu';
                } finally {
                    this.loading = false;
                }
            }
        }));
    });
</script>

<!-- Alpine.js - Load AFTER data definition -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
