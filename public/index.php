<?php

/**
 * Main Application Entry Point
 */

require_once __DIR__ . '/api/core/Database.php';
require_once __DIR__ . '/api/core/Response.php';
require_once __DIR__ . '/api/core/Auth.php';

// Start session
Auth::initSession();

// Check if logged in (optional for now, can be enforced later)
$user = Auth::user();

$pageTitle = 'Allergy.tr - Alerji & İmmünoloji Portalı';

?>
<?php include __DIR__ . '/shared/components/header.php'; ?>

<div class="flex min-h-screen w-full flex-col bg-background-light dark:bg-background-dark">

    <!-- Top App Bar -->
    <header class="flex items-center bg-background-light dark:bg-background-dark p-4 pb-2 justify-between sticky top-0 z-20 border-b border-slate-200/80 dark:border-slate-800/80">
        <button
            x-show="user"
            @click="menuOpen = !menuOpen"
            class="text-slate-800 dark:text-slate-200 flex size-10 shrink-0 items-center justify-center rounded-full hover:bg-slate-200/50 dark:hover:bg-slate-800/50 lg:hidden">
            <span class="material-symbols-outlined">menu</span>
        </button>

        <h1 class="text-slate-900 dark:text-slate-50 text-lg font-bold leading-tight tracking-tight flex-1 text-center lg:text-left lg:pl-4">
            <span x-show="!user">Allergy.tr</span>
            <span x-show="user">A&I Toolkit</span>
        </h1>

        <div class="flex items-center gap-2">
            <!-- User Profile (when logged in) -->
            <div x-show="user" class="hidden lg:flex items-center gap-2">
                <span x-text="user?.full_name" class="text-sm text-slate-600 dark:text-slate-400"></span>
                <div class="size-8 rounded-full bg-primary/20 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-lg">person</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation Drawer (Mobile Overlay) -->
    <div
        x-show="menuOpen && user"
        @click.away="menuOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[60] bg-black/40 dark:bg-black/60 lg:hidden"
        style="display: none;"
    >
        <div
            @click.stop
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="flex h-full w-10/12 max-w-sm flex-col gap-4 bg-background-light dark:bg-background-dark p-4 shadow-xl z-[70]"
        >
            <?php include __DIR__ . '/shared/components/mobile-menu.php'; ?>
        </div>
    </div>

    <!-- Desktop Sidebar + Content Layout -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Desktop Sidebar (Hidden on mobile and when not logged in) -->
        <aside x-show="user" class="hidden lg:block w-64 border-r border-slate-200 dark:border-slate-800 overflow-y-auto">
            <?php include __DIR__ . '/shared/components/sidebar.php'; ?>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Welcome Screen (Not Logged In) -->
            <div x-show="!user && !loading" class="flex items-center justify-center min-h-full p-4">
                <div class="max-w-4xl mx-auto text-center py-12 px-4">
                    <!-- Logo -->
                    <div class="mb-8">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-primary/10 mb-4">
                            <span class="material-symbols-outlined text-primary text-6xl">health_and_safety</span>
                        </div>
                        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                            Allergy.tr
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-400">
                            Alerji & İmmünoloji Portalı
                        </p>
                    </div>

                    <!-- Description -->
                    <div class="mb-12 space-y-4">
                        <p class="text-lg text-gray-700 dark:text-gray-300">
                            Türkiye'nin önde gelen alerji ve immünoloji bilgi platformu
                        </p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                            <div class="p-6 bg-white dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-800">
                                <span class="material-symbols-outlined text-primary text-5xl mb-3">biotech</span>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">İlaç Duyarsızlaştırma</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Güncel protokoller ve tedavi rehberleri</p>
                            </div>
                            <div class="p-6 bg-white dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-800">
                                <span class="material-symbols-outlined text-primary text-5xl mb-3">shield</span>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">İmmün Yetmezlikler</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tanı ve takip kılavuzları</p>
                            </div>
                            <div class="p-6 bg-white dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-800">
                                <span class="material-symbols-outlined text-primary text-5xl mb-3">science</span>
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Laboratuvar</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Test değerlendirme ve yorumlama</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <a href="/login.php"
                           class="w-full sm:w-auto px-8 py-4 bg-primary text-white rounded-lg font-semibold text-lg hover:bg-primary/90 transition-all shadow-lg hover:shadow-xl">
                            Giriş Yap
                        </a>
                        <a href="/register.php"
                           class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-gray-800 text-primary dark:text-white border-2 border-primary rounded-lg font-semibold text-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                            Kayıt Ol
                        </a>
                    </div>

                    <!-- Demo Info -->
                    <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg inline-block">
                        <p class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-1">Demo Hesap ile Deneyin</p>
                        <p class="text-xs text-blue-800 dark:text-blue-200">
                            E-posta: demo@allergy.tr | Şifre: password123
                        </p>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content (Logged In) -->
            <div x-show="user && !loading" class="p-4 sm:p-6 lg:p-8">
                <!-- Dashboard -->
                <div x-show="currentRoute === 'dashboard'">
                    <?php include __DIR__ . '/dashboard.php'; ?>
                </div>

                <!-- Module Content (dynamic) -->
                <div x-show="currentRoute !== 'dashboard'"
                     x-html="moduleContent"
                     class="module-container">
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="flex items-center justify-center py-20">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<?php include __DIR__ . '/shared/components/footer.php'; ?>
