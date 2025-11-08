<div class="module-container p-4 sm:p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-primary text-4xl">monitoring</span>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">
                    RegiSCAR Score
                </h1>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">
                    Drug Reaction with Eosinophilia and Systemic Symptoms (DRESS)
                </p>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-2xl flex-shrink-0">info</span>
                <div>
                    <h3 class="text-base font-bold text-blue-900 dark:text-blue-100 mb-2">
                        Kullanım Amacı
                    </h3>
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        DRESS (Drug Reaction with Eosinophilia and Systemic Symptoms) tanısının olasılığını değerlendirmek için kullanılır.
                        Akut dönemdeki klinik ve laboratuvar bulgularına göre puanlama yapılır.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Criteria -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Criterion Cards -->
            <div id="criteriaContainer"></div>
        </div>

        <!-- Right Column - Score Display (Sticky) -->
        <div class="lg:col-span-1">
            <div class="sticky top-4">
                <div class="bg-gradient-to-br from-primary to-blue-600 rounded-xl p-6 text-white shadow-xl">
                    <div class="text-center mb-4">
                        <p class="text-sm font-semibold uppercase tracking-wider opacity-90 mb-2">Total Score</p>
                        <div class="text-6xl font-bold mb-2" id="totalScore">0</div>
                        <p class="text-xs opacity-75">Score Range: -4 to +9</p>
                    </div>

                    <div class="bg-white/20 backdrop-blur-sm rounded-lg p-4" id="interpretationBox">
                        <p class="text-sm font-semibold mb-1">Interpretation</p>
                        <p class="text-lg font-bold" id="interpretationText">No case (excluded)</p>
                    </div>
                </div>

                <!-- Score Ranges Reference -->
                <div class="mt-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-4">
                    <p class="text-sm font-bold text-slate-900 dark:text-white mb-3">Score Interpretation</p>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <span class="text-slate-700 dark:text-slate-300"><strong>≤ 1:</strong> No case (excluded)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <span class="text-slate-700 dark:text-slate-300"><strong>2-3:</strong> Possible DRESS</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-orange-500"></div>
                            <span class="text-slate-700 dark:text-slate-300"><strong>4-5:</strong> Probable DRESS</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <span class="text-slate-700 dark:text-slate-300"><strong>≥ 6:</strong> Definite DRESS</span>
                        </div>
                    </div>
                </div>

                <!-- Reset Button -->
                <button onclick="resetScore()" class="w-full mt-4 bg-slate-200 dark:bg-slate-700 hover:bg-slate-300 dark:hover:bg-slate-600 text-slate-800 dark:text-white font-semibold py-3 rounded-lg transition-colors">
                    <span class="flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">refresh</span>
                        Reset
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- References -->
    <div class="mt-8 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg p-4">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">menu_book</span>
            References
        </h3>
        <div class="text-xs text-slate-600 dark:text-slate-400 space-y-2">
            <p>
                <strong>Original/Primary Reference:</strong> Kardaun SH, Sidoroff A, Valeyrie-Allanore L, et al.
                Variability in the clinical pattern of cutaneous side-effects of drugs with systemic symptoms:
                does a DRESS syndrome really exist? Br J Dermatol. 2007;156(3):609-11.
            </p>
            <p>
                <strong>Validation:</strong> Used in RegiSCAR study group for standardized classification of DRESS cases.
            </p>
        </div>
    </div>
</div>
