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

        <a
            @click.prevent="navigateTo('desensitization')"
            href="#desensitization"
            :class="currentRoute === 'desensitization' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
            class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
        >
            <span class="material-symbols-outlined text-xl">pill</span>
            <p class="text-sm font-semibold truncate">İlaç Alerjileri</p>
        </a>

        <a
            @click.prevent="navigateTo('betalactam-cross-reactivity')"
            href="#betalactam-cross-reactivity"
            :class="currentRoute === 'betalactam-cross-reactivity' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
            class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
        >
            <span class="material-symbols-outlined text-xl">science</span>
            <p class="text-sm font-semibold truncate">Beta-Laktam Çapraz Reaksiyon</p>
        </a>

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

        <a
            @click.prevent="navigateTo('asthma-rhinitis')"
            href="#asthma-rhinitis"
            :class="currentRoute === 'asthma-rhinitis' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
            class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
        >
            <span class="material-symbols-outlined text-xl">air</span>
            <p class="text-sm font-semibold truncate">Astım ve Rinit</p>
        </a>

        <a
            @click.prevent="navigateTo('calculators')"
            href="#calculators"
            :class="currentRoute === 'calculators' ? 'bg-primary text-white' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800'"
            class="flex h-12 items-center gap-4 rounded-lg px-4 cursor-pointer transition-colors"
        >
            <span class="material-symbols-outlined text-xl">calculate</span>
            <p class="text-sm font-semibold truncate">Hesaplayıcılar</p>
        </a>

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
