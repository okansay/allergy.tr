<!-- Mobile Bottom Navigation -->
<footer class="lg:hidden fixed bottom-0 left-0 right-0 z-10 flex items-center justify-around px-2 py-2 bg-white/80 dark:bg-background-dark/80 backdrop-blur-sm border-t border-gray-200 dark:border-gray-800">
    <a @click.prevent="navigateTo('dashboard')"
       :class="currentRoute === 'dashboard' ? 'text-primary' : 'text-gray-600 dark:text-gray-300'"
       class="flex flex-col items-center justify-center gap-1 w-full py-1 rounded-lg cursor-pointer"
       href="#dashboard">
        <span class="material-symbols-outlined">home</span>
        <span class="text-xs font-medium">Ana Sayfa</span>
    </a>
    <a @click.prevent="navigateTo('laboratory')"
       :class="currentRoute === 'laboratory' ? 'text-primary' : 'text-gray-600 dark:text-gray-300'"
       class="flex flex-col items-center justify-center gap-1 w-full py-1 rounded-lg cursor-pointer"
       href="#laboratory">
        <span class="material-symbols-outlined">calculate</span>
        <span class="text-xs font-medium">Araçlar</span>
    </a>
    <a @click.prevent="navigateTo('guides')"
       :class="currentRoute === 'guides' ? 'text-primary' : 'text-gray-600 dark:text-gray-300'"
       class="flex flex-col items-center justify-center gap-1 w-full py-1 rounded-lg cursor-pointer"
       href="#guides">
        <span class="material-symbols-outlined">article</span>
        <span class="text-xs font-medium">Rehberler</span>
    </a>
    <a class="flex flex-col items-center justify-center text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary gap-1 w-full py-1 rounded-lg"
       href="#"
       x-show="user">
        <div class="bg-primary/20 rounded-full size-6 flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-base">person</span>
        </div>
        <span class="text-xs font-medium">Profil</span>
    </a>
</footer>

<!-- Alpine.js Scripts - Load at end of body for better performance -->
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<!-- Desensitization Module Scripts -->
<script src="/modules/js/desensitization/protocol.js?v=20250108-008"></script>
<script src="/modules/js/desensitization/ui.js?v=20250108-008"></script>

<!-- Beta-Lactam Module Scripts -->
<script src="/modules/js/betalactam/data.js?v=20250108-001"></script>
<script src="/modules/js/betalactam/ui.js?v=20250108-001"></script>

<!-- RegiSCAR Score Calculator Scripts -->
<script src="/modules/js/regiscar/calculator.js?v=20250109-007"></script>

<!-- SCORAD Index Calculator Scripts -->
<script src="/modules/js/scorad/calculator.js?v=20250109-003"></script>

<!-- GINA Module Global Functions -->
<script>
// GINA module state
let ginaCurrentStep = 1;
const ginaTotalSteps = 3;

// Select scenario function
window.selectScenario = function(value, element) {
    console.log('Scenario selected:', value);

    // Remove active class from all options
    const allOptions = document.querySelectorAll('.scenario-option');
    allOptions.forEach(opt => {
        const div = opt.querySelector('div');
        if (div) {
            div.classList.remove('border-primary', 'bg-primary/10');
            div.classList.add('border-slate-300', 'dark:border-slate-600');
        }
    });

    // Add active class to selected option
    const div = element.querySelector('div');
    if (div) {
        div.classList.remove('border-slate-300', 'dark:border-slate-600');
        div.classList.add('border-primary', 'bg-primary/10');
    }

    // Check the radio button
    const radio = element.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
    }

    // Update step 3 fields visibility
    updateGinaStep3Fields();
};

// Update Step 3 fields based on selected scenario
function updateGinaStep3Fields() {
    const scenario = document.querySelector('input[name="scenario"]:checked');
    if (!scenario) return;

    const scenarioValue = scenario.value;

    // Get field containers
    const initialFields = document.getElementById('initialFields');
    const stepAdjustmentFields = document.getElementById('stepAdjustmentFields');
    const postExacerbationFields = document.getElementById('postExacerbationFields');

    // Hide all first
    if (initialFields) initialFields.style.display = 'none';
    if (stepAdjustmentFields) stepAdjustmentFields.style.display = 'none';
    if (postExacerbationFields) postExacerbationFields.style.display = 'none';

    // Show relevant fields
    if (scenarioValue === 'initial' && initialFields) {
        initialFields.style.display = 'block';
    } else if (scenarioValue === 'step_adjustment' && stepAdjustmentFields) {
        stepAdjustmentFields.style.display = 'block';
    } else if (scenarioValue === 'post_exacerbation' && postExacerbationFields) {
        postExacerbationFields.style.display = 'block';
    }
}

// Navigate to step function
window.goToStep = function(stepNumber) {
    console.log('Going to step:', stepNumber);

    // Validate step 1 before going to step 2
    if (stepNumber === 2 && ginaCurrentStep === 1) {
        const age = document.getElementById('age');
        const weight = document.getElementById('weight_kg');
        const scenario = document.querySelector('input[name="scenario"]:checked');

        if (!age || !age.value) {
            alert('Lütfen yaş bilgisini girin.');
            return;
        }
        if (!weight || !weight.value) {
            alert('Lütfen kilo bilgisini girin.');
            return;
        }
        if (!scenario) {
            alert('Lütfen bir klinik senaryo seçin.');
            return;
        }
    }

    // Hide all steps
    for (let i = 1; i <= ginaTotalSteps; i++) {
        const stepEl = document.getElementById('step' + i);
        if (stepEl) stepEl.style.display = 'none';
    }

    // Show target step
    const targetStep = document.getElementById('step' + stepNumber);
    if (targetStep) {
        targetStep.style.display = 'block';
    }
    ginaCurrentStep = stepNumber;

    // Update step 3 fields if going to step 3
    if (stepNumber === 3) {
        updateGinaStep3Fields();
    }

    // Update progress bar
    const progress = (ginaCurrentStep / ginaTotalSteps) * 100;
    const progressBar = document.getElementById('progressBar');
    if (progressBar) progressBar.style.width = progress + '%';

    const stepNum = document.getElementById('currentStepNum');
    if (stepNum) stepNum.textContent = ginaCurrentStep;

    const stepNames = ['Temel Bilgiler', 'Semptom ve Risk Değerlendirmesi', 'Tedavi Bilgileri'];
    const stepName = document.getElementById('currentStepName');
    if (stepName) stepName.textContent = stepNames[ginaCurrentStep - 1];

    // Scroll to top
    const mainContent = document.getElementById('main-content');
    if (mainContent) {
        mainContent.scrollTo({ top: 0, behavior: 'smooth' });
    } else {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
};

// Initialize GINA form when it's loaded
function initializeGinaForm() {
    const form = document.getElementById('ginaForm');
    if (form && !form.dataset.initialized) {
        form.dataset.initialized = 'true';
        form.addEventListener('submit', handleGinaFormSubmit);
        console.log('GINA form initialized');
    }
}

// Call initialization periodically to catch dynamically loaded forms
setInterval(() => {
    if (document.getElementById('ginaForm')) {
        initializeGinaForm();
    }
}, 500);

// Handle GINA form submission
async function handleGinaFormSubmit(e) {
    e.preventDefault();
    console.log('GINA form submitted');

    // Validate Step 3 scenario-specific fields
    const scenario = document.querySelector('input[name="scenario"]:checked');
    if (!scenario) {
        alert('Lütfen bir klinik senaryo seçin.');
        return;
    }

    const scenarioValue = scenario.value;

    if (scenarioValue === 'step_adjustment') {
        const regimen = document.getElementById('controller_regimen_type');
        if (!regimen || !regimen.value) {
            alert('Lütfen mevcut kontrol tedavisi rejimini seçin.');
            return;
        }
    } else if (scenarioValue === 'post_exacerbation') {
        const weeks = document.getElementById('weeks_since_last_exacerbation');
        const severity = document.getElementById('exacerbation_severity');

        if (!weeks || weeks.value === '') {
            alert('Lütfen son alevlenmeden bu yana geçen süreyi girin.');
            return;
        }
        if (!severity || !severity.value) {
            alert('Lütfen alevlenme şiddetini seçin.');
            return;
        }
    }

    // Show loading indicator
    document.getElementById('ginaForm').style.display = 'none';
    document.getElementById('loadingIndicator').style.display = 'block';
    document.getElementById('progressIndicator').style.display = 'none';

    // Collect form data
    const formData = collectGinaFormData();

    try {
        // Send to engine
        const response = await fetch('/modules/asthma-step-engine.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formData)
        });

        if (!response.ok) {
            throw new Error('Değerlendirme sırasında bir hata oluştu.');
        }

        const result = await response.json();

        if (result.success === false) {
            throw new Error(result.error || 'Bilinmeyen hata');
        }

        // Hide loading
        document.getElementById('loadingIndicator').style.display = 'none';

        // Display results (from gina-results.js)
        if (typeof displayResults === 'function') {
            displayResults(result);
        } else {
            console.error('displayResults function not found');
            alert('Sonuçlar yüklenemedi.');
        }

    } catch (error) {
        console.error('Error:', error);
        alert('Bir hata oluştu: ' + error.message);

        // Show form again
        document.getElementById('ginaForm').style.display = 'block';
        document.getElementById('loadingIndicator').style.display = 'none';
        document.getElementById('progressIndicator').style.display = 'block';
    }
}

// Collect GINA form data
function collectGinaFormData() {
    const scenario = document.querySelector('input[name="scenario"]:checked').value;

    const data = {
        age: parseInt(document.getElementById('age').value),
        sex: document.getElementById('sex').value,
        height_cm: parseFloat(document.getElementById('height_cm').value) || null,
        weight_kg: parseFloat(document.getElementById('weight_kg').value),
        scenario: scenario,

        daytime_symptoms_per_week: parseInt(document.getElementById('daytime_symptoms_per_week').value),
        night_waking_per_week: parseInt(document.getElementById('night_waking_per_week').value),
        reliever_use_days_per_week: parseInt(document.getElementById('reliever_use_days_per_week').value),
        activity_limitation: document.getElementById('activity_limitation').value,
        reliever_type: document.getElementById('reliever_type').value,

        ocs_exacerbations_last_12m: parseInt(document.getElementById('ocs_exacerbations_last_12m').value),
        er_visits_last_12m: parseInt(document.getElementById('er_visits_last_12m').value),
        hospitalizations_last_12m: parseInt(document.getElementById('hospitalizations_last_12m').value),
        icu_admission_ever: document.getElementById('icu_admission_ever').checked,
        current_smoker: document.getElementById('current_smoker').value,
        fev1_percent_predicted: parseFloat(document.getElementById('fev1_percent_predicted').value) || null,
        saba_overuse_suspected: document.getElementById('saba_overuse_suspected').checked
    };

    // Scenario-specific fields
    if (scenario === 'initial') {
        data.recent_exacerbation = document.getElementById('recent_exacerbation').checked;
    } else if (scenario === 'step_adjustment') {
        data.controller_regimen_type = document.getElementById('controller_regimen_type').value;
        data.controller_ics_dose_category = document.getElementById('controller_ics_dose_category').value;
        data.months_on_current_step = parseInt(document.getElementById('months_on_current_step').value) || 0;
    } else if (scenario === 'post_exacerbation') {
        data.weeks_since_last_exacerbation = parseInt(document.getElementById('weeks_since_last_exacerbation').value) || 0;
        data.exacerbation_severity = document.getElementById('exacerbation_severity').value;
        data.controller_regimen_type = document.getElementById('controller_regimen_type_post').value;
        data.controller_ics_dose_category = document.getElementById('controller_ics_dose_category_post').value;
        data.months_on_current_step = parseInt(document.getElementById('months_on_current_step_post').value) || 0;
    }

    return data;
}

console.log('GINA global functions loaded');
</script>

<!-- AI Immunotherapy Module Global Function -->
<script>
window.aiImmunotherapyInit = function() {
    return {
        currentStep: 'select_method',
        reportText: '',
        aiProcessing: false,
        aiError: '',
        selectedComponents: {},
        ruleEngineResults: [],
        aiInterpretation: '',

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

        init() {
            const allGroups = [
                ...Object.values(this.componentGroups.pollen).flatMap(g => Object.values(g)).flat(),
                ...Object.values(this.componentGroups.indoor).flatMap(g => Object.values(g)).flat(),
                ...Object.values(this.componentGroups.occupational).flat()
            ];
            allGroups.forEach(comp => { this.selectedComponents[comp] = false; });
        },

        selectMethod(method) {
            this.currentStep = method === 'ai' ? 'ai_input' : 'manual_input';
        },

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

        async runAnalysis() {
            this.ruleEngineResults = [];
            this.aiInterpretation = '';
            this.currentStep = 'results';
            this.aiProcessing = true;

            this.ruleEngineResults = [
                ...this.checkAgacPoleni(this.selectedComponents),
                ...this.checkCayirPoleni(this.selectedComponents),
                ...this.checkAkar(this.selectedComponents),
                ...this.checkKuf(this.selectedComponents),
                ...this.checkHayvanlar(this.selectedComponents)
            ];

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
                this.aiInterpretation = '<p class="text-red-600">AI yorumlama hatası.</p>';
            } finally {
                this.aiProcessing = false;
            }
        },

        checkAgacPoleni(k) {
            let out = [], primer = false, pan = false, panList = [];
            if (k['Bet v 1'] || k['Cup a 1'] || k['Ole e 1'] || k['Pla a 1']) {
                primer = true;
                out.push({grup: 'Ağaç Poleni', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer ağaç poleni duyarlanması saptandı.'});
            }
            if (k['Bet v 2']) { pan = true; panList.push('Profilin'); }
            if (k['Bet v 4']) { pan = true; panList.push('Polcalcin'); }
            if (k['Ole e 7'] || k['Pla a 3']) { pan = true; panList.push('LTP'); }
            if (k['Pru p 7']) { pan = true; panList.push('GRP'); }
            if (!primer && pan) {
                out.push({grup: 'Ağaç Poleni', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer negatif. Pozitiflik panalerjenlerden: ' + panList.join(', ')});
            } else if (primer && pan) {
                out.push({grup: 'Ağaç Poleni', oneri: 'UYARI (Çapraz Reaksiyon)', gerekce: 'Panalerjen pozitifliği: ' + panList.join(', ')});
            }
            return out;
        },

        checkCayirPoleni(k) {
            let out = [], primer = false;
            if (k['Phl p 1'] || k['Phl p 2'] || k['Phl p 5'] || k['Phl p 11']) {
                primer = true;
                out.push({grup: 'Çayır Poleni', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Gerçek çayır poleni duyarlanması.'});
            }
            if (k['Phl p 7']) out.push({grup: 'Çayır Poleni', oneri: 'KLİNİK RİSK UYARISI', gerekce: 'Phl p 7 (Polcalcin): Astım riski.'});
            if (k['Phl p 12']) out.push({grup: 'Çayır Poleni', oneri: 'KLİNİK RİSK UYARISI', gerekce: 'Phl p 12 (Profilin): OAS riski.'});
            if (!primer && (k['Phl p 7'] || k['Phl p 12'])) {
                out.push({grup: 'Çayır Poleni', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer negatif.'});
            }
            return out;
        },

        checkAkar(k) {
            let out = [], primer = false;
            if (k['Der p 1'] || k['Der p 2'] || k['Der p 23'] || k['Der f 1'] || k['Der f 2'] || k['Blo t 5'] || k['Blo t 21']) {
                primer = true;
                out.push({grup: 'HDM', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Gerçek akar duyarlanması.'});
            }
            if (k['Der p 10'] || k['Blo t 10']) {
                if (!primer) {
                    out.push({grup: 'HDM', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Tropomyosin kaynaklı.'});
                } else {
                    out.push({grup: 'HDM', oneri: 'UYARI (Çapraz Reaksiyon)', gerekce: 'Tropomyosin pozitif.'});
                }
            }
            return out;
        },

        checkKuf(k) {
            let out = [];
            if (k['Alt a 1']) {
                out.push({grup: 'Küf (Alternaria)', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer Alternaria.'});
            } else if (!k['Alt a 1'] && k['Alt a 6']) {
                out.push({grup: 'Küf (Alternaria)', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Alt a 1 negatif.'});
            }
            return out;
        },

        checkHayvanlar(k) {
            let out = [];
            if (k['Fel d 1']) {
                out.push({grup: 'Kedi', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer kedi.'});
                if (k['Fel d 2'] || k['Fel d 4']) {
                    out.push({grup: 'Kedi', oneri: 'UYARI (Çapraz Reaksiyon)', gerekce: 'Fel d 2/4 pozitif.'});
                }
            } else if (k['Fel d 2'] || k['Fel d 4']) {
                out.push({grup: 'Kedi', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Fel d 1 negatif.'});
            }
            if (k['Can f 1'] || k['Can f 2'] || k['Can f 4'] || k['Can f 5']) {
                out.push({grup: 'Köpek', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer köpek.'});
            } else if (k['Can f 3'] || k['Can f 6']) {
                out.push({grup: 'Köpek', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Primer negatif.'});
            }
            if (k['Equ c 1']) {
                out.push({grup: 'At', oneri: 'AIT DÜŞÜNÜLEBİLİR', gerekce: 'Primer at.'});
            } else if (k['Equ c 3']) {
                out.push({grup: 'At', oneri: 'AIT ÖNERİLMEZ', gerekce: 'Equ c 1 negatif.'});
            }
            return out;
        },

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
    };
};

console.log('AI Immunotherapy global function loaded');
</script>

<!-- Load GINA results display script -->
<script src="/modules/js/gina/gina-results.js?v=20251113-007"></script>

<!-- Alpine.js App State -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('appState', () => ({
            sidebarOpen: true,
            menuOpen: false,  // Mobile menu state
            currentRoute: 'dashboard',
            user: null,
            loading: false,
            moduleContent: '',

            init() {
                this.checkAuth();
                this.handleRouting();

                // Listen for hash changes
                window.addEventListener('hashchange', () => {
                    this.handleRouting();
                });
            },

            async checkAuth() {
                try {
                    const response = await fetch('/api/auth.php?action=me', {
                        credentials: 'include'
                    });
                    const data = await response.json();

                    if (data.success) {
                        this.user = data.data;
                    }
                } catch (error) {
                    console.error('Auth check failed:', error);
                }
            },

            handleRouting() {
                const hash = window.location.hash.slice(1) || 'dashboard';
                this.navigateTo(hash);
            },

            async navigateTo(route) {
                this.currentRoute = route;
                window.location.hash = route;

                // Load module content
                if (route !== 'dashboard') {
                    await this.loadModule(route);
                } else {
                    this.moduleContent = '';
                }

                // Scroll to top
                if (document.getElementById('main-content')) {
                    document.getElementById('main-content').scrollTo(0, 0);
                }
            },

            async loadModule(moduleName) {
                this.loading = true;
                try {
                    const response = await fetch('/modules/' + moduleName + '.php');
                    if (response.ok) {
                        this.moduleContent = await response.text();
                    } else {
                        this.moduleContent = '<div class="p-8 text-center"><span class="material-symbols-outlined text-6xl text-gray-400 mb-4">construction</span><h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Modül Hazırlanıyor</h2><p class="text-gray-600 dark:text-gray-400">Bu modül yakında eklenecek.</p></div>';
                    }
                } catch (error) {
                    console.error('Module load failed:', error);
                    this.moduleContent = '<div class="p-8 text-center"><span class="material-symbols-outlined text-6xl text-red-400 mb-4">error</span><h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Yükleme Hatası</h2><p class="text-gray-600 dark:text-gray-400">Modül yüklenirken bir hata oluştu.</p></div>';
                } finally {
                    this.loading = false;
                }
            },

            async logout() {
                if (!confirm('Çıkış yapmak istediğinize emin misiniz?')) {
                    return;
                }

                try {
                    await fetch('/api/auth.php?action=logout', {
                        method: 'POST',
                        credentials: 'include'
                    });

                    this.user = null;
                    window.location.href = '/login.php';
                } catch (error) {
                    console.error('Logout failed:', error);
                    alert('Çıkış yapılırken bir hata oluştu');
                }
            }
        }));
    });
</script>

</body>
</html>
