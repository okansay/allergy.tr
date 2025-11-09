<!-- Beta-Lactam Cross-Reactivity Module -->
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
            <span class="material-symbols-outlined align-middle text-4xl">biotech</span>
            Beta-Laktam Antibiyotik Çapraz Reaksiyon Analizi
        </h1>
        <p class="text-gray-600 dark:text-gray-400 text-lg">
            Beta-laktam antibiyotikler arasındaki R1 ve R2 pozisyonu yapısal benzerliklerini inceleyin.
        </p>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6 mb-8">
        <h3 class="font-bold text-blue-900 dark:text-blue-100 mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined">info</span>
            Benzerlik Dereceleri
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Yüksek Benzerlik:</p>
                <ul class="space-y-1 text-blue-800 dark:text-blue-200">
                    <li><span class="inline-block w-16 px-2 py-0.5 bg-orange-500 text-white rounded text-xs mr-2">R1</span> Aynı R1 yapısı</li>
                    <li><span class="inline-block w-16 px-2 py-0.5 bg-yellow-500 text-white rounded text-xs mr-2">R2</span> Aynı R2 yapısı</li>
                    <li><span class="inline-block w-16 px-2 py-0.5 bg-orange-400 text-white rounded text-xs mr-2">R1' / R1''</span> R1 kısmı aynı</li>
                </ul>
            </div>
            <div>
                <p class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Orta Benzerlik:</p>
                <ul class="space-y-1 text-blue-800 dark:text-blue-200">
                    <li><span class="inline-block w-16 px-2 py-0.5 bg-orange-300 text-white rounded text-xs mr-2">r1</span> Benzer R1 yapısı</li>
                    <li><span class="inline-block w-16 px-2 py-0.5 bg-yellow-300 text-white rounded text-xs mr-2">r2</span> Benzer R2 yapısı</li>
                    <li><span class="inline-block w-16 px-2 py-0.5 bg-orange-200 text-gray-800 rounded text-xs mr-2">r1' / r1''</span> R1 kısmı benzer</li>
                </ul>
            </div>
        </div>
        <p class="text-xs text-blue-700 dark:text-blue-300 mt-4">
            <strong>Not:</strong> Boş olan hücreler R1 veya R2 pozisyonunda yapısal benzerlik olmadığını gösterir.
        </p>
    </div>

    <!-- Drug Selection -->
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-6 mb-8">
        <label class="block text-lg font-semibold text-gray-900 dark:text-white mb-4">
            <span class="material-symbols-outlined align-middle">medication</span>
            İlaç Seçimi
        </label>
        <select id="drugSelect"
                class="w-full md:w-1/2 px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <option value="">-- İlaç Seçin --</option>
        </select>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
            Yukarıdaki listeden bir beta-laktam antibiyotik seçerek, o ilaçla yapısal benzerlik gösteren ve göstermeyen diğer antibiyotikleri görüntüleyebilirsiniz.
        </p>
    </div>

    <!-- Results Container -->
    <div id="resultsContainer" class="min-h-[200px]">
        <div class="text-center text-gray-500 dark:text-gray-400 py-12">
            <span class="material-symbols-outlined text-6xl mb-4 opacity-50">search</span>
            <p class="text-lg">Lütfen yukarıdan bir ilaç seçin</p>
        </div>
    </div>

    <!-- Reference -->
    <div class="mt-12 p-6 bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-xl">
        <h3 class="font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined">library_books</span>
            Referans
        </h3>
        <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
            <strong>FIGURE 1:</strong> Comparison of R1 and R2 structural similarities between beta-lactams.
        </p>
        <p class="text-xs text-gray-600 dark:text-gray-400">
            Drugs that have identical R1 or R2 structures are listed as R1 or R2.
            If only the ring or branch chain moiety of the R1 structure is identical, it is listed as R1′ or R1′′, respectively.
            Drugs that have similar R1 or R2 structures are listed as r1 or r2.
            Blank cells imply no R1 or R2 structural similarities.
        </p>
        <p class="text-xs text-gray-500 dark:text-gray-500 mt-3">
            <strong>Kaynak:</strong> European data on penicillin and cephalosporin use (2009)
        </p>
    </div>
</div>

<!-- Load Scripts -->
<script src="/modules/js/betalactam/cross-reactivity-data.js?v=20250108-001"></script>
<script src="/modules/js/betalactam/cross-reactivity.js?v=20250108-001"></script>
