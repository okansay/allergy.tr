<?php

/**
 * Main Application Entry Point
 */

require_once __DIR__ . '/../api/core/Auth.php';

// Start session
Auth::initSession();

// Check if logged in (optional for now, can be enforced later)
$user = Auth::user();

$pageTitle = 'Allergy.tr - Alerji & İmmünoloji Portalı';

?>
<?php include __DIR__ . '/../shared/components/header.php'; ?>

<div class="flex min-h-screen w-full">
    <!-- Sidebar -->
    <?php include __DIR__ . '/../shared/components/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col pb-16 lg:pb-0">
        <!-- Mobile Header -->
        <header class="lg:hidden sticky top-0 z-10 flex items-center justify-between px-4 py-3 bg-white/80 dark:bg-background-dark/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-3xl">health_and_safety</span>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">Allergy.tr</h1>
            </div>
            <button class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                <span class="material-symbols-outlined text-gray-600 dark:text-gray-300">search</span>
            </button>
        </header>

        <!-- Mobile Navigation -->
        <nav class="lg:hidden sticky top-[61px] z-10 flex items-center gap-2 px-4 py-2 bg-white dark:bg-background-dark border-b border-gray-200 dark:border-gray-800 overflow-x-auto no-scrollbar">
            <a @click.prevent="navigateTo('dashboard')"
               :class="currentRoute === 'dashboard' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'"
               class="flex-shrink-0 px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer"
               href="#dashboard">Ana Sayfa</a>
            <a @click.prevent="navigateTo('desensitization')"
               :class="currentRoute === 'desensitization' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'"
               class="flex-shrink-0 px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer"
               href="#desensitization">İlaç Alerjileri</a>
            <a @click.prevent="navigateTo('immune-deficiencies')"
               :class="currentRoute === 'immune-deficiencies' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'"
               class="flex-shrink-0 px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer"
               href="#immune-deficiencies">İmmün Yetmezlikler</a>
            <a @click.prevent="navigateTo('laboratory')"
               :class="currentRoute === 'laboratory' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'"
               class="flex-shrink-0 px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer"
               href="#laboratory">Laboratuvar</a>
            <a @click.prevent="navigateTo('guides')"
               :class="currentRoute === 'guides' ? 'bg-primary text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'"
               class="flex-shrink-0 px-3 py-1.5 rounded-full text-sm font-medium cursor-pointer"
               href="#guides">Rehberler</a>
        </nav>

        <!-- Main Content Area -->
        <main id="main-content" class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
            <!-- Desktop Header -->
            <div class="hidden lg:flex items-center justify-between mb-8">
                <div class="flex items-center gap-2">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800">
                        <span :class="!sidebarOpen && 'rotate-180'"
                              class="material-symbols-outlined text-gray-600 dark:text-gray-300 transition-transform duration-300">menu_open</span>
                    </button>
                    <div x-show="user">
                        <h1 class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">
                            Tekrar hoş geldiniz, <span x-text="user?.title + ' ' + user?.full_name?.split(' ').pop()"></span>!
                        </h1>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">İhtiyacınız olan araçlar ve bilgiler parmaklarınızın ucunda.</p>
                    </div>
                </div>
                <div class="relative w-full max-w-sm">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                    <input class="w-full pl-10 pr-4 py-2 bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                           placeholder="Portalda ara..."
                           type="text"/>
                </div>
            </div>

            <!-- Mobile Header -->
            <div class="mb-6 lg:hidden" x-show="user">
                <h1 class="text-gray-900 dark:text-white text-2xl font-bold leading-tight">
                    Tekrar hoş geldiniz, <span x-text="user?.title + ' ' + user?.full_name?.split(' ').pop()"></span>!
                </h1>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="flex items-center justify-center py-20">
                <div class="spinner"></div>
            </div>

            <!-- Dashboard Content (default) -->
            <div x-show="currentRoute === 'dashboard' && !loading">
                <?php include __DIR__ . '/dashboard.php'; ?>
            </div>

            <!-- Module Content (dynamic) -->
            <div x-show="currentRoute !== 'dashboard' && !loading"
                 x-html="moduleContent"
                 class="module-container">
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<?php include __DIR__ . '/../shared/components/footer.php'; ?>
