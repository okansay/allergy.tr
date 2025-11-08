<!-- Mobile Bottom Navigation -->
<footer class="lg:hidden fixed bottom-0 left-0 right-0 z-10 flex items-center justify-around px-2 py-2 bg-white/80 dark:bg-background-dark/80 backdrop-blur-sm border-t border-gray-200 dark:border-gray-800">
    <a @click.prevent="navigateTo('dashboard')"
       :class="currentRoute === 'dashboard' ? 'text-primary' : 'text-gray-600 dark:text-gray-300'"
       class="flex flex-col items-center justify-center gap-1 w-full py-1 rounded-lg cursor-pointer"
       href="#dashboard">
        <span class="material-symbols-outlined">home</span>
        <span class="text-xs font-medium">Ana Sayfa</span>
    </a>
    <a @click.prevent="navigateTo('laboratory')"
       :class="currentRoute === 'laboratory' ? 'text-primary' : 'text-gray-600 dark:text-gray-300'"
       class="flex flex-col items-center justify-center gap-1 w-full py-1 rounded-lg cursor-pointer"
       href="#laboratory">
        <span class="material-symbols-outlined">calculate</span>
        <span class="text-xs font-medium">Araçlar</span>
    </a>
    <a @click.prevent="navigateTo('guides')"
       :class="currentRoute === 'guides' ? 'text-primary' : 'text-gray-600 dark:text-gray-300'"
       class="flex flex-col items-center justify-center gap-1 w-full py-1 rounded-lg cursor-pointer"
       href="#guides">
        <span class="material-symbols-outlined">article</span>
        <span class="text-xs font-medium">Rehberler</span>
    </a>
    <a class="flex flex-col items-center justify-center text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary gap-1 w-full py-1 rounded-lg"
       href="#"
       x-show="user">
        <div class="bg-primary/20 rounded-full size-6 flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-base">person</span>
        </div>
        <span class="text-xs font-medium">Profil</span>
    </a>
</footer>

<!-- Alpine.js Scripts - Load at end of body for better performance -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Desensitization Module Scripts -->
<script src="/modules/js/desensitization/protocol.js?v=20250108-008"></script>
<script src="/modules/js/desensitization/ui.js?v=20250108-008"></script>

<!-- Alpine.js App State -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('appState', () => ({
            sidebarOpen: true,
            menuOpen: false,  // Mobile menu state
            currentRoute: 'dashboard',
            user: null,
            loading: false,
            moduleContent: '',

            init() {
                this.checkAuth();
                this.handleRouting();

                // Listen for hash changes
                window.addEventListener('hashchange', () => {
                    this.handleRouting();
                });
            },

            async checkAuth() {
                try {
                    const response = await fetch('/api/auth.php?action=me', {
                        credentials: 'include'
                    });
                    const data = await response.json();

                    if (data.success) {
                        this.user = data.data;
                    }
                } catch (error) {
                    console.error('Auth check failed:', error);
                }
            },

            handleRouting() {
                const hash = window.location.hash.slice(1) || 'dashboard';
                this.navigateTo(hash);
            },

            async navigateTo(route) {
                this.currentRoute = route;
                window.location.hash = route;

                // Load module content
                if (route !== 'dashboard') {
                    await this.loadModule(route);
                } else {
                    this.moduleContent = '';
                }

                // Scroll to top
                if (document.getElementById('main-content')) {
                    document.getElementById('main-content').scrollTo(0, 0);
                }
            },

            async loadModule(moduleName) {
                this.loading = true;
                try {
                    const response = await fetch('/modules/' + moduleName + '.php');
                    if (response.ok) {
                        this.moduleContent = await response.text();
                    } else {
                        this.moduleContent = '<div class="p-8 text-center"><span class="material-symbols-outlined text-6xl text-gray-400 mb-4">construction</span><h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Modül Hazırlanıyor</h2><p class="text-gray-600 dark:text-gray-400">Bu modül yakında eklenecek.</p></div>';
                    }
                } catch (error) {
                    console.error('Module load failed:', error);
                    this.moduleContent = '<div class="p-8 text-center"><span class="material-symbols-outlined text-6xl text-red-400 mb-4">error</span><h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Yükleme Hatası</h2><p class="text-gray-600 dark:text-gray-400">Modül yüklenirken bir hata oluştu.</p></div>';
                } finally {
                    this.loading = false;
                }
            },

            async logout() {
                if (!confirm('Çıkış yapmak istediğinize emin misiniz?')) {
                    return;
                }

                try {
                    await fetch('/api/auth.php?action=logout', {
                        method: 'POST',
                        credentials: 'include'
                    });

                    this.user = null;
                    window.location.href = '/login.php';
                } catch (error) {
                    console.error('Logout failed:', error);
                    alert('Çıkış yapılırken bir hata oluştu');
                }
            }
        }));
    });
</script>

</body>
</html>
