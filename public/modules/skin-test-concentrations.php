<div class="space-y-6 pb-20">
    <!-- Module Header -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center justify-center size-14 rounded-xl bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-3xl">science</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">İlaç Deri Testi Konsantrasyonları</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">ENDA/EAACI kılavuzuna göre test konsantrasyonları</p>
            </div>
        </div>
    </div>

    <!-- Information Box -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined">info</span>
            Kullanım Bilgisi
        </h3>
        <div class="space-y-3 text-sm text-blue-900 dark:text-blue-100">
            <p>
                Bu modül, sistemik olarak uygulanan ilaçlar için irrite edici olmayan deri testi konsantrasyonlarını içerir.
                Veriler <strong>ENDA/EAACI Drug Allergy Interest Group</strong> tarafından yayınlanan position paper'a dayanmaktadır.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4">
                <div class="bg-white dark:bg-blue-950/30 rounded-lg p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm">vaccines</span>
                        <span class="font-semibold text-xs">SPT</span>
                    </div>
                    <p class="text-xs">Skin Prick Test - Deri Delme Testi</p>
                </div>
                <div class="bg-white dark:bg-blue-950/30 rounded-lg p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-sm">medication</span>
                        <span class="font-semibold text-xs">IDT</span>
                    </div>
                    <p class="text-xs">Intradermal Test - İntradermal Test</p>
                </div>
                <div class="bg-white dark:bg-blue-950/30 rounded-lg p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-sm">healing</span>
                        <span class="font-semibold text-xs">Yama Testi</span>
                    </div>
                    <p class="text-xs">Patch Test - Geç tip reaksiyonlar için</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Drug Selection Section -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">İlaç Seçimi</h2>

        <!-- Dropdown Selection -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                Listeden Seçin
            </label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none z-10">
                    medication
                </span>
                <select
                    id="drugDropdown"
                    class="w-full pl-12 pr-10 py-3 rounded-lg border border-slate-300 dark:border-slate-600
                           bg-white dark:bg-slate-700 text-slate-900 dark:text-white
                           focus:ring-2 focus:ring-primary focus:border-primary
                           appearance-none cursor-pointer"
                >
                    <option value="">İlaç seçin...</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                    expand_more
                </span>
            </div>
        </div>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white dark:bg-slate-800/50 text-slate-500 dark:text-slate-400">VEYA</span>
            </div>
        </div>

        <!-- Search Input -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                İlaç Arayın
            </label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    search
                </span>
                <input
                    type="text"
                    id="drugSearch"
                    placeholder="İlaç adı yazın (en az 3 harf)..."
                    class="w-full pl-12 pr-12 py-3 rounded-lg border border-slate-300 dark:border-slate-600
                           bg-white dark:bg-slate-700 text-slate-900 dark:text-white
                           focus:ring-2 focus:ring-primary focus:border-primary
                           placeholder:text-slate-400 dark:placeholder:text-slate-500"
                    autocomplete="off"
                />
                <button
                    id="clearSearch"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 hidden">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="mt-3 text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">lightbulb</span>
                <span>İpucu: Türkçe ve İngilizce isimlere göre arama yapabilirsiniz.</span>
            </div>

            <!-- Search Results -->
            <div id="searchResults" class="mt-4 hidden max-h-96 overflow-y-auto"></div>
        </div>
    </div>

    <!-- Category Filters -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Kategorilere Göre Gözat</h2>
        <div id="categoryFilters"></div>
    </div>

    <!-- Drug Details -->
    <div id="drugDetails" class="hidden"></div>

    <!-- Reference -->
    <div class="bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
        <h3 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined">article</span>
            Referans
        </h3>
        <div class="text-sm text-slate-600 dark:text-slate-400 space-y-2">
            <p>
                <strong>Kaynak:</strong> Brockow K, Garvey LH, Aberer W, et al. Skin test concentrations for systemically administered drugs – an ENDA/EAACI Drug Allergy Interest Group position paper. Allergy. 2013;68(6):702-712.
            </p>
            <p>
                <strong>DOI:</strong> <a href="https://doi.org/10.1111/all.12142" target="_blank" rel="noopener" class="text-primary hover:underline">10.1111/all.12142</a>
            </p>
            <p class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                <strong class="text-amber-600 dark:text-amber-400">⚠️ Önemli Uyarı:</strong>
                Bu bilgiler eğitim amaçlıdır. Deri testleri uzman klinisyenler tarafından yapılmalıdır.
                Test öncesi hasta değerlendirmesi ve uygun güvenlik önlemleri alınmalıdır.
                Şiddetli reaksiyonlarda daha düşük konsantrasyonlarla başlanmalıdır.
                Negatif test ilaç alerjisini ekarte ettirmez ve gerekirse provokasyon testi yapılmalıdır.
            </p>
        </div>
    </div>

    <!-- Test Guidelines -->
    <div class="bg-gradient-to-br from-primary/5 to-primary/10 dark:from-primary/10 dark:to-primary/5
                border border-primary/20 dark:border-primary/30 rounded-xl p-6">
        <h3 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">checklist</span>
            Genel Test Prensipleri
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-700 dark:text-slate-300">
            <div class="bg-white/50 dark:bg-slate-800/50 rounded-lg p-4">
                <h4 class="font-semibold mb-2">Test Sırası</h4>
                <ol class="list-decimal list-inside space-y-1 text-xs">
                    <li>Önce spesifik IgE (varsa)</li>
                    <li>Sonra SPT (daha güvenli)</li>
                    <li>SPT negatifse IDT</li>
                    <li>Geç tip reaksiyonlarda yama testi</li>
                </ol>
            </div>
            <div class="bg-white/50 dark:bg-slate-800/50 rounded-lg p-4">
                <h4 class="font-semibold mb-2">Güvenlik</h4>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    <li>Anafilaksi riski olan hastalarda dikkatli olun</li>
                    <li>Şiddetli reaksiyonlarda 1/100 veya 1/1000 ile başlayın</li>
                    <li>Resüsitasyon ekipmanı hazır olmalı</li>
                    <li>Test sonrası en az 30 dk gözlem</li>
                </ul>
            </div>
            <div class="bg-white/50 dark:bg-slate-800/50 rounded-lg p-4">
                <h4 class="font-semibold mb-2">İlaç Hazırlığı</h4>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    <li>Tercihen IV formu kullanın</li>
                    <li>Vazokonstrüktörsüz preparat tercih edin</li>
                    <li>Kombinasyon ilaçlarda her bileşeni test edin</li>
                    <li>Katkı maddelerini unutmayın</li>
                </ul>
            </div>
            <div class="bg-white/50 dark:bg-slate-800/50 rounded-lg p-4">
                <h4 class="font-semibold mb-2">Okuma</h4>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    <li>SPT/IDT anında: 15-20 dakika</li>
                    <li>IDT geç okuma: 24-48 saat</li>
                    <li>Yama testi: 48 ve 72-96 saat</li>
                    <li>Kortikosteroidlerde 4-7 gün kontrolü</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom styles for skin test module */
.material-symbols-outlined {
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Search results scrollbar */
#searchResults::-webkit-scrollbar {
    width: 8px;
}

#searchResults::-webkit-scrollbar-track {
    background: transparent;
}

#searchResults::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.dark #searchResults::-webkit-scrollbar-thumb {
    background: #475569;
}

/* Highlight mark */
mark {
    background-color: #fef08a;
    padding: 0 0.25rem;
    border-radius: 0.25rem;
}

.dark mark {
    background-color: rgba(234, 179, 8, 0.3);
    color: #fef08a;
}

/* Loading animation */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .grid-cols-3 {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Load scripts dynamically for Alpine.js x-html compatibility
(function() {
    console.log('🔄 Loading Skin Test Module scripts...');

    // Check if scripts already loaded
    if (window.skinTestScriptsLoaded) {
        console.log('✅ Scripts already loaded, re-initializing...');
        if (typeof window.safeInitSkinTest === 'function') {
            window.safeInitSkinTest();
        } else {
            console.error('❌ safeInitSkinTest function not found!');
        }
        return;
    }

    // Load data.js
    const dataScript = document.createElement('script');
    dataScript.src = '/modules/js/skintest/data.js';
    dataScript.onload = function() {
        console.log('✅ data.js loaded');

        // Load ui.js after data.js
        const uiScript = document.createElement('script');
        uiScript.src = '/modules/js/skintest/ui.js';
        uiScript.onload = function() {
            console.log('✅ ui.js loaded');
            window.skinTestScriptsLoaded = true;
        };
        uiScript.onerror = function(error) {
            console.error('❌ Failed to load ui.js:', error);
            console.error('Path attempted: /modules/js/skintest/ui.js');
        };
        document.head.appendChild(uiScript);
    };
    dataScript.onerror = function(error) {
        console.error('❌ Failed to load data.js:', error);
        console.error('Path attempted: /modules/js/skintest/data.js');
    };
    document.head.appendChild(dataScript);
})();
</script>
