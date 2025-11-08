// SCORAD Index Calculator
console.log('🔬 SCORAD Index Calculator loaded');

let scoradValues = {
    A: 0,  // Extent (0-100%)
    B: { erythema: 0, edema: 0, oozing: 0, excoriation: 0, lichenification: 0, dryness: 0 },  // Intensity (0-3 each)
    C: { pruritus: 0, sleep: 0 }  // Subjective (0-10 each)
};

function initScoradCalculator() {
    renderScoradUI();
    calculateScorad();
}

function renderScoradUI() {
    const container = document.getElementById('scoradContainer');
    if (!container) return;

    container.innerHTML = `
        <!-- A: Extent -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-5">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="bg-primary/10 text-primary px-2 py-1 rounded text-sm">A</span>
                Extent - Vücut Yüzey Alanı Tutulumu
            </h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Tutulum yüzdesi (0-100%)</p>
            <div class="flex items-center gap-4">
                <button onclick="changeExtent(-10)" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors font-semibold">-10</button>
                <button onclick="changeExtent(-5)" class="px-3 py-2 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors font-semibold">-5</button>
                <button onclick="changeExtent(-1)" class="px-3 py-2 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors font-semibold">-1</button>
                <div class="flex-1 text-center">
                    <div class="text-4xl font-bold text-primary" id="extentValue">0</div>
                    <div class="text-sm text-slate-500">%</div>
                </div>
                <button onclick="changeExtent(1)" class="px-3 py-2 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors font-semibold">+1</button>
                <button onclick="changeExtent(5)" class="px-3 py-2 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors font-semibold">+5</button>
                <button onclick="changeExtent(10)" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors font-semibold">+10</button>
            </div>
        </div>

        <!-- B: Intensity -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-5">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="bg-primary/10 text-primary px-2 py-1 rounded text-sm">B</span>
                Intensity - Şiddet Puanları (Temsilî Alan)
            </h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Her bulgu için 0-3 arası seçin</p>
            <div class="space-y-3">
                ${renderIntensityItem('erythema', 'Erythema (Eritem)')}
                ${renderIntensityItem('edema', 'Edema/Papulation (Ödem/Papül)')}
                ${renderIntensityItem('oozing', 'Oozing/Crusts (Sızıntı/Kabuk)')}
                ${renderIntensityItem('excoriation', 'Excoriation (Ekskoriyasyon)')}
                ${renderIntensityItem('lichenification', 'Lichenification (Likenifikasyon)')}
                ${renderIntensityItem('dryness', 'Dryness (Kuru cilt - lezyonsuz alan)')}
            </div>
        </div>

        <!-- C: Subjective -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-5">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="bg-primary/10 text-primary px-2 py-1 rounded text-sm">C</span>
                Subjective - Subjektif Semptomlar (Son 3 gün/gece)
            </h3>
            <div class="space-y-4">
                ${renderVASItem('pruritus', 'Pruritus (Kaşıntı)', 0, 10)}
                ${renderVASItem('sleep', 'Sleep Loss (Uyku Kaybı)', 0, 10)}
            </div>
        </div>
    `;
}

function renderIntensityItem(id, label) {
    return `
        <div class="flex items-center justify-between gap-2 p-3 rounded-lg bg-slate-50 dark:bg-slate-900/50">
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300 flex-1">${label}</span>
            <div class="flex gap-1">
                ${[0,1,2,3].map(val => `
                    <button
                        onclick="setIntensity('${id}', ${val})"
                        id="btn_${id}_${val}"
                        class="w-12 h-10 rounded-lg font-semibold text-sm transition-colors ${
                            scoradValues.B[id] === val ?
                            'bg-primary text-white' :
                            'bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600'
                        }">
                        ${val}
                    </button>
                `).join('')}
            </div>
        </div>
    `;
}

function renderVASItem(id, label, min, max) {
    return `
        <div>
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-slate-700 dark:text-slate-300">${label}</span>
                <span class="text-2xl font-bold text-primary" id="vas_${id}_value">0</span>
            </div>
            <div class="flex gap-1">
                ${Array.from({length: max - min + 1}, (_, i) => i + min).map(val => `
                    <button
                        onclick="setVAS('${id}', ${val})"
                        id="vas_${id}_${val}"
                        class="flex-1 h-12 rounded-lg font-semibold text-xs transition-colors ${
                            scoradValues.C[id] === val ?
                            'bg-primary text-white' :
                            'bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-600'
                        }">
                        ${val}
                    </button>
                `).join('')}
            </div>
        </div>
    `;
}

function changeExtent(delta) {
    scoradValues.A = Math.max(0, Math.min(100, scoradValues.A + delta));
    document.getElementById('extentValue').textContent = scoradValues.A;
    calculateScorad();
}

function setIntensity(id, value) {
    scoradValues.B[id] = value;
    renderScoradUI();
    calculateScorad();
}

function setVAS(id, value) {
    scoradValues.C[id] = value;
    renderScoradUI();
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
