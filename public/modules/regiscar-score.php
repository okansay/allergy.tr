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

    <!-- Score Display - Bottom Fixed Bar (Mobile) / Sticky (Desktop) -->
    <div class="fixed lg:sticky bottom-0 left-0 right-0 bg-white dark:bg-slate-800 border-t-2 border-slate-200 dark:border-slate-700 shadow-lg z-50 mt-8">
        <div class="max-w-7xl mx-auto p-4 sm:p-6">
            <!-- Score Value Display -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white" id="totalScore">0</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400">/ 9 points</span>
                    </div>
                    <div class="h-8 w-px bg-slate-300 dark:bg-slate-600"></div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wide">Result</p>
                        <p class="text-base sm:text-lg font-bold" id="interpretationText">No case (excluded)</p>
                    </div>
                </div>
                <button onclick="resetScore()" class="flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg transition-colors text-sm font-semibold">
                    <span class="material-symbols-outlined text-lg">refresh</span>
                    <span class="hidden sm:inline">Reset</span>
                </button>
            </div>

            <!-- Score Bar -->
            <div class="relative">
                <!-- Labels Above Bar -->
                <div class="flex justify-between mb-2 text-xs font-semibold">
                    <span class="text-green-600 dark:text-green-400">No case</span>
                    <span class="text-yellow-600 dark:text-yellow-400">Possible</span>
                    <span class="text-orange-600 dark:text-orange-400">Probable</span>
                    <span class="text-red-600 dark:text-red-400">Definite</span>
                </div>

                <!-- Progress Bar -->
                <div class="relative h-10 sm:h-12 rounded-lg overflow-hidden flex shadow-inner">
                    <!-- No case: ≤1 (from -4 to 1 = 5 points out of 14 total range) - GREEN -->
                    <div class="flex-[5] bg-green-100 dark:bg-green-900/30 border-r-2 border-white dark:border-slate-800 relative group cursor-pointer hover:bg-green-200 dark:hover:bg-green-900/40 transition-colors">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-bold text-green-700 dark:text-green-300">≤1</span>
                        </div>
                    </div>
                    <!-- Possible: 2-3 (2 points) - YELLOW -->
                    <div class="flex-[2] bg-yellow-100 dark:bg-yellow-900/30 border-r-2 border-white dark:border-slate-800 relative group cursor-pointer hover:bg-yellow-200 dark:hover:bg-yellow-900/40 transition-colors">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-bold text-yellow-700 dark:text-yellow-300">2-3</span>
                        </div>
                    </div>
                    <!-- Probable: 4-5 (2 points) - ORANGE -->
                    <div class="flex-[2] bg-orange-100 dark:bg-orange-900/30 border-r-2 border-white dark:border-slate-800 relative group cursor-pointer hover:bg-orange-200 dark:hover:bg-orange-900/40 transition-colors">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-bold text-orange-700 dark:text-orange-300">4-5</span>
                        </div>
                    </div>
                    <!-- Definite: ≥6 (from 6 to 9 = 4 points) - RED -->
                    <div class="flex-[4] bg-red-100 dark:bg-red-900/30 relative group cursor-pointer hover:bg-red-200 dark:hover:bg-red-900/40 transition-colors">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-bold text-red-700 dark:text-red-300">≥6</span>
                        </div>
                    </div>

                    <!-- Score Indicator (Dynamic Position) -->
                    <div id="scoreIndicator" class="absolute top-0 bottom-0 w-1 bg-slate-900 dark:bg-white shadow-lg transition-all duration-300" style="left: 0%;">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-3 py-1 rounded text-xs font-bold whitespace-nowrap">
                            Score: <span id="indicatorScore">0</span>
                        </div>
                        <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-slate-900 dark:border-t-white"></div>
                    </div>
                </div>

                <!-- Range Labels -->
                <div class="flex justify-between mt-2 text-xs text-slate-500 dark:text-slate-400">
                    <span>-4</span>
                    <span>0</span>
                    <span>+5</span>
                    <span>+9</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 gap-6 mb-32 pb-4">
        <!-- Criteria -->
        <div class="space-y-4">
            <!-- Criterion Cards -->
            <div id="criteriaContainer"></div>
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
