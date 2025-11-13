/**
 * GINA Asthma Step Advisor - Results Display
 */

/**
 * Display results
 */
function displayResults(result) {
    // Show results container
    document.getElementById('resultsContainer').style.display = 'block';

    // Build summary card
    buildSummaryCard(result);

    // Build detailed recommendations
    buildDetailedRecommendations(result);

    // Scroll to results
    setTimeout(() => {
        document.getElementById('resultsContainer').scrollIntoView({ behavior: 'smooth' });
    }, 100);
}

/**
 * Build summary card
 */
function buildSummaryCard(result) {
    const summaryContent = document.getElementById('summaryContent');

    const ageGroupLabels = {
        '0_5': '0-5 yaş',
        '6_11': '6-11 yaş',
        '12_plus': '≥12 yaş'
    };

    const controlLabels = {
        'well_controlled': '✓ İyi Kontrollü',
        'partly_controlled': '○ Kısmi Kontrollü',
        'uncontrolled': '✗ Kontrolsüz'
    };

    const controlColors = {
        'well_controlled': 'text-green-600 dark:text-green-400',
        'partly_controlled': 'text-yellow-600 dark:text-yellow-400',
        'uncontrolled': 'text-red-600 dark:text-red-400'
    };

    const riskLabels = {
        'low_risk': 'Düşük Risk',
        'high_risk': 'Yüksek Risk'
    };

    const riskColors = {
        'low_risk': 'text-green-600 dark:text-green-400',
        'high_risk': 'text-red-600 dark:text-red-400'
    };

    const severityLabels = {
        'mild': 'Hafif',
        'moderate': 'Orta',
        'severe': 'Ağır'
    };

    const severityColors = {
        'mild': 'text-blue-600 dark:text-blue-400',
        'moderate': 'text-orange-600 dark:text-orange-400',
        'severe': 'text-red-600 dark:text-red-400'
    };

    const stepChangeLabels = {
        'initial': 'Başlangıç tedavisi',
        'step_up': 'Basamak artırımı önerilir',
        'step_down': 'Basamak azaltımı düşünülebilir',
        'no_change': 'Mevcut basamak sürdürülmeli',
        'maintain': 'Mevcut basamak korunmalı',
        'acute_period': 'Akut dönem - yönlendirme gerekli'
    };

    const html = `
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-primary">person</span>
                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Yaş Grubu</div>
                    <div class="font-bold text-slate-900 dark:text-white">${ageGroupLabels[result.age_group]}</div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-primary">check_circle</span>
                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Kontrol Düzeyi</div>
                    <div class="font-bold ${controlColors[result.control_level]}">${controlLabels[result.control_level]}</div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-primary">warning</span>
                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Geleceğe Dönük Risk</div>
                    <div class="font-bold ${riskColors[result.future_risk]}">${riskLabels[result.future_risk]}</div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-primary">trending_up</span>
                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Tahmini Şiddet</div>
                    <div class="font-bold ${severityColors[result.estimated_severity]}">${severityLabels[result.estimated_severity]}</div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-primary">stairs</span>
                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Basamak</div>
                    <div class="font-bold text-slate-900 dark:text-white">
                        ${result.current_step > 0 ? `Step ${result.current_step} → ` : ''}Step ${result.target_step}
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-primary">medical_services</span>
                <div>
                    <div class="text-xs text-slate-500 dark:text-slate-400">Öneri</div>
                    <div class="font-bold text-slate-900 dark:text-white text-sm">${stepChangeLabels[result.recommended_step_change]}</div>
                </div>
            </div>
        </div>
    `;

    summaryContent.innerHTML = html;
}

/**
 * Build detailed recommendations
 */
function buildDetailedRecommendations(result) {
    const detailedResults = document.getElementById('detailedResults');
    let html = '';

    // Severe Asthma Warning
    if (result.severe_asthma_flag) {
        html += `
            <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-500 dark:border-red-700 rounded-xl p-6">
                <h3 class="font-bold text-red-900 dark:text-red-100 mb-3 flex items-center gap-2 text-lg">
                    <span class="material-symbols-outlined text-2xl">emergency</span>
                    Ağır / Zor Tedavi Edilen Astım Uyarısı
                </h3>
                <p class="text-red-800 dark:text-red-200 mb-4">
                    ${result.severe_asthma_comment}
                </p>
                <div class="bg-white/50 dark:bg-slate-800/50 rounded-lg p-4">
                    <p class="text-sm text-red-900 dark:text-red-100 font-semibold mb-2">Önerilen Değerlendirmeler:</p>
                    <ul class="text-sm text-red-800 dark:text-red-200 space-y-1 list-disc list-inside">
                        <li>İnhaler tekniği ve tedaviye uyumu yeniden gözden geçirin</li>
                        <li>Tetikleyici faktörleri (allerjenler, sigara, vb.) değerlendirin</li>
                        <li>Komorbiditeleri (rinit, GÖRH, obezite) araştırın</li>
                        <li>Fenotiplendirme için biyobelirteçleri (eozinofilik, T2-high) kontrol edin</li>
                        <li>Uzman merkeze sevk düşünün</li>
                    </ul>
                </div>
            </div>
        `;
    }

    // Track 1 Option
    if (result.track_1_option) {
        html += buildTrackCard(result.track_1_option, 'Track 1 (ICS-Formoterol Temelli)', 'primary');
    }

    // Track 2 Option
    if (result.track_2_option) {
        html += buildTrackCard(result.track_2_option, 'Track 2 (Günlük ICS/ICS-LABA + SABA)', 'green');
    }

    // Device Recommendation
    const deviceLabels = {
        'pMDI_with_spacer_and_mask': 'pMDI + spacer + maske',
        'pMDI_with_spacer': 'pMDI + spacer',
        'DPI_or_pMDI_with_spacer': 'DPI veya pMDI + spacer',
        'DPI_or_pMDI': 'DPI veya pMDI'
    };

    html += `
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
            <h3 class="font-bold text-blue-900 dark:text-blue-100 mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined">medical_information</span>
                Cihaz Önerisi
            </h3>
            <p class="text-blue-800 dark:text-blue-200">
                <strong>Önerilen inhaler tipi:</strong> ${deviceLabels[result.device_recommendation] || result.device_recommendation}
            </p>
        </div>
    `;

    // Reference
    html += `
        <div class="bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
            <h3 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined">library_books</span>
                Rehber Referansı
            </h3>
            <p class="text-sm text-slate-700 dark:text-slate-300 mb-3">
                ${result.safety_disclaimer}
            </p>
            <p class="text-xs text-slate-600 dark:text-slate-400">
                <strong>Kaynak:</strong> GINA 2024 Global Strategy for Asthma Management and Prevention, 2025 updates
            </p>
        </div>
    `;

    detailedResults.innerHTML = html;
}

/**
 * Build track card
 */
function buildTrackCard(track, title, colorScheme) {
    const colors = {
        'primary': {
            bg: 'bg-primary/10 dark:bg-primary/20',
            border: 'border-primary/30',
            text: 'text-primary',
            heading: 'text-primary'
        },
        'green': {
            bg: 'bg-green-50 dark:bg-green-900/20',
            border: 'border-green-200 dark:border-green-800',
            text: 'text-green-800 dark:text-green-200',
            heading: 'text-green-900 dark:text-green-100'
        }
    };

    const color = colors[colorScheme];

    let html = `
        <div class="${color.bg} border ${color.border} rounded-xl p-6">
            <h3 class="font-bold ${color.heading} mb-4 flex items-center gap-2 text-lg">
                <span class="material-symbols-outlined text-2xl">medication</span>
                ${title}
            </h3>

            <div class="space-y-4">
                <div>
                    <p class="font-semibold ${color.text} mb-2">${track.label}</p>
                    <div class="text-sm ${color.text}">
                        <span class="inline-block px-2 py-1 bg-white/50 dark:bg-slate-800/50 rounded">
                            Step ${track.step}
                        </span>
                        <span class="inline-block px-2 py-1 bg-white/50 dark:bg-slate-800/50 rounded ml-2">
                            ICS Doz: ${track.ics_dose_category}
                        </span>
                    </div>
                </div>

                ${track.example_regimens && track.example_regimens.length > 0 ? `
                    <div class="bg-white/50 dark:bg-slate-800/50 rounded-lg p-4">
                        <p class="font-semibold ${color.text} mb-2 text-sm">Örnek Rejimler:</p>
                        ${track.example_regimens.map(regimen => `
                            <div class="mb-3 last:mb-0">
                                <p class="font-medium text-sm ${color.text}">${regimen.molecule}</p>
                                <p class="text-xs ${color.text} mt-1">${regimen.dose_text}</p>
                                <p class="text-xs ${color.text} opacity-75">Cihaz: ${regimen.device_type}</p>
                            </div>
                        `).join('')}
                    </div>
                ` : ''}

                ${track.add_on_options && track.add_on_options.length > 0 ? `
                    <div class="bg-white/50 dark:bg-slate-800/50 rounded-lg p-4">
                        <p class="font-semibold ${color.text} mb-2 text-sm">Ek Tedavi Seçenekleri:</p>
                        <div class="flex flex-wrap gap-2">
                            ${track.add_on_options.map(addon => `
                                <span class="px-2 py-1 bg-white dark:bg-slate-700 rounded text-xs ${color.text}">${addon}</span>
                            `).join('')}
                        </div>
                    </div>
                ` : ''}

                ${track.notes && track.notes.length > 0 ? `
                    <div class="bg-white/50 dark:bg-slate-800/50 rounded-lg p-4">
                        <p class="font-semibold ${color.text} mb-2 text-sm">Notlar:</p>
                        <ul class="text-xs ${color.text} space-y-1 list-disc list-inside">
                            ${track.notes.map(note => `<li>${note}</li>`).join('')}
                        </ul>
                    </div>
                ` : ''}
            </div>
        </div>
    `;

    return html;
}

/**
 * Make displayResults available globally
 */
window.displayResults = displayResults;
