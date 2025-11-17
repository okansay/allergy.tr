<?php
$pageTitle = 'Giriş Yap - Allergy.tr';
?>
<?php include __DIR__ . '/shared/components/simple-header.php'; ?>

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md" x-data="loginForm()">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary text-5xl">health_and_safety</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Allergy.tr</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Alerji & İmmünoloji Portalı</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-800 rounded-xl p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Giriş Yap</h2>

            <!-- Error Message -->
            <div x-show="error" x-text="error"
                 class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 rounded-lg text-sm">
            </div>

            <!-- Success Message -->
            <div x-show="success" x-text="success"
                 class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 rounded-lg text-sm">
            </div>

            <form @submit.prevent="handleLogin">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            E-posta
                        </label>
                        <input type="email"
                               x-model="form.email"
                               required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="doktor@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Şifre
                        </label>
                        <input type="password"
                               x-model="form.password"
                               required
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                               placeholder="••••••••">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox"
                                   x-model="form.remember"
                                   class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Beni hatırla</span>
                        </label>
                        <a href="#" class="text-sm text-primary hover:underline">Şifremi unuttum</a>
                    </div>

                    <button type="submit"
                            :disabled="loading"
                            class="w-full py-3 px-4 bg-primary text-white rounded-lg font-medium hover:bg-primary/90 focus:ring-4 focus:ring-primary/20 disabled:opacity-50 disabled:cursor-not-allowed transition-all"
                            x-text="loading ? 'Giriş yapılıyor...' : 'Giriş Yap'">
                        Giriş Yap
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Hesabınız yok mu?
                    <a href="/register.php" class="text-primary font-medium hover:underline">Kayıt Olun</a>
                </p>
            </div>

            <!-- Demo Credentials -->
            <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <p class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">Demo Hesap:</p>
                <p class="text-xs text-blue-800 dark:text-blue-200">
                    E-posta: dene@allergy.tr<br>
                    Şifre: sifre123
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    // Define loginForm before Alpine loads
    document.addEventListener('alpine:init', () => {
        Alpine.data('loginForm', () => ({
            form: {
                email: '',
                password: '',
                remember: false
            },
            loading: false,
            error: '',
            success: '',

            async handleLogin() {
                this.error = '';
                this.success = '';
                this.loading = true;

                try {
                    const response = await fetch('/api/auth.php?action=login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        credentials: 'include',
                        body: JSON.stringify(this.form)
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.success = data.message;
                        setTimeout(() => {
                            window.location.href = '/';
                        }, 1000);
                    } else {
                        this.error = data.message;
                    }
                } catch (error) {
                    console.error('Login error:', error);
                    this.error = 'Giriş yapılırken bir hata oluştu';
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
