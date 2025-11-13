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
