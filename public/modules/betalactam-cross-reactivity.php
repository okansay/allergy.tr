<div class="space-y-6 pb-20">
    <!-- Module Header -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="flex items-center justify-center size-14 rounded-xl bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-3xl">science</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Beta-Laktam Çapraz Reaksiyon</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">Penisilin ve sefalosporin yapısal benzerlik analizi</p>
            </div>
        </div>
    </div>

    <!-- Information Box -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
        <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100 mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined">info</span>
            Kullanım Bilgisi
        </h3>
        <p class="text-sm text-blue-900 dark:text-blue-100 mb-3">
            Bu modül, beta-laktam antibiyotikler arasındaki yapısal benzerlikleri (R1 ve R2 yan zincirleri) analiz ederek çapraz reaksiyon riskini değerlendirmenize yardımcı olur.
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div class="bg-white dark:bg-blue-950/30 rounded-lg p-4">
                <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2 text-sm">Benzerlik Seviyeleri:</h4>
                <ul class="text-xs text-blue-800 dark:text-blue-200 space-y-1">
                    <li><strong>R1/R2:</strong> Özdeş yan zincir - Yüksek risk</li>
                    <li><strong>r1/r2:</strong> Benzer yan zincir - Orta risk</li>
                    <li><strong>R1'/R1'':</strong> Kısmi özdeş (halka/dal) - Orta-Yüksek risk</li>
                    <li><strong>r1'/r1'':</strong> Kısmi benzer (halka/dal) - Düşük-Orta risk</li>
                    <li><strong>Boş:</strong> Yapısal benzerlik yok - Düşük risk</li>
                </ul>
            </div>
            <div class="bg-white dark:bg-blue-950/30 rounded-lg p-4">
                <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2 text-sm">Nasıl Kullanılır?</h4>
                <ul class="text-xs text-blue-800 dark:text-blue-200 space-y-1">
                    <li>1. Aşağıdaki listeden alerjisi olan ilacı seçin</li>
                    <li>2. Sistem otomatik olarak diğer tüm beta-laktamları analiz eder</li>
                    <li>3. Sonuçlar risk seviyesine göre gruplandırılır</li>
                    <li>4. Her ilaç için yapısal benzerlik detayları gösterilir</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Drug Selection -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">İlaç Seçimi</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                    Alerjisi Olan İlacı Seçin
                </label>
                <select
                    id="selectedDrug"
                    class="w-full px-4 py-2.5 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">İlaç seçin...</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div id="crossReactivityResults"></div>

    <!-- References -->
    <div class="bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl p-6 text-sm text-slate-600 dark:text-slate-400">
        <h3 class="font-bold text-slate-900 dark:text-white mb-2">Referans</h3>
        <p class="mb-2">
            <strong>Kaynak:</strong> Comparison of R1 and R2 structural similarities between beta-lactams.
            Drugs that have identical R1 or R2 structures are listed as R1 (orange cell) or R2 (yellow cell).
            If only the ring or branch chain moiety of the R1 structure is identical, it is listed as R1′ or R1′′, respectively.
            Drugs that have similar R1 or R2 structures are listed as r1 or r2.
            If only the ring or branch chain moiety of the R1 structure is similar, it is listed as r1′ or r1′′, respectively.
        </p>
        <p class="mt-3 text-xs">
            <strong>Uyarı:</strong> Bu analiz eğitim amaçlıdır. Klinik karar vermede hasta öyküsü, deri testi sonuçları ve güncel kılavuzlar dikkate alınmalıdır.
        </p>
    </div>
</div>

<style>
/* Custom styles for beta-lactam module */
.similarity-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    font-weight: 600;
    border: 1px solid;
}

.risk-high {
    background-color: #FEE2E2;
    border-color: #FCA5A5;
    color: #991B1B;
}

.risk-moderate {
    background-color: #FEF3C7;
    border-color: #FCD34D;
    color: #92400E;
}

.risk-low {
    background-color: #D1FAE5;
    border-color: #6EE7B7;
    color: #065F46;
}

.dark .risk-high {
    background-color: rgba(185, 28, 28, 0.2);
    border-color: rgba(185, 28, 28, 0.5);
    color: #FCA5A5;
}

.dark .risk-moderate {
    background-color: rgba(146, 64, 14, 0.2);
    border-color: rgba(146, 64, 14, 0.5);
    color: #FCD34D;
}

.dark .risk-low {
    background-color: rgba(6, 95, 70, 0.2);
    border-color: rgba(6, 95, 70, 0.5);
    color: #6EE7B7;
}

@media (max-width: 768px) {
    .grid.grid-cols-3 {
        grid-template-columns: 1fr;
    }
}
</style>
