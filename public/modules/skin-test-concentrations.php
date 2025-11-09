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
// Inline Skin Test Module - All code embedded to avoid external file loading issues
(function() {
    'use strict';

    console.log('🔄 Initializing Skin Test Module (inline)...');

    // Check if already loaded
    if (window.skinTestModuleLoaded) {
        console.log('✅ Module already loaded, re-initializing...');
        if (typeof window.initSkinTestModule === 'function') {
            window.initSkinTestModule();
        }
        return;
    }

    // ========== DATA.JS - Drug Database ==========
    const skinTestData = {
        // Beta-lactam Antibiotics
        betalactams: [
            {
                id: 'ppll',
                name: 'Penicilloyl-poly-l-lysine (PPL)',
                searchTerms: ['penicilloyl', 'ppl', 'poly-l-lysine'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '5 × 10⁻⁵ mM',
                idt: '5 × 10⁻⁵ mM',
                patch: 'Uygulanmaz',
                notes: 'Penisilin alerjisi tanısında temel determinant'
            },
            {
                id: 'mdm',
                name: 'Minor Determinant Mixture (MDM)',
                searchTerms: ['minor', 'determinant', 'mdm'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '2 × 10⁻² mM',
                idt: '2 × 10⁻² mM',
                patch: 'Uygulanmaz',
                notes: 'Penisilin alerjisi tanısında minör determinant karışımı'
            },
            {
                id: 'benzylpenicillin',
                name: 'Benzylpenicillin (Penisilin G)',
                searchTerms: ['benzylpenicillin', 'penicillin', 'penisilin', 'benzil'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '10,000 IU/ml',
                idt: '10,000 IU/ml',
                patch: '%5',
                notes: 'Doğal penisilin'
            },
            {
                id: 'amoxicillin',
                name: 'Amoxicillin (Amoksisilin)',
                searchTerms: ['amoxicillin', 'amoksisilin', 'amox'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '20 mg/ml',
                idt: '20 mg/ml',
                patch: '%5',
                notes: 'En sık kullanılan aminopenisilin. Penisilin alerjisinde en önemli determinant'
            },
            {
                id: 'ampicillin',
                name: 'Ampicillin (Ampisilin)',
                searchTerms: ['ampicillin', 'ampisilin', 'amp'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '20 mg/ml',
                idt: '20 mg/ml',
                patch: '%5',
                notes: 'Aminopenisilin grubu'
            },
            {
                id: 'cephalosporins',
                name: 'Sefalosporinler (Genel)',
                searchTerms: ['cephalosporin', 'sefalosporin', 'cef'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '20 mg/ml',
                idt: '20 mg/ml',
                patch: '%5',
                notes: 'Çoğu sefalosporin için güvenli konsantrasyon 20 mg/ml (cefuroxime, ceftriaxone, cefotaxime, ceftazidime, cefazolin, cephalexin, cefaclor, cefatrizine). ÖNEMLİ: Cefepime için farklı konsantrasyon kullanılır (2 mg/ml)'
            },
            {
                id: 'cefepime',
                name: 'Cefepime',
                searchTerms: ['cefepime', 'sefepim'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '2 mg/ml',
                idt: '2 mg/ml',
                patch: '%5',
                notes: '4. kuşak sefalosporin. DİKKAT: Diğer sefalosporinlerden farklı olarak 20 mg/ml irritan olabilir, bu yüzden 2 mg/ml kullanılır (S2k 2023, JACI-IP 2025)'
            },
            {
                id: 'aztreonam',
                name: 'Aztreonam',
                searchTerms: ['aztreonam'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '20 mg/ml',
                idt: '20 mg/ml',
                patch: '%5',
                notes: 'Monobaktam. Bazı merkezler 2-10 mg/ml kullanır. Penisilin/sefalosporin alerjisinde alternatif olabilir'
            },
            {
                id: 'imipenem',
                name: 'Imipenem/Cilastatin',
                searchTerms: ['imipenem', 'cilastatin'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '1 mg/ml',
                idt: '1 mg/ml',
                patch: '%5',
                notes: 'Karbapenem grubu. Geniş spektrumlu beta-laktam antibiyotik'
            },
            {
                id: 'meropenem',
                name: 'Meropenem',
                searchTerms: ['meropenem'],
                category: 'Beta-laktam Antibiyotikler',
                spt: '1 mg/ml',
                idt: '1 mg/ml',
                patch: '%5',
                notes: 'Karbapenem grubu. Merkezlere göre 0.5-1 mg/ml kullanılır'
            }
        ],

        // Perioperative Drugs - Anesthetics
        anesthetics: [
            {
                id: 'thiopental',
                name: 'Thiopental (Tiyopental)',
                searchTerms: ['thiopental', 'tiyopental'],
                category: 'Anestezik Ajanlar',
                undilutedConc: '25 mg/ml',
                spt: '25 mg/ml (Dilüe edilmemiş)',
                idt: '2.5 mg/ml (1/10 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'İndüksiyon anestezisi'
            },
            {
                id: 'propofol',
                name: 'Propofol',
                searchTerms: ['propofol'],
                category: 'Anestezik Ajanlar',
                undilutedConc: '10 mg/ml',
                spt: '10 mg/ml (Dilüe edilmemiş)',
                idt: '1 mg/ml (1/10 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'İndüksiyon ve idame anestezisi'
            },
            {
                id: 'ketamine',
                name: 'Ketamine (Ketamin)',
                searchTerms: ['ketamine', 'ketamin'],
                category: 'Anestezik Ajanlar',
                undilutedConc: '10 mg/ml',
                spt: '10 mg/ml (Dilüe edilmemiş)',
                idt: '1 mg/ml (1/10 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'Disosiyatif anestezik'
            },
            {
                id: 'etomidate',
                name: 'Etomidate',
                searchTerms: ['etomidate', 'etomidat'],
                category: 'Anestezik Ajanlar',
                undilutedConc: '2 mg/ml',
                spt: '2 mg/ml (Dilüe edilmemiş)',
                idt: '0.2 mg/ml (1/10 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'İndüksiyon anestezisi'
            },
            {
                id: 'midazolam',
                name: 'Midazolam',
                searchTerms: ['midazolam'],
                category: 'Anestezik Ajanlar',
                undilutedConc: '5 mg/ml',
                spt: '5 mg/ml (Dilüe edilmemiş)',
                idt: '0.5 mg/ml (1/10 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'Benzodiyazepin, premedikasyon ve sedasyon'
            }
        ],

        // Perioperative Drugs - Opioids
        opioids: [
            {
                id: 'fentanyl',
                name: 'Fentanyl',
                searchTerms: ['fentanyl'],
                category: 'Opioidler',
                undilutedConc: '0.05 mg/ml',
                spt: '0.05 mg/ml (Dilüe edilmemiş)',
                idt: '0.005 mg/ml (1/10 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'Güçlü sentetik opioid. Histamin salınımı yapabilir'
            },
            {
                id: 'alfentanil',
                name: 'Alfentanil',
                searchTerms: ['alfentanil'],
                category: 'Opioidler',
                undilutedConc: '0.5 mg/ml',
                spt: '0.5 mg/ml (Dilüe edilmemiş)',
                idt: '0.05 mg/ml (1/10 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'Fentanyl türevi'
            },
            {
                id: 'sufentanil',
                name: 'Sufentanil',
                searchTerms: ['sufentanil'],
                category: 'Opioidler',
                undilutedConc: '0.005 mg/ml',
                spt: '0.005 mg/ml (Dilüe edilmemiş)',
                idt: '0.0005 mg/ml (1/10 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'Güçlü fentanyl türevi'
            },
            {
                id: 'remifentanil',
                name: 'Remifentanil',
                searchTerms: ['remifentanil'],
                category: 'Opioidler',
                undilutedConc: '0.05 mg/ml',
                spt: '0.05 mg/ml (Dilüe edilmemiş)',
                idt: '0.005 mg/ml (1/10 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'Kısa etkili fentanyl türevi'
            },
            {
                id: 'morphine',
                name: 'Morphine (Morfin)',
                searchTerms: ['morphine', 'morfin'],
                category: 'Opioidler',
                undilutedConc: '10 mg/ml',
                spt: '1 mg/ml (1/10 dilüsyon)',
                idt: '0.01 mg/ml (1/1000 dilüsyon)',
                patch: '%5 petrolatum',
                notes: 'Doğal opioid. Nonspesifik histamin salınımı yapar'
            }
        ],

        // Neuromuscular Blocking Agents
        neuromuscularBlockers: [
            {
                id: 'atracurium',
                name: 'Atracurium (Atrakuryum)',
                searchTerms: ['atracurium', 'atrakuryum'],
                category: 'Nöromüsküler Blokerler',
                undilutedConc: '10 mg/ml',
                spt: '1 mg/ml (1/10 dilüsyon)',
                idt: '0.01 mg/ml (1/1000 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'Histamin salınımı yapabilir. Çapraz reaksiyon riski %60-70'
            },
            {
                id: 'cisatracurium',
                name: 'Cis-atracurium',
                searchTerms: ['cisatracurium', 'cis-atracurium'],
                category: 'Nöromüsküler Blokerler',
                undilutedConc: '2 mg/ml',
                spt: '2 mg/ml (Dilüe edilmemiş)',
                idt: '0.02 mg/ml (1/100 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'Atracurium izomeri'
            },
            {
                id: 'mivacurium',
                name: 'Mivacurium (Mivakuryum)',
                searchTerms: ['mivacurium', 'mivakuryum'],
                category: 'Nöromüsküler Blokerler',
                undilutedConc: '2 mg/ml',
                spt: '0.2 mg/ml (1/10 dilüsyon)',
                idt: '0.01 mg/ml (1/200 dilüsyon)',
                notes: 'Önerilen IDT konsantrasyonu güncellenmiştir (1/200)'
            },
            {
                id: 'rocuronium',
                name: 'Rocuronium (Rokuronyum)',
                searchTerms: ['rocuronium', 'rokuronyum'],
                category: 'Nöromüsküler Blokerler',
                undilutedConc: '10 mg/ml',
                spt: '10 mg/ml (Dilüe edilmemiş)',
                idt: '0.05 mg/ml (1/200 dilüsyon)',
                patch: 'Uygulanmaz',
                notes: 'Sık kullanılan nöromüsküler bloker'
            },
            {
                id: 'vecuronium',
                name: 'Vecuronium (Vekuronyum)',
                searchTerms: ['vecuronium', 'vekuronyum'],
                category: 'Nöromüsküler Blokerler',
                undilutedConc: '4 mg/ml',
                spt: '4 mg/ml (Dilüe edilmemiş)',
                idt: '0.04 mg/ml (1/100 dilüsyon)',
                notes: 'Önerilen IDT konsantrasyonu güncellenmiştir (1/100)'
            },
            {
                id: 'pancuronium',
                name: 'Pancuronium (Pankuronyum)',
                searchTerms: ['pancuronium', 'pankuronyum'],
                category: 'Nöromüsküler Blokerler',
                undilutedConc: '2 mg/ml',
                spt: '2 mg/ml (Dilüe edilmemiş)',
                idt: '0.04 mg/ml (1/50 dilüsyon)',
                notes: 'Önerilen IDT konsantrasyonu güncellenmiştir (1/50)'
            },
            {
                id: 'suxamethonium',
                name: 'Suxamethonium (Sukzametonyum)',
                searchTerms: ['suxamethonium', 'sukzametonyum', 'succinylcholine'],
                category: 'Nöromüsküler Blokerler',
                undilutedConc: '50 mg/ml',
                spt: '10 mg/ml (1/5 dilüsyon)',
                idt: '0.5 mg/ml (1/100 dilüsyon)',
                notes: 'Depolarize edici nöromüsküler bloker. Önerilen IDT konsantrasyonu güncellenmiştir (1/100)'
            }
        ],

        // Anticoagulants
        anticoagulants: [
            {
                id: 'heparin',
                name: 'Heparin (Unfraktione)',
                searchTerms: ['heparin', 'unfraktione', 'ufh'],
                category: 'Antikoagülanlar',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'HIT (Heparin-induced thrombocytopenia) şüphesinde test yapılmamalı'
            },
            {
                id: 'nadroparin',
                name: 'Nadroparin',
                searchTerms: ['nadroparin'],
                category: 'Antikoagülanlar',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Düşük molekül ağırlıklı heparin (LMWH)'
            },
            {
                id: 'dalteparin',
                name: 'Dalteparin',
                searchTerms: ['dalteparin'],
                category: 'Antikoagülanlar',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Düşük molekül ağırlıklı heparin (LMWH)'
            },
            {
                id: 'enoxaparin',
                name: 'Enoxaparin (Enoksaparin)',
                searchTerms: ['enoxaparin', 'enoksaparin'],
                category: 'Antikoagülanlar',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Düşük molekül ağırlıklı heparin (LMWH)'
            },
            {
                id: 'fondaparinux',
                name: 'Fondaparinux',
                searchTerms: ['fondaparinux'],
                category: 'Antikoagülanlar',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Sentetik pentasakkarit, heparinoid'
            }
        ],

        // Platinum Salts
        platinumSalts: [
            {
                id: 'carboplatin',
                name: 'Carboplatin (Karboplatin)',
                searchTerms: ['carboplatin', 'karboplatin'],
                category: 'Platin Tuzları',
                spt: '10 mg/ml',
                idt: '1 mg/ml',
                patch: 'Uygulanmaz',
                notes: 'Kemoterapötik ajan'
            },
            {
                id: 'oxaliplatin',
                name: 'Oxaliplatin (Oksaliplatin)',
                searchTerms: ['oxaliplatin', 'oksaliplatin'],
                category: 'Platin Tuzları',
                spt: '1 mg/ml',
                idt: '0.1 mg/ml',
                patch: 'Uygulanmaz',
                notes: 'Kemoterapötik ajan'
            },
            {
                id: 'cisplatin',
                name: 'Cisplatin (Sisplatin)',
                searchTerms: ['cisplatin', 'sisplatin'],
                category: 'Platin Tuzları',
                spt: '1 mg/ml',
                idt: '0.1 mg/ml',
                patch: 'Uygulanmaz',
                notes: 'Kemoterapötik ajan'
            }
        ],

        // NSAIDs
        nsaids: [
            {
                id: 'metamizole',
                name: 'Metamizole (Metamizol, Dipyrone)',
                searchTerms: ['metamizole', 'metamizol', 'dipyrone', 'novalgin'],
                category: 'NSAİİ - Pirazolon Grubu',
                spt: 'Toz',
                idt: '0.1 mg/ml',
                patch: '%10',
                notes: 'Pirazolon türevi. IgE aracılı reaksiyonlar görülebilir'
            },
            {
                id: 'paracetamol',
                name: 'Paracetamol (Asetaminofen)',
                searchTerms: ['paracetamol', 'acetaminophen', 'asetaminofen'],
                category: 'NSAİİ - Pirazolon Grubu',
                spt: 'Toz',
                idt: '0.1 mg/ml',
                patch: '%10',
                notes: 'Analjezik ve antipiretik'
            },
            {
                id: 'aspirin',
                name: 'Aspirin (Asetilsalisilik Asit)',
                searchTerms: ['aspirin', 'asa', 'acetylsalicylic', 'asetilsalisilik'],
                category: 'NSAİİ - Diğer',
                spt: 'Toz',
                idt: '0.1 mg/ml',
                patch: '%10',
                notes: 'IgE aracılı reaksiyonlar nadirdir, çoğu COX-1 inhibisyonu ilişkili'
            },
            {
                id: 'ibuprofen',
                name: 'Ibuprofen',
                searchTerms: ['ibuprofen'],
                category: 'NSAİİ - Diğer',
                spt: 'Toz',
                idt: '0.1 mg/ml',
                patch: '%10',
                notes: 'Propionic acid türevi'
            },
            {
                id: 'naproxen',
                name: 'Naproxen',
                searchTerms: ['naproxen', 'naproksen'],
                category: 'NSAİİ - Diğer',
                spt: 'Toz',
                idt: '0.1 mg/ml',
                patch: '%10',
                notes: 'Propionic acid türevi'
            },
            {
                id: 'diclofenac',
                name: 'Diclofenac (Diklofenak)',
                searchTerms: ['diclofenac', 'diklofenak'],
                category: 'NSAİİ - Diğer',
                spt: 'Toz',
                idt: '0.1 mg/ml',
                patch: '%10',
                notes: 'Acetic acid türevi'
            },
            {
                id: 'celecoxib',
                name: 'Celecoxib',
                searchTerms: ['celecoxib'],
                category: 'NSAİİ - COX-2 İnhibitörleri',
                spt: 'Toz',
                idt: '0.1 mg/ml',
                patch: '%10',
                notes: 'Selektif COX-2 inhibitörü. Dilüe edilmemiş irrite edici olabilir'
            },
            {
                id: 'etoricoxib',
                name: 'Etoricoxib',
                searchTerms: ['etoricoxib'],
                category: 'NSAİİ - COX-2 İnhibitörleri',
                spt: 'Toz',
                idt: '0.1 mg/ml',
                patch: '%10',
                notes: 'Selektif COX-2 inhibitörü'
            }
        ],

        // Biologicals
        biologicals: [
            {
                id: 'adalimumab',
                name: 'Adalimumab',
                searchTerms: ['adalimumab', 'humira'],
                category: 'Biyolojik Ajanlar',
                spt: '50 mg/ml',
                idt: '50 mg/ml',
                patch: 'Dilüe edilmemiş',
                notes: 'TNF-α antagonisti'
            },
            {
                id: 'etanercept',
                name: 'Etanercept',
                searchTerms: ['etanercept', 'enbrel'],
                category: 'Biyolojik Ajanlar',
                spt: '25 mg/ml',
                idt: '5 mg/ml',
                patch: 'Uygulanmaz',
                notes: 'TNF-α antagonisti'
            },
            {
                id: 'infliximab',
                name: 'Infliximab',
                searchTerms: ['infliximab', 'remicade'],
                category: 'Biyolojik Ajanlar',
                spt: '10 mg/ml',
                idt: '10 mg/ml',
                patch: 'Uygulanmaz',
                notes: 'TNF-α antagonisti'
            },
            {
                id: 'omalizumab',
                name: 'Omalizumab',
                searchTerms: ['omalizumab', 'xolair'],
                category: 'Biyolojik Ajanlar',
                spt: '1.25 µg/ml',
                idt: '1.25 µg/ml',
                patch: 'Uygulanmaz',
                notes: 'Anti-IgE monoklonal antikor'
            }
        ],

        // Local Anesthetics
        localAnesthetics: [
            {
                id: 'lidocaine',
                name: 'Lidocaine (Lidokain)',
                searchTerms: ['lidocaine', 'lidokain', 'xylocaine'],
                category: 'Lokal Anestezikler',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Amid grubu. Vazokonstrüktör içermeyen preparat kullanın'
            },
            {
                id: 'bupivacaine',
                name: 'Bupivacaine (Bupivakain)',
                searchTerms: ['bupivacaine', 'bupivakain', 'marcaine'],
                category: 'Lokal Anestezikler',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Amid grubu. Vazokonstrüktör içermeyen preparat kullanın'
            },
            {
                id: 'mepivacaine',
                name: 'Mepivacaine (Mepivakain)',
                searchTerms: ['mepivacaine', 'mepivakain', 'carbocaine'],
                category: 'Lokal Anestezikler',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Amid grubu. Vazokonstrüktör içermeyen preparat kullanın'
            },
            {
                id: 'prilocaine',
                name: 'Prilocaine (Prilokain)',
                searchTerms: ['prilocaine', 'prilokain', 'citanest'],
                category: 'Lokal Anestezikler',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Amid grubu. Vazokonstrüktör içermeyen preparat kullanın'
            },
            {
                id: 'procaine',
                name: 'Procaine (Prokain)',
                searchTerms: ['procaine', 'prokain', 'novocaine'],
                category: 'Lokal Anestezikler',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Ester grubu. Esterler arası çapraz reaksiyon olabilir'
            }
        ],

        // Contrast Media
        contrastMedia: [
            {
                id: 'ioversol',
                name: 'Ioversol',
                searchTerms: ['ioversol', 'optiray'],
                category: 'Kontrast Medya',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Non-iyonik düşük osmolar kontrast medya'
            },
            {
                id: 'iohexol',
                name: 'Iohexol',
                searchTerms: ['iohexol', 'omnipaque'],
                category: 'Kontrast Medya',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Non-iyonik düşük osmolar kontrast medya'
            },
            {
                id: 'iopromide',
                name: 'Iopromide',
                searchTerms: ['iopromide', 'ultravist'],
                category: 'Kontrast Medya',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Non-iyonik düşük osmolar kontrast medya'
            },
            {
                id: 'gadolinium',
                name: 'Gadolinium Chelates',
                searchTerms: ['gadolinium', 'gadovist', 'dotarem'],
                category: 'Kontrast Medya - MR',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Uygulanmaz',
                notes: 'MR kontrast ajanları. Dilüe edilmemiş IDT yalancı pozitif verebilir'
            }
        ],

        // Proton Pump Inhibitors
        ppi: [
            {
                id: 'omeprazole',
                name: 'Omeprazole',
                searchTerms: ['omeprazole', 'omeprazol'],
                category: 'Proton Pompa İnhibitörleri',
                spt: 'Dilüe edilmemiş',
                idt: '40 mg/ml',
                patch: '%10',
                notes: 'IV preparat kullanın'
            },
            {
                id: 'pantoprazole',
                name: 'Pantoprazole',
                searchTerms: ['pantoprazole', 'pantoprazol'],
                category: 'Proton Pompa İnhibitörleri',
                spt: 'Dilüe edilmemiş',
                idt: '40 mg/ml',
                patch: '%10',
                notes: 'IV preparat kullanın'
            },
            {
                id: 'esomeprazole',
                name: 'Esomeprazole',
                searchTerms: ['esomeprazole', 'esomeprazol'],
                category: 'Proton Pompa İnhibitörleri',
                spt: 'Dilüe edilmemiş',
                idt: '40 mg/ml',
                patch: '%10',
                notes: 'IV preparat kullanın'
            },
            {
                id: 'lansoprazole',
                name: 'Lansoprazole',
                searchTerms: ['lansoprazole', 'lansoprazol'],
                category: 'Proton Pompa İnhibitörleri',
                spt: 'Toz',
                idt: 'IV preparat yok',
                patch: '%10',
                notes: 'IV preparat olmadığı için SPT toz ile yapılır'
            }
        ],

        // Fluoroquinolones
        fluoroquinolones: [
            {
                id: 'ciprofloxacin',
                name: 'Ciprofloxacin (Siprofloksasin)',
                searchTerms: ['ciprofloxacin', 'siprofloksasin', 'cipro', 'cipralex'],
                category: 'Fluorokinolonlar',
                spt: '0.025 mg/ml',
                idt: '0.005 mg/ml',
                patch: 'Uygulanmaz',
                notes: 'En sık kullanılan fluorokinolon. MRGPRX2 aracılı non-IgE reaksiyonlar sıktır. Yanlış pozitif oranı yüksek olduğu için deri testi yorumunda dikkatli olunmalı. IDT pozitifliği için: spesifik FQ flare ≥ histamine flare (0.025 mg/ml) veya flare ≥ 5mm (0.005 mg/ml) ve diğer FQ\'lere negatif olmalı'
            },
            {
                id: 'levofloxacin',
                name: 'Levofloxacin (Levofloksasin)',
                searchTerms: ['levofloxacin', 'levofloksasin', 'levo', 'tavanic'],
                category: 'Fluorokinolonlar',
                spt: '0.025 mg/ml',
                idt: '0.005 mg/ml',
                patch: 'Uygulanmaz',
                notes: 'Yaygın kullanılan fluorokinolon. MRGPRX2 aracılı non-IgE reaksiyonlar sıktır. Gerçek IgE aracılı reaksiyonlar nadirdir ve genellikle ilaca spesifiktir. Deri testi yorumunda yüksek yanlış pozitif oranına dikkat'
            },
            {
                id: 'moxifloxacin',
                name: 'Moxifloxacin (Moksifloksasin)',
                searchTerms: ['moxifloxacin', 'moksifloksasin', 'moxi', 'avelox'],
                category: 'Fluorokinolonlar',
                spt: '0.025 mg/ml',
                idt: '0.005 mg/ml',
                patch: 'Uygulanmaz',
                notes: 'Fluorokinolonlarla ilişkili anafilaksilerin çoğu moksifloksasinledir. Ancak ABD\'de siprofloksasin ve levofloksasin kadar yaygın kullanılmaz. MRGPRX2 aracılı direkt mast hücre aktivasyonu nedeniyle yanlış pozitif testler sıktır'
            },
            {
                id: 'ofloxacin',
                name: 'Ofloxacin',
                searchTerms: ['ofloxacin', 'ofloksasin'],
                category: 'Fluorokinolonlar',
                spt: '0.025 mg/ml',
                idt: '0.005 mg/ml',
                patch: 'Uygulanmaz',
                notes: 'Fluorokinolon grubu antibiyotik. Deri testi yanlış pozitif oranı yüksektir'
            }
        ],

        // Anticonvulsants
        anticonvulsants: [
            {
                id: 'carbamazepine',
                name: 'Carbamazepine (Karbamazepin)',
                searchTerms: ['carbamazepine', 'karbamazepin', 'tegretol'],
                category: 'Antikonvülzanlar',
                spt: 'Uygulanmaz',
                idt: 'Uygulanmaz',
                patch: '%10 (Şiddetli reaksiyonlarda %1 ile başlayın)',
                notes: 'Yama testi en yüksek duyarlılık. Şiddetli reaksiyonlarda alevlenme riski'
            },
            {
                id: 'phenytoin',
                name: 'Phenytoin (Fenitoin)',
                searchTerms: ['phenytoin', 'fenitoin', 'dilantin'],
                category: 'Antikonvülzanlar',
                spt: 'Uygulanmaz',
                idt: 'Uygulanmaz',
                patch: '%10 (Şiddetli reaksiyonlarda %1 ile başlayın)',
                notes: 'Yama testi kullanılır. DRESS, SJS/TEN riski'
            },
            {
                id: 'lamotrigine',
                name: 'Lamotrigine (Lamotrijin)',
                searchTerms: ['lamotrigine', 'lamotrijin', 'lamictal'],
                category: 'Antikonvülzanlar',
                spt: 'Uygulanmaz',
                idt: 'Uygulanmaz',
                patch: '%10 (Şiddetli reaksiyonlarda %1 ile başlayın)',
                notes: 'Yama testinin duyarlılığı düşüktür. SJS/TEN riski'
            },
            {
                id: 'phenobarbital',
                name: 'Phenobarbital (Fenobarbital)',
                searchTerms: ['phenobarbital', 'fenobarbital', 'luminal'],
                category: 'Antikonvülzanlar',
                spt: 'Uygulanmaz',
                idt: 'Uygulanmaz',
                patch: '%10 (Şiddetli reaksiyonlarda %1 ile başlayın)',
                notes: 'Yama testinin duyarlılığı düşük'
            }
        ],

        // Other Antibiotics
        otherAntibiotics: [
            {
                id: 'vancomycin',
                name: 'Vancomycin (Vankomisin)',
                searchTerms: ['vancomycin', 'vankomisin', 'vanko'],
                category: 'Antibiyotikler - Glikopeptid',
                spt: '50 mg/ml',
                idt: '5 mg/ml',
                patch: '%10',
                notes: 'Non-IgE aracılı "Red Man Sendromu" çok sıktır (histamin salınımı). Gerçek IgE aracılı reaksiyonlar nadirdir. Hızlı infüzyon ile reaksiyon riski artar. Yüksek konsantrasyonlar irritan olabilir. Deri testi yanlış pozitif oranı yüksektir'
            },
            {
                id: 'teicoplanin',
                name: 'Teicoplanin',
                searchTerms: ['teicoplanin', 'teikoplanin'],
                category: 'Antibiyotikler - Glikopeptid',
                spt: '25 mg/ml',
                idt: '2.5 mg/ml',
                patch: '%10',
                notes: 'Glikopeptid grubu. Vankomisin alternatifi'
            },
            {
                id: 'clarithromycin',
                name: 'Clarithromycin (Klaritromisin)',
                searchTerms: ['clarithromycin', 'klaritromisin', 'biaxin'],
                category: 'Antibiyotikler - Makrolid',
                spt: '50 mg/ml',
                idt: '5 mg/ml',
                patch: '%10',
                notes: 'Makrolid grubu. Deri testi duyarlılığı düşük, merkezler arası değişkenlik gösterir'
            },
            {
                id: 'azithromycin',
                name: 'Azithromycin (Azitromisin)',
                searchTerms: ['azithromycin', 'azitromisin', 'zithromax'],
                category: 'Antibiyotikler - Makrolid',
                spt: '50 mg/ml',
                idt: '5 mg/ml',
                patch: '%10',
                notes: 'Makrolid grubu. İrritanlık riski var. Deri testi duyarlılığı düşük'
            },
            {
                id: 'metronidazole',
                name: 'Metronidazole (Metronidazol)',
                searchTerms: ['metronidazole', 'metronidazol', 'flagyl'],
                category: 'Antibiyotikler - Nitroimidazol',
                spt: '5 mg/ml',
                idt: '0.05 mg/ml',
                patch: '%10',
                notes: 'Nitroimidazol grubu. Anaerobik bakterilere ve protozolara karşı etkili'
            }
        ],

        // Chemotherapy - Taxanes
        taxanes: [
            {
                id: 'paclitaxel',
                name: 'Paclitaxel',
                searchTerms: ['paclitaxel', 'taxol'],
                category: 'Kemoterapötikler - Taksan',
                spt: '6 mg/ml',
                idt: '0.001 → 1 mg/ml (kademeli)',
                patch: 'Uygulanmaz',
                notes: 'Taksan grubu kemoterapötik. Seri artan IDT (kademeli) önerilir: 0.001 → 0.01 → 0.1 → 1 mg/ml (AAAAI 2022). Hipersensitivite reaksiyonları sık'
            },
            {
                id: 'docetaxel',
                name: 'Docetaxel',
                searchTerms: ['docetaxel', 'taxotere'],
                category: 'Kemoterapötikler - Taksan',
                spt: 'Dilüe edilmemiş (konsantre)',
                idt: '0.001 → 1 mg/ml (kademeli)',
                patch: 'Uygulanmaz',
                notes: 'Taksan grubu. Seri artan IDT önerilir. Paclitaxel ile çapraz reaktivite olabilir. Premedikasyon genellikle gereklidir'
            }
        ],

        // Other drugs
        others: [
            {
                id: 'chlorhexidine',
                name: 'Chlorhexidine (Klorheksidin)',
                searchTerms: ['chlorhexidine', 'klorheksidin'],
                category: 'Antiseptikler',
                spt: '5 mg/ml',
                idt: '0.002 mg/ml',
                patch: '%1',
                notes: 'Perioperatif reaksiyonlarda test paneline dahil edilmeli'
            },
            {
                id: 'patent-blue',
                name: 'Patent Blue',
                searchTerms: ['patent blue', 'isosulfan'],
                category: 'Boyalar',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Uygulanmaz',
                notes: 'Sentinel lenf nodu haritalamada kullanılır'
            },
            {
                id: 'methylene-blue',
                name: 'Methylene Blue',
                searchTerms: ['methylene blue', 'metilen mavisi'],
                category: 'Boyalar',
                spt: '1/100 dilüsyon',
                idt: '1/100 dilüsyon',
                patch: 'Uygulanmaz',
                notes: 'Cerrahi işaretlemede kullanılır'
            },
            {
                id: 'fluorescein',
                name: 'Fluorescein',
                searchTerms: ['fluorescein', 'floresein'],
                category: 'Boyalar',
                spt: 'Dilüe edilmemiş',
                idt: '1/10 dilüsyon',
                patch: 'Dilüe edilmemiş',
                notes: 'Oftalmolojik muayenede kullanılır'
            }
        ]
    };

    // Flatten all drugs into searchable array
    const allDrugs = [];
    Object.keys(skinTestData).forEach(category => {
        allDrugs.push(...skinTestData[category]);
    });

    console.log('📦 Data loaded: ' + allDrugs.length + ' drugs');

    // ========== UI.JS - User Interface Logic ==========
    let searchTimeout = null;
    let selectedDrug = null;

    // Turkish character normalization
    function normalizeText(text) {
        return text.toLowerCase()
            .replace(/ı/g, 'i').replace(/İ/g, 'i')
            .replace(/ğ/g, 'g').replace(/Ğ/g, 'g')
            .replace(/ü/g, 'u').replace(/Ü/g, 'u')
            .replace(/ş/g, 's').replace(/Ş/g, 's')
            .replace(/ö/g, 'o').replace(/Ö/g, 'o')
            .replace(/ç/g, 'c').replace(/Ç/g, 'c');
    }

    // Populate grouped dropdown
    function populateDropdown() {
        const dropdown = document.getElementById('drugDropdown');
        if (!dropdown) return;

        const groupedDrugs = {};
        allDrugs.forEach(drug => {
            if (!groupedDrugs[drug.category]) {
                groupedDrugs[drug.category] = [];
            }
            groupedDrugs[drug.category].push(drug);
        });

        const sortedCategories = Object.keys(groupedDrugs).sort();
        let html = '<option value="">İlaç seçin...</option>';

        sortedCategories.forEach(category => {
            html += '<optgroup label="' + category + '">';
            groupedDrugs[category]
                .sort((a, b) => a.name.localeCompare(b.name, 'tr'))
                .forEach(drug => {
                    html += '<option value="' + drug.id + '">' + drug.name + '</option>';
                });
            html += '</optgroup>';
        });

        dropdown.innerHTML = html;
        console.log('✅ Dropdown populated with ' + allDrugs.length + ' drugs');
    }

    // Setup dropdown
    function setupDropdown() {
        const dropdown = document.getElementById('drugDropdown');
        if (!dropdown) return;

        dropdown.addEventListener('change', function(e) {
            const drugId = e.target.value;
            if (drugId) {
                selectDrug(drugId);
                const searchInput = document.getElementById('drugSearch');
                if (searchInput) {
                    searchInput.value = '';
                    clearSearchResults();
                }
            } else {
                clearDrugDetails();
            }
        });
    }

    // Setup search input
    function setupSearchInput() {
        const searchInput = document.getElementById('drugSearch');
        if (!searchInput) return;

        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.trim();
            const clearBtn = document.getElementById('clearSearch');

            if (clearBtn) {
                if (query.length > 0) {
                    clearBtn.classList.remove('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                }
            }

            if (searchTimeout) clearTimeout(searchTimeout);

            if (query.length >= 3) {
                searchTimeout = setTimeout(function() {
                    performSearch(query);
                }, 300);
            } else {
                clearSearchResults();
            }
        });

        const clearBtn = document.getElementById('clearSearch');
        if (clearBtn) {
            clearBtn.addEventListener('click', function() {
                searchInput.value = '';
                clearSearchResults();
                clearDrugDetails();
                clearBtn.classList.add('hidden');
                searchInput.focus();
            });
        }
    }

    // Perform search
    function performSearch(query) {
        const normalizedQuery = normalizeText(query);
        const results = allDrugs.filter(function(drug) {
            const nameMatch = normalizeText(drug.name).includes(normalizedQuery);
            const termsMatch = drug.searchTerms.some(function(term) {
                return normalizeText(term).includes(normalizedQuery);
            });
            const categoryMatch = normalizeText(drug.category).includes(normalizedQuery);
            return nameMatch || termsMatch || categoryMatch;
        });

        displaySearchResults(results, query);
    }

    // Display search results
    function displaySearchResults(results, query) {
        const resultsContainer = document.getElementById('searchResults');
        if (!resultsContainer) return;

        if (results.length === 0) {
            resultsContainer.innerHTML = '<div class="p-4 text-center text-slate-500 dark:text-slate-400">' +
                '<span class="material-symbols-outlined text-4xl opacity-50">search_off</span>' +
                '<p class="mt-2">"' + query + '" için sonuç bulunamadı</p></div>';
            resultsContainer.classList.remove('hidden');
            return;
        }

        let html = '<div class="space-y-2">';
        results.forEach(function(drug) {
            html += '<button onclick="selectDrug(\'' + drug.id + '\')" ' +
                'class="w-full text-left p-3 rounded-lg border border-slate-200 dark:border-slate-700 ' +
                'bg-white dark:bg-slate-800 hover:border-primary hover:bg-primary/5 ' +
                'transition-all duration-200 group">' +
                '<div class="flex items-center justify-between">' +
                '<div class="flex-1">' +
                '<div class="font-semibold text-slate-900 dark:text-white group-hover:text-primary">' +
                drug.name + '</div>' +
                '<div class="text-xs text-slate-500 dark:text-slate-400 mt-1">' +
                drug.category + '</div></div>' +
                '<span class="material-symbols-outlined text-slate-400 group-hover:text-primary">chevron_right</span>' +
                '</div></button>';
        });
        html += '</div>';

        resultsContainer.innerHTML = html;
        resultsContainer.classList.remove('hidden');
    }

    // Clear search results
    function clearSearchResults() {
        const resultsContainer = document.getElementById('searchResults');
        if (resultsContainer) {
            resultsContainer.innerHTML = '';
            resultsContainer.classList.add('hidden');
        }
    }

    // Select drug and display details
    function selectDrug(drugId) {
        const drug = allDrugs.find(function(d) { return d.id === drugId; });
        if (!drug) return;

        selectedDrug = drug;
        displayDrugDetails(drug);

        const searchInput = document.getElementById('drugSearch');
        if (searchInput) searchInput.value = '';
        clearSearchResults();

        const detailsEl = document.getElementById('drugDetails');
        if (detailsEl) {
            detailsEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Display drug details
    function displayDrugDetails(drug) {
        const detailsContainer = document.getElementById('drugDetails');
        if (!detailsContainer) return;

        let html = '<div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6 space-y-6">' +
            '<div class="border-b border-slate-200 dark:border-slate-700 pb-4">' +
            '<div class="flex items-start justify-between">' +
            '<div><h2 class="text-2xl font-bold text-slate-900 dark:text-white">' + drug.name + '</h2>' +
            '<p class="text-sm text-slate-600 dark:text-slate-400 mt-1">' + drug.category + '</p></div>' +
            '<button onclick="clearDrugDetails()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">' +
            '<span class="material-symbols-outlined">close</span></button></div></div>' +
            '<div class="grid grid-cols-1 md:grid-cols-3 gap-4">' +
            '<div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-950/30 dark:to-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">' +
            '<div class="flex items-center gap-2 mb-3"><span class="material-symbols-outlined text-blue-600 dark:text-blue-400">vaccines</span>' +
            '<h3 class="font-bold text-blue-900 dark:text-blue-100">SPT</h3></div>' +
            '<p class="text-xs text-blue-700 dark:text-blue-300 mb-2">Skin Prick Test</p>' +
            '<div class="bg-white dark:bg-blue-950/50 rounded-lg p-3 mt-2"><p class="text-sm font-mono font-semibold text-blue-900 dark:text-blue-100">' +
            (drug.spt || 'Belirtilmemiş') + '</p></div></div>' +
            '<div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950/30 dark:to-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">' +
            '<div class="flex items-center gap-2 mb-3"><span class="material-symbols-outlined text-green-600 dark:text-green-400">medication</span>' +
            '<h3 class="font-bold text-green-900 dark:text-green-100">IDT</h3></div>' +
            '<p class="text-xs text-green-700 dark:text-green-300 mb-2">Intradermal Test</p>' +
            '<div class="bg-white dark:bg-green-950/50 rounded-lg p-3 mt-2"><p class="text-sm font-mono font-semibold text-green-900 dark:text-green-100">' +
            (drug.idt || 'Belirtilmemiş') + '</p></div></div>' +
            '<div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-950/30 dark:to-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-4">' +
            '<div class="flex items-center gap-2 mb-3"><span class="material-symbols-outlined text-purple-600 dark:text-purple-400">healing</span>' +
            '<h3 class="font-bold text-purple-900 dark:text-purple-100">Yama Testi</h3></div>' +
            '<p class="text-xs text-purple-700 dark:text-purple-300 mb-2">Patch Test</p>' +
            '<div class="bg-white dark:bg-purple-950/50 rounded-lg p-3 mt-2"><p class="text-sm font-mono font-semibold text-purple-900 dark:text-purple-100">' +
            (drug.patch || 'Uygulanmaz') + '</p></div></div></div>';

        if (drug.undilutedConc) {
            html += '<div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg p-4">' +
                '<h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Dilüe Edilmemiş Konsantrasyon</h4>' +
                '<p class="text-sm font-mono text-slate-900 dark:text-white">' + drug.undilutedConc + '</p></div>';
        }

        if (drug.notes) {
            html += '<div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">' +
                '<div class="flex items-start gap-2"><span class="material-symbols-outlined text-amber-600 dark:text-amber-400 flex-shrink-0">info</span>' +
                '<div class="flex-1"><h4 class="text-sm font-semibold text-amber-900 dark:text-amber-100 mb-1">Önemli Notlar</h4>' +
                '<p class="text-sm text-amber-900 dark:text-amber-100">' + drug.notes + '</p></div></div></div>';
        }

        if (drug.searchTerms && drug.searchTerms.length > 0) {
            html += '<div class="border-t border-slate-200 dark:border-slate-700 pt-4">' +
                '<h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Alternatif İsimler / Arama Terimleri</h4>' +
                '<div class="flex flex-wrap gap-2">';
            drug.searchTerms.forEach(function(term) {
                html += '<span class="px-2 py-1 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs rounded-md border border-slate-200 dark:border-slate-600">' +
                    term + '</span>';
            });
            html += '</div></div>';
        }

        html += '</div>';
        detailsContainer.innerHTML = html;
        detailsContainer.classList.remove('hidden');
    }

    // Clear drug details
    function clearDrugDetails() {
        const detailsContainer = document.getElementById('drugDetails');
        if (detailsContainer) {
            detailsContainer.innerHTML = '';
            detailsContainer.classList.add('hidden');
        }

        const dropdown = document.getElementById('drugDropdown');
        if (dropdown) dropdown.value = '';

        selectedDrug = null;
    }

    // Render category buttons
    function renderCategoryButtons() {
        const container = document.getElementById('categoryFilters');
        if (!container) return;

        const categories = {
            'betalactams': { name: 'Beta-laktamlar', icon: 'science', color: 'blue' },
            'fluoroquinolones': { name: 'Fluorokinolonlar', icon: 'category', color: 'lime' },
            'otherAntibiotics': { name: 'Diğer Antibiyotikler', icon: 'medication_liquid', color: 'emerald' },
            'anesthetics': { name: 'Anestezikler', icon: 'local_hospital', color: 'indigo' },
            'opioids': { name: 'Opioidler', icon: 'medication', color: 'purple' },
            'neuromuscularBlockers': { name: 'NM Blokerler', icon: 'offline_bolt', color: 'pink' },
            'anticoagulants': { name: 'Antikoagülanlar', icon: 'water_drop', color: 'red' },
            'platinumSalts': { name: 'Platin Tuzları', icon: 'colorize', color: 'orange' },
            'taxanes': { name: 'Taksanlar', icon: 'healing', color: 'rose' },
            'nsaids': { name: 'NSAİİ', icon: 'pill', color: 'amber' },
            'biologicals': { name: 'Biyolojikler', icon: 'biotech', color: 'green' },
            'localAnesthetics': { name: 'Lokal Anestezikler', icon: 'syringe', color: 'teal' },
            'contrastMedia': { name: 'Kontrast Medya', icon: 'contrast', color: 'cyan' },
            'ppi': { name: 'PPI', icon: 'gastroenterology', color: 'sky' },
            'anticonvulsants': { name: 'Antikonvülzanlar', icon: 'neurology', color: 'violet' },
            'others': { name: 'Diğer', icon: 'more_horiz', color: 'slate' }
        };

        let html = '<div class="flex flex-wrap gap-2">';
        Object.keys(categories).forEach(function(key) {
            const cat = categories[key];
            const count = skinTestData[key] ? skinTestData[key].length : 0;
            if (count > 0) {
                html += '<button onclick="filterByCategory(\'' + key + '\')" ' +
                    'class="flex items-center gap-2 px-4 py-2 rounded-lg border border-' + cat.color + '-200 dark:border-' + cat.color + '-800 ' +
                    'bg-' + cat.color + '-50 dark:bg-' + cat.color + '-950/30 text-' + cat.color + '-700 dark:text-' + cat.color + '-300 ' +
                    'hover:bg-' + cat.color + '-100 dark:hover:bg-' + cat.color + '-900/40 transition-all duration-200">' +
                    '<span class="material-symbols-outlined text-sm">' + cat.icon + '</span>' +
                    '<span class="text-sm font-medium">' + cat.name + '</span>' +
                    '<span class="text-xs opacity-75">(' + count + ')</span></button>';
            }
        });
        html += '</div>';
        container.innerHTML = html;
    }

    // Filter by category
    function filterByCategory(categoryKey) {
        const drugs = skinTestData[categoryKey] || [];
        if (drugs.length === 0) return;

        displaySearchResults(drugs, '');
        const resultsEl = document.getElementById('searchResults');
        if (resultsEl) {
            resultsEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    // Initialize module
    function initSkinTestModule() {
        console.log('🚀 Initializing Skin Test Module...');

        setTimeout(function() {
            const dropdown = document.getElementById('drugDropdown');
            const searchInput = document.getElementById('drugSearch');

            if (dropdown || searchInput) {
                console.log('✅ Module elements found, initializing...');
                populateDropdown();
                setupSearchInput();
                setupDropdown();
                renderCategoryButtons();
                console.log('✅ Module initialized successfully');
            } else {
                console.log('⏳ Module elements not ready yet, retrying...');
                setTimeout(initSkinTestModule, 100);
            }
        }, 50);
    }

    // Export functions to global scope
    window.initSkinTestModule = initSkinTestModule;
    window.selectDrug = selectDrug;
    window.clearDrugDetails = clearDrugDetails;
    window.filterByCategory = filterByCategory;
    window.skinTestModuleLoaded = true;

    // Auto-initialize
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSkinTestModule);
    } else {
        initSkinTestModule();
    }

    console.log('✅ Skin Test Module ready (inline version)');
})();
</script>
