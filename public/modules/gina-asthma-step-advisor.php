<!-- GINA Asthma Step Advisor Module -->
<div class="max-w-7xl mx-auto space-y-6 pb-20">
    <!-- Module Header -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center justify-center size-14 rounded-xl bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-3xl">air</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">GINA Astım Basamak Danışmanı</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">GINA 2024-2025 rehberlerine dayalı astım tedavi basamağı önerileri</p>
            </div>
        </div>

        <!-- Safety Disclaimer - Always Visible -->
        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 mt-4">
            <p class="text-sm text-amber-900 dark:text-amber-100 flex items-start gap-2">
                <span class="material-symbols-outlined text-xl flex-shrink-0">warning</span>
                <span><strong>Önemli:</strong> Bu sistem klinik karar desteğidir, nihai karar hekimindir. Öneriler GINA 2024–2025 rehberleri temel alınarak oluşturulmuştur.</span>
            </p>
        </div>
    </div>

    <!-- Progress Indicator -->
    <div id="progressIndicator" class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Adım <span id="currentStepNum">1</span> / 3</span>
            <span class="text-xs text-slate-500 dark:text-slate-400"><span id="currentStepName">Temel Bilgiler</span></span>
        </div>
        <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
            <div id="progressBar" class="bg-primary h-2 rounded-full transition-all duration-300" style="width: 33.33%"></div>
        </div>
    </div>

    <!-- Multi-Step Form -->
    <form id="ginaForm" class="space-y-6" novalidate>

        <!-- Step 1: Basic Information & Scenario -->
        <div id="step1" class="form-step bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">person</span>
                Temel Bilgiler ve Senaryo
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Yaş <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="age" name="age" required min="0" max="120"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Hastanın yaşı">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Cinsiyet
                    </label>
                    <select id="sex" name="sex"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                        <option value="male">Erkek</option>
                        <option value="female">Kadın</option>
                        <option value="other">Diğer</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Boy (cm)
                    </label>
                    <input type="number" id="height_cm" name="height_cm" min="0" max="250" step="0.1"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Boy (opsiyonel)">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                        Kilo (kg) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="weight_kg" name="weight_kg" required min="1" max="300" step="0.1"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Kilo">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">
                    Klinik Senaryo <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="scenario-option cursor-pointer" onclick="selectScenario('initial', this)">
                        <input type="radio" name="scenario" value="initial" required class="hidden">
                        <div class="border-2 border-slate-300 dark:border-slate-600 rounded-xl p-4 hover:border-primary hover:bg-primary/5 transition-all">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary text-2xl">new_label</span>
                                <div>
                                    <div class="font-semibold text-slate-900 dark:text-white">İlk Tedavi</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">Yeni tanı astım hastası</div>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="scenario-option cursor-pointer" onclick="selectScenario('step_adjustment', this)">
                        <input type="radio" name="scenario" value="step_adjustment" class="hidden">
                        <div class="border-2 border-slate-300 dark:border-slate-600 rounded-xl p-4 hover:border-primary hover:bg-primary/5 transition-all">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary text-2xl">tune</span>
                                <div>
                                    <div class="font-semibold text-slate-900 dark:text-white">Basamak Ayarı</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">Mevcut tedaviyi değerlendirme</div>
                                </div>
                            </div>
                        </div>
                    </label>

                    <label class="scenario-option cursor-pointer" onclick="selectScenario('post_exacerbation', this)">
                        <input type="radio" name="scenario" value="post_exacerbation" class="hidden">
                        <div class="border-2 border-slate-300 dark:border-slate-600 rounded-xl p-4 hover:border-primary hover:bg-primary/5 transition-all">
                            <div class="flex items-center gap-3">
                                <span class="material-symbols-outlined text-primary text-2xl">emergency</span>
                                <div>
                                    <div class="font-semibold text-slate-900 dark:text-white">Alevlenme Sonrası</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">Atak sonrası değerlendirme</div>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <button type="button" onclick="goToStep(2)"
                    class="px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-semibold flex items-center gap-2">
                    Devam Et
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- Step 2: Symptom Control & Risk Assessment -->
        <div id="step2" class="form-step bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6" style="display: none;">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">assessment</span>
                Semptom Kontrolü ve Risk Değerlendirmesi
            </h2>

            <!-- Symptom Control Questions (Last 4 weeks) -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6 mb-6">
                <h3 class="font-bold text-blue-900 dark:text-blue-100 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">info</span>
                    Semptom Kontrolü (Son 4 Hafta)
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Haftada kaç gün gündüz semptom var? (0-7)
                        </label>
                        <input type="number" id="daytime_symptoms_per_week" name="daytime_symptoms_per_week" required min="0" max="7"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="0-7 gün">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Nefes darlığı, hışıltı, öksürük, göğüs sıkışması</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Haftada kaç gece uyanma? (0-7)
                        </label>
                        <input type="number" id="night_waking_per_week" name="night_waking_per_week" required min="0" max="7"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="0-7 gece">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Haftada kaç gün kurtarıcı ilaç kullanımı? (0-7)
                        </label>
                        <input type="number" id="reliever_use_days_per_week" name="reliever_use_days_per_week" required min="0" max="7"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="0-7 gün">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Egzersiz öncesi rutin kullanım hariç</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Aktivite kısıtlılığı
                        </label>
                        <select id="activity_limitation" name="activity_limitation" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="none">Yok</option>
                            <option value="mild">Hafif</option>
                            <option value="marked">Belirgin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Kurtarıcı ilaç tipi
                        </label>
                        <select id="reliever_type" name="reliever_type" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="saba">SABA (Kısa etkili beta-agonist)</option>
                            <option value="ics_formoterol">ICS-Formoterol</option>
                            <option value="other">Diğer</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Risk Factors (Last 12 months) -->
            <div class="bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl p-6 mb-6">
                <h3 class="font-bold text-orange-900 dark:text-orange-100 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined">warning</span>
                    Risk Faktörleri (Son 12 Ay)
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Sistemik steroid gerektiren atak sayısı
                        </label>
                        <input type="number" id="ocs_exacerbations_last_12m" name="ocs_exacerbations_last_12m" required min="0"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="0">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Acil servis başvuru sayısı
                        </label>
                        <input type="number" id="er_visits_last_12m" name="er_visits_last_12m" required min="0"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="0">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Hastaneye yatış sayısı
                        </label>
                        <input type="number" id="hospitalizations_last_12m" name="hospitalizations_last_12m" required min="0"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="0">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="icu_admission_ever" name="icu_admission_ever"
                                class="rounded border-slate-300 text-primary focus:ring-primary">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Hiç YBÜ'ye yatış oldu mu?</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            Sigara kullanımı
                        </label>
                        <select id="current_smoker" name="current_smoker" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                            <option value="never">Hiç kullanmadı</option>
                            <option value="former">Eski içici</option>
                            <option value="current">Aktif içici</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                            FEV1 (% öngörülen) - Opsiyonel
                        </label>
                        <input type="number" id="fev1_percent_predicted" name="fev1_percent_predicted" min="0" max="150" step="0.1"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                            placeholder="Örn: 85">
                    </div>

                    <div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="saba_overuse_suspected" name="saba_overuse_suspected"
                                class="rounded border-slate-300 text-primary focus:ring-primary">
                            <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">SABA aşırı kullanımı var mı?</span>
                        </label>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 ml-6">Yıllık ≥3 kutu</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <button type="button" onclick="goToStep(1)"
                    class="px-6 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Geri
                </button>
                <button type="button" onclick="goToStep(3)"
                    class="px-6 py-2.5 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-semibold flex items-center gap-2">
                    Devam Et
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- Step 3: Scenario-Specific Fields -->
        <div id="step3" class="form-step bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6" style="display: none;">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined">medication</span>
                Tedavi Bilgileri
            </h2>

            <!-- Initial Treatment Scenario Fields -->
            <div id="initialFields" class="scenario-fields" style="display: none;">
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6">
                    <h3 class="font-bold text-green-900 dark:text-green-100 mb-4">İlk Tedavi Senaryosu</h3>
                    <p class="text-sm text-green-800 dark:text-green-200 mb-4">
                        Yeni tanı astım hastası için başlangıç tedavi basamağını belirlemek üzere gerekli bilgiler zaten toplanmıştır.
                    </p>

                    <div class="space-y-4">
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" id="recent_exacerbation" name="recent_exacerbation"
                                    class="rounded border-slate-300 text-primary focus:ring-primary">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">Son 12 haftada ağır atak geçirdi mi?</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step Adjustment Scenario Fields -->
            <div id="stepAdjustmentFields" class="scenario-fields" style="display: none;">
                <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-6">
                    <h3 class="font-bold text-purple-900 dark:text-purple-100 mb-4">Mevcut Tedavi Bilgileri</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Kontrolör tedavi tipi
                            </label>
                            <select id="controller_regimen_type" name="controller_regimen_type"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="none">Yok</option>
                                <option value="ics_monotherapy">Sadece ICS</option>
                                <option value="ics_laba_formoterol">ICS-LABA (Formoterol)</option>
                                <option value="ics_laba_nonformoterol">ICS-LABA (Non-formoterol)</option>
                                <option value="laba_only">Sadece LABA</option>
                                <option value="ltra">LTRA</option>
                                <option value="lama">LAMA</option>
                                <option value="biologic_addon">Biyolojik tedavi eklendi</option>
                                <option value="maintenance_ocs">İdame oral steroid</option>
                                <option value="other">Diğer</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                ICS doz kategorisi
                            </label>
                            <select id="controller_ics_dose_category" name="controller_ics_dose_category"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="not_applicable">Uygulanmaz</option>
                                <option value="low">Düşük</option>
                                <option value="medium">Orta</option>
                                <option value="high">Yüksek</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Mevcut basamakta kaç aydır? <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="months_on_current_step" name="months_on_current_step" min="0"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Ay sayısı">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Post-Exacerbation Scenario Fields -->
            <div id="postExacerbationFields" class="scenario-fields" style="display: none;">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                    <h3 class="font-bold text-red-900 dark:text-red-100 mb-4">Alevlenme Sonrası Değerlendirme</h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Son alevlenmeden bu yana kaç hafta geçti? <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="weeks_since_last_exacerbation" name="weeks_since_last_exacerbation" min="0" max="52"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Hafta sayısı">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Alevlenme şiddeti
                            </label>
                            <select id="exacerbation_severity" name="exacerbation_severity"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="mild_moderate">Hafif-Orta</option>
                                <option value="severe_hospitalized">Ağır (Hastaneye yatış)</option>
                                <option value="icu">YBÜ</option>
                            </select>
                        </div>

                        <!-- Also include current controller fields -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Mevcut kontrolör tedavi tipi
                            </label>
                            <select id="controller_regimen_type_post" name="controller_regimen_type"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="none">Yok</option>
                                <option value="ics_monotherapy">Sadece ICS</option>
                                <option value="ics_laba_formoterol">ICS-LABA (Formoterol)</option>
                                <option value="ics_laba_nonformoterol">ICS-LABA (Non-formoterol)</option>
                                <option value="laba_only">Sadece LABA</option>
                                <option value="ltra">LTRA</option>
                                <option value="lama">LAMA</option>
                                <option value="biologic_addon">Biyolojik tedavi eklendi</option>
                                <option value="maintenance_ocs">İdame oral steroid</option>
                                <option value="other">Diğer</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                ICS doz kategorisi
                            </label>
                            <select id="controller_ics_dose_category_post" name="controller_ics_dose_category"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                                <option value="not_applicable">Uygulanmaz</option>
                                <option value="low">Düşük</option>
                                <option value="medium">Orta</option>
                                <option value="high">Yüksek</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Mevcut basamakta kaç aydır?
                            </label>
                            <input type="number" id="months_on_current_step_post" name="months_on_current_step" min="0"
                                class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                                placeholder="Ay sayısı">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <button type="button" onclick="goToStep(2)"
                    class="px-6 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Geri
                </button>
                <button type="submit" id="submitBtn"
                    class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold flex items-center gap-2">
                    <span class="material-symbols-outlined">done</span>
                    Değerlendir
                </button>
            </div>
        </div>

    </form>

    <!-- Results Container -->
    <div id="resultsContainer" style="display: none;" class="space-y-6">
        <!-- Summary Card -->
        <div class="bg-gradient-to-r from-primary/10 to-blue-500/10 dark:from-primary/20 dark:to-blue-500/20 border border-primary/30 rounded-xl p-6">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-3xl text-primary">summarize</span>
                Değerlendirme Özeti
            </h2>
            <div id="summaryContent" class="space-y-3"></div>
        </div>

        <!-- Detailed Recommendations -->
        <div id="detailedResults" class="space-y-6"></div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
            <button type="button" onclick="location.reload()"
                class="flex-1 px-6 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors font-semibold flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">refresh</span>
                Yeni Değerlendirme
            </button>
            <button type="button" onclick="window.print()"
                class="flex-1 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors font-semibold flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">print</span>
                Yazdır
            </button>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loadingIndicator" style="display: none;" class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-12">
        <div class="flex flex-col items-center justify-center gap-4">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
            <p class="text-slate-600 dark:text-slate-400 font-semibold">Değerlendiriliyor...</p>
        </div>
    </div>
</div>

<!-- GINA Module Scripts: All JavaScript functions are loaded globally in footer.php -->
