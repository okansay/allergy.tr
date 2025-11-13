<!-- Desensitization Protocol Library Module v1.0 -->
<div class="module-container p-4 sm:p-6 max-w-7xl mx-auto" x-data="{
    // Current Step
    currentStep: 1,
    
    // Search State
    searchQuery: '',
    selectedRoute: 'all',
    
    // Protocols Data
    protocols: [],
    filteredProtocols: [],
    selectedProtocol: null,
    
    // Protocol Parameters
    protocolParams: {},
    
    // Calculated Steps
    calculatedSteps: [],
    editableSteps: [],
    targetDose: 0,
    
    // UI State
    showSearchHelp: false,
    loading: false,
    
    async init() {
        await this.loadProtocols();
        this.filterProtocols();
    },
    
    async loadProtocols() {
        this.loading = true;
        try {
            const response = await fetch('/modules/data/drug-desensitization-protocols.json');
            const data = await response.json();
            this.protocols = data.protocols || [];
            this.filterProtocols();
        } catch (error) {
            console.error('Failed to load protocols:', error);
            alert('Protokoller yüklenirken hata oluştu');
        } finally {
            this.loading = false;
        }
    },
    
    filterProtocols() {
        let results = this.protocols;
        
        // Filter by search query
        if (this.searchQuery.trim()) {
            const query = this.searchQuery.toLowerCase().trim();
            results = results.filter(p => {
                // Search in drug name first (exact matches)
                const exactDrugMatch = p.example_drugs.some(drug => 
                    drug.toLowerCase() === query
                );
                if (exactDrugMatch) return true;
                
                // Then partial matches in drug names
                const partialDrugMatch = p.example_drugs.some(drug => 
                    drug.toLowerCase().includes(query)
                );
                if (partialDrugMatch) return true;
                
                // Then drug class
                if (p.drug_class.toLowerCase().includes(query)) return true;
                
                // Then protocol label
                if (p.protocol_label.toLowerCase().includes(query)) return true;
                
                return false;
            });
            
            // Sort by relevance: exact drug match > partial drug match > class match
            results.sort((a, b) => {
                const query = this.searchQuery.toLowerCase().trim();
                const aExact = a.example_drugs.some(d => d.toLowerCase() === query);
                const bExact = b.example_drugs.some(d => d.toLowerCase() === query);
                if (aExact && !bExact) return -1;
                if (!aExact && bExact) return 1;
                
                const aPartial = a.example_drugs.some(d => d.toLowerCase().includes(query));
                const bPartial = b.example_drugs.some(d => d.toLowerCase().includes(query));
                if (aPartial && !bPartial) return -1;
                if (!aPartial && bPartial) return 1;
                
                return 0;
            });
        }
        
        // Filter by route
        if (this.selectedRoute !== 'all') {
            results = results.filter(p => p.route.toLowerCase() === this.selectedRoute.toLowerCase());
        }
        
        // Sort by reference type (guideline > review > case series)
        results.sort((a, b) => {
            const typeOrder = { 'guideline': 1, 'position_paper': 2, 'systematic_review': 3, 'review': 4, 'case_series': 5 };
            const aType = a.main_references[0]?.type || 'case_series';
            const bType = b.main_references[0]?.type || 'case_series';
            return (typeOrder[aType] || 99) - (typeOrder[bType] || 99);
        });
        
        this.filteredProtocols = results;
    },
    
    selectProtocol(protocol) {
        this.selectedProtocol = protocol;
        this.protocolParams = {};
        this.calculatedSteps = [];
        this.editableSteps = [];
        
        // Initialize parameters with defaults
        protocol.user_inputs.forEach(input => {
            if (input.default !== undefined) {
                this.protocolParams[input.name] = input.default;
            } else {
                this.protocolParams[input.name] = '';
            }
        });
        
        this.currentStep = 2;
    },
    
    calculateSteps() {
        if (!this.validateParameters()) {
            return;
        }
        
        const protocol = this.selectedProtocol;
        const scaling = protocol.scaling;
        
        let steps = [];
        
        if (scaling.type === 'relative_to_final_dose') {
            steps = this.calculateRelativeDoseSteps(protocol, scaling);
        } else if (scaling.type === 'fixed_step_sequence') {
            steps = this.calculateFixedSteps(protocol, scaling);
        } else if (scaling.type === 'relative_to_final_volume') {
            steps = this.calculateVolumeSteps(protocol, scaling);
        }
        
        this.calculatedSteps = steps;
        this.editableSteps = JSON.parse(JSON.stringify(steps)); // Deep clone
        this.currentStep = 3;
    },
    
    calculateRelativeDoseSteps(protocol, scaling) {
        const targetDose = parseFloat(this.protocolParams.target_final_dose_mg || this.protocolParams.target_single_dose_mg || 0);
        this.targetDose = targetDose;
        
        const referenceDose = scaling.reference_final_dose_mg;
        const referenceSteps = scaling.reference_step_doses_mg || [];
        const scaleFactor = targetDose / referenceDose;
        
        let steps = [];
        let cumulativeDose = 0;
        
        const numberOfBags = this.protocolParams.number_of_bags || scaling.default_number_of_bags || 3;
        const stepsPerBag = Math.ceil(referenceSteps.length / numberOfBags);
        
        referenceSteps.forEach((refDose, index) => {
            const stepDose = refDose * scaleFactor;
            cumulativeDose += stepDose;
            
            const bagIndex = Math.floor(index / stepsPerBag) + 1;
            const stepInterval = this.protocolParams.step_interval_min || scaling.default_step_interval_min || 15;
            
            steps.push({
                step_number: index + 1,
                bag_index: bagIndex,
                step_dose_mg: stepDose,
                step_interval_min: stepInterval,
                cumulative_dose_mg: cumulativeDose,
                editable: true
            });
        });
        
        return steps;
    },
    
    calculateFixedSteps(protocol, scaling) {
        const targetDose = parseFloat(this.protocolParams.target_maintenance_dose_mg || this.protocolParams.target_single_dose_mg || 0);
        this.targetDose = targetDose;
        
        const referenceSteps = scaling.reference_step_doses_mg || [];
        const scaleFactor = targetDose / scaling.reference_final_dose_mg;
        
        let steps = [];
        let cumulativeDose = 0;
        
        referenceSteps.forEach((refDose, index) => {
            const stepDose = refDose * scaleFactor;
            cumulativeDose += stepDose;
            
            steps.push({
                step_number: index + 1,
                step_dose_mg: stepDose,
                step_interval_min: this.protocolParams.step_interval_min || scaling.default_step_interval_min || 30,
                cumulative_dose_mg: cumulativeDose,
                editable: true
            });
        });
        
        return steps;
    },
    
    calculateVolumeSteps(protocol, scaling) {
        const targetVolume = parseFloat(this.protocolParams.target_total_volume_ml || 0);
        this.targetDose = targetVolume; // For volume-based protocols
        
        const referenceVolume = scaling.reference_final_volume_ml;
        const stepCount = scaling.reference_step_count || 10;
        const scaleFactor = targetVolume / referenceVolume;
        
        let steps = [];
        let cumulativeVolume = 0;
        
        // Generate exponentially increasing volumes
        for (let i = 0; i < stepCount; i++) {
            const fraction = Math.pow(2, i) / Math.pow(2, stepCount - 1);
            const stepVolume = targetVolume * fraction;
            cumulativeVolume += stepVolume;
            
            steps.push({
                step_number: i + 1,
                step_volume_ml: stepVolume,
                step_interval_min: this.protocolParams.step_interval_min || scaling.default_step_interval_min || 15,
                cumulative_volume_ml: cumulativeVolume,
                editable: true
            });
        }
        
        return steps;
    },
    
    validateParameters() {
        const protocol = this.selectedProtocol;

        for (const input of protocol.user_inputs) {
            if (input.required && !this.protocolParams[input.name]) {
                alert('Lütfen zorunlu alan doldurun: ' + input.label);
                return false;
            }
        }

        return true;
    },
    
    recalculateFromEdits() {
        // Recalculate cumulative doses
        let cumulative = 0;
        this.editableSteps.forEach(step => {
            const dose = parseFloat(step.step_dose_mg || step.step_volume_ml || 0);
            cumulative += dose;
            if (step.cumulative_dose_mg !== undefined) {
                step.cumulative_dose_mg = cumulative;
            } else if (step.cumulative_volume_ml !== undefined) {
                step.cumulative_volume_ml = cumulative;
            }
        });
        
        // Check if total matches target
        const finalCumulative = cumulative;
        const tolerance = this.targetDose * 0.05; // 5% tolerance

        if (Math.abs(finalCumulative - this.targetDose) > tolerance) {
            alert('Uyarı: Düzenlenen basamakların toplamı (' + finalCumulative.toFixed(2) + ') hedef dozdan (' + this.targetDose.toFixed(2) + ') çok farklı. Hedef doz bu girdilerle verilemez.');
        }
    },
    
    addStep(index) {
        const newStep = {
            step_number: 0,
            step_dose_mg: 0,
            step_interval_min: 15,
            cumulative_dose_mg: 0,
            editable: true
        };
        this.editableSteps.splice(index + 1, 0, newStep);
        this.renumberSteps();
        this.recalculateFromEdits();
    },
    
    removeStep(index) {
        if (this.editableSteps.length <= 1) {
            alert('En az bir basamak olmalıdır');
            return;
        }
        this.editableSteps.splice(index, 1);
        this.renumberSteps();
        this.recalculateFromEdits();
    },
    
    renumberSteps() {
        this.editableSteps.forEach((step, index) => {
            step.step_number = index + 1;
        });
    },
    
    goBack() {
        if (this.currentStep > 1) {
            this.currentStep--;
        }
    },
    
    reset() {
        if (confirm('Tüm verileri sıfırlamak istediğinizden emin misiniz?')) {
            this.currentStep = 1;
            this.searchQuery = '';
            this.selectedRoute = 'all';
            this.selectedProtocol = null;
            this.protocolParams = {};
            this.calculatedSteps = [];
            this.editableSteps = [];
            this.filterProtocols();
        }
    },
    
    printProtocol() {
        window.print();
    },
    
    getRouteLabel(route) {
        const labels = {
            'IV': 'İntravenöz',
            'oral': 'Oral',
            'all': 'Tümü'
        };
        return labels[route] || route;
    },
    
    getReferenceTypeLabel(type) {
        const labels = {
            'guideline': 'Kılavuz',
            'position_paper': 'Pozisyon Bildirisi',
            'systematic_review': 'Sistematik Derleme',
            'review': 'Derleme',
            'case_series': 'Olgu Serisi'
        };
        return labels[type] || type;
    }
}">

    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-4">
            <span class="material-symbols-outlined text-primary text-4xl">medication</span>
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white">
                    Desensitizasyon Protokol Kütüphanesi
                </h1>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">
                    İlaç Desensitizasyon Protokollerini Ara ve Ölçekle
                </p>
            </div>
        </div>
    </div>

    <!-- Step 1: Search & Select Protocol -->
    <div x-show="currentStep === 1" class="space-y-6">
        <!-- Search -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">search</span>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Protokol Ara</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        İlaç Adı veya Sınıfı
                    </label>
                    <input 
                        type="text" 
                        x-model="searchQuery"
                        @input="filterProtocols()"
                        placeholder="Örn: amoxicillin, beta-lactam, aspirin"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-700 dark:text-white">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Uygulama Yolu
                    </label>
                    <select 
                        x-model="selectedRoute"
                        @change="filterProtocols()"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-700 dark:text-white">
                        <option value="all">Tümü</option>
                        <option value="IV">İntravenöz (IV)</option>
                        <option value="oral">Oral</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4 text-sm text-slate-600 dark:text-slate-400">
                <p><strong>Arama Mantığı:</strong> Önce ilaca özgü protokoller, sonra ilaç sınıfı protokolleri listelenir. Kılavuzlar ve pozisyon bildirisi öncelikli gösterilir.</p>
            </div>
        </div>

        <!-- Results -->
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                    Bulunan Protokoller (<span x-text="filteredProtocols.length"></span>)
                </h3>
            </div>
            
            <div x-show="loading" class="text-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div>
            </div>
            
            <div x-show="!loading && filteredProtocols.length === 0" class="text-center py-8 text-slate-600 dark:text-slate-400">
                <span class="material-symbols-outlined text-6xl mb-4">search_off</span>
                <p>Protokol bulunamadı. Farklı bir arama deneyin.</p>
            </div>
            
            <template x-for="protocol in filteredProtocols" :key="protocol.protocol_id">
                <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-5 hover:shadow-lg transition-shadow cursor-pointer"
                     @click="selectProtocol(protocol)">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-1" x-text="protocol.protocol_label"></h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">
                                <span class="font-medium">Sınıf:</span> <span x-text="protocol.drug_class"></span> | 
                                <span class="font-medium">Yol:</span> <span x-text="getRouteLabel(protocol.route)"></span>
                            </p>
                        </div>
                        <span class="material-symbols-outlined text-primary">arrow_forward</span>
                    </div>
                    
                    <div class="mb-3">
                        <p class="text-sm text-slate-700 dark:text-slate-300">
                            <strong>Örnek ilaçlar:</strong> <span x-text="protocol.example_drugs.join(', ')"></span>
                        </p>
                    </div>
                    
                    <div class="border-t border-slate-200 dark:border-slate-700 pt-3">
                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400 mb-2">Ana Referanslar:</p>
                        <template x-for="ref in protocol.main_references.slice(0, 2)" :key="ref.first_author + ref.year">
                            <div class="text-xs text-slate-600 dark:text-slate-400 mb-1">
                                <span class="px-2 py-0.5 bg-primary/10 text-primary rounded text-xs font-medium mr-2" x-text="getReferenceTypeLabel(ref.type)"></span>
                                <span x-text="ref.first_author + ' et al., ' + ref.year + ' - ' + ref.journal"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Step 2: Parameters -->
    <div x-show="currentStep === 2" class="space-y-6">
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">tune</span>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">Protokol Parametreleri</h2>
            </div>
            
            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <p class="text-sm text-blue-900 dark:text-blue-100 font-medium mb-1" x-text="selectedProtocol?.protocol_label"></p>
                <p class="text-xs text-blue-800 dark:text-blue-200" x-text="selectedProtocol?.drug_class + ' - ' + getRouteLabel(selectedProtocol?.route)"></p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <template x-for="input in selectedProtocol?.user_inputs || []" :key="input.name">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            <span x-text="input.label"></span>
                            <span x-show="input.required" class="text-red-500">*</span>
                        </label>
                        
                        <input 
                            x-show="input.type === 'float' || input.type === 'integer'"
                            type="number"
                            :step="input.type === 'float' ? '0.01' : '1'"
                            x-model="protocolParams[input.name]"
                            :required="input.required"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-700 dark:text-white">
                        
                        <input 
                            x-show="input.type === 'string'"
                            type="text"
                            x-model="protocolParams[input.name]"
                            :required="input.required"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-700 dark:text-white">
                        
                        <div x-show="input.type === 'boolean'" class="flex items-center">
                            <input 
                                type="checkbox"
                                x-model="protocolParams[input.name]"
                                class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                            <span class="ml-2 text-sm text-slate-600 dark:text-slate-400">Evet</span>
                        </div>
                    </div>
                </template>
            </div>
            
            <div class="flex gap-3">
                <button 
                    @click="goBack()"
                    class="px-6 py-2 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span>Geri</span>
                    </span>
                </button>
                
                <button 
                    @click="calculateSteps()"
                    class="flex-1 px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                    <span class="flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">calculate</span>
                        <span>Basamakları Hesapla</span>
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Step 3: Edit Steps & Final Protocol -->
    <div x-show="currentStep === 3" class="space-y-6">
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">edit_note</span>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Hesaplanan Basamaklar</h2>
                </div>
                
                <div class="flex gap-2">
                    <button 
                        @click="printProtocol()"
                        class="px-4 py-2 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined">print</span>
                            <span class="hidden sm:inline">Yazdır</span>
                        </span>
                    </button>
                </div>
            </div>
            
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <p class="text-sm text-green-900 dark:text-green-100">
                    <strong>Hedef Doz:</strong> <span x-text="targetDose.toFixed(2)"></span> <span x-text="selectedProtocol?.scaling.type === 'relative_to_final_volume' ? 'mL' : 'mg'"></span>
                </p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-100 dark:bg-slate-700">
                        <tr>
                            <th class="px-4 py-2 text-left">Basamak</th>
                            <th class="px-4 py-2 text-left" x-show="editableSteps[0]?.bag_index">Torba</th>
                            <th class="px-4 py-2 text-left">Doz</th>
                            <th class="px-4 py-2 text-left">Süre (dk)</th>
                            <th class="px-4 py-2 text-left">Kümülatif</th>
                            <th class="px-4 py-2 text-center">İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(step, index) in editableSteps" :key="index">
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <td class="px-4 py-2" x-text="step.step_number"></td>
                                <td class="px-4 py-2" x-show="step.bag_index" x-text="step.bag_index"></td>
                                <td class="px-4 py-2">
                                    <input 
                                        type="number" 
                                        step="0.01"
                                        x-model="step.step_dose_mg"
                                        @change="recalculateFromEdits()"
                                        class="w-24 px-2 py-1 border border-slate-300 dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white text-sm">
                                    <span class="text-xs text-slate-600 dark:text-slate-400 ml-1">mg</span>
                                </td>
                                <td class="px-4 py-2">
                                    <input 
                                        type="number"
                                        x-model="step.step_interval_min"
                                        class="w-20 px-2 py-1 border border-slate-300 dark:border-slate-600 rounded dark:bg-slate-700 dark:text-white text-sm">
                                </td>
                                <td class="px-4 py-2">
                                    <span x-text="(step.cumulative_dose_mg || step.cumulative_volume_ml || 0).toFixed(2)"></span>
                                    <span class="text-xs text-slate-600 dark:text-slate-400 ml-1" x-text="step.cumulative_volume_ml ? 'mL' : 'mg'"></span>
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <button 
                                        @click="addStep(index)"
                                        class="text-green-600 hover:text-green-700 mr-2"
                                        title="Sonra Ekle">
                                        <span class="material-symbols-outlined text-sm">add_circle</span>
                                    </button>
                                    <button 
                                        @click="removeStep(index)"
                                        class="text-red-600 hover:text-red-700"
                                        title="Sil">
                                        <span class="material-symbols-outlined text-sm">remove_circle</span>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex gap-3">
                <button 
                    @click="goBack()"
                    class="px-6 py-2 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined">arrow_back</span>
                        <span>Parametrelere Dön</span>
                    </span>
                </button>
                
                <button 
                    @click="reset()"
                    class="px-6 py-2 border border-red-300 dark:border-red-600 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                    <span class="flex items-center gap-2">
                        <span class="material-symbols-outlined">refresh</span>
                        <span>Yeni Protokol</span>
                    </span>
                </button>
            </div>
        </div>
        
        <!-- References Section (for print) -->
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6 print:block">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Referanslar</h3>
            <template x-for="ref in selectedProtocol?.main_references || []" :key="ref.first_author + ref.year">
                <div class="mb-3 text-sm text-slate-700 dark:text-slate-300">
                    <p>
                        <span class="font-medium" x-text="ref.first_author"></span> et al. 
                        (<span x-text="ref.year"></span>). 
                        <span x-text="ref.title"></span>. 
                        <em x-text="ref.journal"></em>.
                    </p>
                    <a x-show="ref.url" :href="ref.url" target="_blank" class="text-primary hover:underline text-xs">
                        <span x-text="ref.url"></span>
                    </a>
                </div>
            </template>
        </div>
    </div>
    
    <!-- Print Styles -->
    <style>
        @media print {
            .print\:block { display: block !important; }
            button { display: none !important; }
            .border { border-color: #000 !important; }
        }
    </style>

</div>
