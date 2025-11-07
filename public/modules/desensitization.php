<div class="space-y-6 pb-20">
    <!-- Module Header -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center justify-center size-14 rounded-xl bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-3xl">vaccines</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">İlaç Desensitizasyonu</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">İlaç desensitizasyon protokolü hesaplayıcı</p>
            </div>
        </div>
    </div>

    <!-- Protocol Type Selection -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Protokol Tipi Seçin</h2>
        <div class="flex flex-col sm:flex-row gap-4">
            <button type="button"
                class="btn-protocol flex-1 px-6 py-4 rounded-xl font-semibold text-lg transition-all border-2 border-primary text-primary hover:bg-primary hover:text-white"
                data-type="castells"
                onclick="selectProtocolType('castells')">
                Castells Protokolü
            </button>
            <button type="button"
                class="btn-protocol flex-1 px-6 py-4 rounded-xl font-semibold text-lg transition-all border-2 border-green-600 text-green-600 hover:bg-green-600 hover:text-white"
                data-type="custom"
                onclick="selectProtocolType('custom')">
                Özel Protokol
            </button>
        </div>
    </div>

    <!-- Main Form -->
    <form id="protocolForm" class="space-y-6">

        <!-- Common Fields (Hidden by default) -->
        <div id="commonFields" class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6" style="display: none;">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Genel Bilgiler</h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">İlaç Adı</label>
                    <input type="text"
                        id="drugName"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="İlaç adını girin"
                        required>
                </div>

                <div class="dose-input-group">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Hedef Doz</label>
                    <input type="number"
                        id="targetDose"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Hedef doz"
                        step="0.001"
                        required>

                    <div class="flex items-center gap-3 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" id="useCustomUnit" class="rounded border-slate-300 text-primary focus:ring-primary">
                            <span class="text-sm text-slate-700 dark:text-slate-300">Farklı birim kullan</span>
                        </label>
                        <input type="text"
                            id="customUnit"
                            class="px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white text-sm"
                            placeholder="Birim (örn: mcg, ünite)"
                            style="display: none;">
                    </div>
                </div>

                <div id="dilutionVolumeGroup">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Sulandırma Miktarı (mL)</label>
                    <input type="number"
                        id="dilutionVolume"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                        placeholder="Sulandırma miktarı"
                        step="0.1">
                </div>

                <div id="adminRouteSection" style="display: none;">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Uygulama Yolu</label>
                    <select id="adminRoute"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                        onchange="handleAdminRouteChange()">
                        <option value="">Seçin</option>
                        <option value="iv">İntravenöz (IV)</option>
                        <option value="subcutan">Subkütan</option>
                        <option value="oral">Oral</option>
                    </select>
                </div>

                <div id="ivTypeSection" style="display: none;">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">IV Uygulama Tipi</label>
                    <select id="ivType"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary"
                        onchange="handleIVTypeChange()">
                        <option value="">Seçin</option>
                        <option value="infusion">İnfüzyon</option>
                        <option value="bolus">Bolus</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Castells Options -->
        <div id="castellsOptions" style="display: none;"></div>

        <!-- Custom Protocol -->
        <div id="customProtocol" style="display: none;"></div>

        <!-- Solution Fields -->
        <div id="solutionFields"></div>

        <!-- Step Fields -->
        <div id="stepFields"></div>

        <!-- Submit Container (Hidden initially) -->
        <div id="submitContainer" style="display: none;" class="flex gap-4">
            <button type="button"
                class="flex-1 px-6 py-3 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors"
                onclick="resetForm()">
                Temizle
            </button>
            <button type="button"
                class="flex-1 px-6 py-3 rounded-lg bg-green-600 text-white font-semibold hover:bg-green-700 transition-colors"
                onclick="calculateProtocol()">
                Hesapla
            </button>
        </div>
    </form>

    <!-- Results Section -->
    <div id="resultSection"></div>

    <!-- References -->
    <div class="bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl p-6 text-sm text-slate-600 dark:text-slate-400">
        <h3 class="font-bold text-slate-900 dark:text-white mb-2">Referanslar</h3>
        <ul class="space-y-1 list-disc list-inside">
            <li>Castells MC, et al. Hypersensitivity drug reactions and desensitization protocols. Med Clin North Am. 2020</li>
            <li>Wong JT, Long A. Desensitization for immediate hypersensitivity: state of the art. Ann Allergy Asthma Immunol. 2018</li>
        </ul>
        <p class="mt-3 text-xs">
            <strong>Uyarı:</strong> Bu hesaplayıcıdaki bilgiler eğitim amaçlıdır. Klinik uygulamada güncel kılavuzlara başvurunuz.
        </p>
    </div>
</div>

<style>
/* Custom styles for desensitization module */
.btn-protocol.active[data-type="castells"] {
    background-color: rgb(79, 70, 229);
    color: white;
    border-color: rgb(79, 70, 229);
}

.btn-protocol.active[data-type="custom"] {
    background-color: rgb(5, 150, 105);
    color: white;
    border-color: rgb(5, 150, 105);
}

.step-section {
    background: white;
    border: 1px solid rgb(226, 232, 240);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin: 1rem 0;
}

.dark .step-section {
    background: rgba(51, 65, 85, 0.5);
    border-color: rgba(51, 65, 85, 0.8);
}

.step-inputs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 0.5rem;
}

.step-inputs > div {
    display: flex;
    flex-direction: column;
}

.step-inputs label {
    font-size: 0.875rem;
    font-weight: 500;
    color: rgb(71, 85, 105);
    margin-bottom: 0.25rem;
}

.dark .step-inputs label {
    color: rgb(203, 213, 225);
}

.section-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: rgb(15, 23, 42);
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgb(226, 232, 240);
}

.dark .section-title {
    color: white;
    border-color: rgba(51, 65, 85, 0.8);
}

.results-section {
    background: white;
    border: 1px solid rgb(226, 232, 240);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin: 1rem 0;
}

.dark .results-section {
    background: rgba(51, 65, 85, 0.5);
    border-color: rgba(51, 65, 85, 0.8);
}

.results-section h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: rgb(15, 23, 42);
    text-align: center;
    margin-bottom: 1rem;
}

.dark .results-section h3 {
    color: white;
}

#stepsTable {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
    font-size: 0.875rem;
}

#stepsTable th,
#stepsTable td {
    padding: 0.75rem;
    border: 1px solid rgb(226, 232, 240);
    text-align: center;
}

.dark #stepsTable th,
.dark #stepsTable td {
    border-color: rgba(51, 65, 85, 0.8);
}

#stepsTable th {
    background-color: rgb(71, 85, 105);
    color: white;
    font-weight: 600;
}

#stepsTable tr:nth-child(even) {
    background-color: rgb(248, 250, 252);
}

.dark #stepsTable tr:nth-child(even) {
    background-color: rgba(30, 41, 59, 0.5);
}

#stepsTable tfoot td {
    background-color: rgb(241, 245, 249);
    font-weight: 600;
    text-align: left;
    padding: 1rem;
}

.dark #stepsTable tfoot td {
    background-color: rgba(30, 41, 59, 0.7);
    color: rgb(203, 213, 225);
}

.export-buttons {
    display: flex;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 1.5rem;
    flex-wrap: wrap;
}

.btn-export {
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 600;
    color: white;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}

.btn-export:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
    .step-inputs {
        grid-template-columns: 1fr;
    }

    #stepsTable {
        font-size: 0.75rem;
    }

    #stepsTable th,
    #stepsTable td {
        padding: 0.5rem;
    }
}

@media print {
    /* Hide everything except the results table */
    body > *:not(#resultSection) {
        display: none !important;
    }

    /* Hide all siblings and parents of resultSection */
    .space-y-6 > *:not(#resultSection) {
        display: none !important;
    }

    /* Hide specific elements */
    .btn-container,
    .export-buttons,
    #commonFields,
    #solutionFields,
    #stepFields,
    #submitContainer,
    header,
    nav,
    aside,
    footer,
    .bg-slate-50,
    .border.border-slate-200 {
        display: none !important;
    }

    /* Make sure resultSection is visible and full width */
    #resultSection {
        display: block !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 20px !important;
    }

    /* Ensure results section content is visible */
    #resultSection * {
        display: revert !important;
    }

    /* Table styling for print */
    #stepsTable {
        page-break-inside: avoid;
        border-collapse: collapse;
        width: 100%;
    }

    #stepsTable th,
    #stepsTable td {
        border: 1px solid #000;
        padding: 8px;
    }
}
</style>
