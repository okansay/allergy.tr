// SCORAD Index Calculator
console.log('🔬 SCORAD Index Calculator loaded');

let scoradValues = {
    ageGroup: 'adult',  // 'adult' (≥2 years) or 'child' (<2 years)
    bodyAreas: {  // Percentage of each body area affected (0-100%)
        head: 0,
        trunkAnterior: 0,
        trunkPosterior: 0,
        upperLimbRight: 0,
        upperLimbLeft: 0,
        lowerLimbRight: 0,
        lowerLimbLeft: 0,
        genitals: 0
    },
    A: 0,  // Extent (0-100%)
    B: { erythema: 0, edema: 0, oozing: 0, excoriation: 0, lichenification: 0, dryness: 0 },  // Intensity (0-3 each)
    C: { pruritus: 0, sleep: 0 }  // Subjective (0-10 each)
};

// Body surface area percentages by age group
const bsaPercentages = {
    adult: { // ≥2 years
        head: 9,
        trunkAnterior: 18,
        trunkPosterior: 18,
        upperLimbRight: 9,
        upperLimbLeft: 9,
        lowerLimbRight: 18,
        lowerLimbLeft: 18,
        genitals: 1
    },
    child: { // <2 years
        head: 21,
        trunkAnterior: 18,
        trunkPosterior: 18,
        upperLimbRight: 9,
        upperLimbLeft: 9,
        lowerLimbRight: 13.5,
        lowerLimbLeft: 13.5,
        genitals: 1
    }
};

const bodyAreaLabels = {
    head: 'Baş ve Boyun',
    trunkAnterior: 'Gövde Ön',
    trunkPosterior: 'Gövde Arka',
    upperLimbRight: 'Sağ Kol',
    upperLimbLeft: 'Sol Kol',
    lowerLimbRight: 'Sağ Bacak',
    lowerLimbLeft: 'Sol Bacak',
    genitals: 'Genital'
};

function initScoradCalculator() {
    renderScoradUI();
    calculateScorad();
}

function renderScoradUI() {
    const container = document.getElementById('scoradContainer');
    if (!container) return;

    container.innerHTML = `
        <!-- Age Group Selection -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-700 border border-blue-200 dark:border-slate-600 rounded-lg p-5">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">child_care</span>
                Yaş Grubu Seçimi
            </h3>
            <div class="flex gap-3">
                <button onclick="setAgeGroup('child')"
                    class="flex-1 py-3 px-4 rounded-lg font-semibold transition-all ${scoradValues.ageGroup === 'child' ? 'bg-primary text-white shadow-lg' : 'bg-white dark:bg-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-500'}">
                    < 2 Yaş
                </button>
                <button onclick="setAgeGroup('adult')"
                    class="flex-1 py-3 px-4 rounded-lg font-semibold transition-all ${scoradValues.ageGroup === 'adult' ? 'bg-primary text-white shadow-lg' : 'bg-white dark:bg-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-500'}">
                    ≥ 2 Yaş
                </button>
            </div>
        </div>

        <!-- A: Extent - Body Area Selection -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-5">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="bg-primary/10 text-primary px-2 py-1 rounded text-sm">A</span>
                Extent - Vücut Yüzey Alanı Tutulumu
            </h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Her bölgenin tutulum yüzdesini ayarlayın</p>

            <!-- Body Diagram Reference -->
            <div class="mb-4 p-3 bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-900/50 dark:to-slate-800/50 rounded-lg border border-slate-200 dark:border-slate-700">
                <div class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-2 text-center">
                    ${scoradValues.ageGroup === 'child' ? '< 2 Yaş' : '≥ 2 Yaş'} - Max BSA Değerleri
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                    ${Object.entries(bsaPercentages[scoradValues.ageGroup]).map(([area, percentage]) => `
                        <div class="flex items-center justify-between p-2 rounded bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600">
                            <span class="font-medium text-xs">${bodyAreaLabels[area]}</span>
                            <span class="font-bold text-primary">${percentage}%</span>
                        </div>
                    `).join('')}
                </div>
            </div>

            <!-- Body Area Sliders -->
            <div class="space-y-4 mb-4">
                ${Object.entries(bodyAreaLabels).map(([area, label]) => {
                    const maxPercentage = bsaPercentages[scoradValues.ageGroup][area];
                    const value = scoradValues.bodyAreas[area] || 0;
                    const percentage = maxPercentage === 0 ? 0 : (value / maxPercentage) * 100;
                    return `
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">${label}</span>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    Max: <span class="font-bold text-primary">${maxPercentage}%</span>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="range"
                                    min="0" max="${maxPercentage}" step="0.1"
                                    value="${value}"
                                    onchange="setBodyAreaPercentage('${area}', parseFloat(this.value))"
                                    oninput="setBodyAreaPercentage('${area}', parseFloat(this.value))"
                                    class="w-full h-2 bg-slate-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-8 [&::-webkit-slider-thumb]:h-8 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary [&::-webkit-slider-thumb]:cursor-pointer [&::-webkit-slider-thumb]:relative [&::-webkit-slider-thumb]:shadow-lg [&::-moz-range-thumb]:w-8 [&::-moz-range-thumb]:h-8 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:bg-primary [&::-moz-range-thumb]:border-0 [&::-moz-range-thumb]:cursor-pointer [&::-moz-range-thumb]:shadow-lg">
                                <div class="absolute -top-8 left-0 text-xs font-bold text-primary transition-all duration-150" style="left: ${percentage}%; transform: translateX(-50%);" id="area_${area}_label">
                                    ${value.toFixed(1)}%
                                </div>
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>

            <!-- Total Extent Display -->
            <div class="text-center p-4 bg-gradient-to-r from-primary/10 to-primary/5 rounded-lg border-2 border-primary/30">
                <div class="text-sm text-slate-600 dark:text-slate-400 mb-1">Toplam Tutulum (A)</div>
                <div class="text-4xl font-bold text-primary" id="extentValue">${scoradValues.A.toFixed(1)}%</div>
            </div>
        </div>

        <!-- B: Intensity with Buttons -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-5">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="bg-primary/10 text-primary px-2 py-1 rounded text-sm">B</span>
                Intensity - Şiddet Puanları (Temsilî Alan)
            </h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">En şiddetli olan temsilî alanı değerlendirin (0: Yok, 1: Hafif, 2: Orta, 3: Şiddetli)</p>
            <div class="space-y-3">
                ${renderIntensitySlider('erythema', 'Erythema (Eritem)')}
                ${renderIntensitySlider('edema', 'Edema/Papulation (Ödem/Papül)')}
                ${renderIntensitySlider('oozing', 'Oozing/Crusts (Sızıntı/Kabuk)')}
                ${renderIntensitySlider('excoriation', 'Excoriation (Ekskoriyasyon)')}
                ${renderIntensitySlider('lichenification', 'Lichenification (Likenifikasyon)')}
                ${renderIntensitySlider('dryness', 'Dryness (Kuru cilt - lezyonsuz alan)')}
            </div>
        </div>

        <!-- C: Subjective with Sliders -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-5">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="bg-primary/10 text-primary px-2 py-1 rounded text-sm">C</span>
                Subjective - Subjektif Semptomlar (Son 3 gün/gece)
            </h3>
            <div class="space-y-5">
                ${renderVASSlider('pruritus', 'Pruritus (Kaşıntı)', 0, 10)}
                ${renderVASSlider('sleep', 'Sleep Loss (Uyku Kaybı)', 0, 10)}
            </div>
        </div>
    `;
}

function renderIntensitySlider(id, label) {
    const value = scoradValues.B[id];
    const severityLabels = {
        0: { label: 'Yok', color: 'slate' },
        1: { label: 'Hafif', color: 'green' },
        2: { label: 'Orta', color: 'yellow' },
        3: { label: 'Şiddetli', color: 'red' }
    };

    return `
        <div class="p-4 rounded-lg bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900/50 dark:to-slate-800/50 border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">${label}</span>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-slate-500 dark:text-slate-400">Seçili:</span>
                    <span class="text-xl font-bold text-primary" id="intensity_${id}_value">${value}</span>
                </div>
            </div>
            <div class="grid grid-cols-4 gap-2">
                ${[0,1,2,3].map(val => {
                    const isActive = value === val;
                    const severity = severityLabels[val];
                    return `
                        <button
                            onclick="setIntensity('${id}', ${val})"
                            class="relative group flex flex-col items-center justify-center py-3 px-2 rounded-lg font-semibold transition-all duration-200 transform ${
                                isActive ?
                                `bg-${severity.color}-500 text-white shadow-lg scale-105 ring-2 ring-${severity.color}-400 ring-offset-2 dark:ring-offset-slate-800` :
                                `bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-${severity.color}-50 dark:hover:bg-slate-600 hover:scale-102 border-2 border-slate-200 dark:border-slate-600`
                            }">
                            <span class="text-2xl font-bold mb-1">${val}</span>
                            <span class="text-xs ${isActive ? 'text-white' : 'text-slate-500 dark:text-slate-400'}">${severity.label}</span>
                            ${isActive ? '<div class="absolute -top-1 -right-1 w-3 h-3 bg-white rounded-full border-2 border-' + severity.color + '-500"></div>' : ''}
                        </button>
                    `;
                }).join('')}
            </div>
        </div>
    `;
}

function renderVASSlider(id, label, min, max) {
    const value = scoradValues.C[id];
    return `
        <div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">${label}</span>
                <span class="text-3xl font-bold text-primary" id="vas_${id}_value">${value}</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 dark:text-slate-400 w-12">Hiç (${min})</span>
                <input type="range"
                    min="${min}" max="${max}" step="1"
                    value="${value}"
                    onchange="setVAS('${id}', parseInt(this.value))"
                    oninput="setVAS('${id}', parseInt(this.value))"
                    class="flex-1 h-2 bg-slate-200 dark:bg-slate-700 rounded-lg appearance-none cursor-pointer [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-6 [&::-webkit-slider-thumb]:h-6 [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-primary [&::-webkit-slider-thumb]:cursor-pointer [&::-moz-range-thumb]:w-6 [&::-moz-range-thumb]:h-6 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:bg-primary [&::-moz-range-thumb]:border-0 [&::-moz-range-thumb]:cursor-pointer">
                <span class="text-xs text-slate-500 dark:text-slate-400 w-16 text-right">Çok şiddetli (${max})</span>
            </div>
            <div class="flex justify-between mt-1 px-12">
                ${Array.from({length: max - min + 1}, (_, i) => i + min).map(v => `<span class="text-xs text-slate-400 ${value === v ? 'font-bold text-primary' : ''}">${v}</span>`).join('')}
            </div>
        </div>
    `;
}

function setAgeGroup(ageGroup) {
    scoradValues.ageGroup = ageGroup;
    scoradValues.bodyAreas = {  // Reset body areas when age changes
        head: 0,
        trunkAnterior: 0,
        trunkPosterior: 0,
        upperLimbRight: 0,
        upperLimbLeft: 0,
        lowerLimbRight: 0,
        lowerLimbLeft: 0,
        genitals: 0
    };
    calculateExtent();
    renderScoradUI();
    calculateScorad();
}

function setBodyAreaPercentage(area, percentage) {
    scoradValues.bodyAreas[area] = percentage;

    // Update label position and text
    const maxBSA = bsaPercentages[scoradValues.ageGroup][area];
    const position = maxBSA === 0 ? 0 : (percentage / maxBSA) * 100;

    const label = document.getElementById(`area_${area}_label`);
    if (label) {
        label.style.left = position + '%';
        label.textContent = percentage.toFixed(1) + '%';
    }

    calculateExtent();

    // Update total display
    const extentValue = document.getElementById('extentValue');
    if (extentValue) {
        extentValue.textContent = scoradValues.A.toFixed(1) + '%';
    }

    calculateScorad();
}

function calculateExtent() {
    let total = 0;

    Object.keys(scoradValues.bodyAreas).forEach(area => {
        const areaPercentage = scoradValues.bodyAreas[area] || 0;
        // Now the slider values are already in BSA percentage, just sum them up
        total += areaPercentage;
    });

    scoradValues.A = Math.min(100, total);
}

function setIntensity(id, value) {
    scoradValues.B[id] = value;
    // Re-render UI to update button states
    renderScoradUI();
    calculateScorad();
}

function setVAS(id, value) {
    scoradValues.C[id] = value;
    // Update value display without full re-render
    const valueEl = document.getElementById(`vas_${id}_value`);
    if (valueEl) valueEl.textContent = value;
    calculateScorad();
}

function calculateScorad() {
    const A = scoradValues.A;
    const B = Object.values(scoradValues.B).reduce((sum, val) => sum + val, 0);
    const C = Object.values(scoradValues.C).reduce((sum, val) => sum + val, 0);

    const total = (A / 5) + ((7 * B) / 2) + C;

    document.getElementById('displayA').textContent = A;
    document.getElementById('displayB').textContent = B;
    document.getElementById('displayC').textContent = C;

    updateScoreDisplay(total);
}

function updateScoreDisplay(score) {
    document.getElementById('totalScore').textContent = score.toFixed(1);
    document.getElementById('indicatorScore').textContent = score.toFixed(1);

    let severity = 'Mild';
    let color = 'green';
    if (score >= 50.1) {
        severity = 'Severe';
        color = 'red';
    } else if (score >= 25) {
        severity = 'Moderate';
        color = 'yellow';
    }

    const severityEl = document.getElementById('severityText');
    severityEl.textContent = severity;
    severityEl.className = `text-base sm:text-lg font-bold text-${color}-600 dark:text-${color}-400`;

    // Update indicator position
    const percentage = Math.min(100, (score / 103) * 100);
    document.getElementById('scoreIndicator').style.left = percentage + '%';
}

function resetScorad() {
    scoradValues = {
        ageGroup: 'adult',
        bodyAreas: {
            head: 0,
            trunkAnterior: 0,
            trunkPosterior: 0,
            upperLimbRight: 0,
            upperLimbLeft: 0,
            lowerLimbRight: 0,
            lowerLimbLeft: 0,
            genitals: 0
        },
        A: 0,
        B: { erythema: 0, edema: 0, oozing: 0, excoriation: 0, lichenification: 0, dryness: 0 },
        C: { pruritus: 0, sleep: 0 }
    };
    renderScoradUI();
    calculateScorad();
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('scoradContainer')) {
        initScoradCalculator();
    }
});

// Dynamic loading support
if (typeof window !== 'undefined') {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                const container = document.getElementById('scoradContainer');
                if (container && !container.hasAttribute('data-initialized')) {
                    container.setAttribute('data-initialized', 'true');
                    initScoradCalculator();
                }
            }
        });
    });

    setTimeout(function() {
        const targetNode = document.querySelector('.module-container') || document.body;
        observer.observe(targetNode, { childList: true, subtree: true });
    }, 100);
}
