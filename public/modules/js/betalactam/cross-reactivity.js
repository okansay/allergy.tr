// Beta-Lactam Cross-Reactivity Calculator
console.log('🧬 Beta-Lactam Cross-Reactivity module loaded');

// Get all drugs as a flat list
function getAllDrugs() {
    const allDrugs = [];
    for (const category in betalactamDrugs) {
        betalactamDrugs[category].forEach(drug => {
            allDrugs.push({
                ...drug,
                category: category
            });
        });
    }
    return allDrugs;
}

// Get similarity between two drugs
function getSimilarity(drug1, drug2) {
    // Try both orders
    const key1 = `${drug1}|${drug2}`;
    const key2 = `${drug2}|${drug1}`;

    return crossReactivityMatrix[key1] || crossReactivityMatrix[key2] || null;
}

// Get category display name
function getCategoryName(category) {
    const names = {
        'penicillins': 'Penisilinler',
        'cephalosporins1st': 'Sefalosporinler (1. Jenerasyon)',
        'cephalosporins2nd': 'Sefalosporinler (2. Jenerasyon)',
        'cephalosporins3rd': 'Sefalosporinler (3. Jenerasyon)',
        'cephalosporins4th': 'Sefalosporinler (4. Jenerasyon)',
        'cephalosporins5th': 'Sefalosporinler (5. Jenerasyon)',
        'monobactam': 'Monobaktam'
    };
    return names[category] || category;
}

// Get similarity explanation
function getSimilarityExplanation(similarity) {
    const explanations = {
        'R1': { text: 'Aynı R1 yapısı', color: 'bg-orange-500', risk: 'Yüksek' },
        'R2': { text: 'Aynı R2 yapısı', color: 'bg-yellow-500', risk: 'Yüksek' },
        'R1\'': { text: 'R1 yapısının bir kısmı aynı (halka veya yan zincir)', color: 'bg-orange-400', risk: 'Orta-Yüksek' },
        'R1\'\'': { text: 'R1 yapısının diğer bir kısmı aynı', color: 'bg-orange-400', risk: 'Orta-Yüksek' },
        'R2\'': { text: 'R2 yapısının bir kısmı aynı', color: 'bg-yellow-400', risk: 'Orta-Yüksek' },
        'r1': { text: 'Benzer R1 yapısı', color: 'bg-orange-300', risk: 'Orta' },
        'r2': { text: 'Benzer R2 yapısı', color: 'bg-yellow-300', risk: 'Orta' },
        'r1\'': { text: 'R1 yapısının bir kısmı benzer (halka veya yan zincir)', color: 'bg-orange-200', risk: 'Düşük-Orta' },
        'r1\'\'': { text: 'R1 yapısının diğer bir kısmı benzer', color: 'bg-orange-200', risk: 'Düşük-Orta' },
        'r2\'': { text: 'R2 yapısının bir kısmı benzer', color: 'bg-yellow-200', risk: 'Düşük-Orta' },
        'R1r2': { text: 'Aynı R1 ve benzer R2 yapısı', color: 'bg-gradient-to-r from-orange-500 to-yellow-300', risk: 'Yüksek' },
        'r1R2': { text: 'Benzer R1 ve aynı R2 yapısı', color: 'bg-gradient-to-r from-orange-300 to-yellow-500', risk: 'Yüksek' },
        'r1r2': { text: 'Benzer R1 ve R2 yapısı', color: 'bg-gradient-to-r from-orange-300 to-yellow-300', risk: 'Orta' },
        'R1\'r2': { text: 'R1 yapısının bir kısmı aynı, benzer R2', color: 'bg-gradient-to-r from-orange-400 to-yellow-300', risk: 'Orta-Yüksek' },
        'r1\'R2': { text: 'R1 yapısının bir kısmı benzer, aynı R2', color: 'bg-gradient-to-r from-orange-200 to-yellow-500', risk: 'Orta-Yüksek' },
        'r1\'r2': { text: 'R1 ve R2 yapılarının kısımları benzer', color: 'bg-gradient-to-r from-orange-200 to-yellow-200', risk: 'Düşük-Orta' },
        'R1\'R2': { text: 'R1 ve R2 yapılarının kısımları aynı', color: 'bg-gradient-to-r from-orange-400 to-yellow-500', risk: 'Yüksek' },
        'R1\'\'r2': { text: 'R1 yapısının diğer kısmı aynı, benzer R2', color: 'bg-gradient-to-r from-orange-400 to-yellow-300', risk: 'Orta-Yüksek' },
        'R1\'\'R2': { text: 'R1 yapısının diğer kısmı aynı, aynı R2', color: 'bg-gradient-to-r from-orange-400 to-yellow-500', risk: 'Yüksek' }
    };

    return explanations[similarity] || { text: 'Bilinmeyen benzerlik', color: 'bg-gray-400', risk: 'Bilinmiyor' };
}

// Populate drug dropdown
function populateDrugDropdown() {
    const dropdown = document.getElementById('drugSelect');
    if (!dropdown) return;

    const allDrugs = getAllDrugs();

    // Group by category
    let currentCategory = null;
    allDrugs.forEach(drug => {
        if (drug.category !== currentCategory) {
            const optgroup = document.createElement('optgroup');
            optgroup.label = getCategoryName(drug.category);
            dropdown.appendChild(optgroup);
            currentCategory = drug.category;
        }

        const option = document.createElement('option');
        option.value = drug.name;
        option.textContent = drug.name;
        dropdown.lastChild.appendChild(option);
    });
}

// Display cross-reactivity results
function displayCrossReactivity(selectedDrug) {
    const resultsContainer = document.getElementById('resultsContainer');
    if (!resultsContainer) return;

    if (!selectedDrug) {
        resultsContainer.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 py-8">Lütfen bir ilaç seçin</div>';
        return;
    }

    const allDrugs = getAllDrugs();
    const similarDrugs = [];
    const noSimilarityDrugs = [];

    allDrugs.forEach(drug => {
        if (drug.name === selectedDrug) return; // Skip self

        const similarity = getSimilarity(selectedDrug, drug.name);

        if (similarity) {
            similarDrugs.push({
                ...drug,
                similarity: similarity,
                info: getSimilarityExplanation(similarity)
            });
        } else {
            noSimilarityDrugs.push(drug);
        }
    });

    // Sort by risk level
    const riskOrder = { 'Yüksek': 0, 'Orta-Yüksek': 1, 'Orta': 2, 'Düşük-Orta': 3, 'Düşük': 4 };
    similarDrugs.sort((a, b) => (riskOrder[a.info.risk] || 99) - (riskOrder[b.info.risk] || 99));

    let html = '';

    // Similar drugs section
    if (similarDrugs.length > 0) {
        html += `
        <div class="mb-8">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                <span class="material-symbols-outlined align-middle text-red-500">warning</span>
                Yapısal Benzerliği Olan İlaçlar (${similarDrugs.length})
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Bu ilaçlar <strong>${selectedDrug}</strong> ile yapısal benzerlik gösterir ve çapraz reaksiyon riski vardır.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        `;

        similarDrugs.forEach(drug => {
            html += `
            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 ${drug.info.color} bg-opacity-10">
                <div class="flex items-start justify-between mb-2">
                    <h4 class="font-bold text-gray-900 dark:text-white">${drug.name}</h4>
                    <span class="px-2 py-1 text-xs font-semibold rounded ${drug.info.color} text-white">
                        ${drug.info.risk}
                    </span>
                </div>
                <p class="text-sm text-gray-700 dark:text-gray-300 mb-1">
                    <span class="font-semibold">Benzerlik:</span> <code class="bg-gray-200 dark:bg-gray-700 px-1 rounded">${drug.similarity}</code>
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    ${drug.info.text}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">
                    ${getCategoryName(drug.category)}
                </p>
            </div>
            `;
        });

        html += `
            </div>
        </div>
        `;
    }

    // No similarity drugs section
    if (noSimilarityDrugs.length > 0) {
        html += `
        <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                <span class="material-symbols-outlined align-middle text-green-500">check_circle</span>
                Yapısal Benzerliği Olmayan İlaçlar (${noSimilarityDrugs.length})
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Bu ilaçlar <strong>${selectedDrug}</strong> ile R1/R2 pozisyonunda yapısal benzerlik göstermez. Çapraz reaksiyon riski daha düşüktür.
            </p>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
        `;

        noSimilarityDrugs.forEach(drug => {
            html += `
            <div class="border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 rounded-lg p-3">
                <p class="font-semibold text-gray-900 dark:text-white text-sm">${drug.name}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${getCategoryName(drug.category)}</p>
            </div>
            `;
        });

        html += `
            </div>
        </div>
        `;
    }

    resultsContainer.innerHTML = html;
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    populateDrugDropdown();

    const drugSelect = document.getElementById('drugSelect');
    if (drugSelect) {
        drugSelect.addEventListener('change', function() {
            displayCrossReactivity(this.value);
        });
    }
});
