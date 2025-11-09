<div x-data="{
    searchQuery: '',
    selectedDrugId: null,
    
    // Sadece test için 10 ilaç - sonra hepsini ekleriz
    allDrugs: [
        { id: 'amoxicillin', name: 'Amoxicillin (Amoksisilin)', category: 'Beta-laktam', spt: '20 mg/ml', idt: '20 mg/ml', patch: '%5', searchTerms: ['amoxicillin', 'amoksisilin'], notes: 'En sık kullanılan aminopenisilin' },
        { id: 'ampicillin', name: 'Ampicillin (Ampisilin)', category: 'Beta-laktam', spt: '20 mg/ml', idt: '20 mg/ml', patch: '%5', searchTerms: ['ampicillin', 'ampisilin'], notes: 'Aminopenisilin grubu' },
        { id: 'ciprofloxacin', name: 'Ciprofloxacin (Siprofloksasin)', category: 'Fluorokinolon', spt: '0.025 mg/ml', idt: '0.005 mg/ml', patch: 'Uygulanmaz', searchTerms: ['ciprofloxacin', 'siprofloksasin', 'cipro'], notes: 'MRGPRX2 aracılı non-IgE reaksiyonlar sıktır' },
        { id: 'vancomycin', name: 'Vancomycin (Vankomisin)', category: 'Glikopeptid', spt: '50 mg/ml', idt: '5 mg/ml', patch: '%10', searchTerms: ['vancomycin', 'vankomisin'], notes: 'Red Man Sendromu riski' }
    ],
    
    get filteredDrugs() {
        if (!this.searchQuery || this.searchQuery.length < 3) return [];
        const query = this.searchQuery.toLowerCase();
        return this.allDrugs.filter(drug => 
            drug.name.toLowerCase().includes(query) ||
            drug.category.toLowerCase().includes(query) ||
            drug.searchTerms.some(term => term.toLowerCase().includes(query))
        );
    },
    
    get selectedDrug() {
        return this.allDrugs.find(d => d.id === this.selectedDrugId);
    },
    
    selectDrug(drugId) {
        this.selectedDrugId = drugId;
        this.searchQuery = '';
    }
}" class="space-y-6 pb-20">

    <!-- Header -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">İlaç Deri Testi Konsantrasyonları</h1>
        <p class="text-slate-600 dark:text-slate-400 mt-1">ENDA/EAACI kılavuzuna göre test konsantrasyonları (TEST)</p>
    </div>

    <!-- Search -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">İlaç Arayın</label>
        <input 
            type="text" 
            x-model="searchQuery"
            placeholder="İlaç adı yazın (en az 3 harf)..."
            class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white"
        />
        
        <!-- Search Results -->
        <div x-show="filteredDrugs.length > 0" class="mt-4 space-y-2">
            <template x-for="drug in filteredDrugs" :key="drug.id">
                <button 
                    @click="selectDrug(drug.id)"
                    class="w-full text-left p-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-primary hover:bg-primary/5"
                >
                    <div class="font-semibold text-slate-900 dark:text-white" x-text="drug.name"></div>
                    <div class="text-xs text-slate-500 dark:text-slate-400" x-text="drug.category"></div>
                </button>
            </template>
        </div>
    </div>

    <!-- Drug Details -->
    <div x-show="selectedDrug" class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white" x-text="selectedDrug?.name"></h2>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1" x-text="selectedDrug?.category"></p>
        
        <div class="grid grid-cols-3 gap-4 mt-6">
            <div class="border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="font-bold text-blue-900 dark:text-blue-100 mb-2">SPT</div>
                <div class="font-mono text-sm" x-text="selectedDrug?.spt"></div>
            </div>
            <div class="border border-green-200 dark:border-green-800 rounded-lg p-4">
                <div class="font-bold text-green-900 dark:text-green-100 mb-2">IDT</div>
                <div class="font-mono text-sm" x-text="selectedDrug?.idt"></div>
            </div>
            <div class="border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                <div class="font-bold text-purple-900 dark:text-purple-100 mb-2">Yama</div>
                <div class="font-mono text-sm" x-text="selectedDrug?.patch"></div>
            </div>
        </div>
        
        <div x-show="selectedDrug?.notes" class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
            <div class="font-semibold text-amber-900 dark:text-amber-100 mb-1">Önemli Notlar</div>
            <div class="text-sm text-amber-900 dark:text-amber-100" x-text="selectedDrug?.notes"></div>
        </div>
    </div>

</div>
