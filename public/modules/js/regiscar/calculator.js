// RegiSCAR Score Calculator
console.log('🔬 RegiSCAR Score Calculator loaded');

// RegiSCAR scoring data
const regiscarData = {
    name: "RegiSCAR-DRESS",
    version: "1.0",
    scoreRange: { min: -4, max: 9 },
    finalInterpretation: [
        { min: -999, max: 1, label: "No case (excluded)", color: "green" },
        { min: 2, max: 3, label: "Possible DRESS", color: "yellow" },
        { min: 4, max: 5, label: "Probable DRESS", color: "orange" },
        { min: 6, max: 999, label: "Definite DRESS", color: "red" }
    ],
    criteria: [
        {
            id: "fever_385",
            label: "Ateş ≥ 38.5°C",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır veya Bilinmiyor", points: -1 },
                { value: "yes", label: "Evet", points: 0 }
            ],
            notes: "Akut dönem ateş. Yokluğu puan düşürür; varlığı ek puan vermez."
        },
        {
            id: "lymph_nodes",
            label: "Büyümüş Lenf Nodları",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır veya Bilinmiyor", points: 0 },
                { value: "yes", label: "Evet (≥1 cm, en az 2 farklı bölge)", points: 1 }
            ],
            notes: "≥1 cm ve en az 2 farklı anatomik bölge gereklidir."
        },
        {
            id: "eosinophilia",
            label: "Eozinofili",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır veya Bilinmiyor", points: 0 },
                { value: "mild", label: "Hafif (0.7-1.49 x10⁹/L veya %10-19.9)", points: 1 },
                { value: "severe", label: "Şiddetli (≥1.5 x10⁹/L veya ≥%20)", points: 2 }
            ],
            notes: "Lökopeni varsa (WBC<4.0) yüzde değerleri kullanılır."
        },
        {
            id: "atypical_lymphocytes",
            label: "Atipik Lenfositler",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır veya Bilinmiyor", points: 0 },
                { value: "yes", label: "Evet (yayma veya CBC flag)", points: 1 }
            ]
        },
        {
            id: "skin_extent",
            label: "Cilt Döküntüsü Yaygınlığı >%50 VYA",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır veya Bilinmiyor", points: 0 },
                { value: "yes", label: "Evet (>%50 vücut yüzey alanı)", points: 1 }
            ]
        },
        {
            id: "skin_suggestive",
            label: "DRESS'e Özgü Döküntü",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır", points: 0 },
                { value: "yes", label: "Evet (≥2 özellik)", points: 1 }
            ],
            notes: "En az 2 özellik: (i) bacaklar dışı purpura, (ii) infiltrasyon, (iii) yüz ödemi, (iv) psoriazifor deskuamasyon."
        },
        {
            id: "organ_liver",
            label: "Organ Tutulumu - Karaciğer",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır", points: 0 },
                { value: "yes", label: "Evet (ALT/AST/ALP/Bil >2xUNL)", points: 1 }
            ],
            notes: "ALT>2xUNL (2 kez) VEYA D-bil>2xUNL (2 kez) VEYA AST+T-bil+ALP hepsi >2xUNL (1 kez)"
        },
        {
            id: "organ_kidney",
            label: "Organ Tutulumu - Böbrek",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır", points: 0 },
                { value: "yes", label: "Evet (Kreatinin/Proteinüri/Hematüri)", points: 1 }
            ],
            notes: "Kreatinin >1.5x bazal (2 kez) VEYA proteinüri >1g/gün VEYA hematüri VEYA GFR azalması"
        },
        {
            id: "organ_lung",
            label: "Organ Tutulumu - Akciğer",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır", points: 0 },
                { value: "yes", label: "Evet (İnterstisyel tutulum/ABG)", points: 1 }
            ],
            notes: "BT/grafi interstisyel tutulum VEYA BAL/biyopsi anormal VEYA kan gazları anormal"
        },
        {
            id: "organ_muscle_heart",
            label: "Organ Tutulumu - Kas/Kalp",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır", points: 0 },
                { value: "yes", label: "Evet (CPK/Troponin/EKG/EKO)", points: 1 }
            ],
            notes: "CPK>2xUNL VEYA CPK-MM/MB yüksek VEYA Troponin-T>0.01 VEYA görüntüleme/EKG anormal"
        },
        {
            id: "organ_pancreas",
            label: "Organ Tutulumu - Pankreas",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır", points: 0 },
                { value: "yes", label: "Evet (Amilaz/Lipaz >2xUNL)", points: 1 }
            ]
        },
        {
            id: "organ_other",
            label: "Organ Tutulumu - Diğer",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır", points: 0 },
                { value: "yes", label: "Evet (Dalak/Tiroid/SSS/GİS)", points: 1 }
            ]
        },
        {
            id: "resolution_15d",
            label: "Döküntü Rezolüsyon Süresi ≥15 Gün",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır (<15 gün)", points: -1 },
                { value: "yes", label: "Evet (≥15 gün) veya Bilinmiyor", points: 0 }
            ],
            notes: "15 günden kısa sürede düzelme DRESS'e aykırıdır ve -1 puan verir."
        },
        {
            id: "exclude_other",
            label: "Diğer Nedenlerin Dışlanması",
            type: "single_choice",
            options: [
                { value: "no", label: "Hayır veya <3 test", points: 0 },
                { value: "yes", label: "Evet (≥3 test negatif)", points: 1 }
            ],
            notes: "En az 3 test (HAV, HBV, HCV, Mycoplasma/Chlamydia, ANA, kan kültürü) yapılmış ve hepsi negatif ise +1."
        }
    ]
};

// State management
let currentScores = {};
let organScores = [];

// Initialize calculator
function initRegiscarCalculator() {
    renderCriteria();
    calculateScore();
}

// Render all criteria
function renderCriteria() {
    const container = document.getElementById('criteriaContainer');
    if (!container) return;

    let html = '';

    regiscarData.criteria.forEach((criterion, index) => {
        const isOrgan = criterion.id.startsWith('organ_');

        html += `
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-4 sm:p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start gap-3 mb-4">
                    <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="text-primary font-bold text-sm">${index + 1}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white mb-1 break-words">
                            ${criterion.label}
                        </h3>
                        ${criterion.notes ? `
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                <span class="material-symbols-outlined text-sm align-middle">info</span>
                                ${criterion.notes}
                            </p>
                        ` : ''}
                    </div>
                </div>

                <div class="space-y-2">
                    ${criterion.options.map(option => `
                        <label class="flex items-center gap-3 p-3 rounded-lg border-2 cursor-pointer transition-all
                            ${currentScores[criterion.id] === option.value ?
                                'border-primary bg-primary/5 dark:bg-primary/10' :
                                'border-slate-200 dark:border-slate-700 hover:border-primary/50 dark:hover:border-primary/50'
                            }">
                            <input
                                type="radio"
                                name="${criterion.id}"
                                value="${option.value}"
                                onchange="handleSelection('${criterion.id}', '${option.value}', ${option.points}, ${isOrgan})"
                                ${currentScores[criterion.id] === option.value ? 'checked' : ''}
                                class="w-5 h-5 text-primary focus:ring-primary focus:ring-2"
                            />
                            <div class="flex-1">
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-200">${option.label}</span>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-bold ${
                                option.points > 0 ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' :
                                option.points < 0 ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' :
                                'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300'
                            }">
                                ${option.points >= 0 ? '+' : ''}${option.points}
                            </span>
                        </label>
                    `).join('')}
                </div>

                ${isOrgan ? `
                    <div class="mt-2 text-xs text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 p-2 rounded">
                        ⚠️ Organ tutulumundan maksimum 2 puan alınabilir
                    </div>
                ` : ''}
            </div>
        `;
    });

    container.innerHTML = html;
}

// Handle selection change
function handleSelection(criterionId, value, points, isOrgan) {
    currentScores[criterionId] = value;

    // Track organ scores separately
    if (isOrgan) {
        const index = organScores.findIndex(item => item.id === criterionId);
        if (index !== -1) {
            organScores[index].points = points;
        } else {
            organScores.push({ id: criterionId, points: points });
        }
    }

    calculateScore();
}

// Calculate total score
function calculateScore() {
    let total = 0;
    let organPoints = 0;

    // Calculate organ points (capped at 2)
    organScores.forEach(organ => {
        organPoints += organ.points;
    });
    organPoints = Math.min(organPoints, 2); // Cap at 2 points

    // Calculate non-organ points
    Object.keys(currentScores).forEach(criterionId => {
        const criterion = regiscarData.criteria.find(c => c.id === criterionId);
        if (criterion && !criterion.id.startsWith('organ_')) {
            const selectedOption = criterion.options.find(opt => opt.value === currentScores[criterionId]);
            if (selectedOption) {
                total += selectedOption.points;
            }
        }
    });

    // Add capped organ points
    total += organPoints;

    // Update display
    updateScoreDisplay(total);
}

// Update score display
function updateScoreDisplay(score) {
    console.log('🔬 RegiSCAR updateScoreDisplay called with score:', score);

    // Update score text
    const scoreElements = document.querySelectorAll('#totalScore');
    scoreElements.forEach(el => el.textContent = score);

    const indicatorScore = document.getElementById('indicatorScore');
    if (indicatorScore) {
        indicatorScore.textContent = score;
    }

    // Find interpretation
    const interpretation = regiscarData.finalInterpretation.find(
        interp => score >= interp.min && score <= interp.max
    );

    console.log('🔬 Found interpretation:', interpretation);

    if (interpretation) {
        const interpretationEl = document.getElementById('interpretationText');
        console.log('🔬 interpretationText element:', interpretationEl);

        if (interpretationEl) {
            console.log('🔬 Setting text to:', interpretation.label, 'and color:', interpretation.color);
            interpretationEl.textContent = interpretation.label;
            // Set className directly like SCORAD does (more reliable with Tailwind JIT)
            interpretationEl.className = `text-base sm:text-lg font-bold text-${interpretation.color}-600 dark:text-${interpretation.color}-400`;
            console.log('🔬 New className:', interpretationEl.className);
        } else {
            console.error('🔬 interpretationText element NOT FOUND!');
        }
    } else {
        console.error('🔬 No interpretation found for score:', score);
    }

    // Update indicator position on bar
    const indicator = document.getElementById('scoreIndicator');
    if (indicator) {
        // Score range: -4 to +9 (total 14 points)
        const minScore = -4;
        const maxScore = 9;
        const range = maxScore - minScore; // 13

        // Normalize score to 0-100%
        let percentage = ((score - minScore) / range) * 100;

        // Clamp to 0-100%
        percentage = Math.max(0, Math.min(100, percentage));

        indicator.style.left = percentage + '%';
    }
}

// Reset score
function resetScore() {
    currentScores = {};
    organScores = [];

    // Uncheck all radio buttons
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.checked = false;
    });

    renderCriteria();
    calculateScore();
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('criteriaContainer')) {
        initRegiscarCalculator();
    }
});

// Also watch for dynamic module loading
if (typeof window !== 'undefined') {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                const container = document.getElementById('criteriaContainer');
                if (container && !container.hasAttribute('data-initialized')) {
                    container.setAttribute('data-initialized', 'true');
                    initRegiscarCalculator();
                }
            }
        });
    });

    setTimeout(function() {
        const targetNode = document.querySelector('.module-container') || document.body;
        observer.observe(targetNode, { childList: true, subtree: true });
    }, 100);
}
