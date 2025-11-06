function getDefaultRate(step) {
    return step * 2;
}

function getDefaultSolution(step) {
    return Math.ceil(step / 4);
}

function generateSolutionOptions(defaultSolution) {
    let options = '';
    for (let i = 1; i <= solutionCount; i++) {
        options += `<option value="${i}" ${i === defaultSolution ? 'selected' : ''}>Solüsyon ${i}</option>`;
    }
    return options;
}

// Form ve UI etkileşimleri için olay dinleyicileri
document.addEventListener('DOMContentLoaded', function() {
    const useCustomUnitCheckbox = document.getElementById('useCustomUnit');
    const customUnitInput = document.getElementById('customUnit');

    if (useCustomUnitCheckbox && customUnitInput) {
        useCustomUnitCheckbox.addEventListener('change', function() {
            customUnitInput.style.display = this.checked ? 'block' : 'none';
            if (this.checked) {
                customUnitInput.required = true;
                customUnitInput.focus();
            } else {
                customUnitInput.required = false;
                customUnitInput.value = '';
            }
        });
    }

    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('reset', function() {
            resetForm();
        });
    }
});

// Input validasyonu işlemleri
function validateInitialInputs() {
    const targetDose = parseFloat(document.getElementById('targetDose').value);
    const dilutionVolume = parseFloat(document.getElementById('dilutionVolume').value);
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const customUnit = document.getElementById('customUnit').value;

    if (!targetDose || targetDose <= 0) {
        alert('Lütfen geçerli bir hedef doz giriniz.');
        return false;
    }
    if (!dilutionVolume || dilutionVolume <= 0) {
        alert('Lütfen geçerli bir sulandırma miktarı giriniz.');
        return false;
    }
    if (useCustomUnit && !customUnit.trim()) {
        alert('Lütfen doz birimi giriniz.');
        return false;
    }
    return true;
}

// Form elemanlarının görünürlük yönetimi
function toggleFormElements(type) {
    const castellsOptions = document.getElementById('castellsOptions');
    const customProtocol = document.getElementById('customProtocol');
    const commonFields = document.getElementById('commonFields');

    commonFields.style.display = 'block';
    castellsOptions.style.display = type === 'castells' ? 'block' : 'none';
    customProtocol.style.display = type === 'custom' ? 'block' : 'none';
}

// UI güncellemesi için yardımcı fonksiyonlar
function updateButtonStates(selectedButton, buttonClass) {
    const buttons = document.querySelectorAll(buttonClass);
    buttons.forEach(btn => {
        btn.classList.remove('active');
    });
    selectedButton.classList.add('active');
}

function clearResults() {
    const resultSection = document.getElementById('resultSection');
    if (resultSection) {
        resultSection.innerHTML = '';
    }
}

function showLoadingIndicator() {
    const loadingDiv = document.createElement('div');
    loadingDiv.id = 'loadingIndicator';
    loadingDiv.className = 'loading-overlay';
    loadingDiv.innerHTML = '<div class="loading-spinner"></div><div>İşlem yapılıyor...</div>';
    loadingDiv.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 1rem;
        color: white;
        z-index: 9999;
    `;
    document.body.appendChild(loadingDiv);
}

function hideLoadingIndicator() {
    const loadingDiv = document.getElementById('loadingIndicator');
    if (loadingDiv) {
        loadingDiv.remove();
    }
}

// Hata mesajı gösterme
function showError(message) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    errorDiv.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #f56565;
        color: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        z-index: 1000;
    `;
    document.body.appendChild(errorDiv);
    setTimeout(() => {
        errorDiv.remove();
    }, 3000);
}

// Input elemanlarının durumunu güncelleme
function updateInputState(inputElement, isReadOnly) {
    inputElement.readOnly = isReadOnly;
    inputElement.style.backgroundColor = isReadOnly ? '#f3f4f6' : 'white';
}

// Form alanlarının dinamik oluşturulması
function createFormField(labelText, inputType, options = {}) {
    const fieldDiv = document.createElement('div');
    fieldDiv.className = 'form-group';

    const label = document.createElement('label');
    label.className = 'block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2';
    label.textContent = labelText;

    const input = document.createElement(inputType === 'select' ? 'select' : 'input');
    input.className = 'w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white';

    if (inputType === 'select') {
        options.options.forEach(opt => {
            const option = document.createElement('option');
            option.value = opt.value;
            option.textContent = opt.text;
            input.appendChild(option);
        });
    } else {
        input.type = inputType;
    }

    Object.keys(options).forEach(key => {
        if (key !== 'options') {
            input[key] = options[key];
        }
    });

    fieldDiv.appendChild(label);
    fieldDiv.appendChild(input);

    return fieldDiv;
}

function updateStepCalculations(stepNumber) {
    const isLastStep = stepNumber === stepCount;
    const solutionSelect = document.getElementById(`step${stepNumber}Solution`);
    const rateInput = document.getElementById(`step${stepNumber}Rate`);
    const timeInput = document.getElementById(`step${stepNumber}Time`);
    const doseInput = document.getElementById(`step${stepNumber}Dose`);

    if (!solutionSelect.value) return;

    const solution = document.getElementById(`solution${solutionSelect.value}Conc`);
    if (!solution) return;

    const concentration = parseFloat(solution.value);
    const rate = parseFloat(rateInput.value);

    if (isLastStep) {
        let totalDoseGiven = 0;
        for (let i = 1; i < stepCount; i++) {
            const dose = parseFloat(document.getElementById(`step${i}Dose`).value);
            if (!isNaN(dose)) {
                totalDoseGiven += dose;
            }
        }

        const targetDose = parseFloat(document.getElementById('targetDose').value);
        const remainingDose = targetDose - totalDoseGiven;

        if (!isNaN(rate) && rate > 0) {
            const timeNeeded = (remainingDose * 60) / (rate * concentration);
            timeInput.value = timeNeeded.toFixed(2);
            doseInput.value = remainingDose;
        }
    } else {
        const time = parseFloat(timeInput.value);
        if (!isNaN(rate) && !isNaN(time)) {
            const volume = (rate * time) / 60;
            const calculatedDose = volume * concentration;
            doseInput.value = calculatedDose;
        }
    }
}
