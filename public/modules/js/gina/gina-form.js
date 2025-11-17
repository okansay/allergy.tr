/**
 * GINA Asthma Step Advisor - Form Management
 * Note: selectScenario and goToStep are defined globally in footer.php
 */

// Initialize - Wait for DOM to be fully loaded
function initializeWhenReady() {
    const form = document.getElementById('ginaForm');
    if (form) {
        initializeScenarioHandlers();
        initializeForm();
    } else {
        // Retry after a short delay
        setTimeout(initializeWhenReady, 50);
    }
}

// Start initialization
initializeWhenReady();

/**
 * Initialize scenario selection handlers (backup method)
 */
function initializeScenarioHandlers() {
    // This is now handled via onclick, but keeping for backwards compatibility
    console.log('Scenario handlers initialized');
}

/**
 * Initialize form submission
 */
function initializeForm() {
    const form = document.getElementById('ginaForm');
    if (!form) {
        console.error('GINA form not found');
        return;
    }
    form.addEventListener('submit', handleFormSubmit);
}

/**
 * Validate form step 3 before submission
 */
function validateStep3() {
    const scenario = document.querySelector('input[name="scenario"]:checked');
    if (!scenario) {
        alert('Lütfen bir klinik senaryo seçin.');
        return false;
    }

    const scenarioValue = scenario.value;

    // Validate scenario-specific fields
    if (scenarioValue === 'step_adjustment') {
        const regimen = document.getElementById('controller_regimen_type');
        if (!regimen || !regimen.value) {
            alert('Lütfen mevcut kontrol tedavisi rejimini seçin.');
            return false;
        }
    } else if (scenarioValue === 'post_exacerbation') {
        const weeks = document.getElementById('weeks_since_last_exacerbation');
        const severity = document.getElementById('exacerbation_severity');

        if (!weeks || weeks.value === '') {
            alert('Lütfen son alevlenmeden bu yana geçen süreyi girin.');
            return false;
        }
        if (!severity || !severity.value) {
            alert('Lütfen alevlenme şiddetini seçin.');
            return false;
        }
    }

    return true;
}

// Note: updateStep3Fields is defined globally as updateGinaStep3Fields in footer.php

/**
 * Handle form submission
 */
async function handleFormSubmit(e) {
    e.preventDefault();

    if (!validateStep3()) {
        return;
    }

    // Show loading indicator
    document.getElementById('ginaForm').style.display = 'none';
    document.getElementById('loadingIndicator').style.display = 'block';
    document.getElementById('progressIndicator').style.display = 'none';

    // Collect form data
    const formData = collectFormData();

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

        // Display results
        displayResults(result);

    } catch (error) {
        console.error('Error:', error);
        alert('Bir hata oluştu: ' + error.message);

        // Show form again
        document.getElementById('ginaForm').style.display = 'block';
        document.getElementById('loadingIndicator').style.display = 'none';
        document.getElementById('progressIndicator').style.display = 'block';
    }
}

/**
 * Collect all form data
 */
function collectFormData() {
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
