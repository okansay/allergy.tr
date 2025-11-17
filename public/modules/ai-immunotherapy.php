<!-- AI İmmünoterapi Karar Destek Sistemi -->
<div x-data="{
    // State
    currentStep: 'select_method',
    reportText: '',
    aiProcessing: false,
    aiError: '',
    selectedComponents: {},
    ruleEngineResults: [],
    aiInterpretation: '',

    // Component Groups Data
    componentGroups: {
        pollen: {
            tree: {
                'Huş (Birch)': ['Bet v 1', 'Bet v 2', 'Bet v 4', 'Bet v 6'],
                'Kızılağaç (Alder)': ['Aln g 1', 'Aln g 4'],
                'Fındık (Hazel)': ['Cor a 1'],
                'Selvi (Cypress)': ['Cup a 1'],
                'Zeytin (Olive)': ['Ole e 1', 'Ole e 7', 'Ole e 9'],
                'Dişbudak (Ash)': ['Fra e 1'],
                'Çınar (Plane Tree)': ['Pla a 1', 'Pla a 2', 'Pla a 3'],
                'Japon Sediri (Sugi)': ['Cry j 1'],
                'Diğer (GRP)': ['Pru p 7']
            },
            grass: {
                'Timoti (Timothy)': ['Phl p 1', 'Phl p 2', 'Phl p 5', 'Phl p 6', 'Phl p 7', 'Phl p 11', 'Phl p 12'],
                'Bermuda Çimeni': ['Cyn d 1']
            },
            weed: {
                'Kanarya Otu (Ragweed)': ['Amb a 1'],
                'Pelin Otu (Mugwort)': ['Art v 1', 'Art v 3'],
                'Duvar Fesleğeni (Pellitory)': ['Par j 2'],
                'Sinir Otu (Plantain)': ['Pla l 1']
            }
        },
        indoor: {
            mite: {
                'D. pteronyssinus': ['Der p 1', 'Der p 2', 'Der p 5', 'Der p 7', 'Der p 10', 'Der p 11', 'Der p 20', 'Der p 21', 'Der p 23'],
                'D. farinae': ['Der f 1', 'Der f 2'],
                'Blomia tropicalis': ['Blo t 5', 'Blo t 10', 'Blo t 21']
            },
            cockroach: {
                'Blatella germanica': ['Bla g 1', 'Bla g 2', 'Bla g 4', 'Bla g 5'],
                'Periplaneta americana': ['Per a 7']
            },
            mould: {
                'Aspergillus fumigatus': ['Asp f 1', 'Asp f 3', 'Asp f 4', 'Asp f 6'],
                'Alternaria alternata': ['Alt a 1', 'Alt a 6'],
                'Cladosporium herbarum': ['Cla h 8']
            },
            furry: {
                'Kedi (Cat)': ['Fel d 1', 'Fel d 2', 'Fel d 4', 'Fel d 7'],
                'Köpek (Dog)': ['Can f 1', 'Can f 2', 'Can f 3', 'Can f 4', 'Can f 5', 'Can f 6'],
                'At (Horse)': ['Equ c 1', 'Equ c 3', 'Equ c 4'],
                'Sığır (Cattle)': ['Bos d 2'],
                'Fare (Mouse)': ['Mus m 1']
            }
        },
        occupational: {
            'Lateks (Latex)': ['Hev b 1', 'Hev b 3', 'Hev b 5', 'Hev b 6.02', 'Hev b 8'],
            'Buğday (Wheat - Solunumsal)': ['Tri a 14', 'Tri a 19', 'Tri a aA/TI']
        }
    },

    // Initialize
    init() {
        const allGroups = [
            ...Object.values(this.componentGroups.pollen).flatMap(g => Object.values(g)).flat(),
            ...Object.values(this.componentGroups.indoor).flatMap(g => Object.values(g)).flat(),
            ...Object.values(this.componentGroups.occupational).flat()
        ];
        allGroups.forEach(comp => { this.selectedComponents[comp] = false; });
    },

    // Method Selection
    selectMethod(method) {
        this.currentStep = method === 'ai' ? 'ai_input' : 'manual_input';
    },

    // AI Parse Report
    async parseReportWithAI() {
        this.aiProcessing = true;
        this.aiError = '';
        try {
            const response = await fetch('/api/gemini-parse.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ reportText: this.reportText })
            });
            const data = await response.json();
            if (!response.ok || data.error) throw new Error(data.error || 'AI analiz hatası');
            if (data.components && Array.isArray(data.components)) {
                data.components.forEach(comp => {
                    if (this.selectedComponents.hasOwnProperty(comp)) {
                        this.selectedComponents[comp] = true;
                    }
                });
            }
            this.currentStep = 'verification';
        } catch (error) {
            this.aiError = error.message;
        } finally {
            this.aiProcessing = false;
        }
    },

    // Run Analysis
    async runAnalysis() {
        this.ruleEngineResults = [];
        this.aiInterpretation = '';
        this.currentStep = 'results';
        this.aiProcessing = true;

        // Rule Engine
        this.ruleEngineResults = [
            ...this.checkAgacPoleni(this.selectedComponents),
            ...this.checkCayirPoleni(this.selectedComponents),
            ...this.checkAkar(this.selectedComponents),
            ...this.checkKuf(this.selectedComponents),
            ...this.checkHayvanlar(this.selectedComponents)
        ];

        // AI Interpretation
        try {
            const response = await fetch('/api/gemini-interpret.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    selectedComponents: this.selectedComponents,
                    ruleEngineResults: this.ruleEngineResults
                })
            });
            const data = await response.json();
            if (!response.ok || data.error) throw new Error(data.error || 'AI yorumlama hatası');
            this.aiInterpretation = data.interpretation || '';
        } catch (error) {
            console.error('AI Error:', error);
            this.aiInterpretation = '<p class=\"text-red-600\">AI yorumlama hatası. Teknik sonuçları yukarıda görebilirsiniz.</p>';
        } finally {
            this.aiProcessing = false;
        }
    },

    // Rule Engine: Tree Pollen
    checkAgacPoleni(k) {
        let out = [], primer = false, pan = false, panList = [];
        if (k['Bet v 1'] || k['Cup a 1'] || k['Ole e 1'] || k['Pla a 1']) {
            primer = true;
            out.push({grup: 'Ağaç Poleni', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer ağaç poleni duyarlanması saptandı (Bet v 1, Cup a 1, Ole e 1 veya Pla a 1 pozitif).'});
        }
        if (k['Bet v 2']) { pan = true; panList.push('Profilin (Bet v 2)'); }
        if (k['Bet v 4']) { pan = true; panList.push('Polcalcin (Bet v 4)'); }
        if (k['Ole e 7'] || k['Pla a 3']) { pan = true; panList.push('LTP (Ole e 7 / Pla a 3)'); }
        if (k['Pru p 7']) { pan = true; panList.push('GRP (Pru p 7)'); }
        if (!primer && pan) {
            out.push({grup: 'Ağaç Poleni', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer belirteç negatif. Pozitiflik panalerjenlerden: ' + panList.join(', ')});
        } else if (primer && pan) {
            out.push({grup: 'Ağaç Poleni', oneri: 'UYARI (Çapraz Reaksiyon)', gerekce: 'Primer duyarlanma var ancak panalerjen pozitifliği (' + panList.join(', ') + ') mevcut.'});
        }
        return out;
    },

    // Rule Engine: Grass Pollen
    checkCayirPoleni(k) {
        let out = [], primer = false;
        if (k['Phl p 1'] || k['Phl p 2'] || k['Phl p 5'] || k['Phl p 11']) {
            primer = true;
            out.push({grup: 'Çayır Poleni', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Gerçek çayır poleni duyarlanması saptandı (Phl p 1, 2, 5 veya 11 pozitif).'});
        }
        if (k['Phl p 7']) out.push({grup: 'Çayır Poleni', oneri: 'KLİNİK RİSK UYARISI', gerekce: 'Phl p 7 (Polcalcin) pozitifliği: Astım riski.'});
        if (k['Phl p 12']) out.push({grup: 'Çayır Poleni', oneri: 'KLİNİK RİSK UYARISI', gerekce: 'Phl p 12 (Profilin) pozitifliği: OAS riski.'});
        if (!primer && (k['Phl p 7'] || k['Phl p 12'])) {
            out.push({grup: 'Çayır Poleni', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer belirteçler negatif. Pozitiflik panalerjenlerden.'});
        }
        return out;
    },

    // Rule Engine: HDM
    checkAkar(k) {
        let out = [], primer = false;
        if (k['Der p 1'] || k['Der p 2'] || k['Der p 23'] || k['Der f 1'] || k['Der f 2'] || k['Blo t 5'] || k['Blo t 21']) {
            primer = true;
            out.push({grup: 'Ev Tozu Akarı (HDM)', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Gerçek akar duyarlanması saptandı.'});
        }
        if (k['Der p 10'] || k['Blo t 10']) {
            if (!primer) {
                out.push({grup: 'Ev Tozu Akarı (HDM)', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer belirteçler negatif. Pozitiflik Tropomyosin kaynaklı.'});
            } else {
                out.push({grup: 'Ev Tozu Akarı (HDM)', oneri: 'UYARI (Çapraz Reaksiyon)', gerekce: 'Akar AIT uygun, ancak Tropomyosin pozitifliği mevcut.'});
            }
        }
        return out;
    },

    // Rule Engine: Mould
    checkKuf(k) {
        let out = [];
        if (k['Alt a 1']) {
            out.push({grup: 'Küf (Alternaria)', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer Alternaria duyarlanması (Alt a 1 pozitif).'});
        } else if (!k['Alt a 1'] && k['Alt a 6']) {
            out.push({grup: 'Küf (Alternaria)', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer belirteç Alt a 1 negatif.'});
        }
        return out;
    },

    // Rule Engine: Animals
    checkHayvanlar(k) {
        let out = [];
        // Cat
        if (k['Fel d 1']) {
            out.push({grup: 'Kedi', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer kedi duyarlanması (Fel d 1 pozitif).'});
            if (k['Fel d 2'] || k['Fel d 4']) {
                out.push({grup: 'Kedi', oneri: 'UYARI (Çapraz Reaksiyon)', gerekce: 'Fel d 2/4 pozitif: diğer hayvanlarla çapraz reaksiyon riski.'});
            }
        } else if (k['Fel d 2'] || k['Fel d 4']) {
            out.push({grup: 'Kedi', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer belirteç Fel d 1 negatif. Pozitiflik çapraz reaktiflerden.'});
        }
        // Dog
        if (k['Can f 1'] || k['Can f 2'] || k['Can f 4'] || k['Can f 5']) {
            out.push({grup: 'Köpek', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer köpek duyarlanması saptandı.'});
        } else if (k['Can f 3'] || k['Can f 6']) {
            out.push({grup: 'Köpek', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer belirteçler negatif. Pozitiflik çapraz reaktiflerden.'});
        }
        // Horse
        if (k['Equ c 1']) {
            out.push({grup: 'At', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer at duyarlanması (Equ c 1 pozitif).'});
        } else if (k['Equ c 3']) {
            out.push({grup: 'At', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer belirteç negatif. Pozitiflik Equ c 3 (Albumin) kaynaklı.'});
        }
        return out;
    },

    // Helper Functions
    clearAllSelections() {
        Object.keys(this.selectedComponents).forEach(key => { this.selectedComponents[key] = false; });
    },

    resetToStart() {
        this.currentStep = 'select_method';
        this.reportText = '';
        this.aiError = '';
        this.aiProcessing = false;
        this.ruleEngineResults = [];
        this.aiInterpretation = '';
        this.clearAllSelections();
    }
}"
x-init="init()"
class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-900 dark:to-slate-800 p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center gap-4">
                <span class="material-symbols-outlined text-5xl text-indigo-600 dark:text-indigo-400">psychology</span>
                <div>
                    <h1 class="text-3xl font-bold text-slate-800 dark:text-white">AI İmmünoterapi Karar Destek</h1>
                    <p class="text-slate-600 dark:text-slate-300 mt-1">Moleküler Alerji Karar Desteği (MA-KDS) - Solunumsal Modül</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Kaynak: EAACI Molecular Allergology Pocket Guide 2024</p>
                </div>
            </div>
        </div>

        <!-- ADIM 1: Giriş Yöntemi Seçimi -->
        <div x-show="currentStep === 'select_method'" class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-6 text-center">Veri Giriş Yöntemi Seçin</h2>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- AI Destekli Giriş -->
                    <div @click="selectMethod('ai')"
                         class="cursor-pointer bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 border-2 border-indigo-300 dark:border-indigo-700 rounded-xl p-6 hover:shadow-xl transition-all transform hover:scale-105">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-6xl text-indigo-600 dark:text-indigo-400 mb-4">auto_awesome</span>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Rapor Metni ile Otomatik Giriş</h3>
                            <p class="text-slate-600 dark:text-slate-300 text-sm mb-4">Laboratuvar raporunuzu yapıştırın, AI otomatik olarak analiz etsin</p>
                            <div class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                <span class="material-symbols-outlined text-lg">send</span>
                                AI ile Başla
                            </div>
                        </div>
                    </div>

                    <!-- Manuel Giriş -->
                    <div @click="selectMethod('manual')"
                         class="cursor-pointer bg-gradient-to-br from-slate-50 to-gray-50 dark:from-slate-800/30 dark:to-gray-800/30 border-2 border-slate-300 dark:border-slate-700 rounded-xl p-6 hover:shadow-xl transition-all transform hover:scale-105">
                        <div class="text-center">
                            <span class="material-symbols-outlined text-6xl text-slate-600 dark:text-slate-400 mb-4">checklist</span>
                            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-3">Manuel Komponent Seçimi</h3>
                            <p class="text-slate-600 dark:text-slate-300 text-sm mb-4">Pozitif komponentleri listeden manuel olarak seçin</p>
                            <div class="inline-flex items-center gap-2 bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                                <span class="material-symbols-outlined text-lg">edit_square</span>
                                Manuel Giriş
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ADIM 2A: AI Destekli Giriş -->
        <div x-show="currentStep === 'ai_input'" class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Laboratuvar Raporu Yükle</h2>
                    <button @click="currentStep = 'select_method'" class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </button>
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                        Lütfen laboratuvar raporunuzun metnini buraya yapıştırın:
                    </label>
                    <textarea x-model="reportText"
                              rows="12"
                              class="w-full px-4 py-3 border-2 border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-slate-700 dark:text-white"
                              placeholder="Örnek:
ImmunoCAP Results:
- Bet v 1: 15.2 kU/L (Class 3)
- Phl p 5: 3.8 kU/L (Class 2)
- Der p 1: 28.5 kU/L (Class 4)
..."></textarea>

                    <div x-show="aiError" class="bg-red-50 dark:bg-red-900/30 border border-red-300 dark:border-red-700 rounded-lg p-4 text-sm text-red-800 dark:text-red-300">
                        <strong>Hata:</strong> <span x-text="aiError"></span>
                    </div>

                    <button @click="parseReportWithAI()"
                            :disabled="!reportText.trim() || aiProcessing"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-300 disabled:cursor-not-allowed text-white font-semibold py-4 rounded-lg flex items-center justify-center gap-3 transition-all">
                        <span x-show="!aiProcessing" class="material-symbols-outlined">rocket_launch</span>
                        <span x-show="aiProcessing" class="material-symbols-outlined animate-spin">progress_activity</span>
                        <span x-text="aiProcessing ? 'AI Analiz Ediyor...' : 'Raporu Tara ve Analiz Et'"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- ADIM 2B & Doğrulama: Manuel/AI Sonrası Komponent Seçimi -->
        <div x-show="currentStep === 'manual_input' || currentStep === 'verification'" class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800 dark:text-white" x-text="currentStep === 'verification' ? 'AI Sonuçlarını Doğrulayın' : 'Pozitif Komponentleri Seçin'"></h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1" x-show="currentStep === 'verification'">
                            AI tarafından tespit edilen pozitif komponentler işaretlendi. Lütfen kontrol edin.
                        </p>
                    </div>
                    <button @click="resetToStart()" class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Komponent Listesi -->
                <div class="space-y-6 max-h-[600px] overflow-y-auto pr-4">
                    <!-- 🤧 POLLENs -->
                    <div class="border-2 border-yellow-300 dark:border-yellow-700 rounded-lg p-4 bg-yellow-50 dark:bg-yellow-900/20">
                        <h3 class="text-lg font-bold mb-4"><span class="text-2xl">🤧</span> Polenler</h3>

                        <div class="ml-6 space-y-3">
                            <h4 class="font-semibold text-slate-700 dark:text-slate-300">🌳 Ağaç Polenleri</h4>
                            <template x-for="(comps, name) in componentGroups.pollen.tree" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 mt-4">🌾 Çayır Polenleri</h4>
                            <template x-for="(comps, name) in componentGroups.pollen.grass" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 mt-4">🌿 Yabani Ot Polenleri</h4>
                            <template x-for="(comps, name) in componentGroups.pollen.weed" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- 🏠 INDOOR -->
                    <div class="border-2 border-blue-300 dark:border-blue-700 rounded-lg p-4 bg-blue-50 dark:bg-blue-900/20">
                        <h3 class="text-lg font-bold mb-4"><span class="text-2xl">🏠</span> İç Ortam Alerjenleri</h3>

                        <div class="ml-6 space-y-3">
                            <h4 class="font-semibold text-slate-700 dark:text-slate-300">🛏️ Ev Tozu Akarları</h4>
                            <template x-for="(comps, name) in componentGroups.indoor.mite" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 mt-4">🪳 Hamamböceği</h4>
                            <template x-for="(comps, name) in componentGroups.indoor.cockroach" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 mt-4">🍄 Küf Mantarları</h4>
                            <template x-for="(comps, name) in componentGroups.indoor.mould" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 mt-4">🐾 Kürklü Hayvanlar</h4>
                            <template x-for="(comps, name) in componentGroups.indoor.furry" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- 🏭 OCCUPATIONAL -->
                    <div class="border-2 border-indigo-300 dark:border-indigo-700 rounded-lg p-4 bg-indigo-50 dark:bg-indigo-900/20">
                        <h3 class="text-lg font-bold mb-4"><span class="text-2xl">🏭</span> Mesleki Alerjenler</h3>

                        <div class="ml-6 space-y-3">
                            <template x-for="(comps, name) in componentGroups.occupational" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Analiz Butonu -->
                <div class="mt-8 flex gap-4">
                    <button @click="runAnalysis()"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-lg flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined">science</span>
                        <span>Onayla ve Analiz Et</span>
                    </button>
                    <button @click="clearAllSelections()"
                            class="bg-slate-300 hover:bg-slate-400 text-slate-700 font-semibold px-6 py-4 rounded-lg">
                        Temizle
                    </button>
                </div>
            </div>
        </div>

        <!-- ADIM 3-5: Sonuç Ekranı -->
        <div x-show="currentStep === 'results'" class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Moleküler Profil Analiz Sonucu</h2>
                    <button @click="resetToStart()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                        <span class="material-symbols-outlined">refresh</span>
                        Yeni Analiz
                    </button>
                </div>

                <!-- AI İşleniyor -->
                <div x-show="aiProcessing" class="text-center py-12">
                    <span class="material-symbols-outlined text-6xl text-indigo-600 animate-spin mb-4">progress_activity</span>
                    <p class="text-lg text-slate-600">AI sonuçlarınızı yorumluyor...</p>
                </div>

                <!-- Teknik Sonuçlar -->
                <div x-show="!aiProcessing" class="space-y-4">
                    <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            🧬 Pozitif Komponentler (<span x-text="Object.keys(selectedComponents).filter(k => selectedComponents[k]).length"></span>)
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="comp in Object.keys(selectedComponents).filter(k => selectedComponents[k])" :key="comp">
                                <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-xs font-semibold" x-text="comp"></span>
                            </template>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-4">Teknik Değerlendirme (Kural Motoru)</h3>

                    <template x-for="(result, index) in ruleEngineResults" :key="index">
                        <div class="border-l-4 rounded-lg p-4 mb-3"
                             :class="{
                                 'border-green-500 bg-green-50 dark:bg-green-900/20': result.oneri.includes('DÜŞÜNÜLEBİLİR'),
                                 'border-red-500 bg-red-50 dark:bg-red-900/20': result.oneri.includes('ÖNERİLMEZ'),
                                 'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20': result.oneri.includes('UYARI') || result.oneri.includes('RİSK')
                             }">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-2xl"
                                      :class="{
                                          'text-green-600': result.oneri.includes('DÜŞÜNÜLEBİLİR'),
                                          'text-red-600': result.oneri.includes('ÖNERİLMEZ'),
                                          'text-yellow-600': result.oneri.includes('UYARI') || result.oneri.includes('RİSK')
                                      }">
                                    <span x-show="result.oneri.includes('DÜŞÜNÜLEBİLİR')">check_circle</span>
                                    <span x-show="result.oneri.includes('ÖNERİLMEZ')">cancel</span>
                                    <span x-show="result.oneri.includes('UYARI') || result.oneri.includes('RİSK')">warning</span>
                                </span>
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-800 dark:text-white mb-1" x-text="result.grup"></h4>
                                    <p class="text-sm font-semibold mb-2"
                                       :class="{
                                           'text-green-700': result.oneri.includes('DÜŞÜNÜLEBİLİR'),
                                           'text-red-700': result.oneri.includes('ÖNERİLMEZ'),
                                           'text-yellow-700': result.oneri.includes('UYARI') || result.oneri.includes('RİSK')
                                       }"
                                       x-text="result.oneri"></p>
                                    <p class="text-sm text-slate-600 dark:text-slate-300" x-text="result.gerekce"></p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- AI Yorumlu Rapor -->
                    <div x-show="aiInterpretation" class="mt-8 border-t-2 border-indigo-300 pt-6">
                        <h3 class="text-xl font-bold text-indigo-800 dark:text-indigo-300 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-3xl">psychology</span>
                            AI Destekli Klinik Yorum
                        </h3>

                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-lg p-6 prose prose-sm max-w-none">
                            <div x-html="aiInterpretation"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
