<div class="flex flex-col p-4">
    <!-- Logo Section -->
    <div class="flex items-center gap-2 mb-8 px-2">
        <span class="material-symbols-outlined text-primary text-3xl">health_and_safety</span>
        <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200">Allergy.tr</h2>
    </div>

    <!-- Navigation List -->
    <nav class="flex flex-col gap-1">
        <a
            @click.prevent="navigateTo('dashboard')"
            href="#dashboard"
            :class="currentRoute === 'dashboard' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
            class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
        >
            <span class="material-symbols-outlined text-xl">dashboard</span>
            <p class="text-sm font-semibold truncate">Ana Sayfa</p>
        </a>

        <!-- İlaç Alerjileri - Dropdown Menu -->
        <div x-data="{ open: false }">
            <!-- Ana Menü -->
            <div
                @click="open = !open"
                :class="(currentRoute === 'desensitization' || currentRoute === 'betalactam-cross-reactivity' || currentRoute === 'skin-test-concentrations') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
            >
                <span class="material-symbols-outlined text-xl">pill</span>
                <p class="text-sm font-semibold truncate flex-1">İlaç Alerjileri</p>
                <span class="material-symbols-outlined text-lg transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
            </div>

            <!-- Alt Menüler -->
            <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                <a
                    @click.prevent="navigateTo('desensitization')"
                    href="#desensitization"
                    :class="currentRoute === 'desensitization' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer transition-colors"
                >
                    <span class="material-symbols-outlined text-lg">vaccines</span>
                    <p class="text-sm font-medium truncate">İlaç Desensitizasyonu</p>
                </a>

                <a
                    @click.prevent="navigateTo('betalactam-cross-reactivity')"
                    href="#betalactam-cross-reactivity"
                    :class="currentRoute === 'betalactam-cross-reactivity' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer transition-colors"
                >
                    <span class="material-symbols-outlined text-lg">science</span>
                    <p class="text-sm font-medium truncate">Beta-Laktam Çapraz</p>
                </a>

                <a
                    @click.prevent="navigateTo('skin-test-concentrations')"
                    href="#skin-test-concentrations"
                    :class="currentRoute === 'skin-test-concentrations' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer transition-colors"
                >
                    <span class="material-symbols-outlined text-lg">syringe</span>
                    <p class="text-sm font-medium truncate">Deri Testi Konsantrasyonları</p>
                </a>
            </div>
        </div>

        <a
            @click.prevent="navigateTo('immune-deficiencies')"
            href="#immune-deficiencies"
            :class="currentRoute === 'immune-deficiencies' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
            class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
        >
            <span class="material-symbols-outlined text-xl">shield</span>
            <p class="text-sm font-semibold truncate">İmmün Yetmezlikler</p>
        </a>

        <a
            @click.prevent="navigateTo('food-allergies')"
            href="#food-allergies"
            :class="currentRoute === 'food-allergies' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
            class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
        >
            <span class="material-symbols-outlined text-xl">bakery_dining</span>
            <p class="text-sm font-semibold truncate">Gıda Alerjileri</p>
        </a>

        <!-- Astım ve Rinit - Dropdown Menu -->
        <div x-data="{ open: false }">
            <!-- Ana Menü -->
            <div
                @click="open = !open"
                :class="(currentRoute === 'asthma-rhinitis' || currentRoute === 'gina-asthma-step-advisor') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
            >
                <span class="material-symbols-outlined text-xl">air</span>
                <p class="text-sm font-semibold truncate flex-1">Astım ve Rinit</p>
                <span class="material-symbols-outlined text-lg transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
            </div>

            <!-- Alt Menüler -->
            <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                <a
                    @click.prevent="navigateTo('asthma-rhinitis')"
                    href="#asthma-rhinitis"
                    :class="currentRoute === 'asthma-rhinitis' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer transition-colors"
                >
                    <span class="material-symbols-outlined text-lg">info</span>
                    <p class="text-sm font-medium truncate">Astım ve Rinit Ana Sayfa</p>
                </a>

                <a
                    @click.prevent="navigateTo('gina-asthma-step-advisor')"
                    href="#gina-asthma-step-advisor"
                    :class="currentRoute === 'gina-asthma-step-advisor' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer transition-colors"
                >
                    <span class="material-symbols-outlined text-lg">stairs</span>
                    <p class="text-sm font-medium truncate">GINA Astım Basamak Danışmanı</p>
                </a>
            </div>
        </div>

        <!-- Skorlamalar - Dropdown Menu -->
        <div x-data="{ open: false }">
            <!-- Ana Menü -->
            <div
                @click="open = !open"
                :class="(currentRoute === 'regiscar-score' || currentRoute === 'scorad-index') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
            >
                <span class="material-symbols-outlined text-xl">assignment</span>
                <p class="text-sm font-semibold truncate flex-1">Skorlamalar</p>
                <span class="material-symbols-outlined text-lg transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
            </div>

            <!-- Alt Menüler -->
            <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                <a
                    @click.prevent="navigateTo('regiscar-score')"
                    href="#regiscar-score"
                    :class="currentRoute === 'regiscar-score' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer transition-colors"
                >
                    <span class="material-symbols-outlined text-lg">monitoring</span>
                    <p class="text-sm font-medium truncate">RegiSCAR-DRESS</p>
                </a>
                <a
                    @click.prevent="navigateTo('scorad-index')"
                    href="#scorad-index"
                    :class="currentRoute === 'scorad-index' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer transition-colors"
                >
                    <span class="material-symbols-outlined text-lg">dermatology</span>
                    <p class="text-sm font-medium truncate">SCORAD Index</p>
                </a>
            </div>
        </div>

        <a
            @click.prevent="navigateTo('calculators')"
            href="#calculators"
            :class="currentRoute === 'calculators' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
            class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
        >
            <span class="material-symbols-outlined text-xl">calculate</span>
            <p class="text-sm font-semibold truncate">Hesaplayıcılar</p>
        </a>

        <!-- Skorlamalar - Dropdown Menu -->
        <div x-data="{ open: false }">
            <!-- Ana Menü -->
            <div
                @click="open = !open"
                :class="(currentRoute === 'regiscar-score' || currentRoute === 'scorad-index') ? 'bg-primary/10 text-primary' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
            >
                <span class="material-symbols-outlined text-xl">assignment</span>
                <p class="text-sm font-semibold truncate flex-1">Skorlamalar</p>
                <span class="material-symbols-outlined text-lg transition-transform" :class="open ? 'rotate-180' : ''">expand_more</span>
            </div>

            <!-- Alt Menüler -->
            <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                <a
                    @click.prevent="navigateTo('regiscar-score')"
                    href="#regiscar-score"
                    :class="currentRoute === 'regiscar-score' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer transition-colors"
                >
                    <span class="material-symbols-outlined text-lg">monitoring</span>
                    <p class="text-sm font-medium truncate">RegiSCAR-DRESS</p>
                </a>
                <a
                    @click.prevent="navigateTo('scorad-index')"
                    href="#scorad-index"
                    :class="currentRoute === 'scorad-index' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer transition-colors"
                >
                    <span class="material-symbols-outlined text-lg">dermatology</span>
                    <p class="text-sm font-medium truncate">SCORAD Index</p>
                </a>
            </div>
        </div>

        <!-- Logout -->
        <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
            <a
                href="/api/auth.php?action=logout"
                class="flex h-12 items-center gap-4 rounded-lg px-4 hover:bg-red-100 dark:hover:bg-red-900/20 cursor-pointer transition-colors text-red-600 dark:text-red-400"
            >
                <span class="material-symbols-outlined text-xl">logout</span>
                <p class="text-sm font-semibold truncate">Çıkış Yap</p>
            </a>
        </div>
    </nav>
</div>
