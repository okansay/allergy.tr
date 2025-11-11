<!-- Search Bar -->
<div class="px-0 py-3">
    <label class="flex flex-col min-w-40 h-12 w-full">
        <div class="flex w-full flex-1 items-stretch rounded-xl h-full shadow-sm">
            <div class="text-slate-500 dark:text-slate-400 flex bg-white dark:bg-slate-800 items-center justify-center pl-4 rounded-l-xl border-y border-l border-slate-300 dark:border-slate-700">
                <span class="material-symbols-outlined">search</span>
            </div>
            <input
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-xl text-slate-900 dark:text-slate-50 bg-white dark:bg-slate-800 h-full placeholder:text-slate-500 dark:placeholder:text-slate-400 px-4 text-base font-normal leading-normal border-y border-r border-slate-300 dark:border-slate-700 focus:ring-2 focus:ring-primary focus:border-primary"
                placeholder="Konu veya ilaç ara..."
                value=""
            />
        </div>
    </label>
</div>

<!-- Category Grid -->
<div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-4 py-4">
    <!-- İlaç Alerjileri -->
    <div class="flex flex-1 gap-3.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/50 p-4 flex-col shadow-sm">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">pill</span>
            <div class="flex flex-col gap-1">
                <h2 class="text-slate-900 dark:text-slate-50 text-base font-bold leading-tight">İlaç Alerjileri</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal">Drug Allergies</p>
            </div>
        </div>
        <div class="flex flex-col gap-2 mt-2 pl-2 border-l-2 border-primary/30">
            <a
                @click.prevent="navigateTo('desensitization')"
                href="#desensitization"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer group"
            >
                <span class="material-symbols-outlined text-primary text-lg">vaccines</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-primary">İlaç Desensitizasyonu</span>
            </a>
            <a
                @click.prevent="navigateTo('betalactam-cross-reactivity')"
                href="#betalactam-cross-reactivity"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer group"
            >
                <span class="material-symbols-outlined text-primary text-lg">science</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-primary">Beta-Laktam Çapraz Reaksiyon</span>
            </a>
            <a
                @click.prevent="navigateTo('skin-test-concentrations')"
                href="#skin-test-concentrations"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer group"
            >
                <span class="material-symbols-outlined text-primary text-lg">science</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-primary">Deri Testi Konsantrasyonları</span>
            </a>
            <a
                @click.prevent="navigateTo('desensitization-protocol-library')"
                href="#desensitization-protocol-library"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer group"
            >
                <span class="material-symbols-outlined text-primary text-lg">library_books</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-primary">Protokol Kütüphanesi</span>
            </a>
        </div>
    </div>

    <!-- İmmün Yetmezlikler -->
    <a
        @click.prevent="navigateTo('immune-deficiencies')"
        href="#immune-deficiencies"
        class="flex flex-1 gap-3.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/50 p-4 flex-col shadow-sm hover:shadow-md transition-shadow cursor-pointer"
    >
        <span class="material-symbols-outlined text-primary">shield</span>
        <div class="flex flex-col gap-1">
            <h2 class="text-slate-900 dark:text-slate-50 text-base font-bold leading-tight">İmmün Yetmezlikler</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal">Immunodeficiencies</p>
        </div>
    </a>

    <!-- Besin Alerjileri -->
    <div class="flex flex-1 gap-3.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/50 p-4 flex-col shadow-sm">
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">restaurant</span>
            <div class="flex flex-col gap-1">
                <h2 class="text-slate-900 dark:text-slate-50 text-base font-bold leading-tight">Besin Alerjileri</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal">Food Allergies</p>
            </div>
        </div>
        <div class="flex flex-col gap-2 mt-2 pl-2 border-l-2 border-primary/30">
            <a
                @click.prevent="navigateTo('oit-food-protocols')"
                href="#oit-food-protocols"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer group"
            >
                <span class="material-symbols-outlined text-primary text-lg">healing</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-primary">Besin Desensitizasyon (OIT)</span>
            </a>
            <a
                @click.prevent="navigateTo('food-allergies')"
                href="#food-allergies"
                class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors cursor-pointer group"
            >
                <span class="material-symbols-outlined text-primary text-lg">bakery_dining</span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-primary">Genel Bilgiler</span>
            </a>
        </div>
    </div>

    <!-- Astım ve Rinit -->
    <a
        @click.prevent="navigateTo('asthma-rhinitis')"
        href="#asthma-rhinitis"
        class="flex flex-1 gap-3.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/50 p-4 flex-col shadow-sm hover:shadow-md transition-shadow cursor-pointer"
    >
        <span class="material-symbols-outlined text-primary">air</span>
        <div class="flex flex-col gap-1">
            <h2 class="text-slate-900 dark:text-slate-50 text-base font-bold leading-tight">Astım ve Rinit</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal">Asthma & Rhinitis</p>
        </div>
    </a>

    <!-- Anafilaksi -->
    <a
        @click.prevent="navigateTo('anaphylaxis')"
        href="#anaphylaxis"
        class="flex flex-1 gap-3.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/50 p-4 flex-col shadow-sm hover:shadow-md transition-shadow cursor-pointer"
    >
        <span class="material-symbols-outlined text-primary">syringe</span>
        <div class="flex flex-col gap-1">
            <h2 class="text-slate-900 dark:text-slate-50 text-base font-bold leading-tight">Anafilaksi</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal">Anaphylaxis</p>
        </div>
    </a>

    <!-- Araçlar ve Hesaplayıcılar -->
    <a
        @click.prevent="navigateTo('calculators')"
        href="#calculators"
        class="flex flex-1 gap-3.5 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/50 p-4 flex-col shadow-sm hover:shadow-md transition-shadow cursor-pointer"
    >
        <span class="material-symbols-outlined text-primary">calculate</span>
        <div class="flex flex-col gap-1">
            <h2 class="text-slate-900 dark:text-slate-50 text-base font-bold leading-tight">Araçlar ve Hesaplayıcılar</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal">Tools & Calculators</p>
        </div>
    </a>
</div>
