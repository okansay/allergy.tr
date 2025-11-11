<!-- OIT Food Protocols Module v1.0.1 -->
<div class="module-container p-4 sm:p-6 max-w-7xl mx-auto" x-data="{
    // UI State
    currentStep: 1,
    showIntro: false,
    showHowItWorks: false,
    showSafety: false,
    showOptionalFields: false,

    // Patient Data
    patientData: {
        age_years: null,
        weight_kg: null,
        allergen: '',
        other_allergen_text: '',
        asthma_control: 'none',
        history_of_anaphylaxis: false,
        history_of_eoe: false,
        baseline_ofc_threshold: null,
        specific_ige: null,
        skin_prick_wheal_mm: null,
        distance_to_emergency_minutes: null
    },

    // Protocol Selection
    protocolFilter: {
        allergen: null
    },
    selectedProtocol: null,

    // Protocols Data
    protocols: [
        {
            id: 'varshney2011_peanut_jaci',
            display_name_tr: 'Varshney ve ark., 2011 – Yer fıstığı OIT (JACI)',
            allergen: 'peanut',
            protocol_speed: 'conventional',
            literature: {
                title: 'A randomized controlled study of peanut oral immunotherapy: clinical desensitization and modulation of the allergic response',
                first_author: 'Varshney',
                year: 2011,
                journal: 'Journal of Allergy and Clinical Immunology',
                pmid: '21377034'
            },
            requires_omalizumab: false,
            eligibility_summary_tr: 'Yer fıstığı ile oral provokasyonla doğrulanmış IgE aracılı yer fıstığı alerjisi olan çocuklarda uygulanan konvansiyonel OIT protokolü. Yaş aralığı, dışlama kriterleri ve ayrıntılar için özgün makaleye bakılmalıdır.',
            protocol_type_label_tr: 'Konvansiyonel yer fıstığı OIT',
            notes_tr: 'Bu şablon, Varshney 2011 çalışmasına dayanmaktadır. Gerçek doz değerleri, artışım lojiği ve gözlem süreleri, özgün makaleden okunarak merkeziniz tarafından girilmelidir.'
        },
        {
            id: 'anagnostou2014_peanut_lancet_stop2',
            display_name_tr: 'Anagnostou ve ark., 2014 – Yer fıstığı OIT (STOP II, Lancet)',
            allergen: 'peanut',
            protocol_speed: 'conventional',
            literature: {
                title: 'Assessing the efficacy of oral immunotherapy for the desensitisation of peanut allergy in children (STOP II): a phase 2 randomised controlled trial',
                first_author: 'Anagnostou',
                year: 2014,
                journal: 'The Lancet',
                pmid: '24485709'
            },
            requires_omalizumab: false,
            eligibility_summary_tr: 'Çocukluk çağı yer fıstığı alerjisinde, randomize kontrollü faz 2 çalışma protokolüne dayalı konvansiyonel OIT şablonu. Çalışmaya alınma ve dışlama kriterleri için mutlaka orijinal makaleye bakılmalıdır.',
            protocol_type_label_tr: 'Konvansiyonel yer fıstığı OIT (STOP II)',
            notes_tr: 'Bu şablon, STOP II çalışmasının doz ve izlem mantığını temsil eder; mg düzeyleri ve ziyaret sıklığı, özgün Lancet makalesinden alınarak ayrıca tanımlanmalıdır.'
        },
        {
            id: 'skripak2008_milk_jaci',
            display_name_tr: 'Skripak ve ark., 2008 – Süt OIT (JACI)',
            allergen: 'cow_milk',
            protocol_speed: 'conventional',
            literature: {
                title: 'A randomized, double-blind, placebo-controlled study of milk oral immunotherapy for cow milk allergy',
                first_author: 'Skripak',
                year: 2008,
                journal: 'Journal of Allergy and Clinical Immunology',
                pmid: '18951617'
            },
            requires_omalizumab: false,
            eligibility_summary_tr: 'IgE aracılı inek sütü alerjisi olan çocuklarda yapılan randomize, çift kör, plasebo kontrollü süt OIT çalışmasının şablonu. Çalışma tasarımı, OFC protokolleri ve dışlama kriterleri için makaleye başvurulmalıdır.',
            protocol_type_label_tr: 'Konvansiyonel süt OIT',
            notes_tr: 'Bu şablon, Skripak 2008 süt OIT çalışmasına dayanmaktadır. Gerçek doz adımları ve artışım hızları, özgün JACI makalesine göre merkeziniz tarafından ayrıca tanımlanmalıdır.'
        },
        {
            id: 'burks2012_egg_nejm',
            display_name_tr: 'Burks ve ark., 2012 – Yumurta OIT (NEJM)',
            allergen: 'egg',
            protocol_speed: 'conventional',
            literature: {
                title: 'Oral immunotherapy for treatment of egg allergy in children',
                first_author: 'Burks',
                year: 2012,
                journal: 'New England Journal of Medicine',
                pmid: '22808958'
            },
            requires_omalizumab: false,
            eligibility_summary_tr: 'Yumurta alerjisi olan çocuklarda yapılan, çok merkezli, çift kör, plasebo kontrollü OIT çalışmasının şablonu. Yaş aralığı, randomizasyon ayrıntıları ve uzun dönem izlem için NEJM makalesine bakılmalıdır.',
            protocol_type_label_tr: 'Konvansiyonel yumurta OIT',
            notes_tr: 'Bu şablon, Burks 2012 NEJM yumurta OIT çalışmasına dayanmaktadır. Doz artışım planları ve hedef bakım dozları, özgün yayından bire bir alınıp girilmelidir.'
        }
    ],

    get filteredProtocols() {
        if (this.protocolFilter.allergen === null) {
            return this.protocols;
        }
        return this.protocols.filter(p => p.allergen === this.protocolFilter.allergen);
    },

    selectProtocol(protocol) {
        this.selectedProtocol = protocol;
    },

    validateAndNext() {
        if (!this.patientData.age_years || !this.patientData.weight_kg || !this.patientData.allergen) {
            alert('Lütfen zorunlu alanları doldurun (Yaş, Kilo, Alerjen)');
            return;
        }
        this.currentStep = 2;
    },

    goToSummary() {
        if (!this.selectedProtocol) {
            alert('Lütfen bir protokol seçin');
            return;
        }
        this.currentStep = 3;
    },

    getAllergenLabel() {
        const labels = {
            'peanut': 'Yer Fıstığı',
            'cow_milk': 'İnek Sütü',
            'egg': 'Yumurta',
            'other': this.patientData.other_allergen_text || 'Diğer'
        };
        return labels[this.patientData.allergen] || '';
    },

    getAsthmaLabel() {
        const labels = {
            'none': 'Yok',
            'well_controlled': 'İyi Kontrollü',
            'partly_controlled': 'Kısmen Kontrollü',
            'uncontrolled': 'Kontrolsüz'
        };
        return labels[this.patientData.asthma_control] || '';
    },

    printSummary() {
        window.print();
    },

    resetForm() {
        if (confirm('Formu sıfırlamak istediğinizden emin misiniz?')) {
            this.currentStep = 1;
            this.patientData = {
                age_years: null,
                weight_kg: null,
                allergen: '',
                other_allergen_text: '',
                asthma_control: 'none',
                history_of_anaphylaxis: false,
                history_of_eoe: false,
                baseline_ofc_threshold: null,
                specific_ige: null,
                skin_prick_wheal_mm: null,
                distance_to_emergency_minutes: null
            };
            this.selectedProtocol = null;
            this.protocolFilter.allergen = null;
        }
    }
}">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-primary text-4xl">restaurant</span>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">
                    Besin Alerjisi OIT Protokol Kütüphanesi
                </h1>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">
                    Oral İmmünoterapi Protokolleri
                </p>
            </div>
        </div>
    </div>

    <!-- Info Accordions -->
    <div class="space-y-3 mb-6">
        <!-- Introduction -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
            <button
                @click="showIntro = !showIntro"
                class="w-full flex items-center justify-between p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">info</span>
                    <h3 class="font-bold text-slate-900 dark:text-white">Giriş ve Amaç</h3>
                </div>
                <span class="material-symbols-outlined transition-transform" :class="showIntro ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="showIntro" x-collapse class="p-4 pt-0 text-sm text-slate-600 dark:text-slate-400 space-y-2">
                <p>Bu sayfa, besin alerjisi için literatüre dayalı oral immünoterapi (OIT) protokollerini hekime okunur ve yapılandırılmış şekilde sunmak için tasarlanmıştır.</p>
                <p>Her protokol, özgün klinik çalışmadan alınmış bir şablonu temsil eder; sistem yeni bir tedavi şeması üretmez, sadece seçilen makaledeki protokolün hekime uygun biçimde organize edilmesine yardımcı olur.</p>
            </div>
        </div>

        <!-- How It Works -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg overflow-hidden">
            <button
                @click="showHowItWorks = !showHowItWorks"
                class="w-full flex items-center justify-between p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">settings</span>
                    <h3 class="font-bold text-slate-900 dark:text-white">Nasıl Çalışır?</h3>
                </div>
                <span class="material-symbols-outlined transition-transform" :class="showHowItWorks ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="showHowItWorks" x-collapse class="p-4 pt-0 text-sm text-slate-600 dark:text-slate-400">
                <ol class="list-decimal list-inside space-y-2">
                    <li>Önce hastaya ait temel klinik bilgileri girin (yaş, kilo, alerjen, eşlik eden hastalıklar vb.).</li>
                    <li>Ardından, protokolü dayandırmak istediğiniz literatürü seçin (örneğin Varshney 2011 yer fıstığı, Skripak 2008 süt, Burks 2012 yumurta vb.).</li>
                    <li>Sistem, seçilen yayına ait protokol tipini (konvansiyonel, cluster, rush) ve temel özellikleri gösterir; merkezinizin kendi doz basamakları bu şablonun içine yerleştirilir.</li>
                    <li>Çıktıda, yalnızca sizin girdiğiniz doz adımları ve izlem planları görünür; sistem, günlük klinik kararlarınızı otomatik olarak değiştirmez.</li>
                </ol>
            </div>
        </div>

        <!-- Safety Disclaimer -->
        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 rounded-lg overflow-hidden">
            <button
                @click="showSafety = !showSafety"
                class="w-full flex items-center justify-between p-4 hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">warning</span>
                    <h3 class="font-bold text-red-900 dark:text-red-100">Güvenlik Uyarısı</h3>
                </div>
                <span class="material-symbols-outlined transition-transform text-red-600 dark:text-red-400" :class="showSafety ? 'rotate-180' : ''">expand_more</span>
            </button>
            <div x-show="showSafety" x-collapse class="p-4 pt-0 text-sm text-red-800 dark:text-red-200 space-y-2">
                <p><strong>Bu araç yalnızca besin alerjisi alanında deneyimli çocuk veya erişkin alerji-immünoloji uzmanı tarafından kullanılmak üzere tasarlanmıştır.</strong></p>
                <p>OIT endikasyonu, kontrendikasyonları, hasta seçimi, doz basamakları ve acil durum yönetimi, daima güncel ulusal ve uluslararası kılavuzlar, yerel mevzuat ve klinik kararınız temelinde belirlenmelidir.</p>
                <p>Sistem, hiçbir şekilde otomatik tedavi önerisi, doz hesaplayıcı ya da ruhsatlı ürünün resmi özetini ikame etmez. Her bir protokol için mutlaka özgün makalenin tam metnine ve ilgili ürün bilgilerinin resmi özetlerine yeniden başvurun.</p>
            </div>
        </div>
    </div>

    <!-- Step Indicator -->
    <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-700 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <button
                @click="currentStep = 1"
                :class="currentStep === 1 ? 'bg-primary text-white' : 'bg-white dark:bg-slate-600 text-slate-700 dark:text-slate-200'"
                class="flex-1 py-3 px-4 rounded-lg font-semibold transition-all mx-1 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-sm">person</span>
                <span class="hidden sm:inline">1. Hasta Bilgileri</span>
                <span class="sm:hidden">1</span>
            </button>
            <span class="material-symbols-outlined text-slate-400">arrow_forward</span>
            <button
                @click="currentStep = 2"
                :class="currentStep === 2 ? 'bg-primary text-white' : 'bg-white dark:bg-slate-600 text-slate-700 dark:text-slate-200'"
                class="flex-1 py-3 px-4 rounded-lg font-semibold transition-all mx-1 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-sm">list_alt</span>
                <span class="hidden sm:inline">2. Protokol Seçimi</span>
                <span class="sm:hidden">2</span>
            </button>
            <span class="material-symbols-outlined text-slate-400">arrow_forward</span>
            <button
                @click="currentStep = 3"
                :class="currentStep === 3 ? 'bg-primary text-white' : 'bg-white dark:bg-slate-600 text-slate-700 dark:text-slate-200'"
                class="flex-1 py-3 px-4 rounded-lg font-semibold transition-all mx-1 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-sm">description</span>
                <span class="hidden sm:inline">3. Özet</span>
                <span class="sm:hidden">3</span>
            </button>
        </div>
    </div>

    <!-- Step 1: Patient Information -->
    <div x-show="currentStep === 1" class="space-y-4">
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">person</span>
                Hasta Bilgileri Formu
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Age -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Yaş (yıl) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        x-model.number="patientData.age_years"
                        min="0"
                        max="99"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-slate-700 dark:text-white"
                        required>
                </div>

                <!-- Weight -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Kilo (kg) <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="number"
                        x-model.number="patientData.weight_kg"
                        min="3"
                        max="200"
                        step="0.1"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-slate-700 dark:text-white"
                        required>
                </div>

                <!-- Allergen -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Besin Alerjeni <span class="text-red-500">*</span>
                    </label>
                    <select
                        x-model="patientData.allergen"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-slate-700 dark:text-white"
                        required>
                        <option value="">Seçiniz...</option>
                        <option value="peanut">Yer fıstığı</option>
                        <option value="cow_milk">İnek sütü</option>
                        <option value="egg">Yumurta</option>
                        <option value="other">Diğer</option>
                    </select>
                </div>

                <!-- Other Allergen (if selected) -->
                <div x-show="patientData.allergen === 'other'">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Diğer Alerjen Açıklaması
                    </label>
                    <input
                        type="text"
                        x-model="patientData.other_allergen_text"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-slate-700 dark:text-white">
                </div>

                <!-- Asthma Control -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Astım Kontrol Durumu
                    </label>
                    <select
                        x-model="patientData.asthma_control"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-slate-700 dark:text-white">
                        <option value="none">Astım yok</option>
                        <option value="well_controlled">İyi kontrollü</option>
                        <option value="partly_controlled">Kısmen kontrollü</option>
                        <option value="uncontrolled">Kontrolsüz</option>
                    </select>
                </div>

                <!-- Anaphylaxis History -->
                <div class="flex items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            x-model="patientData.history_of_anaphylaxis"
                            class="w-5 h-5 text-primary focus:ring-primary rounded">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Anafilaksi Öyküsü</span>
                    </label>
                </div>

                <!-- EoE History -->
                <div class="flex items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input
                            type="checkbox"
                            x-model="patientData.history_of_eoe"
                            class="w-5 h-5 text-primary focus:ring-primary rounded">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Eozinofilik Özofajit (EoE) Öyküsü</span>
                    </label>
                </div>
            </div>

            <!-- Optional Fields Accordion -->
            <div class="mt-6">
                <button
                    @click="showOptionalFields = !showOptionalFields"
                    class="flex items-center gap-2 text-primary hover:text-primary/80 font-semibold">
                    <span class="material-symbols-outlined transition-transform" :class="showOptionalFields ? 'rotate-90' : ''">chevron_right</span>
                    <span>Opsiyonel Alanlar (Test Sonuçları)</span>
                </button>

                <div x-show="showOptionalFields" x-collapse class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <!-- Baseline OFC -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Başlangıç OFC Eşiği (mg protein)
                        </label>
                        <input
                            type="number"
                            x-model.number="patientData.baseline_ofc_threshold"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-slate-700 dark:text-white">
                    </div>

                    <!-- Specific IgE -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Spesifik IgE (kU/L)
                        </label>
                        <input
                            type="number"
                            x-model.number="patientData.specific_ige"
                            step="0.01"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-slate-700 dark:text-white">
                    </div>

                    <!-- Skin Prick Test -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Prik Testi Kabarıklık Çapı (mm)
                        </label>
                        <input
                            type="number"
                            x-model.number="patientData.skin_prick_wheal_mm"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-slate-700 dark:text-white">
                    </div>

                    <!-- Distance to Emergency -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            En Yakın Acil Servise Ulaşım Süresi (dakika)
                        </label>
                        <input
                            type="number"
                            x-model.number="patientData.distance_to_emergency_minutes"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-slate-700 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Next Button -->
            <div class="mt-6 flex justify-end">
                <button
                    @click="validateAndNext()"
                    class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                    <span>Protokol Seçimine Geç</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Step 2: Protocol Selection -->
    <div x-show="currentStep === 2" class="space-y-4">
        <!-- Filter Bar -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-4">
            <div class="flex flex-wrap items-center gap-3">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Filtrele:</span>

                <!-- Allergen Filter -->
                <button
                    @click="protocolFilter.allergen = null"
                    :class="protocolFilter.allergen === null ? 'bg-primary text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200'"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    Tümü
                </button>
                <button
                    @click="protocolFilter.allergen = 'peanut'"
                    :class="protocolFilter.allergen === 'peanut' ? 'bg-primary text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200'"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    Yer Fıstığı
                </button>
                <button
                    @click="protocolFilter.allergen = 'cow_milk'"
                    :class="protocolFilter.allergen === 'cow_milk' ? 'bg-primary text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200'"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    İnek Sütü
                </button>
                <button
                    @click="protocolFilter.allergen = 'egg'"
                    :class="protocolFilter.allergen === 'egg' ? 'bg-primary text-white' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200'"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    Yumurta
                </button>
            </div>
        </div>

        <!-- Protocol Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <template x-for="protocol in filteredProtocols" :key="protocol.id">
                <div
                    @click="selectProtocol(protocol)"
                    :class="selectedProtocol?.id === protocol.id ? 'border-primary bg-primary/5' : 'border-slate-200 dark:border-slate-700'"
                    class="bg-white dark:bg-slate-800 border-2 rounded-lg p-5 cursor-pointer hover:shadow-lg transition-all">

                    <!-- Protocol Title -->
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2" x-text="protocol.display_name_tr"></h3>

                    <!-- Protocol Type Badge -->
                    <div class="flex items-center gap-2 mb-3">
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 text-xs font-semibold rounded">
                            Konvansiyonel OIT
                        </span>
                        <span x-show="protocol.requires_omalizumab" class="px-2 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 text-xs font-semibold rounded">
                            Omalizumab
                        </span>
                    </div>

                    <!-- Literature Info -->
                    <div class="text-sm text-slate-600 dark:text-slate-400 space-y-1 mb-3">
                        <p><strong>Yazar:</strong> <span x-text="protocol.literature.first_author + ' et al.'"></span></p>
                        <p><strong>Yıl:</strong> <span x-text="protocol.literature.year"></span></p>
                        <p><strong>Dergi:</strong> <span x-text="protocol.literature.journal"></span></p>
                        <p x-show="protocol.literature.pmid"><strong>PMID:</strong> <span x-text="protocol.literature.pmid"></span></p>
                    </div>

                    <!-- Eligibility Summary -->
                    <div class="text-xs text-slate-500 dark:text-slate-400 border-t border-slate-200 dark:border-slate-700 pt-3" x-text="protocol.eligibility_summary_tr"></div>

                    <!-- Selected Indicator -->
                    <div x-show="selectedProtocol?.id === protocol.id" class="mt-3 flex items-center gap-2 text-primary font-semibold text-sm">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        <span>Seçili Protokol</span>
                    </div>
                </div>
            </template>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-6">
            <button
                @click="currentStep = 1"
                class="flex items-center gap-2 px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg font-semibold hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Geri</span>
            </button>
            <button
                @click="goToSummary()"
                :disabled="!selectedProtocol"
                :class="selectedProtocol ? 'bg-primary hover:bg-primary/90' : 'bg-slate-300 dark:bg-slate-600 cursor-not-allowed'"
                class="flex items-center gap-2 px-6 py-3 text-white rounded-lg font-semibold transition-colors">
                <span>Özete Geç</span>
                <span class="material-symbols-outlined">arrow_forward</span>
            </button>
        </div>
    </div>

    <!-- Step 3: Summary -->
    <div x-show="currentStep === 3" class="space-y-4">
        <!-- Patient Summary Card -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">person</span>
                Hasta Bilgileri Özeti
            </h2>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Yaş</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-white" x-text="patientData.age_years + ' yıl'"></p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Kilo</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-white" x-text="patientData.weight_kg + ' kg'"></p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Alerjen</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-white" x-text="getAllergenLabel()"></p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Astım</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-white" x-text="getAsthmaLabel()"></p>
                </div>
            </div>

            <div x-show="patientData.history_of_anaphylaxis || patientData.history_of_eoe" class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Özel Durumlar:</p>
                <div class="flex flex-wrap gap-2">
                    <span x-show="patientData.history_of_anaphylaxis" class="px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 text-xs font-semibold rounded-full">
                        Anafilaksi Öyküsü
                    </span>
                    <span x-show="patientData.history_of_eoe" class="px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 text-xs font-semibold rounded-full">
                        EoE Öyküsü
                    </span>
                </div>
            </div>
        </div>

        <!-- Selected Protocol Card -->
        <div x-show="selectedProtocol" class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">assignment</span>
                Seçilen Protokol
            </h2>

            <div class="space-y-4">
                <div>
                    <h3 class="font-bold text-lg text-slate-900 dark:text-white" x-text="selectedProtocol?.display_name_tr"></h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1" x-text="selectedProtocol?.protocol_type_label_tr"></p>
                </div>

                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4">
                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Literatür Kaynağı:</p>
                    <p class="text-sm text-slate-600 dark:text-slate-400" x-text="selectedProtocol?.literature.first_author + ' et al. (' + selectedProtocol?.literature.year + '). ' + selectedProtocol?.literature.title + '. ' + selectedProtocol?.literature.journal + '.'"></p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">PMID: <span x-text="selectedProtocol?.literature.pmid"></span></p>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4">
                    <p class="text-sm text-blue-900 dark:text-blue-100" x-text="selectedProtocol?.eligibility_summary_tr"></p>
                </div>

                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500 rounded-lg p-4">
                    <p class="text-xs text-yellow-900 dark:text-yellow-100" x-text="selectedProtocol?.notes_tr"></p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <button
                @click="currentStep = 2"
                class="flex items-center justify-center gap-2 px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg font-semibold hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Geri</span>
            </button>

            <button
                @click="printSummary()"
                class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                <span class="material-symbols-outlined">print</span>
                <span>Yazdır / PDF</span>
            </button>

            <button
                @click="resetForm()"
                class="flex items-center justify-center gap-2 px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors">
                <span class="material-symbols-outlined">refresh</span>
                <span>Yeni Protokol</span>
            </button>
        </div>
    </div>
</div>
