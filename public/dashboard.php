<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    <!-- Hızlı Hesaplayıcılar -->
    <div class="flex flex-col gap-4 rounded-xl p-4 sm:p-6 bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-800">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center size-10 rounded-lg bg-primary/10 text-primary">
                <span class="material-symbols-outlined">calculate</span>
            </div>
            <h3 class="text-gray-900 dark:text-white text-lg font-bold">Hızlı Hesaplayıcılar</h3>
        </div>
        <div class="flex flex-col gap-3">
            <a class="block p-3 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" href="#">
                <p class="font-semibold text-gray-800 dark:text-gray-200 text-sm">Beta-Laktam Çapraz Reaksiyon</p>
            </a>
            <a class="block p-3 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" href="#">
                <p class="font-semibold text-gray-800 dark:text-gray-200 text-sm">Vücut Yüzey Alanı (BSA)</p>
            </a>
            <a class="block p-3 rounded-lg bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" href="#">
                <p class="font-semibold text-gray-800 dark:text-gray-200 text-sm">eGFR Hesaplama</p>
            </a>
        </div>
    </div>

    <!-- Son Eklenenler -->
    <div class="flex flex-col gap-4 rounded-xl p-4 sm:p-6 bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-800">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center size-10 rounded-lg bg-green-500/10 text-green-600 dark:text-green-400">
                <span class="material-symbols-outlined">new_releases</span>
            </div>
            <h3 class="text-gray-900 dark:text-white text-lg font-bold">Son Eklenenler</h3>
        </div>
        <div class="flex flex-col gap-4" x-data="{ recentItems: [] }" x-init="
            fetch('/api/content.php?type=recent')
                .then(r => r.json())
                .then(data => { if(data.success) recentItems = data.data; })
        ">
            <template x-if="recentItems.length === 0">
                <p class="text-sm text-gray-500 dark:text-gray-400">Yükleniyor...</p>
            </template>
            <template x-for="item in recentItems" :key="item.id">
                <div class="flex gap-3 items-start">
                    <span class="material-symbols-outlined text-gray-400 dark:text-gray-500 mt-0.5 text-xl">article</span>
                    <div>
                        <p class="font-medium text-gray-800 dark:text-gray-200 text-sm" x-text="item.title"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400" x-text="item.created_at"></p>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Sık Kullandıklarım -->
    <div class="flex flex-col gap-4 rounded-xl p-4 sm:p-6 bg-white dark:bg-gray-800/50 border border-gray-200 dark:border-gray-800">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center size-10 rounded-lg bg-yellow-500/10 text-yellow-600 dark:text-yellow-400">
                <span class="material-symbols-outlined">star</span>
            </div>
            <h3 class="text-gray-900 dark:text-white text-lg font-bold">Sık Kullandıklarım</h3>
        </div>
        <div class="flex flex-col gap-3">
            <a @click.prevent="navigateTo('desensitization')"
               class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors cursor-pointer"
               href="#desensitization">
                <span class="material-symbols-outlined text-primary text-base">medication</span>
                <span class="font-medium text-gray-700 dark:text-gray-300 text-sm">İlaç Desensitizasyon Protokolü</span>
            </a>
            <a @click.prevent="navigateTo('laboratory')"
               class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors cursor-pointer"
               href="#laboratory">
                <span class="material-symbols-outlined text-primary text-base">data_table</span>
                <span class="font-medium text-gray-700 dark:text-gray-300 text-sm">Lenfosit Alt Grup Referans Değerleri</span>
            </a>
        </div>
    </div>
</div>
