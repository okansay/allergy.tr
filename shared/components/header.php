<!DOCTYPE html>
<html class="light" lang="tr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= $pageTitle ?? 'Allergy.tr - Alerji & İmmünoloji Portalı' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>

    <!-- Alpine.js Collapse Plugin -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>

    <!-- Custom Styles -->
    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' 0,
                'opsz' 24
        }
        .group .material-symbols-outlined.rotate-icon {
            transition: transform 0.2s ease-in-out;
        }
        .group[aria-expanded="true"] .material-symbols-outlined.rotate-icon {
            transform: rotate(90deg);
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Loading spinner */
        .spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #135bec;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- Alpine.js App State - Define before Alpine loads -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('appState', () => ({
                sidebarOpen: true,
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
                    document.getElementById('main-content')?.scrollTo(0, 0);
                },

                async loadModule(moduleName) {
                    this.loading = true;
                    try {
                        const response = await fetch(`/modules/${moduleName}.php`);
                        if (response.ok) {
                            this.moduleContent = await response.text();
                        } else {
                            this.moduleContent = `<div class="p-8 text-center">
                                <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">construction</span>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Modül Hazırlanıyor</h2>
                                <p class="text-gray-600 dark:text-gray-400">Bu modül yakında eklenecek.</p>
                            </div>`;
                        }
                    } catch (error) {
                        console.error('Module load failed:', error);
                        this.moduleContent = `<div class="p-8 text-center">
                            <span class="material-symbols-outlined text-6xl text-red-400 mb-4">error</span>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Yükleme Hatası</h2>
                            <p class="text-gray-600 dark:text-gray-400">Modül yüklenirken bir hata oluştu.</p>
                        </div>`;
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
</head>
<body class="font-display bg-background-light dark:bg-background-dark" x-data="appState">
