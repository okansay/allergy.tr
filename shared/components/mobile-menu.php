<div class="flex items-center justify-between pb-4 border-b border-slate-200 dark:border-slate-700">
    <h2 class="text-xl font-bold text-slate-800 dark:text-slate-200">Menu</h2>
    <button @click="menuOpen = false" class="text-slate-500 dark:text-slate-400">
        <span class="material-symbols-outlined">close</span>
    </button>
</div>

<nav class="flex-1 overflow-y-auto py-4">
    <ul class="flex flex-col gap-2">
        <li>
            <a
                @click.prevent="navigateTo('dashboard'); menuOpen = false"
                href="#dashboard"
                :class="currentRoute === 'dashboard' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer"
            >
                <span class="material-symbols-outlined" :class="currentRoute === 'dashboard' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">dashboard</span>
                <p :class="currentRoute === 'dashboard' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-base font-bold truncate">Ana Sayfa</p>
            </a>
        </li>

        <!-- İlaç Alerjileri - Dropdown Menu -->
        <li x-data="{ open: false }">
            <!-- Ana Menü -->
            <div
                @click="open = !open"
                :class="(currentRoute === 'desensitization' || currentRoute === 'betalactam-cross-reactivity' || currentRoute === 'skin-test-concentrations') ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer"
            >
                <span class="material-symbols-outlined" :class="(currentRoute === 'desensitization' || currentRoute === 'betalactam-cross-reactivity' || currentRoute === 'skin-test-concentrations') ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">pill</span>
                <p :class="(currentRoute === 'desensitization' || currentRoute === 'betalactam-cross-reactivity' || currentRoute === 'skin-test-concentrations') ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-base font-bold truncate flex-1">İlaç Alerjileri</p>
                <span class="material-symbols-outlined text-lg transition-transform" :class="[open ? 'rotate-180' : '', (currentRoute === 'desensitization' || currentRoute === 'betalactam-cross-reactivity' || currentRoute === 'skin-test-concentrations') ? 'text-primary' : 'text-slate-600 dark:text-slate-400']">expand_more</span>
            </div>

            <!-- Alt Menüler -->
            <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                <a
                    @click.prevent="navigateTo('desensitization'); menuOpen = false"
                    href="#desensitization"
                    :class="currentRoute === 'desensitization' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-lg" :class="currentRoute === 'desensitization' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">vaccines</span>
                    <p :class="currentRoute === 'desensitization' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-sm font-medium truncate">İlaç Desensitizasyonu</p>
                </a>

                <a
                    @click.prevent="navigateTo('betalactam-cross-reactivity'); menuOpen = false"
                    href="#betalactam-cross-reactivity"
                    :class="currentRoute === 'betalactam-cross-reactivity' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-lg" :class="currentRoute === 'betalactam-cross-reactivity' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">science</span>
                    <p :class="currentRoute === 'betalactam-cross-reactivity' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-sm font-medium truncate">Beta-Laktam Çapraz</p>
                </a>

                <a
                    @click.prevent="navigateTo('skin-test-concentrations'); menuOpen = false"
                    href="#skin-test-concentrations"
                    :class="currentRoute === 'skin-test-concentrations' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-lg" :class="currentRoute === 'skin-test-concentrations' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">syringe</span>
                    <p :class="currentRoute === 'skin-test-concentrations' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-sm font-medium truncate">Deri Testi Konsantrasyonları</p>
                </a>
            </div>
        </li>

        <li>
            <a
                @click.prevent="navigateTo('immune-deficiencies'); menuOpen = false"
                href="#immune-deficiencies"
                :class="currentRoute === 'immune-deficiencies' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer"
            >
                <span class="material-symbols-outlined" :class="currentRoute === 'immune-deficiencies' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">shield</span>
                <p :class="currentRoute === 'immune-deficiencies' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-base font-bold truncate">İmmün Yetmezlikler</p>
            </a>
        </li>

        <!-- Besin Alerjileri - Dropdown Menu -->
        <li x-data="{ open: false }">
            <!-- Ana Menü -->
            <div
                @click="open = !open"
                :class="(currentRoute === 'food-allergies' || currentRoute === 'oit-food-protocols') ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer"
            >
                <span class="material-symbols-outlined" :class="(currentRoute === 'food-allergies' || currentRoute === 'oit-food-protocols') ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">restaurant</span>
                <p :class="(currentRoute === 'food-allergies' || currentRoute === 'oit-food-protocols') ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-base font-bold truncate flex-1">Besin Alerjileri</p>
                <span class="material-symbols-outlined text-lg transition-transform" :class="[open ? 'rotate-180' : '', (currentRoute === 'food-allergies' || currentRoute === 'oit-food-protocols') ? 'text-primary' : 'text-slate-600 dark:text-slate-400']">expand_more</span>
            </div>

            <!-- Alt Menüler -->
            <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                <a
                    @click.prevent="navigateTo('oit-food-protocols'); menuOpen = false"
                    href="#oit-food-protocols"
                    :class="currentRoute === 'oit-food-protocols' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-lg" :class="currentRoute === 'oit-food-protocols' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">healing</span>
                    <p :class="currentRoute === 'oit-food-protocols' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-sm font-medium truncate">Besin Desensitizasyon</p>
                </a>

                <a
                    @click.prevent="navigateTo('food-allergies'); menuOpen = false"
                    href="#food-allergies"
                    :class="currentRoute === 'food-allergies' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-lg" :class="currentRoute === 'food-allergies' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">bakery_dining</span>
                    <p :class="currentRoute === 'food-allergies' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-sm font-medium truncate">Genel Bilgiler</p>
                </a>
            </div>
        </li>

        <li>
            <a
                @click.prevent="navigateTo('calculators'); menuOpen = false"
                href="#calculators"
                :class="currentRoute === 'calculators' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer"
            >
                <span class="material-symbols-outlined" :class="currentRoute === 'calculators' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">calculate</span>
                <p :class="currentRoute === 'calculators' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-base font-bold truncate">Hesaplayıcılar</p>
            </a>
        </li>

        <!-- Skorlamalar - Dropdown Menu -->
        <li x-data="{ open: false }">
            <!-- Ana Menü -->
            <div
                @click="open = !open"
                :class="(currentRoute === 'regiscar-score' || currentRoute === 'scorad-index') ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer"
            >
                <span class="material-symbols-outlined" :class="(currentRoute === 'regiscar-score' || currentRoute === 'scorad-index') ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">assignment</span>
                <p :class="(currentRoute === 'regiscar-score' || currentRoute === 'scorad-index') ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-base font-bold truncate flex-1">Skorlamalar</p>
                <span class="material-symbols-outlined text-lg transition-transform" :class="[open ? 'rotate-180' : '', (currentRoute === 'regiscar-score' || currentRoute === 'scorad-index') ? 'text-primary' : 'text-slate-600 dark:text-slate-400']">expand_more</span>
            </div>

            <!-- Alt Menüler -->
            <div x-show="open" x-collapse class="ml-4 mt-1 space-y-1">
                <a
                    @click.prevent="navigateTo('regiscar-score'); menuOpen = false"
                    href="#regiscar-score"
                    :class="currentRoute === 'regiscar-score' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-lg" :class="currentRoute === 'regiscar-score' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">monitoring</span>
                    <p :class="currentRoute === 'regiscar-score' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-sm font-medium truncate">RegiSCAR-DRESS</p>
                </a>
                <a
                    @click.prevent="navigateTo('scorad-index'); menuOpen = false"
                    href="#scorad-index"
                    :class="currentRoute === 'scorad-index' ? 'bg-primary/20' : 'hover:bg-slate-200/50 dark:hover:bg-slate-800/50'"
                    class="flex h-10 items-center gap-3 rounded-lg px-4 cursor-pointer"
                >
                    <span class="material-symbols-outlined text-lg" :class="currentRoute === 'scorad-index' ? 'text-primary' : 'text-slate-600 dark:text-slate-400'">dermatology</span>
                    <p :class="currentRoute === 'scorad-index' ? 'text-primary' : 'text-slate-800 dark:text-slate-200'" class="text-sm font-medium truncate">SCORAD Index</p>
                </a>
            </div>
        </li>

        <li class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
            <a
                href="/api/auth.php?action=logout"
                class="flex h-12 items-center gap-4 rounded-lg px-4 hover:bg-red-100 dark:hover:bg-red-900/20 cursor-pointer"
            >
                <span class="material-symbols-outlined text-red-600 dark:text-red-400">logout</span>
                <p class="text-red-600 dark:text-red-400 text-base font-bold truncate">Çıkış Yap</p>
            </a>
        </li>
    </ul>
</nav>
