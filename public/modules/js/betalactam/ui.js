// Beta-Lactam Cross-Reactivity UI
console.log('🔬 Beta-Lactam Cross-Reactivity Module loaded');

// Initialize the module
function initBetalactamModule() {
    populateDrugDropdown();

    const drugSelect = document.getElementById('selectedDrug');
    if (drugSelect) {
        drugSelect.addEventListener('change', handleDrugSelection);
    }
}

// Populate the drug dropdown with grouped options
function populateDrugDropdown() {
    const drugSelect = document.getElementById('selectedDrug');
    if (!drugSelect) return;

    // Group drugs by category
    const groupedDrugs = {};
    betalactamData.drugs.forEach(drug => {
        if (!groupedDrugs[drug.group]) {
            groupedDrugs[drug.group] = [];
        }
        groupedDrugs[drug.group].push(drug);
    });

    // Sort groups in logical order
    const groupOrder = [
        'Penicillins',
        'Cephalosporins (1st Gen)',
        'Cephalosporins (2nd Gen)',
        'Cephalosporins (3rd Gen)',
        'Cephalosporins (4th Gen)',
        'Cephalosporins (5th Gen)',
        'Monobactam'
    ];

    // Build dropdown HTML
    let html = '<option value="">İlaç seçin...</option>';

    groupOrder.forEach(groupName => {
        if (groupedDrugs[groupName]) {
            html += `<optgroup label="${groupName}">`;
            groupedDrugs[groupName].forEach(drug => {
                html += `<option value="${drug.id}">${drug.name}</option>`;
            });
            html += '</optgroup>';
        }
    });

    drugSelect.innerHTML = html;
}

// Handle drug selection
function handleDrugSelection(event) {
    const selectedDrugId = event.target.value;
    const resultsContainer = document.getElementById('crossReactivityResults');

    if (!selectedDrugId) {
        resultsContainer.innerHTML = '';
        return;
    }

    const selectedDrug = betalactamData.drugs.find(d => d.id === selectedDrugId);
    if (!selectedDrug) return;

    displayCrossReactivity(selectedDrug);
}

// Display cross-reactivity results
function displayCrossReactivity(selectedDrug) {
    const resultsContainer = document.getElementById('crossReactivityResults');
    const crossReactions = betalactamData.crossReactivity[selectedDrug.id] || {};

    // Categorize drugs by similarity level
    const categorized = {
        high: [],      // R1, R2, R1r2, r1R2, R1', R1'', R1'r2, R1''r2
        moderate: [],  // r1, r2, r1r2, r1'r2, r1'R2, r1', r1''
        low: []        // '' (no similarity)
    };

    betalactamData.drugs.forEach(drug => {
        if (drug.id === selectedDrug.id) return; // Skip self

        const similarity = crossReactions[drug.id] || '';

        // Categorize based on similarity level
        if (['R1', 'R2', 'R1r2', 'r1R2', "R1'", "R1''", "R1'r2", "R1''r2"].includes(similarity)) {
            categorized.high.push({ drug, similarity });
        } else if (similarity === '') {
            categorized.low.push({ drug, similarity });
        } else {
            categorized.moderate.push({ drug, similarity });
        }
    });

    // Build HTML with prominent drug name banner
    let html = `
        <div class="bg-gradient-to-r from-primary to-blue-600 rounded-xl p-8 mb-6 shadow-lg">
            <div class="text-center">
                <div class="inline-block bg-white/20 backdrop-blur-sm px-4 py-2 rounded-lg mb-4">
                    <p class="text-white/90 text-sm font-semibold uppercase tracking-wider">Seçilen İlaç</p>
                </div>
                <h2 class="text-4xl font-bold text-white mb-3 drop-shadow-lg">
                    ${selectedDrug.name}
                </h2>
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-6 py-2 rounded-full">
                    <span class="material-symbols-outlined text-white text-lg">category</span>
                    <p class="text-white font-semibold">${selectedDrug.group}</p>
                </div>
                ${selectedDrug.commonlyUsed ? `
                    <div class="mt-3">
                        <span class="inline-flex items-center gap-1 bg-yellow-400 text-yellow-900 px-3 py-1 rounded-full text-sm font-bold">
                            <span class="material-symbols-outlined text-base">star</span>
                            Sık Kullanılan İlaç
                        </span>
                    </div>
                ` : ''}
            </div>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-2xl">info</span>
                <div>
                    <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-2">
                        Çapraz Reaksiyon Analizi
                    </h3>
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        Aşağıda <strong>${selectedDrug.name}</strong> ile diğer beta-laktam antibiyotikler arasındaki
                        yapısal benzerlikler ve çapraz reaksiyon riskleri gösterilmektedir.
                    </p>
                </div>
            </div>
        </div>`;

    // High risk section
    if (categorized.high.length > 0) {
        html += buildRiskSection(
            'Yüksek Risk - Çapraz Reaksiyon İhtimali Yüksek',
            categorized.high,
            'red',
            'Bu ilaçlar ile seçilen ilaç arasında güçlü yapısal benzerlik vardır. Çapraz reaksiyon riski yüksektir.'
        );
    }

    // Moderate risk section
    if (categorized.moderate.length > 0) {
        html += buildRiskSection(
            'Orta Risk - Çapraz Reaksiyon İhtimali Orta',
            categorized.moderate,
            'yellow',
            'Bu ilaçlar ile seçilen ilaç arasında kısmi yapısal benzerlik vardır. Çapraz reaksiyon riski orta düzeydedir.'
        );
    }

    // Low risk section (no similarity)
    if (categorized.low.length > 0) {
        html += buildRiskSection(
            'Düşük Risk - Yapısal Benzerlik Yok',
            categorized.low,
            'green',
            'Bu ilaçlar ile seçilen ilaç arasında R1 veya R2 yapısal benzerliği yoktur. Çapraz reaksiyon riski düşüktür.'
        );
    }

    resultsContainer.innerHTML = html;
}

// Build a risk section
function buildRiskSection(title, drugs, colorScheme, description) {
    const colors = {
        red: {
            bg: 'bg-red-50 dark:bg-red-900/20',
            border: 'border-red-200 dark:border-red-800',
            title: 'text-red-900 dark:text-red-100',
            badge: 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 border-red-300 dark:border-red-700',
            icon: '⚠️'
        },
        yellow: {
            bg: 'bg-yellow-50 dark:bg-yellow-900/20',
            border: 'border-yellow-200 dark:border-yellow-800',
            title: 'text-yellow-900 dark:text-yellow-100',
            badge: 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200 border-yellow-300 dark:border-yellow-700',
            icon: '⚡'
        },
        green: {
            bg: 'bg-green-50 dark:bg-green-900/20',
            border: 'border-green-200 dark:border-green-800',
            title: 'text-green-900 dark:text-green-100',
            badge: 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 border-green-300 dark:border-green-700',
            icon: '✓'
        }
    };

    const c = colors[colorScheme];

    let html = `
        <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <span class="text-2xl">${c.icon}</span>
                <h4 class="text-lg font-bold text-slate-900 dark:text-white">${title}</h4>
                <span class="ml-auto px-3 py-1 rounded-full text-sm font-semibold ${c.badge} border">
                    ${drugs.length} ilaç
                </span>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">${description}</p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">`;

    drugs.forEach(({ drug, similarity }) => {
        const similarityInfo = betalactamData.similarityLevels[similarity];
        const cardColor = similarity === '' ? c.bg : `${c.bg}`;

        html += `
            <div class="${cardColor} ${c.border} border rounded-lg p-4 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-2">
                    <h5 class="font-semibold text-slate-900 dark:text-white text-sm">${drug.name}</h5>
                    ${drug.commonlyUsed ? '<span class="text-xs bg-blue-500 text-white px-2 py-0.5 rounded">Sık Kullanılan</span>' : ''}
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-400 mb-2">${drug.group}</p>
                ${similarity !== '' ? `
                    <div class="mt-2 pt-2 border-t ${c.border}">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-semibold ${c.title}">${similarityInfo.label}</span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400">${similarityInfo.description}</p>
                    </div>
                ` : ''}
            </div>`;
    });

    html += `
            </div>
        </div>`;

    return html;
}

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the beta-lactam cross-reactivity page
    if (document.getElementById('selectedDrug')) {
        initBetalactamModule();
    }
});

// Also watch for dynamic module loading (for Alpine.js x-html)
if (typeof window !== 'undefined') {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                const drugSelect = document.getElementById('selectedDrug');
                if (drugSelect && !drugSelect.hasAttribute('data-initialized')) {
                    drugSelect.setAttribute('data-initialized', 'true');
                    initBetalactamModule();
                }
            }
        });
    });

    // Start observing after a short delay to ensure Alpine has loaded
    setTimeout(function() {
        const targetNode = document.querySelector('.module-container') || document.body;
        observer.observe(targetNode, { childList: true, subtree: true });
    }, 100);
}
