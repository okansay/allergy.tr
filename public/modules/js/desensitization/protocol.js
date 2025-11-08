// Desensitization Protocol Calculator v20250108-004
console.log('🔬 Protocol.js loaded - Version 20250108-004 - Debug rate calculation');

let solutionCount = 0;
let stepCount = 0;
let activeProtocolType = null;
let activeStepCount = null;

function resetForm() {
    const form = document.getElementById('protocolForm');
    if (form) form.reset();

    const elements = [
        'castellsOptions',
        'customProtocol',
        'commonFields',
        'solutionFields',
        'stepFields',
        'resultSection',
        'ivTypeSection',
        'ivMethodSection'
    ];

    elements.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            if (id === 'solutionFields' || id === 'stepFields' || id === 'resultSection') {
                element.innerHTML = '';
            } else {
                element.style.display = 'none';
            }
        }
    });

    solutionCount = 0;
    stepCount = 0;
    activeProtocolType = null;
    activeStepCount = null;
}

function selectProtocolType(type) {
    activeProtocolType = type;
    activeStepCount = null;

    resetForm();

    const buttons = document.querySelectorAll('.btn-protocol');
    buttons.forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-type') === type) {
            btn.classList.add('active');
        }
    });

    const commonFields = document.getElementById('commonFields');
    if (commonFields) {
        commonFields.style.display = 'block';
    }

    if (type === 'castells') {
        const castellsOptions = document.getElementById('castellsOptions');
        const customProtocol = document.getElementById('customProtocol');
        const adminRoute = document.getElementById('adminRoute');
        const adminRouteSection = document.getElementById('adminRouteSection');
        const ivType = document.getElementById('ivType');

        // Hide route and type selections but set their values
        document.getElementById('ivTypeSection').style.display = 'none';
        if (adminRouteSection) adminRouteSection.style.display = 'none';

        // Set values automatically
        adminRoute.value = 'iv';
        ivType.value = 'infusion';

        // Show solution count selection
        castellsOptions.innerHTML = `
            <div class="form-group">
                <label class="form-label">Solüsyon Sayısı</label>
                <div class="btn-container">
                    <button type="button" class="btn" onclick="selectCastellsSolutionCount(3)">3 Solüsyon</button>
                    <button type="button" class="btn" onclick="selectCastellsSolutionCount(4)">4 Solüsyon</button>
                </div>
            </div>`;

        castellsOptions.style.display = 'block';
        if (customProtocol) customProtocol.style.display = 'none';

        handleIVTypeChange();
    } else {
        const castellsOptions = document.getElementById('castellsOptions');
        const customProtocol = document.getElementById('customProtocol');
        const adminRouteSection = document.getElementById('adminRouteSection');

        document.getElementById('ivTypeSection').style.display = 'none';
        if (adminRouteSection) adminRouteSection.style.display = 'block';

        if (castellsOptions) castellsOptions.style.display = 'none';
        if (customProtocol) customProtocol.style.display = 'block';
    }
}

function selectCastellsSolutionCount(count) {
    // CRITICAL: Set protocol type for Castells
    activeProtocolType = 'castells';
    console.log('✅ Castells protocol activated - rates will use doubling pattern');

    solutionCount = count;
    const totalSteps = count * 4;

    // Validate inputs first
    const targetDose = parseFloat(document.getElementById('targetDose').value);
    const dilutionVolume = parseFloat(document.getElementById('dilutionVolume').value);

    if (!targetDose || isNaN(targetDose) || targetDose <= 0) {
        alert('Lütfen geçerli bir hedef doz giriniz.');
        return;
    }
    if (!dilutionVolume || isNaN(dilutionVolume) || dilutionVolume <= 0) {
        alert('Lütfen geçerli bir sulandırma miktarı giriniz.');
        return;
    }

    // Generate solution fields directly
    generateSolutionFields(count);

    // After generating solution fields, set step count and generate steps
    const stepCountInput = document.getElementById('stepCount');
    if (stepCountInput) {
        stepCountInput.value = totalSteps;
        // Don't auto-generate steps, wait for user to click the button
    }
}

function handleAdminRouteChange() {
    const adminRoute = document.getElementById('adminRoute');
    const ivTypeSection = document.getElementById('ivTypeSection');
    const dilutionVolumeGroup = document.getElementById('dilutionVolumeGroup');

    // Clear previous fields
    document.getElementById('solutionFields').innerHTML = '';
    document.getElementById('stepFields').innerHTML = '';
    document.getElementById('resultSection').innerHTML = '';

    if (adminRoute && adminRoute.value === 'iv') {
        ivTypeSection.style.display = 'block';
        dilutionVolumeGroup.style.display = 'block';
    } else if (adminRoute && adminRoute.value === 'subcutan') {
        ivTypeSection.style.display = 'none';
        dilutionVolumeGroup.style.display = 'none';
        showSubcutanForm();
    } else if (adminRoute && adminRoute.value === 'oral') {
        ivTypeSection.style.display = 'none';
        dilutionVolumeGroup.style.display = 'none';
        showOralForm();
    } else {
        ivTypeSection.style.display = 'none';
        dilutionVolumeGroup.style.display = 'block';
        document.getElementById('solutionFields').innerHTML = '';
        document.getElementById('stepFields').innerHTML = '';
    }
}

function showSubcutanForm() {
    const useCustomUnit = document.getElementById('useCustomUnit');
    const customUnitInput = document.getElementById('customUnit');
    const updateLabels = () => {
        const unit = useCustomUnit.checked ? customUnitInput.value : 'mg';
        const ilacMiktariLabel = document.querySelector('label[for="ilacMiktar"]');
        const konsLabel = document.querySelector('label[for="initialConcentration"]');
        if (ilacMiktariLabel) ilacMiktariLabel.textContent = `İlaç Miktarı (${unit})`;
        if (konsLabel) konsLabel.textContent = `Başlangıç Konsantrasyonu (${unit}/mL)`;
    };

    const solutionFields = document.getElementById('solutionFields');
    const unit = useCustomUnit.checked ? customUnitInput.value : 'mg';

    solutionFields.innerHTML = `
        <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">İlaç Ampul (mL)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="ampulVolume" min="0.1" step="0.1" required
                        onchange="calculateInitialConcentration()">
                </div>
                <div>
                    <label for="ilacMiktar" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">İlaç Miktarı (${unit})</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="ilacMiktar" min="0.1" step="0.1" required
                        onchange="calculateInitialConcentration()">
                </div>
                <div>
                    <label for="initialConcentration" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Başlangıç Konsantrasyonu (${unit}/mL)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-600 text-slate-900 dark:text-white font-bold" id="initialConcentration" readonly>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Basamak Sayısı</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="stepCount" min="1" max="10" required>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Not: Son basamaktaki hacim ve doz hedef doza göre otomatik hesaplanacaktır.</p>
                </div>
                <div class="flex gap-4">
                    <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-primary text-white font-semibold hover:bg-primary/90 transition-colors" onclick="generateSubcutanSteps()">Basamakları Oluştur</button>
                </div>
            </div>
        </div>`;

    // Add event listeners for unit changes
    useCustomUnit.addEventListener('change', updateLabels);
    customUnitInput.addEventListener('input', () => {
        if (useCustomUnit.checked) {
            updateLabels();
        }
    });
}

function generateSubcutanSteps() {
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';
    const ampulVolume = parseFloat(document.getElementById('ampulVolume').value);
    const ilacMiktar = parseFloat(document.getElementById('ilacMiktar').value);
    const initialConcentration = ilacMiktar / ampulVolume;
    document.getElementById('initialConcentration').value = initialConcentration.toFixed(4);
    const targetDose = parseFloat(document.getElementById('targetDose').value);
    const count = parseInt(document.getElementById('stepCount').value);

    if (!targetDose || targetDose <= 0) {
        alert('Lütfen geçerli bir hedef doz giriniz.');
        return;
    }

    if (!count || count < 1) {
        alert('Lütfen geçerli bir basamak sayısı girin.');
        return;
    }

    stepCount = count;
    let html = '<div class="step-section">';
    html += '<div class="section-title">Subkütan Basamak Detayları</div>';

    for (let i = 1; i <= count; i++) {
        const isLastStep = i === count;
        html += `
        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Basamak ${i}</label>
            <div class="step-inputs">
                <div>
                    <label>Bekleme Süresi (dk)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="step${i}Interval" value="15" required>
                </div>
                <div>
                    <label>Dilüsyon Oranı (1/x)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="step${i}DilutionRatio" min="1" required oninput="calculateSubcutanStepDose(${i})">
                </div>
                <div>
                    <label>Son Konsantrasyon (${unit}/mL)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-600 text-slate-900 dark:text-white" id="step${i}FinalConc" readonly>
                </div>
                <div>
                    <label>Hacim (mL)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 ${isLastStep ? 'bg-slate-100 dark:bg-slate-600' : 'bg-white dark:bg-slate-700'} text-slate-900 dark:text-white" id="step${i}Volume" step="0.01"
                        ${isLastStep ? 'readonly' : ''}
                        onchange="updateDoseCalculation(${i})"
                        required>
                </div>
                <div>
                    <label>Verilen Doz (${unit})</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-600 text-slate-900 dark:text-white" id="step${i}Dose" readonly>
                </div>
            </div>
        </div>`;
    }

    html += `</div>
    <div class="flex gap-4 mt-6">
        <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition-colors" onclick="calculateSubcutanProtocol()">Hesapla</button>
    </div>`;

    document.getElementById('stepFields').innerHTML = html;
}

function handleIVTypeChange() {
    const ivType = document.getElementById('ivType');
    const solutionFields = document.getElementById('solutionFields');
    const stepFields = document.getElementById('stepFields');
    const resultSection = document.getElementById('resultSection');
    const dilutionVolumeGroup = document.getElementById('dilutionVolumeGroup');

    if (!ivType || !solutionFields) return;

    // Clear previous fields
    solutionFields.innerHTML = '';
    if (stepFields) stepFields.innerHTML = '';
    if (resultSection) resultSection.innerHTML = '';

    if (ivType.value === 'infusion') {
        dilutionVolumeGroup.style.display = 'block';
        showSolutionForm();
    } else if (ivType.value === 'bolus') {
        dilutionVolumeGroup.style.display = 'none';
        showBolusForm();
    }
}

function showSolutionForm() {
    const solutionFields = document.getElementById('solutionFields');
    solutionFields.innerHTML = `
        <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Solüsyon Sayısı</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="solutionCount" min="1" max="5" required>
                </div>
                <div class="flex gap-4">
                    <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-primary text-white font-semibold hover:bg-primary/90 transition-colors" onclick="validateAndGenerateCustom()">Protokol Tasarla</button>
                </div>
            </div>
        </div>`;
}

function showBolusForm() {
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';
    document.getElementById('dilutionVolume').parentElement.style.display = 'none';
    const solutionFields = document.getElementById('solutionFields');
    solutionFields.innerHTML = `
        <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Basamak Sayısı</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="stepCount" min="1" max="10" required>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Not: Son basamaktaki bolus miktarı hedef doza göre otomatik hesaplanacaktır.</p>
                </div>
                <div class="flex gap-4">
                    <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-primary text-white font-semibold hover:bg-primary/90 transition-colors" onclick="generateBolusSteps()">Basamakları Oluştur</button>
                </div>
            </div>
        </div>`;
}

function validateAndGenerateCustom() {
    const targetDose = parseFloat(document.getElementById('targetDose').value);
    const dilutionVolume = parseFloat(document.getElementById('dilutionVolume').value);
    const solutionCountInput = document.getElementById('solutionCount');

    if (!targetDose || isNaN(targetDose) || targetDose <= 0) {
        alert('Lütfen geçerli bir hedef doz giriniz.');
        return;
    }
    if (!dilutionVolume || isNaN(dilutionVolume) || dilutionVolume <= 0) {
        alert('Lütfen geçerli bir sulandırma miktarı giriniz.');
        return;
    }

    // Get solution count from input (for custom protocol)
    if (solutionCountInput) {
        solutionCount = parseInt(solutionCountInput.value);
        if (!solutionCount || solutionCount < 1) {
            alert('Lütfen geçerli bir solüsyon sayısı girin.');
            return;
        }
    }

    // Check if step count exists and validate solutions
    const stepCountInput = document.getElementById('stepCount');
    if (stepCountInput && stepCountInput.value) {
        for (let i = 1; i <= solutionCount; i++) {
            const conc = document.getElementById(`solution${i}Conc`)?.value;
            if (!conc || isNaN(conc) || conc <= 0) {
                alert('Lütfen tüm solüsyon detaylarını doldurunuz.');
                return;
            }
        }
        const stepCountValue = parseInt(stepCountInput.value);
        if (!stepCountValue || stepCountValue < 1) {
            alert('Lütfen geçerli bir basamak sayısı girin.');
            return;
        }
    }

    generateSolutionFields(solutionCount);
}

function generateBolusSteps() {
    // Input validation
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';
    const targetDose = parseFloat(document.getElementById('targetDose').value);
    const stepCountValue = document.getElementById('stepCount').value;

    if (!targetDose || isNaN(targetDose) || targetDose <= 0) {
        alert('Lütfen geçerli bir hedef doz giriniz.');
        return;
    }

    if (!targetDose || targetDose <= 0) {
        alert('Lütfen geçerli bir hedef doz giriniz.');
        return;
    }

    const count = parseInt(stepCountValue);
    if (!count || count < 1) {
        alert('Lütfen geçerli bir basamak sayısı girin.');
        return;
    }

    stepCount = count;
    let html = '<div class="step-section">';
    html += '<div class="section-title">Bolus Basamak Detayları</div>';

    for (let i = 1; i <= count; i++) {
        const isLastStep = i === count;
        html += `
        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Basamak ${i}</label>
            <div class="step-inputs">
                <div>
                    <label>Bekleme Süresi (dk)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="step${i}Interval" value="15" required>
                </div>
                <div>
                    <label>Konsantrasyon</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="step${i}Concentration" step="0.0001" required
                        oninput="calculateBolusStepDose(${i})">
                </div>
                <div>
                    <label>Hacim (mL)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 ${isLastStep ? 'bg-slate-100 dark:bg-slate-600' : 'bg-white dark:bg-slate-700'} text-slate-900 dark:text-white" id="step${i}Volume" step="0.1"
                        ${isLastStep ? 'readonly' : ''}
                        oninput="calculateBolusStepDose(${i})"
                        required>
                </div>
                <div>
                    <label>Verilen Doz (${unit})</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-600 text-slate-900 dark:text-white" id="step${i}Dose" readonly>
                </div>
            </div>
        </div>`;
    }

    html += `</div>
    <div class="flex gap-4 mt-6">
        <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition-colors" onclick="calculateBolusProtocol()">Hesapla</button>
    </div>`;

    document.getElementById('stepFields').innerHTML = html;
}

function calculateBolusProtocol() {
    const stepCountValue = document.querySelectorAll('[id^="step"][id$="Concentration"]').length;
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';

    // Validate all fields are filled
    for (let i = 1; i <= stepCountValue; i++) {
        const interval = document.getElementById(`step${i}Interval`).value;
        const concentration = document.getElementById(`step${i}Concentration`).value;
        const volume = document.getElementById(`step${i}Volume`).value;

        if (!interval || !concentration || (!volume && i !== stepCountValue)) {
            alert('Lütfen tüm basamak detaylarını doldurunuz.');
            return;
        }
    }

    let cumulativeDose = 0;
    let totalTime = 0;
    const targetDose = parseFloat(document.getElementById('targetDose').value);

    // Son basamak hesaplaması
    let lastStepDose = targetDose;
    for (let i = 1; i < stepCountValue; i++) {
        const concentration = parseFloat(document.getElementById(`step${i}Concentration`).value);
        const volume = parseFloat(document.getElementById(`step${i}Volume`).value);
        const dose = concentration * volume;
        lastStepDose -= dose;
    }

    if (lastStepDose > 0) {
        const lastConcentration = parseFloat(document.getElementById(`step${stepCountValue}Concentration`).value);
        const lastVolume = lastStepDose / lastConcentration;
        document.getElementById(`step${stepCountValue}Volume`).value = lastVolume.toFixed(2);
    }

    let html = `
    <div class="results-section">
        <h3>BOLUS UYGULAMA BASAMAKLARI</h3>
        <div class="overflow-x-auto">
        <table id="stepsTable">
            <thead>
                <tr>
                    <th>Basamak</th>
                    <th>Bekleme Süresi (dk)</th>
                    <th>Konsantrasyon</th>
                    <th>Hacim (mL)</th>
                    <th>Doz (${unit})</th>
                    <th>Kümülatif Doz (${unit})</th>
                </tr>
            </thead>
            <tbody>`;

    for (let i = 1; i <= stepCountValue; i++) {
        const concentration = parseFloat(document.getElementById(`step${i}Concentration`).value);
        const volume = parseFloat(document.getElementById(`step${i}Volume`).value);
        const interval = parseFloat(document.getElementById(`step${i}Interval`).value);

        const dose = concentration * volume;
        cumulativeDose += dose;
        totalTime += interval;

        html += `
            <tr>
                <td>${i}</td>
                <td>${interval}</td>
                <td>${formatNumber(concentration, 4)}</td>
                <td>${formatNumber(volume, 2)}</td>
                <td>${formatNumber(dose, 3)}</td>
                <td>${formatNumber(cumulativeDose, 3)}</td>
            </tr>`;
    }

    html += `
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">Toplam Doz: ${cumulativeDose.toFixed(3)} ${unit} / Toplam Süre: ${formatTime(totalTime)}</td>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>`;

    document.getElementById('resultSection').innerHTML = html;
    addExportButtons();
}

function calculateSubcutanProtocol() {
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';
    const stepCountValue = document.querySelectorAll('[id^="step"][id$="DilutionRatio"]').length;

    // Validate all fields are filled
    for (let i = 1; i <= stepCountValue; i++) {
        const interval = document.getElementById(`step${i}Interval`).value;
        const dilutionRatio = document.getElementById(`step${i}DilutionRatio`).value;
        const volume = document.getElementById(`step${i}Volume`).value;

        if (!interval || !dilutionRatio || (!volume && i !== stepCountValue)) {
            alert('Lütfen tüm basamak detaylarını doldurunuz.');
            return;
        }
    }

    let cumulativeDose = 0;
    let totalTime = 0;
    const targetDose = parseFloat(document.getElementById('targetDose').value);

    // Calculate last step
    let lastStepDose = targetDose;
    for (let i = 1; i < stepCountValue; i++) {
        const dilutionRatio = parseFloat(document.getElementById(`step${i}DilutionRatio`).value);
        const volume = parseFloat(document.getElementById(`step${i}Volume`).value);
        const initialConc = parseFloat(document.getElementById('initialConcentration').value);
        const finalConc = initialConc * (1 / dilutionRatio);
        const dose = finalConc * volume;
        lastStepDose -= dose;
    }

    if (lastStepDose > 0) {
        const lastDilutionRatio = parseFloat(document.getElementById(`step${stepCountValue}DilutionRatio`).value);
        const initialConc = parseFloat(document.getElementById('initialConcentration').value);
        const finalConc = initialConc * (1/lastDilutionRatio);
        const lastVolume = lastStepDose / finalConc;
        document.getElementById(`step${stepCountValue}Volume`).value = lastVolume.toFixed(2);
    }

    let html = `
    <div class="results-section">
        <h3>SUBKÜTAN UYGULAMA BASAMAKLARI</h3>
        <div class="overflow-x-auto">
        <table id="stepsTable">
            <thead>
                <tr>
                    <th>Basamak</th>
                    <th>Bekleme Süresi (dk)</th>
                    <th>Dilüsyon Oranı</th>
                    <th>Son Konsantrasyon (${unit}/mL)</th>
                    <th>Hacim (mL)</th>
                    <th>Doz (${unit})</th>
                    <th>Kümülatif Doz (${unit})</th>
                </tr>
            </thead>
            <tbody>`;

    for (let i = 1; i <= stepCountValue; i++) {
        const dilutionRatio = parseFloat(document.getElementById(`step${i}DilutionRatio`).value);
        const volume = parseFloat(document.getElementById(`step${i}Volume`).value);
        const interval = parseFloat(document.getElementById(`step${i}Interval`).value);
        const initialConc = parseFloat(document.getElementById('initialConcentration').value);
        const finalConc = initialConc * (1 / dilutionRatio);
        const dose = finalConc * volume;
        cumulativeDose += dose;
        totalTime += interval;

        html += `
            <tr>
                <td>${i}</td>
                <td>${interval}</td>
                <td>1/${dilutionRatio}</td>
                <td>${formatNumber(finalConc)}</td>
                <td>${formatNumber(volume)}</td>
                <td>${formatNumber(dose)}</td>
                <td>${formatNumber(cumulativeDose)}</td>
            </tr>`;
    }

    html += `
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        Toplam Süre: ${formatTime(totalTime)}<br>
                        Verilen Dozlar Toplamı: ${formatNumber(cumulativeDose, 3)} ${unit}<br>
                        Hedef Doz: ${formatNumber(targetDose, 3)} ${unit}
                    </td>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>`;

    document.getElementById('resultSection').innerHTML = html;
    addExportButtons();
}

function calculateInitialConcentration() {
    const ampulVolume = parseFloat(document.getElementById('ampulVolume').value);
    const ilacMiktar = parseFloat(document.getElementById('ilacMiktar').value);

    if (ampulVolume && ilacMiktar) {
        const initialConc = ilacMiktar / ampulVolume;
        document.getElementById('initialConcentration').value = initialConcentration.toFixed(4);
    }
}

function updateDoseCalculation(stepNumber) {
    const isLastStep = stepNumber === stepCount;
    const dilutionRatio = document.getElementById(`step${stepNumber}DilutionRatio`);
    const volume = document.getElementById(`step${stepNumber}Volume`);
    const doseInput = document.getElementById(`step${stepNumber}Dose`);
    const finalConcInput = document.getElementById(`step${stepNumber}FinalConc`);
    const initialConc = parseFloat(document.getElementById('initialConcentration').value);
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';

    if (!dilutionRatio) return;

    const ratio = parseFloat(dilutionRatio.value);
    const volumeValue = parseFloat(volume.value);
    if (!ratio || ratio <= 0) return;

    const finalConc = initialConc * (1/ratio);
    finalConcInput.value = Number(parseFloat(finalConc).toFixed(10)).toString();

    // Only calculate dose when both volume and dilution ratio are entered
    if (volumeValue && ratio) {
        const dose = finalConc * volumeValue;
        doseInput.value = dose.toFixed(10);
    }

    if (isLastStep) {
        let totalDoseGiven = 0;
        for (let i = 1; i < stepCount; i++) {
            const stepDose = parseFloat(document.getElementById(`step${i}Dose`).value) || 0;
            totalDoseGiven += stepDose;
        }

        const targetDose = parseFloat(document.getElementById('targetDose').value);
        const remainingDose = targetDose - totalDoseGiven;
        const lastVolume = remainingDose / finalConc;

        volume.value = lastVolume.toFixed(2);
        doseInput.value = remainingDose.toFixed(3);
    } else {
        const volumeValue = parseFloat(volume.value);
        if (volumeValue && ratio) {
            const dose = finalConc * volumeValue;
            doseInput.value = dose.toFixed(10);
        } else {
            doseInput.value = '';
        }
    }
}

function formatNumber(number, decimals = 5) {
    let formatted = parseFloat(number).toFixed(5);
    formatted = formatted.replace(/\.?0+$/, "");
    return formatted.includes(".") ? formatted : formatted + ".0";
}

function formatTime(totalMinutes) {
    const hours = Math.floor(totalMinutes / 60);
    const minutes = Math.floor(totalMinutes % 60);
    const seconds = Math.round((totalMinutes % 1) * 60);

    let result = `${totalMinutes.toFixed(2)} dakika`;
    if (hours > 0 || minutes > 0) {
        result += ` (${hours} saat ${minutes} dakika`;
        if (seconds > 0) {
            result += ` ${seconds} saniye`;
        }
        result += ')';
    }
    return result;
}

function addExportButtons() {
    const resultSection = document.getElementById('resultSection');
    if (!resultSection) return;

    const existingButtons = document.querySelector('.export-buttons');
    if (existingButtons) return; // Already added

    const buttonsHTML = `
        <div class="export-buttons">
            <button type="button" class="btn-export" style="background-color: #10B981;" onclick="exportToExcel()">
                📥 Excel İndir
            </button>
            <button type="button" class="btn-export" style="background-color: #3B82F6;" onclick="exportToWord()">
                📄 Word İndir
            </button>
            <button type="button" class="btn-export" style="background-color: #8B5CF6;" onclick="printResults()">
                🖨️ Yazdır
            </button>
        </div>`;

    resultSection.innerHTML += buttonsHTML;
}

function printResults() {
    const resultSection = document.getElementById('resultSection');
    if (!resultSection) {
        alert('Sonuç bulunamadı.');
        return;
    }

    const drugName = document.getElementById('drugName')?.value || 'İlaç Desensitizasyon Protokolü';

    // Create a new window for printing
    const printWindow = window.open('', '_blank', 'width=800,height=600');

    // Write the HTML content
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Desensitizasyon Protokolü - ${drugName}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    color: #000;
                }
                h2, h3 {
                    text-align: center;
                    color: #2d3748;
                    margin-bottom: 20px;
                }
                .info {
                    margin: 10px 0;
                    font-size: 14px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: center;
                    font-size: 12px;
                }
                th {
                    background-color: #4a5568;
                    color: white;
                    font-weight: bold;
                }
                tr:nth-child(even) {
                    background-color: #f7fafc;
                }
                tfoot td {
                    background-color: #e2e8f0;
                    font-weight: 600;
                    text-align: left;
                }
                .warning {
                    margin-top: 20px;
                    padding-top: 10px;
                    border-top: 1px solid #cbd5e0;
                    font-size: 10px;
                    color: #666;
                }
                @media print {
                    body {
                        margin: 10px;
                    }
                    .no-print {
                        display: none;
                    }
                }
            </style>
        </head>
        <body>
            <h2>İlaç Desensitizasyon Protokolü</h2>
            <div class="info"><strong>İlaç:</strong> ${drugName}</div>
            <div class="info"><strong>Tarih:</strong> ${new Date().toLocaleDateString('tr-TR', { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })}</div>
            <div class="info"><strong>Hazırlayan:</strong> Allergy.tr Desensitizasyon Hesaplayıcı</div>
            ${resultSection.innerHTML}
            <div class="warning">
                <p><strong>Uyarı:</strong> Bu protokol eğitim amaçlıdır. Klinik uygulamada güncel kılavuzlara ve kurumsal protokollere başvurunuz.</p>
                <p><strong>Referanslar:</strong></p>
                <ul>
                    <li>Castells MC, et al. Hypersensitivity drug reactions and desensitization protocols. Med Clin North Am. 2020</li>
                    <li>Wong JT, Long A. Desensitization for immediate hypersensitivity: state of the art. Ann Allergy Asthma Immunol. 2018</li>
                </ul>
            </div>
        </body>
        </html>
    `);

    printWindow.document.close();

    // Wait for content to load then print
    printWindow.onload = function() {
        // Remove export buttons from print content
        const exportButtons = printWindow.document.querySelector('.export-buttons');
        if (exportButtons) {
            exportButtons.remove();
        }

        setTimeout(function() {
            printWindow.print();
            printWindow.close();
        }, 250);
    };
}

function generateSolutionFields(count) {
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';
    const targetDose = parseFloat(document.getElementById('targetDose').value);
    const dilutionVolume = parseFloat(document.getElementById('dilutionVolume').value);
    const stockConc = targetDose / dilutionVolume;

    solutionCount = count;
    let html = '<div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">';
    html += '<div class="section-title">Solüsyon Detayları</div>';
    html += '<div class="space-y-4">';

    for (let i = 1; i <= count; i++) {
        const defaultConc = stockConc * Math.pow(0.1, count - i);
        html += `
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Solüsyon ${i} Konsantrasyonu (${unit}/ml)</label>
            <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="solution${i}Conc"
                value="${defaultConc}"
                step="0.0000001" min="0" max="9999999.9999999" required>
        </div>`;
    }
    html += '</div>';

    const defaultStepCount = count * 4;

    html += `
    <div class="mt-4">
        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Basamak Sayısı</label>
        <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="stepCount" min="1" max="20" value="${defaultStepCount}" required>
    </div>
    <div class="flex gap-4 mt-6">
        <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-primary text-white font-semibold hover:bg-primary/90 transition-colors" onclick="generateStepFields()">Basamakları Oluştur</button>
    </div>
    </div>`;

    document.getElementById('solutionFields').innerHTML = html;
    document.getElementById('stepFields').innerHTML = '';
    document.getElementById('submitContainer').style.display = 'none';
}

function showOralForm() {
    const solutionFields = document.getElementById('solutionFields');
    solutionFields.innerHTML = `
        <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Basamak Sayısı</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="stepCount" min="1" max="10" required>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Not: Son basamaktaki hacim hedef doza göre otomatik hesaplanacaktır.</p>
                </div>
                <div class="flex gap-4">
                    <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-primary text-white font-semibold hover:bg-primary/90 transition-colors" onclick="generateOralSteps()">Basamakları Oluştur</button>
                </div>
            </div>
        </div>`;
}

function generateOralSteps() {
    const targetDose = parseFloat(document.getElementById('targetDose').value);
    const count = parseInt(document.getElementById('stepCount').value);

    if (!targetDose || targetDose <= 0) {
        alert('Lütfen geçerli bir hedef doz giriniz.');
        return;
    }

    if (!count || count < 1) {
        alert('Lütfen geçerli bir basamak sayısı girin.');
        return;
    }

    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';

    stepCount = count;
    let html = '<div class="step-section">';
    html += '<div class="section-title">Oral Basamak Detayları</div>';

    for (let i = 1; i <= count; i++) {
        const isLastStep = i === count;
        html += `
        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Basamak ${i}</label>
            <div class="step-inputs">
                <div>
                    <label>Bekleme Süresi (dk)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="step${i}Interval" value="15" required>
                </div>
                <div>
                    <label>Konsantrasyon (${unit}/mL)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="step${i}Concentration" step="0.0001" required
                        oninput="calculateOralStepDose(${i})">
                </div>
                <div>
                    <label>Hacim (mL)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 ${isLastStep ? 'bg-slate-100 dark:bg-slate-600' : 'bg-white dark:bg-slate-700'} text-slate-900 dark:text-white" id="step${i}Volume" step="0.1"
                        ${isLastStep ? 'readonly' : ''}
                        required oninput="calculateOralStepDose(${i})">
                </div>
                <div>
                    <label>Verilen Doz (${unit})</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-600 text-slate-900 dark:text-white" id="step${i}Dose" readonly>
                </div>
            </div>
        </div>`;
    }

    html += `</div>
    <div class="flex gap-4 mt-6">
        <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition-colors" onclick="calculateOralProtocol()">Hesapla</button>
    </div>`;

    document.getElementById('stepFields').innerHTML = html;
}

function calculateOralProtocol() {
    const stepCountValue = document.querySelectorAll('[id^="step"][id$="Concentration"]').length;
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';

    // Validate all fields are filled
    for (let i = 1; i <= stepCountValue; i++) {
        const interval = document.getElementById(`step${i}Interval`).value;
        const concentration = document.getElementById(`step${i}Concentration`).value;
        const volume = document.getElementById(`step${i}Volume`).value;

        if (!interval || !concentration || (!volume && i !== stepCountValue)) {
            alert('Lütfen tüm basamak detaylarını doldurunuz.');
            return;
        }
    }

    let cumulativeDose = 0;
    let totalTime = 0;
    const targetDose = parseFloat(document.getElementById('targetDose').value);

    // Calculate last step volume
    let lastStepDose = targetDose;
    for (let i = 1; i < stepCountValue; i++) {
        const concentration = parseFloat(document.getElementById(`step${i}Concentration`).value);
        const volume = parseFloat(document.getElementById(`step${i}Volume`).value);
        const dose = concentration * volume;
        lastStepDose -= dose;
    }

    if (lastStepDose > 0) {
        const lastConcentration = parseFloat(document.getElementById(`step${stepCountValue}Concentration`).value);
        const lastVolume = lastStepDose / lastConcentration;
        document.getElementById(`step${stepCountValue}Volume`).value = lastVolume.toFixed(2);
    }

    let html = `
    <div class="results-section">
        <h3>ORAL UYGULAMA BASAMAKLARI</h3>
        <div class="overflow-x-auto">
        <table id="stepsTable">
            <thead>
                <tr>
                    <th>Basamak</th>
                    <th>Bekleme Süresi (dk)</th>
                    <th>Konsantrasyon (${unit}/mL)</th>
                    <th>Hacim (mL)</th>
                    <th>Verilen Doz (${unit})</th>
                    <th>Kümülatif Doz (${unit})</th>
                </tr>
            </thead>
            <tbody>`;

    for (let i = 1; i <= stepCountValue; i++) {
        const concentration = parseFloat(document.getElementById(`step${i}Concentration`).value);
        const volume = parseFloat(document.getElementById(`step${i}Volume`).value);
        const interval = parseFloat(document.getElementById(`step${i}Interval`).value);

        const dose = concentration * volume;
        cumulativeDose += dose;
        totalTime += interval;

        html += `
            <tr>
                <td>${i}</td>
                <td>${interval}</td>
                <td>${formatNumber(concentration, 4)}</td>
                <td>${formatNumber(volume, 2)}</td>
                <td>${formatNumber(dose, 3)}</td>
                <td>${formatNumber(cumulativeDose, 3)}</td>
            </tr>`;
    }

    html += `
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6">Toplam Doz: ${formatNumber(cumulativeDose, 3)} ${unit} / Toplam Süre: ${formatTime(totalTime)}</td>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>`;

    document.getElementById('resultSection').innerHTML = html;
    addExportButtons();
}

function getCastellsRate(stepNumber) {
    // Castells protocol uses standardized rates with doubling pattern
    const stepIndex = stepNumber - 1; // Convert to 0-indexed
    const solutionIndex = Math.floor(stepIndex / 4); // Which solution (0, 1, 2, ...)
    const stepInSolution = stepIndex % 4; // Which step within the solution (0-3)

    // Base rates for each solution: 2, 5, 10, 20, 40, 80...
    const bases = [2, 5, 10, 20, 40, 80, 160, 320]; // Enough for 8 solutions
    const base = bases[solutionIndex];

    // Multipliers within each solution
    // First solution has special pattern: [1, 2.5, 5, 10]
    // All other solutions double: [1, 2, 4, 8]
    const multipliers = solutionIndex === 0
        ? [1, 2.5, 5, 10]  // First solution: 2, 5, 10, 20
        : [1, 2, 4, 8];    // Other solutions: base, base*2, base*4, base*8

    return base * multipliers[stepInSolution];
}

function generateStepFields() {
    const ivType = document.getElementById('ivType');
    const isInfusion = ivType && ivType.value === 'infusion';

    if (isInfusion) {
        // Validate solution details first
        for (let i = 1; i <= solutionCount; i++) {
            const conc = document.getElementById(`solution${i}Conc`)?.value;
            if (!conc || isNaN(conc) || conc <= 0) {
                alert('Lütfen önce tüm solüsyon detaylarını doldurunuz.');
                return;
            }
        }
    }

    const count = parseInt(document.getElementById('stepCount').value);
    if (!count || count < 1) {
        alert('Lütfen geçerli bir basamak sayısı girin.');
        return;
    }

    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';

    stepCount = count;
    let html = '<div class="step-section">';
    html += '<div class="section-title">İnfüzyon Basamak Detayları</div>';

    for (let i = 1; i <= count; i++) {
        // Debug: Log what's happening with rate calculation
        console.log(`🔍 Step ${i} - activeProtocolType:`, activeProtocolType);
        const castellsRate = getCastellsRate(i);
        console.log(`🔍 Step ${i} - getCastellsRate() returns:`, castellsRate);

        // Use Castells protocol rates (doubling pattern) or linear for custom protocols
        const defaultRate = activeProtocolType === 'castells' ? getCastellsRate(i) : i * 2;
        console.log(`🔍 Step ${i} - defaultRate selected:`, defaultRate, `(linear would be: ${i * 2})`);

        const defaultTime = i === count ? '' : 15;
        const defaultSolution = Math.ceil(i / 4);
        const isLastStep = i === count;

        html += `
        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Basamak ${i}</label>
            <div class="step-inputs">
                <div>
                    <label>Solüsyon</label>
                    <select class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="step${i}Solution" required onchange="updateStepCalculations(${i})">
                        <option value="">Seçin</option>`;

        for (let j = 1; j <= solutionCount; j++) {
            html += `<option value="${j}" ${j === defaultSolution ? 'selected' : ''}>Solüsyon ${j}</option>`;
        }

        html += `
                    </select>
                </div>
                <div>
                    <label>Hız (mL/saat)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white" id="step${i}Rate"
                        value="${defaultRate}"
                        step="0.1" onchange="updateStepCalculations(${i})" required>
                </div>
                <div>
                    <label>Süre (dakika)</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 ${isLastStep ? 'bg-slate-100 dark:bg-slate-600' : 'bg-white dark:bg-slate-700'} text-slate-900 dark:text-white" id="step${i}Time"
                        value="${defaultTime}"
                        ${isLastStep ? 'readonly' : ''}
                        onchange="updateStepCalculations(${i})"
                        required>
                </div>
                <div>
                    <label>Verilen Doz (${unit})</label>
                    <input type="number" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-slate-100 dark:bg-slate-600 text-slate-900 dark:text-white" id="step${i}Dose"
                        readonly>
                </div>
            </div>
        </div>`;
    }

    html += '</div>';
    html += `
    <div id="submitContainer" class="flex gap-4 mt-6">
        <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors" onclick="resetForm()">Temizle</button>
        <button type="button" class="flex-1 px-6 py-3 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition-colors" onclick="calculateInfusionProtocol()">Hesapla</button>
    </div>`;

    document.getElementById('stepFields').innerHTML = html;

    // Auto-calculate initial doses
    for (let i = 1; i <= count; i++) {
        if (i !== count) {
            updateStepCalculations(i);
        }
    }

    // Now calculate the last step after all previous steps are done
    updateStepCalculations(count);
}

function calculateInfusionProtocol() {
    const stepCountValue = document.querySelectorAll('[id^="step"][id$="Solution"]').length;
    const useCustomUnit = document.getElementById('useCustomUnit').checked;
    const unit = useCustomUnit ? document.getElementById('customUnit').value : 'mg';
    const targetDose = parseFloat(document.getElementById('targetDose').value);
    let dilutionVolume = parseFloat(document.getElementById('dilutionVolume').value);

    // Default to 100mL if not specified
    if (!dilutionVolume || isNaN(dilutionVolume) || dilutionVolume <= 0) {
        dilutionVolume = 100;
    }

    console.log('=== Calculating Infusion Protocol (Reference Method) ===');
    console.log('Target Dose:', targetDose, unit);
    console.log('Total Steps:', stepCountValue);
    console.log('Dilution Volume:', dilutionVolume, 'mL');

    // Calculate cumulative dose from all steps before last solution starts
    let cumulativeDose = 0;
    const lastSolutionNum = parseInt(document.getElementById(`step${stepCountValue}Solution`).value);

    // First pass: calculate cumulative dose before last solution
    for (let i = 1; i <= stepCountValue; i++) {
        const solutionNum = parseInt(document.getElementById(`step${i}Solution`).value);

        // Only process steps before last solution starts
        if (solutionNum < lastSolutionNum) {
            const rate = parseFloat(document.getElementById(`step${i}Rate`).value);
            const time = parseFloat(document.getElementById(`step${i}Time`).value);
            const concentration = parseFloat(document.getElementById(`solution${solutionNum}Conc`).value);

            const volume = (rate * time) / 60;
            const dose = volume * concentration;
            cumulativeDose += dose;
        }
    }

    // Update last solution concentration (Reference implementation)
    const correctedConcentration = (targetDose - cumulativeDose) / dilutionVolume;
    document.getElementById(`solution${lastSolutionNum}Conc`).value = correctedConcentration;

    console.log('Last Solution Concentration Correction:');
    console.log('  Cumulative dose before last solution:', cumulativeDose.toFixed(6), unit);
    console.log('  Remaining dose:', (targetDose - cumulativeDose).toFixed(6), unit);
    console.log('  Corrected concentration:', correctedConcentration.toFixed(6), unit + '/mL');

    // Second pass: calculate all steps including last solution's steps (except final step)
    cumulativeDose = 0;
    for (let i = 1; i < stepCountValue; i++) {
        const solutionNum = parseInt(document.getElementById(`step${i}Solution`).value);
        const rate = parseFloat(document.getElementById(`step${i}Rate`).value);
        const time = parseFloat(document.getElementById(`step${i}Time`).value);
        const concentration = parseFloat(document.getElementById(`solution${solutionNum}Conc`).value);

        if (!solutionNum || isNaN(rate) || isNaN(time) || isNaN(concentration)) {
            alert('Lütfen tüm basamak detaylarını doldurunuz.');
            return;
        }

        const volume = (rate * time) / 60;
        const dose = volume * concentration;
        cumulativeDose += dose;

        console.log(`Step ${i}: Sol=${solutionNum}, Rate=${rate}, Time=${time}, Vol=${volume.toFixed(3)}, Conc=${concentration.toFixed(6)}, Dose=${dose.toFixed(6)}, Cum=${cumulativeDose.toFixed(6)}`);
    }

    console.log('Cumulative dose before last step:', cumulativeDose.toFixed(6), unit);

    // Calculate last step (Reference implementation)
    const lastRate = parseFloat(document.getElementById(`step${stepCountValue}Rate`).value);
    const lastConcentration = parseFloat(document.getElementById(`solution${lastSolutionNum}Conc`).value);

    if (!lastRate || isNaN(lastRate) || !lastConcentration || isNaN(lastConcentration)) {
        alert('Lütfen son basamak detaylarını doldurunuz.');
        return;
    }

    // Calculate remaining dose and required volume for last step
    const remainingDose = targetDose - cumulativeDose;
    const requiredVolume = remainingDose / lastConcentration;
    const lastTime = (requiredVolume * 60) / lastRate;

    console.log('Last Step Calculation:');
    console.log('  Remaining dose:', remainingDose.toFixed(6), unit);
    console.log('  Last rate:', lastRate, 'mL/hr');
    console.log('  Last concentration:', lastConcentration.toFixed(6), 'mg/mL');
    console.log('  Required volume:', requiredVolume.toFixed(3), 'mL');
    console.log('  Calculated time:', lastTime.toFixed(2), 'minutes');

    document.getElementById(`step${stepCountValue}Time`).value = lastTime.toFixed(2);

    // Build results table
    cumulativeDose = 0;  // Reset for table display
    let totalTime = 0;

    let html = `
    <div class="results-section">
        <h3>İNFÜZYON UYGULAMA BASAMAKLARI</h3>
        <div class="overflow-x-auto">
        <table id="stepsTable">
            <thead>
                <tr>
                    <th>Basamak</th>
                    <th>Solüsyon</th>
                    <th>Hız (mL/saat)</th>
                    <th>Süre (dakika)</th>
                    <th>Hacim (mL)</th>
                    <th>Verilen Doz (${unit})</th>
                    <th>Kümülatif Doz (${unit})</th>
                </tr>
            </thead>
            <tbody>`;

    for (let i = 1; i <= stepCountValue; i++) {
        const solutionNum = document.getElementById(`step${i}Solution`).value;
        const rate = parseFloat(document.getElementById(`step${i}Rate`).value);
        const time = parseFloat(document.getElementById(`step${i}Time`).value);
        const concentration = parseFloat(document.getElementById(`solution${solutionNum}Conc`).value);

        const volume = (rate * time) / 60;
        const dose = volume * concentration;
        cumulativeDose += dose;
        totalTime += time;

        html += `
            <tr>
                <td>${i}</td>
                <td>${solutionNum}</td>
                <td>${formatNumber(rate, 2)}</td>
                <td>${formatNumber(time, 2)}</td>
                <td>${formatNumber(volume, 2)}</td>
                <td>${formatNumber(dose, 3)}</td>
                <td>${formatNumber(cumulativeDose, 3)}</td>
            </tr>`;
    }

    html += `
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        Toplam Süre: ${formatTime(totalTime)}<br>
                        Verilen Toplam Doz: ${formatNumber(cumulativeDose, 3)} ${unit}<br>
                        Hedef Doz: ${formatNumber(targetDose, 3)} ${unit}
                    </td>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>`;

    document.getElementById('resultSection').innerHTML = html;
    addExportButtons();
}

function calculateBolusStepDose(stepNumber) {
    const concentrationInput = document.getElementById(`step${stepNumber}Concentration`);
    const volumeInput = document.getElementById(`step${stepNumber}Volume`);
    const doseInput = document.getElementById(`step${stepNumber}Dose`);
    const targetDose = parseFloat(document.getElementById('targetDose').value);

    const concentration = parseFloat(concentrationInput.value);
    const volume = parseFloat(volumeInput.value);

    if (!isNaN(concentration) && !isNaN(volume)) {
        const dose = concentration * volume;
        let cumulativeDose = 0;

        // Calculate cumulative dose up to current step
        for (let i = 1; i <= stepNumber; i++) {
            if (i === stepNumber) {
                cumulativeDose += dose;
            } else {
                const prevDose = parseFloat(document.getElementById(`step${i}Dose`).value) || 0;
                cumulativeDose += prevDose;
            }
        }

        if (cumulativeDose > targetDose) {
            alert(`Uyarı: Bu değerler hedef dozu (${targetDose}) aşacak şekilde ${cumulativeDose.toFixed(3)} kümülatif doza neden olacak!`);
            volumeInput.value = '';
            doseInput.value = '';
            return;
        }

        doseInput.value = dose.toFixed(10);
    }
}

function calculateOralStepDose(stepNumber) {
    const concentrationInput = document.getElementById(`step${stepNumber}Concentration`);
    const volumeInput = document.getElementById(`step${stepNumber}Volume`);
    const doseInput = document.getElementById(`step${stepNumber}Dose`);
    const targetDose = parseFloat(document.getElementById('targetDose').value);

    const concentration = parseFloat(concentrationInput.value);
    const volume = parseFloat(volumeInput.value);

    if (!isNaN(concentration) && !isNaN(volume)) {
        const dose = concentration * volume;
        let cumulativeDose = 0;

        // Calculate cumulative dose up to current step
        for (let i = 1; i <= stepNumber; i++) {
            if (i === stepNumber) {
                cumulativeDose += dose;
            } else {
                const prevDose = parseFloat(document.getElementById(`step${i}Dose`).value) || 0;
                cumulativeDose += prevDose;
            }
        }

        if (cumulativeDose > targetDose) {
            alert(`Uyarı: Bu değerler hedef dozu (${targetDose}) aşacak şekilde ${cumulativeDose.toFixed(3)} kümülatif doza neden olacak!`);
            volumeInput.value = '';
            doseInput.value = '';
            return;
        }

        doseInput.value = dose.toFixed(10);
    }
}

function calculateSubcutanStepDose(stepNumber) {
    const dilutionRatioInput = document.getElementById(`step${stepNumber}DilutionRatio`);
    const volumeInput = document.getElementById(`step${stepNumber}Volume`);
    const doseInput = document.getElementById(`step${stepNumber}Dose`);
    const finalConcInput = document.getElementById(`step${stepNumber}FinalConc`);
    const targetDose = parseFloat(document.getElementById('targetDose').value);

    const dilutionRatio = parseFloat(dilutionRatioInput.value);
    const volume = parseFloat(volumeInput.value);
    const initialConc = parseFloat(document.getElementById('initialConcentration').value);

    if (!isNaN(dilutionRatio) && dilutionRatio > 0) {
        const finalConc = initialConc * (1/dilutionRatio);
        finalConcInput.value = Number(parseFloat(finalConc).toFixed(10)).toString();

        if (!isNaN(volume)) {
            const dose = finalConc * volume;
            let cumulativeDose = 0;

            // Calculate cumulative dose up to current step
            for (let i = 1; i <= stepNumber; i++) {
                if (i === stepNumber) {
                    cumulativeDose += dose;
                } else {
                    const prevDose = parseFloat(document.getElementById(`step${i}Dose`).value) || 0;
                    cumulativeDose += prevDose;
                }
            }

            if (cumulativeDose > targetDose) {
                alert(`Uyarı: Bu değerler hedef dozu (${targetDose}) aşacak şekilde ${cumulativeDose.toFixed(3)} kümülatif doza neden olacak!`);
                volumeInput.value = '';
                doseInput.value = '';
                return;
            }

            doseInput.value = dose.toFixed(10);
        }
    }
}

// Export functions
function exportToExcel() {
    const table = document.getElementById('stepsTable');
    if (!table) {
        alert('Önce protokolü hesaplayınız.');
        return;
    }

    const drugName = document.getElementById('drugName').value || 'protokol';
    const tableHTML = table.outerHTML;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/api/desensitization/export.php';
    form.target = '_blank';

    const exportTypeInput = document.createElement('input');
    exportTypeInput.type = 'hidden';
    exportTypeInput.name = 'export_type';
    exportTypeInput.value = 'excel';
    form.appendChild(exportTypeInput);

    const tableDataInput = document.createElement('input');
    tableDataInput.type = 'hidden';
    tableDataInput.name = 'table_data';
    tableDataInput.value = tableHTML;
    form.appendChild(tableDataInput);

    const drugNameInput = document.createElement('input');
    drugNameInput.type = 'hidden';
    drugNameInput.name = 'drug_name';
    drugNameInput.value = drugName;
    form.appendChild(drugNameInput);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}

function exportToWord() {
    const table = document.getElementById('stepsTable');
    if (!table) {
        alert('Önce protokolü hesaplayınız.');
        return;
    }

    const drugName = document.getElementById('drugName').value || 'protokol';
    const tableHTML = table.outerHTML;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/api/desensitization/export.php';
    form.target = '_blank';

    const exportTypeInput = document.createElement('input');
    exportTypeInput.type = 'hidden';
    exportTypeInput.name = 'export_type';
    exportTypeInput.value = 'word';
    form.appendChild(exportTypeInput);

    const tableDataInput = document.createElement('input');
    tableDataInput.type = 'hidden';
    tableDataInput.name = 'table_data';
    tableDataInput.value = tableHTML;
    form.appendChild(tableDataInput);

    const drugNameInput = document.createElement('input');
    drugNameInput.type = 'hidden';
    drugNameInput.name = 'drug_name';
    drugNameInput.value = drugName;
    form.appendChild(drugNameInput);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
