<!-- Asthma & Rhinitis Category Page -->
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Category Header -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center justify-center size-14 rounded-xl bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-3xl">air</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Astım ve Rinit</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">Asthma & Rhinitis Management Tools</p>
            </div>
        </div>
    </div>

    <!-- Available Modules -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- GINA Asthma Step Advisor -->
        <a
            @click.prevent="navigateTo('gina-asthma-step-advisor')"
            href="#gina-asthma-step-advisor"
            class="flex flex-col gap-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-800/50 p-6 shadow-sm hover:shadow-md transition-all cursor-pointer group"
        >
            <div class="flex items-center justify-center size-12 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 group-hover:bg-blue-500/20 transition-colors">
                <span class="material-symbols-outlined text-3xl">stairs</span>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-2 group-hover:text-primary transition-colors">
                    GINA Astım Basamak Danışmanı
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    GINA 2024-2025 rehberlerine dayalı astım tedavi basamağı değerlendirmesi ve önerileri
                </p>
            </div>
            <div class="flex items-center gap-2 text-sm font-semibold text-primary mt-auto">
                <span>Başlat</span>
                <span class="material-symbols-outlined text-lg">arrow_forward</span>
            </div>
        </a>

        <!-- Placeholder for future modules -->
        <div class="flex flex-col gap-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/30 p-6 opacity-60">
            <div class="flex items-center justify-center size-12 rounded-xl bg-slate-200 dark:bg-slate-700">
                <span class="material-symbols-outlined text-3xl text-slate-400">construction</span>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                    Astım Kontrol Testi (ACT)
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    Astım kontrol düzeyini değerlendirme testi (Yakında)
                </p>
            </div>
        </div>

        <div class="flex flex-col gap-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/30 p-6 opacity-60">
            <div class="flex items-center justify-center size-12 rounded-xl bg-slate-200 dark:bg-slate-700">
                <span class="material-symbols-outlined text-3xl text-slate-400">construction</span>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-2">
                    Rinit Yönetimi
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    ARIA rehberine dayalı rinit değerlendirme ve tedavi önerileri (Yakında)
                </p>
            </div>
        </div>
    </div>
</div>
