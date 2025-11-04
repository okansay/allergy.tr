<aside :class="sidebarOpen ? 'w-64' : 'w-20'"
       class="hidden lg:flex flex-shrink-0 bg-white dark:bg-background-dark dark:border-r dark:border-gray-800 p-4 flex-col justify-between transition-all duration-300">
    <div class="flex flex-col gap-8">
        <!-- Logo -->
        <div class="flex items-center gap-2 px-2 h-10">
            <span class="material-symbols-outlined text-primary text-3xl">health_and_safety</span>
            <h1 :class="!sidebarOpen && 'opacity-0 scale-0'"
                class="text-xl font-bold text-gray-900 dark:text-white transition-all duration-200 whitespace-nowrap">
                Allergy.tr
            </h1>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-col gap-1">
            <!-- Ana Sayfa -->
            <a @click.prevent="navigateTo('dashboard')"
               :class="currentRoute === 'dashboard' ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'"
               class="flex items-center gap-3 px-3 py-2 rounded-lg cursor-pointer"
               href="#dashboard">
                <span class="material-symbols-outlined">home</span>
                <span :class="!sidebarOpen && 'opacity-0 scale-0'"
                      class="text-sm font-medium transition-all duration-200 whitespace-nowrap">Ana Sayfa</span>
            </a>

            <!-- İlaç Alerjileri -->
            <div class="group" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex w-full items-center justify-between gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined">vaccines</span>
                        <span :class="!sidebarOpen && 'opacity-0 scale-0'"
                              class="text-sm font-medium transition-all duration-200 whitespace-nowrap">İlaç Alerjileri</span>
                    </div>
                    <span :class="!sidebarOpen && 'opacity-0 scale-0'"
                          class="material-symbols-outlined rotate-icon text-base transition-all duration-200">chevron_right</span>
                </button>
                <div class="pl-6 pt-1 overflow-hidden" x-collapse x-show="open && sidebarOpen">
                    <a @click.prevent="navigateTo('desensitization')"
                       class="flex items-center gap-3 px-3 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md whitespace-nowrap cursor-pointer"
                       href="#desensitization">İlaç Desensitizasyonu</a>
                    <a class="flex items-center gap-3 px-3 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md whitespace-nowrap"
                       href="#">Beta-laktamlar</a>
                    <a class="flex items-center gap-3 px-3 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md whitespace-nowrap"
                       href="#">Protokoller</a>
                </div>
            </div>

            <!-- İmmün Yetmezlikler -->
            <div class="group" x-data="{ open: false }">
                <button @click="open = !open"
                        class="flex w-full items-center justify-between gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined">bloodtype</span>
                        <span :class="!sidebarOpen && 'opacity-0 scale-0'"
                              class="text-sm font-medium transition-all duration-200 whitespace-nowrap">İmmün Yetmezlikler</span>
                    </div>
                    <span :class="!sidebarOpen && 'opacity-0 scale-0'"
                          class="material-symbols-outlined rotate-icon text-base transition-all duration-200">chevron_right</span>
                </button>
                <div class="pl-6 pt-1 overflow-hidden" x-collapse x-show="open && sidebarOpen">
                    <a @click.prevent="navigateTo('immune-deficiencies')"
                       class="flex items-center gap-3 px-3 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md whitespace-nowrap cursor-pointer"
                       href="#immune-deficiencies">Genel Bakış</a>
                    <a class="flex items-center gap-3 px-3 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md whitespace-nowrap"
                       href="#">Lenfosit Alt Grupları</a>
                    <a class="flex items-center gap-3 px-3 py-2 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-md whitespace-nowrap"
                       href="#">Tanı Kriterleri</a>
                </div>
            </div>

            <!-- Laboratuvar -->
            <a @click.prevent="navigateTo('laboratory')"
               :class="currentRoute === 'laboratory' ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'"
               class="flex items-center gap-3 px-3 py-2 rounded-lg cursor-pointer"
               href="#laboratory">
                <span class="material-symbols-outlined">science</span>
                <span :class="!sidebarOpen && 'opacity-0 scale-0'"
                      class="text-sm font-medium transition-all duration-200 whitespace-nowrap">Laboratuvar</span>
            </a>

            <!-- Rehberler -->
            <a @click.prevent="navigateTo('guides')"
               :class="currentRoute === 'guides' ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'"
               class="flex items-center gap-3 px-3 py-2 rounded-lg cursor-pointer"
               href="#guides">
                <span class="material-symbols-outlined">article</span>
                <span :class="!sidebarOpen && 'opacity-0 scale-0'"
                      class="text-sm font-medium transition-all duration-200 whitespace-nowrap">Rehberler</span>
            </a>
        </nav>
    </div>

    <!-- Bottom Section -->
    <div class="flex flex-col gap-4">
        <!-- Ayarlar -->
        <a class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800"
           href="#">
            <span class="material-symbols-outlined">settings</span>
            <span :class="!sidebarOpen && 'opacity-0 scale-0'"
                  class="text-sm font-medium transition-all duration-200 whitespace-nowrap">Ayarlar</span>
        </a>

        <!-- User Profile -->
        <div class="border-t border-gray-200 dark:border-gray-800 pt-4">
            <div class="flex items-center gap-3" x-show="user">
                <div class="bg-primary/20 rounded-full size-10 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary">person</span>
                </div>
                <div :class="!sidebarOpen && 'opacity-0 scale-0'"
                     class="flex flex-col transition-all duration-200 whitespace-nowrap">
                    <h2 class="text-gray-900 dark:text-white text-sm font-semibold" x-text="user?.full_name"></h2>
                    <p class="text-gray-500 dark:text-gray-400 text-xs" x-text="user?.specialty"></p>
                </div>
            </div>
            <button @click="logout"
                    x-show="user"
                    class="mt-2 w-full flex items-center gap-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg">
                <span class="material-symbols-outlined text-base">logout</span>
                <span :class="!sidebarOpen && 'opacity-0 scale-0'" class="transition-all duration-200">Çıkış</span>
            </button>
        </div>
    </div>
</aside>
