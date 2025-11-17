<!-- AI İmmünoterapi Karar Destek Sistemi -->
<div x-data="aiImmunotherapyModule()" class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-900 dark:to-slate-800 p-4 md:p-8">
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
ImmunoCAP Allergen-specific IgE Results
- Bet v 1 (rBet v 1): 15.2 kU/L (Class 3)
- Phl p 5 (rPhl p 5): 3.8 kU/L (Class 2)
- Der p 1 (rDer p 1): 28.5 kU/L (Class 4)
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
                            AI tarafından tespit edilen pozitif komponentler işaretlendi. Lütfen kontrol edin ve gerekirse düzeltin.
                        </p>
                    </div>
                    <button @click="resetToStart()" class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Komponent Listesi (Hierarchical) -->
                <div class="space-y-6 max-h-[600px] overflow-y-auto pr-4">
                    <!-- 🤧 1. POLLENs -->
                    <div class="border-2 border-yellow-300 dark:border-yellow-700 rounded-lg p-4 bg-yellow-50 dark:bg-yellow-900/20">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-2xl">🤧</span>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Polenler</h3>
                        </div>

                        <!-- Ağaç Polenleri -->
                        <div class="ml-6 space-y-3">
                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                                <span class="material-symbols-outlined text-green-600">forest</span>
                                Ağaç Polenleri
                            </h4>

                            <template x-for="(group, allergen) in componentGroups.pollen.tree" :key="allergen">
                                <div class="ml-4 border-l-2 border-slate-200 dark:border-slate-600 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2" x-text="allergen"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="component in group" :key="component">
                                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox"
                                                       :checked="selectedComponents[component]"
                                                       @change="selectedComponents[component] = $event.target.checked"
                                                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <span x-text="component"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- Çayır Polenleri -->
                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2 mt-4">
                                <span class="material-symbols-outlined text-green-500">grass</span>
                                Çayır Polenleri
                            </h4>

                            <template x-for="(group, allergen) in componentGroups.pollen.grass" :key="allergen">
                                <div class="ml-4 border-l-2 border-slate-200 dark:border-slate-600 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2" x-text="allergen"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="component in group" :key="component">
                                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox"
                                                       :checked="selectedComponents[component]"
                                                       @change="selectedComponents[component] = $event.target.checked"
                                                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <span x-text="component"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- Yabani Ot Polenleri -->
                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2 mt-4">
                                <span class="material-symbols-outlined text-amber-600">nature</span>
                                Yabani Ot Polenleri
                            </h4>

                            <template x-for="(group, allergen) in componentGroups.pollen.weed" :key="allergen">
                                <div class="ml-4 border-l-2 border-slate-200 dark:border-slate-600 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2" x-text="allergen"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="component in group" :key="component">
                                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox"
                                                       :checked="selectedComponents[component]"
                                                       @change="selectedComponents[component] = $event.target.checked"
                                                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <span x-text="component"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- 🏠 2. İÇ ORTAM ALERJENLERİ -->
                    <div class="border-2 border-blue-300 dark:border-blue-700 rounded-lg p-4 bg-blue-50 dark:bg-blue-900/20">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-2xl">🏠</span>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white">İç Ortam Alerjenleri</h3>
                        </div>

                        <div class="ml-6 space-y-3">
                            <!-- Ev Tozu Akarları -->
                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2">
                                <span class="material-symbols-outlined text-red-600">bed</span>
                                Ev Tozu Akarları (HDM)
                            </h4>

                            <template x-for="(group, allergen) in componentGroups.indoor.mite" :key="allergen">
                                <div class="ml-4 border-l-2 border-slate-200 dark:border-slate-600 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2" x-text="allergen"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="component in group" :key="component">
                                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox"
                                                       :checked="selectedComponents[component]"
                                                       @change="selectedComponents[component] = $event.target.checked"
                                                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <span x-text="component"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- Hamamböceği -->
                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2 mt-4">
                                <span class="material-symbols-outlined text-orange-600">pest_control</span>
                                Hamamböceği
                            </h4>

                            <template x-for="(group, allergen) in componentGroups.indoor.cockroach" :key="allergen">
                                <div class="ml-4 border-l-2 border-slate-200 dark:border-slate-600 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2" x-text="allergen"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="component in group" :key="component">
                                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox"
                                                       :checked="selectedComponents[component]"
                                                       @change="selectedComponents[component] = $event.target.checked"
                                                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <span x-text="component"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- Küf Mantarları -->
                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2 mt-4">
                                <span class="material-symbols-outlined text-purple-600">cloud</span>
                                Küf Mantarları
                            </h4>

                            <template x-for="(group, allergen) in componentGroups.indoor.mould" :key="allergen">
                                <div class="ml-4 border-l-2 border-slate-200 dark:border-slate-600 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2" x-text="allergen"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="component in group" :key="component">
                                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox"
                                                       :checked="selectedComponents[component]"
                                                       @change="selectedComponents[component] = $event.target.checked"
                                                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <span x-text="component"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <!-- Kürklü Hayvanlar -->
                            <h4 class="font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-2 mt-4">
                                <span class="material-symbols-outlined text-pink-600">pets</span>
                                Kürklü Hayvanlar
                            </h4>

                            <template x-for="(group, allergen) in componentGroups.indoor.furry" :key="allergen">
                                <div class="ml-4 border-l-2 border-slate-200 dark:border-slate-600 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2" x-text="allergen"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="component in group" :key="component">
                                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox"
                                                       :checked="selectedComponents[component]"
                                                       @change="selectedComponents[component] = $event.target.checked"
                                                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <span x-text="component"></span>
                                            </label>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- 🏭 3. MESLEKİ VE DİĞER -->
                    <div class="border-2 border-indigo-300 dark:border-indigo-700 rounded-lg p-4 bg-indigo-50 dark:bg-indigo-900/20">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-2xl">🏭</span>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Mesleki ve Diğer Solunumsal Alerjenler</h3>
                        </div>

                        <div class="ml-6 space-y-3">
                            <template x-for="(group, allergen) in componentGroups.occupational" :key="allergen">
                                <div class="ml-4 border-l-2 border-slate-200 dark:border-slate-600 pl-4">
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2" x-text="allergen"></p>
                                    <div class="grid md:grid-cols-3 gap-2">
                                        <template x-for="component in group" :key="component">
                                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer hover:bg-slate-100 dark:hover:bg-slate-700 p-2 rounded">
                                                <input type="checkbox"
                                                       :checked="selectedComponents[component]"
                                                       @change="selectedComponents[component] = $event.target.checked"
                                                       class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                <span x-text="component"></span>
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
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-4 rounded-lg flex items-center justify-center gap-3 transition-all">
                        <span class="material-symbols-outlined">science</span>
                        <span>Onayla ve Analiz Et</span>
                    </button>
                    <button @click="clearAllSelections()"
                            class="bg-slate-300 hover:bg-slate-400 text-slate-700 font-semibold px-6 py-4 rounded-lg transition-all">
                        Temizle
                    </button>
                </div>
            </div>
        </div>

        <!-- ADIM 3-5: Sonuç Ekranı (AI Yorumlu) -->
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
                    <span class="material-symbols-outlined text-6xl text-indigo-600 dark:text-indigo-400 animate-spin mb-4">progress_activity</span>
                    <p class="text-lg text-slate-600 dark:text-slate-300">AI sonuçlarınızı yorumluyor...</p>
                </div>

                <!-- Teknik Sonuçlar (Kural Motoru) -->
                <div x-show="!aiProcessing" class="space-y-4">
                    <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4 mb-6">
                        <h3 class="font-semibold text-slate-700 dark:text-slate-300 mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600">biotech</span>
                            Pozitif Komponentler (<span x-text="Object.keys(selectedComponents).filter(k => selectedComponents[k]).length"></span>)
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
                                           'text-green-700 dark:text-green-300': result.oneri.includes('DÜŞÜNÜLEBİLİR'),
                                           'text-red-700 dark:text-red-300': result.oneri.includes('ÖNERİLMEZ'),
                                           'text-yellow-700 dark:text-yellow-300': result.oneri.includes('UYARI') || result.oneri.includes('RİSK')
                                       }"
                                       x-text="result.oneri"></p>
                                    <p class="text-sm text-slate-600 dark:text-slate-300" x-text="result.gerekce"></p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- AI Yorumlu Rapor -->
                    <div x-show="aiInterpretation" class="mt-8 border-t-2 border-indigo-300 dark:border-indigo-700 pt-6">
                        <h3 class="text-xl font-bold text-indigo-800 dark:text-indigo-300 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-3xl">psychology</span>
                            AI Destekli Klinik Yorum
                        </h3>

                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-lg p-6 prose prose-sm max-w-none dark:prose-invert">
                            <div x-html="aiInterpretation"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function aiImmunotherapyModule() {
    return {
        // State Management
        currentStep: 'select_method', // select_method, ai_input, manual_input, verification, results
        reportText: '',
        aiProcessing: false,
        aiError: '',
        selectedComponents: {},
        ruleEngineResults: [],
        aiInterpretation: '',

        // Component Groups (Hierarchical Data)
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
            this.initializeComponentsObject();
        },

        initializeComponentsObject() {
            // Tüm komponentleri false olarak başlat
            const allGroups = [
                ...Object.values(this.componentGroups.pollen).flatMap(g => Object.values(g)).flat(),
                ...Object.values(this.componentGroups.indoor).flatMap(g => Object.values(g)).flat(),
                ...Object.values(this.componentGroups.occupational).flat()
            ];

            allGroups.forEach(comp => {
                this.selectedComponents[comp] = false;
            });
        },

        // Method Selection
        selectMethod(method) {
            if (method === 'ai') {
                this.currentStep = 'ai_input';
            } else {
                this.currentStep = 'manual_input';
            }
        },

        // AI: Parse Report with Gemini 2.5 Pro
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

                if (!response.ok || data.error) {
                    throw new Error(data.error || 'AI analiz hatası');
                }

                // AI'dan gelen komponentleri işaretle
                if (data.components && Array.isArray(data.components)) {
                    data.components.forEach(comp => {
                        if (this.selectedComponents.hasOwnProperty(comp)) {
                            this.selectedComponents[comp] = true;
                        }
                    });
                }

                // Doğrulama ekranına geç
                this.currentStep = 'verification';

            } catch (error) {
                this.aiError = error.message;
            } finally {
                this.aiProcessing = false;
            }
        },

        // Rule Engine: Run Analysis
        async runAnalysis() {
            this.ruleEngineResults = [];
            this.aiInterpretation = '';
            this.currentStep = 'results';
            this.aiProcessing = true;

            // ADIM 3: Kural Motoru
            this.ruleEngineResults = this.executeRuleEngine(this.selectedComponents);

            // ADIM 4: AI Yorumlama
            await this.getAIInterpretation();

            this.aiProcessing = false;
        },

        // KURAL MOTORU (Deterministik)
        executeRuleEngine(komponentler) {
            let sonuclar = [];

            sonuclar.push(...this.checkAgacPoleni(komponentler));
            sonuclar.push(...this.checkCayirPoleni(komponentler));
            sonuclar.push(...this.checkAkar(komponentler));
            sonuclar.push(...this.checkKuf(komponentler));
            sonuclar.push(...this.checkHayvanlar(komponentler));
            // Diğer gruplar eklenebilir...

            return sonuclar;
        },

        // B01: AĞAÇ POLENİ ALGORİTMASI
        checkAgacPoleni(komponentler) {
            let ciktilar = [];
            let primerDuyarlanma = false;
            let panalerjenUyarisi = false;
            let panalerjenler = [];

            if (komponentler['Bet v 1'] || komponentler['Cup a 1'] || komponentler['Ole e 1'] || komponentler['Pla a 1']) {
                primerDuyarlanma = true;
                ciktilar.push({
                    grup: "Ağaç Poleni",
                    oneri: "AIT DÜŞÜNÜLEBİLİR",
                    gerekce: "Primer ağaç poleni duyarlanması saptandı (Bet v 1, Cup a 1, Ole e 1 veya Pla a 1 pozitif)."
                });
            }

            if (komponentler['Bet v 2']) { panalerjenUyarisi = true; panalerjenler.push("Profilin (Bet v 2)"); }
            if (komponentler['Bet v 4']) { panalerjenUyarisi = true; panalerjenler.push("Polcalcin (Bet v 4)"); }
            if (komponentler['Ole e 7'] || komponentler['Pla a 3']) { panalerjenUyarisi = true; panalerjenler.push("LTP (Ole e 7 / Pla a 3)"); }
            if (komponentler['Pru p 7']) { panalerjenUyarisi = true; panalerjenler.push("GRP (Pru p 7)"); }

            if (!primerDuyarlanma && panalerjenUyarisi) {
                ciktilar.push({
                    grup: "Ağaç Poleni",
                    oneri: "AIT ÖNERİLMEZ",
                    gerekce: "Primer duyarlanma belirteci (örn. Bet v 1) negatif. Pozitiflik panalerjenlerden kaynaklı: " + panalerjenler.join(', ')
                });
            } else if (primerDuyarlanma && panalerjenUyarisi) {
                ciktilar.push({
                    grup: "Ağaç Poleni",
                    oneri: "UYARI (Çapraz Reaksiyon)",
                    gerekce: "Primer duyarlanma (AIT için uygun) olmasına rağmen, panalerjen pozitifliği (" + panalerjenler.join(', ') + ") mevcut. Bu durum polen dışı (örn. gıda) reaksiyon riskini gösterebilir."
                });
            }

            return ciktilar;
        },

        // B02: ÇAYIR POLENİ ALGORİTMASI
        checkCayirPoleni(komponentler) {
            let ciktilar = [];
            let primerDuyarlanma = false;

            if (komponentler['Phl p 1'] || komponentler['Phl p 2'] || komponentler['Phl p 5'] || komponentler['Phl p 11']) {
                primerDuyarlanma = true;
                ciktilar.push({
                    grup: "Çayır Poleni",
                    oneri: "AIT DÜŞÜNÜLEBİLİR",
                    gerekce: "Gerçek çayır poleni duyarlanması saptandı (Phl p 1, 2, 5 veya 11 pozitif)."
                });
            }

            if (komponentler['Phl p 7']) {
                ciktilar.push({
                    grup: "Çayır Poleni",
                    oneri: "KLİNİK RİSK UYARISI",
                    gerekce: "Phl p 7 (Polcalcin) pozitifliği: Astım riski ile ilişkilidir."
                });
            }
            if (komponentler['Phl p 12']) {
                ciktilar.push({
                    grup: "Çayır Poleni",
                    oneri: "KLİNİK RİSK UYARISI",
                    gerekce: "Phl p 12 (Profilin) pozitifliği: Oral Alerji Sendromu (OAS) riski ile ilişkilidir."
                });
            }

            if (!primerDuyarlanma && (komponentler['Phl p 7'] || komponentler['Phl p 12'])) {
                ciktilar.push({
                    grup: "Çayır Poleni",
                    oneri: "AIT ÖNERİLMEZ",
                    gerekce: "Primer duyarlanma belirteçleri (örn. Phl p 1, 5) negatif. Pozitiflik panalerjenlerden (Polcalcin/Profilin) kaynaklı."
                });
            }

            return ciktilar;
        },

        // B04: EV TOZU AKARI ALGORİTMASI
        checkAkar(komponentler) {
            let ciktilar = [];
            let primerDuyarlanma = false;

            if (komponentler['Der p 1'] || komponentler['Der p 2'] || komponentler['Der p 23'] ||
                komponentler['Der f 1'] || komponentler['Der f 2'] ||
                komponentler['Blo t 5'] || komponentler['Blo t 21']) {
                primerDuyarlanma = true;
                ciktilar.push({
                    grup: "Ev Tozu Akarı (HDM)",
                    oneri: "AIT DÜŞÜNÜLEBİLİR",
                    gerekce: "Gerçek akar duyarlanması saptandı (Der p 1/2/23, Der f 1/2 veya Blo t 5/21 pozitif)."
                });
            }

            if (komponentler['Der p 10'] || komponentler['Blo t 10']) {
                if (!primerDuyarlanma) {
                    ciktilar.push({
                        grup: "Ev Tozu Akarı (HDM)",
                        oneri: "AIT ÖNERİLMEZ",
                        gerekce: "Primer akar belirteçleri negatif. Pozitiflik Tropomyosin (Der p 10) kaynaklı. Kabuklu deniz ürünleri, hamamböceği veya parazit (Helmint) çapraz reaksiyonunu araştırın."
                    });
                } else {
                    ciktilar.push({
                        grup: "Ev Tozu Akarı (HDM)",
                        oneri: "UYARI (Çapraz Reaksiyon)",
                        gerekce: "Akar AIT için uygun, ancak Der p 10 (Tropomyosin) pozitifliği nedeniyle kabuklu deniz ürünleri/hamamböceği alerjisi riski olabilir."
                    });
                }
            }

            return ciktilar;
        },

        // B07: KÜF (ALTERNARIA) ALGORİTMASI
        checkKuf(komponentler) {
            let ciktilar = [];

            if (komponentler['Alt a 1']) {
                ciktilar.push({
                    grup: "Küf (Alternaria)",
                    oneri: "AIT DÜŞÜNÜLEBİLİR",
                    gerekce: "Primer Alternaria duyarlanması saptandı (Alt a 1 pozitif)."
                });
            } else if (!komponentler['Alt a 1'] && komponentler['Alt a 6']) {
                ciktilar.push({
                    grup: "Küf (Alternaria)",
                    oneri: "AIT ÖNERİLMEZ",
                    gerekce: "Primer belirteç Alt a 1 negatif. AIT önerilmez (B07 Algoritması)."
                });
            }

            return ciktilar;
        },

        // B06 / C07: HAYVANLAR ALGORİTMASI
        checkHayvanlar(komponentler) {
            let ciktilar = [];

            // KEDİ
            if (komponentler['Fel d 1']) {
                ciktilar.push({
                    grup: "Kedi",
                    oneri: "AIT DÜŞÜNÜLEBİLİR",
                    gerekce: "Primer kedi duyarlanması saptandı (Fel d 1 pozitif)."
                });
                if (komponentler['Fel d 2'] || komponentler['Fel d 4']) {
                    ciktilar.push({
                        grup: "Kedi",
                        oneri: "UYARI (Çapraz Reaksiyon)",
                        gerekce: "Fel d 2 (Albumin) / Fel d 4 (Lipocalin) pozitifliği diğer hayvanlarla (örn. köpek, at) veya et/süt ile çapraz reaksiyon riski taşıyabilir."
                    });
                }
            } else if (komponentler['Fel d 2'] || komponentler['Fel d 4']) {
                ciktilar.push({
                    grup: "Kedi",
                    oneri: "AIT ÖNERİLMEZ",
                    gerekce: "Primer belirteç Fel d 1 negatif. Pozitiflik çapraz reaktif proteinlerden (Fel d 2/4) kaynaklı. Primer kaynağı (örn. Köpek, At) araştırın."
                });
            }

            // KÖPEK
            if (komponentler['Can f 1'] || komponentler['Can f 2'] || komponentler['Can f 4'] || komponentler['Can f 5']) {
                ciktilar.push({
                    grup: "Köpek",
                    oneri: "AIT DÜŞÜNÜLEBİLİR",
                    gerekce: "Primer köpek duyarlanması saptandı (Can f 1/2/4/5 pozitif)."
                });
            } else if (komponentler['Can f 3'] || komponentler['Can f 6']) {
                ciktilar.push({
                    grup: "Köpek",
                    oneri: "AIT ÖNERİLMEZ",
                    gerekce: "Primer belirteçler (örn. Can f 1/2/4/5) negatif. Pozitiflik çapraz reaktif proteinlerden (Can f 3/6) kaynaklı. Primer kaynağı (örn. Kedi, At) araştırın."
                });
            }

            // AT
            if (komponentler['Equ c 1']) {
                ciktilar.push({
                    grup: "At",
                    oneri: "AIT DÜŞÜNÜLEBİLİR",
                    gerekce: "Primer at duyarlanması saptandı (Equ c 1 pozitif)."
                });
            } else if (komponentler['Equ c 3']) {
                ciktilar.push({
                    grup: "At",
                    oneri: "AIT ÖNERİLMEZ",
                    gerekce: "Primer belirteç Equ c 1 negatif. Pozitiflik Equ c 3 (Serum Albumin) kaynaklı. Primer kaynağı araştırın."
                });
            }

            return ciktilar;
        },

        // AI: Get Interpretation from Gemini 2.5 Pro
        async getAIInterpretation() {
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

                if (!response.ok || data.error) {
                    throw new Error(data.error || 'AI yorumlama hatası');
                }

                this.aiInterpretation = data.interpretation || '';

            } catch (error) {
                console.error('AI Interpretation Error:', error);
                this.aiInterpretation = '<p class="text-red-600">AI yorumlama sırasında bir hata oluştu. Teknik sonuçları yukarıda görebilirsiniz.</p>';
            }
        },

        // Helper Functions
        clearAllSelections() {
            Object.keys(this.selectedComponents).forEach(key => {
                this.selectedComponents[key] = false;
            });
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
    }
}
</script>
