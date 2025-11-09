// Skin Test Concentrations UI
console.log('🧪 Skin Test Concentrations Module loaded');

let searchTimeout = null;
let selectedDrug = null;

// Initialize the module
function initSkinTestModule() {
    populateDropdown();
    setupSearchInput();
    setupDropdown();
    renderCategoryButtons();
}

// Populate the grouped dropdown
function populateDropdown() {
    const dropdown = document.getElementById('drugDropdown');
    if (!dropdown) return;

    // Group drugs by category
    const groupedDrugs = {};
    allDrugs.forEach(drug => {
        const category = drug.category;
        if (!groupedDrugs[category]) {
            groupedDrugs[category] = [];
        }
        groupedDrugs[category].push(drug);
    });

    // Sort categories
    const sortedCategories = Object.keys(groupedDrugs).sort();

    // Build dropdown HTML
    let html = '<option value="">İlaç seçin...</option>';

    sortedCategories.forEach(category => {
        html += `<optgroup label="${category}">`;
        // Sort drugs within category alphabetically
        groupedDrugs[category]
            .sort((a, b) => a.name.localeCompare(b.name, 'tr'))
            .forEach(drug => {
                html += `<option value="${drug.id}">${drug.name}</option>`;
            });
        html += '</optgroup>';
    });

    dropdown.innerHTML = html;
}

// Setup dropdown selection
function setupDropdown() {
    const dropdown = document.getElementById('drugDropdown');
    if (!dropdown) return;

    dropdown.addEventListener('change', (e) => {
        const drugId = e.target.value;
        if (drugId) {
            selectDrug(drugId);
            // Clear search input
            const searchInput = document.getElementById('drugSearch');
            if (searchInput) {
                searchInput.value = '';
                clearSearchResults();
            }
        } else {
            clearDrugDetails();
        }
    });
}

// Setup search input with debounce
function setupSearchInput() {
    const searchInput = document.getElementById('drugSearch');
    if (!searchInput) return;

    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.trim();
        const clearBtn = document.getElementById('clearSearch');

        // Show/hide clear button
        if (clearBtn) {
            if (query.length > 0) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
            }
        }

        // Clear previous timeout
        if (searchTimeout) {
            clearTimeout(searchTimeout);
        }

        // Only search if 3 or more characters
        if (query.length >= 3) {
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300); // 300ms debounce
        } else {
            clearSearchResults();
        }
    });

    // Clear button
    const clearBtn = document.getElementById('clearSearch');
    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            searchInput.value = '';
            clearSearchResults();
            clearDrugDetails();
            clearBtn.classList.add('hidden');
            searchInput.focus();
        });
    }
}

// Normalize text for Turkish/English search
function normalizeText(text) {
    return text
        .toLowerCase()
        .replace(/ı/g, 'i')
        .replace(/İ/g, 'i')
        .replace(/ğ/g, 'g')
        .replace(/Ğ/g, 'g')
        .replace(/ü/g, 'u')
        .replace(/Ü/g, 'u')
        .replace(/ş/g, 's')
        .replace(/Ş/g, 's')
        .replace(/ö/g, 'o')
        .replace(/Ö/g, 'o')
        .replace(/ç/g, 'c')
        .replace(/Ç/g, 'c');
}

// Perform drug search
function performSearch(query) {
    const normalizedQuery = normalizeText(query);

    const results = allDrugs.filter(drug => {
        // Normalize and search in name
        const normalizedName = normalizeText(drug.name);
        const nameMatch = normalizedName.includes(normalizedQuery);

        // Normalize and search in search terms
        const termsMatch = drug.searchTerms.some(term => {
            const normalizedTerm = normalizeText(term);
            return normalizedTerm.includes(normalizedQuery);
        });

        // Also search in category
        const normalizedCategory = normalizeText(drug.category);
        const categoryMatch = normalizedCategory.includes(normalizedQuery);

        return nameMatch || termsMatch || categoryMatch;
    });

    displaySearchResults(results, query);
}

// Display search results
function displaySearchResults(results, query) {
    const resultsContainer = document.getElementById('searchResults');
    if (!resultsContainer) return;

    if (results.length === 0) {
        resultsContainer.innerHTML = `
            <div class="p-4 text-center text-slate-500 dark:text-slate-400">
                <span class="material-symbols-outlined text-4xl opacity-50">search_off</span>
                <p class="mt-2">"${query}" için sonuç bulunamadı</p>
            </div>
        `;
        resultsContainer.classList.remove('hidden');
        return;
    }

    let html = '<div class="space-y-2">';

    results.forEach(drug => {
        html += `
            <button onclick="selectDrug('${drug.id}')"
                class="w-full text-left p-3 rounded-lg border border-slate-200 dark:border-slate-700
                       bg-white dark:bg-slate-800 hover:border-primary hover:bg-primary/5
                       transition-all duration-200 group">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="font-semibold text-slate-900 dark:text-white group-hover:text-primary">
                            ${highlightMatch(drug.name, query)}
                        </div>
                        <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            ${drug.category}
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">
                        chevron_right
                    </span>
                </div>
            </button>
        `;
    });

    html += '</div>';
    resultsContainer.innerHTML = html;
    resultsContainer.classList.remove('hidden');
}

// Highlight matching text
function highlightMatch(text, query) {
    const lowerText = text.toLowerCase();
    const lowerQuery = query.toLowerCase();
    const index = lowerText.indexOf(lowerQuery);

    if (index === -1) return text;

    const before = text.substring(0, index);
    const match = text.substring(index, index + query.length);
    const after = text.substring(index + query.length);

    return `${before}<mark class="bg-yellow-200 dark:bg-yellow-900/50 px-1 rounded">${match}</mark>${after}`;
}

// Clear search results
function clearSearchResults() {
    const resultsContainer = document.getElementById('searchResults');
    if (resultsContainer) {
        resultsContainer.innerHTML = '';
        resultsContainer.classList.add('hidden');
    }
}

// Select a drug and display details
function selectDrug(drugId) {
    const drug = allDrugs.find(d => d.id === drugId);
    if (!drug) return;

    selectedDrug = drug;
    displayDrugDetails(drug);

    // Clear search
    document.getElementById('drugSearch').value = '';
    clearSearchResults();

    // Scroll to details
    document.getElementById('drugDetails').scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Display drug details
function displayDrugDetails(drug) {
    const detailsContainer = document.getElementById('drugDetails');
    if (!detailsContainer) return;

    const html = `
        <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6 space-y-6">
            <!-- Drug Header -->
            <div class="border-b border-slate-200 dark:border-slate-700 pb-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                            ${drug.name}
                        </h2>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">
                            ${drug.category}
                        </p>
                    </div>
                    <button onclick="clearDrugDetails()"
                        class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>

            <!-- Test Concentrations -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- SPT -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-950/30 dark:to-blue-900/20
                            border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">vaccines</span>
                        <h3 class="font-bold text-blue-900 dark:text-blue-100">SPT</h3>
                    </div>
                    <p class="text-xs text-blue-700 dark:text-blue-300 mb-2">Skin Prick Test</p>
                    <div class="bg-white dark:bg-blue-950/50 rounded-lg p-3 mt-2">
                        <p class="text-sm font-mono font-semibold text-blue-900 dark:text-blue-100">
                            ${drug.spt || 'Belirtilmemiş'}
                        </p>
                    </div>
                </div>

                <!-- IDT -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950/30 dark:to-green-900/20
                            border border-green-200 dark:border-green-800 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400">medication</span>
                        <h3 class="font-bold text-green-900 dark:text-green-100">IDT</h3>
                    </div>
                    <p class="text-xs text-green-700 dark:text-green-300 mb-2">Intradermal Test</p>
                    <div class="bg-white dark:bg-green-950/50 rounded-lg p-3 mt-2">
                        <p class="text-sm font-mono font-semibold text-green-900 dark:text-green-100">
                            ${drug.idt || 'Belirtilmemiş'}
                        </p>
                    </div>
                </div>

                <!-- Patch Test -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-950/30 dark:to-purple-900/20
                            border border-purple-200 dark:border-purple-800 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">healing</span>
                        <h3 class="font-bold text-purple-900 dark:text-purple-100">Yama Testi</h3>
                    </div>
                    <p class="text-xs text-purple-700 dark:text-purple-300 mb-2">Patch Test</p>
                    <div class="bg-white dark:bg-purple-950/50 rounded-lg p-3 mt-2">
                        <p class="text-sm font-mono font-semibold text-purple-900 dark:text-purple-100">
                            ${drug.patch || 'Uygulanmaz'}
                        </p>
                    </div>
                </div>
            </div>

            ${drug.undilutedConc ? `
            <!-- Undiluted Concentration -->
            <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg p-4">
                <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Dilüe Edilmemiş Konsantrasyon
                </h4>
                <p class="text-sm font-mono text-slate-900 dark:text-white">
                    ${drug.undilutedConc}
                </p>
            </div>
            ` : ''}

            ${drug.notes ? `
            <!-- Notes -->
            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
                <div class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 flex-shrink-0">info</span>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-100 mb-1">
                            Önemli Notlar
                        </h4>
                        <p class="text-sm text-amber-900 dark:text-amber-100">
                            ${drug.notes}
                        </p>
                    </div>
                </div>
            </div>
            ` : ''}

            <!-- Alternative Names -->
            ${drug.searchTerms && drug.searchTerms.length > 0 ? `
            <div class="border-t border-slate-200 dark:border-slate-700 pt-4">
                <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Alternatif İsimler / Arama Terimleri
                </h4>
                <div class="flex flex-wrap gap-2">
                    ${drug.searchTerms.map(term => `
                        <span class="px-2 py-1 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300
                                     text-xs rounded-md border border-slate-200 dark:border-slate-600">
                            ${term}
                        </span>
                    `).join('')}
                </div>
            </div>
            ` : ''}
        </div>
    `;

    detailsContainer.innerHTML = html;
    detailsContainer.classList.remove('hidden');
}

// Clear drug details
function clearDrugDetails() {
    const detailsContainer = document.getElementById('drugDetails');
    if (detailsContainer) {
        detailsContainer.innerHTML = '';
        detailsContainer.classList.add('hidden');
    }

    // Reset dropdown
    const dropdown = document.getElementById('drugDropdown');
    if (dropdown) {
        dropdown.value = '';
    }

    selectedDrug = null;
}

// Render category filter buttons
function renderCategoryButtons() {
    const container = document.getElementById('categoryFilters');
    if (!container) return;

    const categories = {
        'betalactams': { name: 'Beta-laktamlar', icon: 'science', color: 'blue' },
        'fluoroquinolones': { name: 'Fluorokinolonlar', icon: 'category', color: 'lime' },
        'otherAntibiotics': { name: 'Diğer Antibiyotikler', icon: 'medication_liquid', color: 'emerald' },
        'anesthetics': { name: 'Anestezikler', icon: 'local_hospital', color: 'indigo' },
        'opioids': { name: 'Opioidler', icon: 'medication', color: 'purple' },
        'neuromuscularBlockers': { name: 'NM Blokerler', icon: 'offline_bolt', color: 'pink' },
        'anticoagulants': { name: 'Antikoagülanlar', icon: 'water_drop', color: 'red' },
        'platinumSalts': { name: 'Platin Tuzları', icon: 'colorize', color: 'orange' },
        'taxanes': { name: 'Taksanlar', icon: 'healing', color: 'rose' },
        'nsaids': { name: 'NSAİİ', icon: 'pill', color: 'amber' },
        'biologicals': { name: 'Biyolojikler', icon: 'biotech', color: 'green' },
        'localAnesthetics': { name: 'Lokal Anestezikler', icon: 'syringe', color: 'teal' },
        'contrastMedia': { name: 'Kontrast Medya', icon: 'contrast', color: 'cyan' },
        'ppi': { name: 'PPI', icon: 'gastroenterology', color: 'sky' },
        'anticonvulsants': { name: 'Antikonvülzanlar', icon: 'neurology', color: 'violet' },
        'others': { name: 'Diğer', icon: 'more_horiz', color: 'slate' }
    };

    let html = '<div class="flex flex-wrap gap-2">';

    Object.keys(categories).forEach(key => {
        const cat = categories[key];
        const count = skinTestData[key]?.length || 0;

        if (count > 0) {
            html += `
                <button onclick="filterByCategory('${key}')"
                    class="flex items-center gap-2 px-4 py-2 rounded-lg border border-${cat.color}-200 dark:border-${cat.color}-800
                           bg-${cat.color}-50 dark:bg-${cat.color}-950/30 text-${cat.color}-700 dark:text-${cat.color}-300
                           hover:bg-${cat.color}-100 dark:hover:bg-${cat.color}-900/40 transition-all duration-200">
                    <span class="material-symbols-outlined text-sm">${cat.icon}</span>
                    <span class="text-sm font-medium">${cat.name}</span>
                    <span class="text-xs opacity-75">(${count})</span>
                </button>
            `;
        }
    });

    html += '</div>';
    container.innerHTML = html;
}

// Filter by category
function filterByCategory(categoryKey) {
    const drugs = skinTestData[categoryKey] || [];

    if (drugs.length === 0) return;

    // Display all drugs in category
    displaySearchResults(drugs, '');

    // Scroll to results
    document.getElementById('searchResults').scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSkinTestModule);
} else {
    initSkinTestModule();
}
