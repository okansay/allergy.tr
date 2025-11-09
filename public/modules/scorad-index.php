<div class="module-container p-4 sm:p-6 max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-primary text-4xl">dermatology</span>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">
                    SCORAD Index
                </h1>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">
                    Scoring Atopic Dermatitis
                </p>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-2xl flex-shrink-0">info</span>
                <div class="w-full">
                    <h3 class="text-base font-bold text-blue-900 dark:text-blue-100 mb-2">Atopik Dermatit Şiddet Değerlendirmesi</h3>
                    <p class="text-sm text-blue-800 dark:text-blue-200 mb-2 font-semibold">
                        SCORAD = A/5 + 7B/2 + C (0-103)
                    </p>
                    <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1 mb-3">
                        <li>• <strong>A:</strong> Vücut yüzey alanı tutulumu (yaş grubuna göre)</li>
                        <li>• <strong>B:</strong> Şiddet skorları (6 bulgu × 0-3 = 0-18)</li>
                        <li>• <strong>C:</strong> Subjektif semptomlar (kaşıntı + uyku × 0-10 = 0-20)</li>
                    </ul>
                    <div class="text-xs text-blue-600 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/40 rounded p-2">
                        <strong>Not:</strong> Vücut yüzde oranları yaşa göre değişir (2 yaş altı çocuklarda baş %21, 2 yaş üzerinde %9)
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Criteria Container -->
    <div id="scoradContainer" class="space-y-6 mb-32"></div>

    <!-- Score Display - Bottom Fixed Bar -->
    <div class="fixed lg:sticky bottom-0 left-0 right-0 bg-white dark:bg-slate-800 border-t-2 border-slate-200 dark:border-slate-700 shadow-lg z-50 mt-8">
        <div class="max-w-7xl mx-auto p-4 sm:p-6">
            <!-- Score Value Display -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4 flex-wrap">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white" id="totalScore">0</span>
                        <span class="text-sm text-slate-500 dark:text-slate-400">/ 103</span>
                    </div>
                    <div class="h-8 w-px bg-slate-300 dark:bg-slate-600 hidden sm:block"></div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 uppercase tracking-wide">Severity</p>
                        <p class="text-base sm:text-lg font-bold" id="severityText">Mild</p>
                    </div>
                    <div class="text-xs text-slate-500">
                        <span>A: <strong id="displayA">0</strong></span> |
                        <span>B: <strong id="displayB">0</strong></span> |
                        <span>C: <strong id="displayC">0</strong></span>
                    </div>
                </div>
                <button onclick="resetScorad()" class="flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg transition-colors text-sm font-semibold">
                    <span class="material-symbols-outlined text-lg">refresh</span>
                    <span class="hidden sm:inline">Reset</span>
                </button>
            </div>

            <!-- Score Bar -->
            <div class="relative">
                <div class="flex justify-between mb-2 text-xs font-semibold">
                    <span class="text-green-600 dark:text-green-400">Mild</span>
                    <span class="text-yellow-600 dark:text-yellow-400">Moderate</span>
                    <span class="text-red-600 dark:text-red-400">Severe</span>
                </div>

                <div class="relative h-10 sm:h-12 rounded-lg overflow-hidden flex shadow-inner">
                    <!-- Mild: 0-24.9 -->
                    <div class="flex-[25] bg-green-100 dark:bg-green-900/30 border-r-2 border-white dark:border-slate-800 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-bold text-green-700 dark:text-green-300">0-24</span>
                        </div>
                    </div>
                    <!-- Moderate: 25-50 -->
                    <div class="flex-[26] bg-yellow-100 dark:bg-yellow-900/30 border-r-2 border-white dark:border-slate-800 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-bold text-yellow-700 dark:text-yellow-300">25-50</span>
                        </div>
                    </div>
                    <!-- Severe: 50.1-103 -->
                    <div class="flex-[52] bg-red-100 dark:bg-red-900/30 relative">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-bold text-red-700 dark:text-red-300">50+</span>
                        </div>
                    </div>

                    <!-- Score Indicator -->
                    <div id="scoreIndicator" class="absolute top-0 bottom-0 w-1 bg-slate-900 dark:bg-white shadow-lg transition-all duration-300" style="left: 0%;">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-3 py-1 rounded text-xs font-bold whitespace-nowrap">
                            <span id="indicatorScore">0</span>
                        </div>
                        <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-slate-900 dark:border-t-white"></div>
                    </div>
                </div>

                <div class="flex justify-between mt-2 text-xs text-slate-500 dark:text-slate-400">
                    <span>0</span>
                    <span>50</span>
                    <span>103</span>
                </div>
            </div>
        </div>
    </div>

    <!-- References -->
    <div class="mt-8 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg p-4">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">menu_book</span>
            References
        </h3>
        <div class="text-xs text-slate-600 dark:text-slate-400">
            <p>European Task Force on Atopic Dermatitis. Severity scoring of atopic dermatitis: the SCORAD index. Dermatology. 1993;186(1):23-31.</p>
        </div>
    </div>
</div>
