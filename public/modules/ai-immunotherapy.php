<!-- AI İmmünoterapi Karar Destek Sistemi -->
<div x-data="window.aiImmunotherapyInit()" class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-900 dark:to-slate-800 p-4 md:p-8">
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
                              placeholder="Örnek:&#10;ImmunoCAP Results:&#10;- Bet v 1: 15.2 kU/L (Class 3)&#10;- Phl p 5: 3.8 kU/L (Class 2)&#10;- Der p 1: 28.5 kU/L (Class 4)&#10;..."></textarea>

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
                            AI tarafından tespit edilen pozitif komponentler işaretlendi.
                        </p>
                    </div>
                    <button @click="resetToStart()" class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Komponent Listesi -->
                <div class="space-y-6 max-h-[600px] overflow-y-auto pr-4">
                    <!-- Polenler -->
                    <div class="border-2 border-yellow-300 rounded-lg p-4 bg-yellow-50">
                        <h3 class="text-lg font-bold mb-4">🤧 Polenler</h3>
                        <div class="ml-6 space-y-3">
                            <h4 class="font-semibold">🌳 Ağaç Polenleri</h4>
                            <template x-for="(comps, name) in componentGroups.pollen.tree" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <h4 class="font-semibold mt-4">🌾 Çayır Polenleri</h4>
                            <template x-for="(comps, name) in componentGroups.pollen.grass" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <h4 class="font-semibold mt-4">🌿 Yabani Ot Polenleri</h4>
                            <template x-for="(comps, name) in componentGroups.pollen.weed" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- İç Ortam -->
                    <div class="border-2 border-blue-300 rounded-lg p-4 bg-blue-50">
                        <h3 class="text-lg font-bold mb-4">🏠 İç Ortam Alerjenleri</h3>
                        <div class="ml-6 space-y-3">
                            <h4 class="font-semibold">🛏️ Ev Tozu Akarları</h4>
                            <template x-for="(comps, name) in componentGroups.indoor.mite" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 p-2 rounded">
                                                <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                <span x-text="comp"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <template x-for="category in ['cockroach', 'mould', 'furry']" :key="category">
                                <template x-for="(comps, name) in componentGroups.indoor[category]" :key="name">
                                    <div class="ml-4 border-l-2 border-slate-200 pl-4 mt-4">
                                        <p class="text-sm font-semibold mb-2" x-text="name"></p>
                                        <div class="grid md:grid-cols-3 gap-2">
                                            <template x-for="comp in comps" :key="comp">
                                                <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 p-2 rounded">
                                                    <input type="checkbox" x-model="selectedComponents[comp]" class="rounded text-indigo-600">
                                                    <span x-text="comp"></span>
                                                </label>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>

                    <!-- Mesleki -->
                    <div class="border-2 border-indigo-300 rounded-lg p-4 bg-indigo-50">
                        <h3 class="text-lg font-bold mb-4">🏭 Mesleki Alerjenler</h3>
                        <div class="ml-6 space-y-3">
                            <template x-for="(comps, name) in componentGroups.occupational" :key="name">
                                <div class="ml-4 border-l-2 border-slate-200 pl-4">
                                    <p class="text-sm font-semibold mb-2" x-text="name"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="comp in comps" :key="comp">
                                            <label class="flex items-center gap-2 text-sm cursor-pointer hover:bg-slate-100 p-2 rounded">
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

                <div x-show="aiProcessing" class="text-center py-12">
                    <span class="material-symbols-outlined text-6xl text-indigo-600 animate-spin mb-4">progress_activity</span>
                    <p class="text-lg text-slate-600">AI sonuçlarınızı yorumluyor...</p>
                </div>

                <div x-show="!aiProcessing" class="space-y-4">
                    <div class="bg-slate-50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold mb-2">
                            🧬 Pozitif Komponentler (<span x-text="Object.keys(selectedComponents).filter(k => selectedComponents[k]).length"></span>)
                        </h3>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="comp in Object.keys(selectedComponents).filter(k => selectedComponents[k])" :key="comp">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold" x-text="comp"></span>
                            </template>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold mb-4">Teknik Değerlendirme</h3>

                    <template x-for="(result, index) in ruleEngineResults" :key="index">
                        <div class="border-l-4 rounded-lg p-4 mb-3"
                             :class="{
                                 'border-green-500 bg-green-50': result.oneri.includes('DÜŞÜNÜLEBİLİR'),
                                 'border-red-500 bg-red-50': result.oneri.includes('ÖNERİLMEZ'),
                                 'border-yellow-500 bg-yellow-50': result.oneri.includes('UYARI') || result.oneri.includes('RİSK')
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
                                    <h4 class="font-bold mb-1" x-text="result.grup"></h4>
                                    <p class="text-sm font-semibold mb-2" x-text="result.oneri"></p>
                                    <p class="text-sm" x-text="result.gerekce"></p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <div x-show="aiInterpretation" class="mt-8 border-t-2 border-indigo-300 pt-6">
                        <h3 class="text-xl font-bold text-indigo-800 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-3xl">psychology</span>
                            AI Destekli Klinik Yorum
                        </h3>
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-6 prose prose-sm max-w-none">
                            <div x-html="aiInterpretation"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
