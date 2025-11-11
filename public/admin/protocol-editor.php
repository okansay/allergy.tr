<?php
/**
 * Admin Panel for Adding New Desensitization Protocols
 */

$pageTitle = 'Protokol Editörü - Allergy.tr';
?>
<?php include __DIR__ . '/../../shared/components/header.php'; ?>

<div class="min-h-screen bg-background-light dark:bg-background-dark p-4" x-data="protocolEditor()">
    <div class="max-w-5xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Protokol Editörü</h1>
            <p class="text-slate-600 dark:text-slate-400">Yeni desensitizasyon protokolü ekleyin</p>
            <a href="/" class="text-primary hover:underline text-sm">← Ana Sayfaya Dön</a>
        </div>

        <!-- Success/Error Messages -->
        <div x-show="successMessage" x-transition class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <p class="text-green-900 dark:text-green-100" x-text="successMessage"></p>
        </div>

        <div x-show="errorMessage" x-transition class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <p class="text-red-900 dark:text-red-100" x-text="errorMessage"></p>
        </div>

        <!-- Protocol Form -->
        <form @submit.prevent="submitProtocol()" class="space-y-6">
            <!-- Basic Information -->
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Temel Bilgiler</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Protokol ID <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            x-model="protocol.protocol_id"
                            required
                            placeholder="Örn: beta_lactam_iv_12_step"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-700 dark:text-white">
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Benzersiz ID, küçük harf ve alt çizgi</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Protokol Adı <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            x-model="protocol.protocol_label"
                            required
                            placeholder="Örn: IV beta-laktam hızlı desensitizasyon"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            İlaç Sınıfı <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            x-model="protocol.drug_class"
                            required
                            placeholder="Örn: beta-lactam antibiotic"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Uygulama Yolu <span class="text-red-500">*</span>
                        </label>
                        <select 
                            x-model="protocol.route"
                            required
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-700 dark:text-white">
                            <option value="">Seçin...</option>
                            <option value="IV">İntravenöz (IV)</option>
                            <option value="oral">Oral</option>
                            <option value="SC">Subkütan (SC)</option>
                            <option value="IM">İntramüsküler (IM)</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Örnek İlaçlar (virgülle ayırın)
                    </label>
                    <input 
                        type="text" 
                        x-model="exampleDrugsText"
                        placeholder="Örn: penicillin G, ampicillin, amoxicillin"
                        class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-700 dark:text-white">
                </div>
            </div>

            <!-- References -->
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Referanslar</h2>

                <template x-for="(ref, index) in protocol.main_references" :key="index">
                    <div class="border border-slate-200 dark:border-slate-700 rounded-lg p-4 mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">İlk Yazar</label>
                                <input 
                                    type="text" 
                                    x-model="ref.first_author"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Yıl</label>
                                <input 
                                    type="number" 
                                    x-model="ref.year"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Dergi</label>
                                <input 
                                    type="text" 
                                    x-model="ref.journal"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tip</label>
                                <select 
                                    x-model="ref.type"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
                                    <option value="guideline">Kılavuz</option>
                                    <option value="position_paper">Pozisyon Bildirisi</option>
                                    <option value="systematic_review">Sistematik Derleme</option>
                                    <option value="review">Derleme</option>
                                    <option value="case_series">Olgu Serisi</option>
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Başlık</label>
                                <input 
                                    type="text" 
                                    x-model="ref.title"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">URL</label>
                                <input 
                                    type="url" 
                                    x-model="ref.url"
                                    class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
                            </div>
                        </div>

                        <button 
                            type="button"
                            @click="removeReference(index)"
                            class="mt-2 text-red-600 hover:text-red-700 text-sm">
                            Referansı Kaldır
                        </button>
                    </div>
                </template>

                <button 
                    type="button"
                    @click="addReference()"
                    class="px-4 py-2 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700">
                    + Referans Ekle
                </button>
            </div>

            <!-- Scaling Configuration -->
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg p-6">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Ölçekleme Ayarları</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Ölçekleme Tipi</label>
                        <select 
                            x-model="protocol.scaling.type"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
                            <option value="relative_to_final_dose">Hedef Doza Göre Oransal</option>
                            <option value="fixed_step_sequence">Sabit Basamak Dizisi</option>
                            <option value="relative_to_final_volume">Hacim Bazlı</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Referans Final Doz (mg)</label>
                        <input 
                            type="number" 
                            step="0.01"
                            x-model="protocol.scaling.reference_final_dose_mg"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Referans Basamak Dozları (virgülle ayırın)</label>
                        <input 
                            type="text" 
                            x-model="referenceDosesText"
                            placeholder="Örn: 0.02, 0.05, 0.1, 0.2, 0.5, 1.0, 2.0"
                            class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg dark:bg-slate-700 dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex gap-3">
                <button 
                    type="submit"
                    :disabled="submitting"
                    class="flex-1 px-6 py-3 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors disabled:opacity-50">
                    <span x-show="!submitting">Protokol Ekle</span>
                    <span x-show="submitting">Ekleniyor...</span>
                </button>

                <button 
                    type="button"
                    @click="resetForm()"
                    class="px-6 py-3 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700">
                    Formu Sıfırla
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function protocolEditor() {
    return {
        protocol: {
            protocol_id: '',
            protocol_label: '',
            drug_class: '',
            example_drugs: [],
            route: '',
            main_references: [],
            scaling: {
                type: 'relative_to_final_dose',
                reference_final_dose_mg: 1000,
                reference_step_doses_mg: [],
                default_step_interval_min: 15,
                default_number_of_bags: 3
            },
            user_inputs: [],
            outputs: []
        },
        exampleDrugsText: '',
        referenceDosesText: '',
        submitting: false,
        successMessage: '',
        errorMessage: '',

        addReference() {
            this.protocol.main_references.push({
                first_author: '',
                year: new Date().getFullYear(),
                journal: '',
                title: '',
                url: '',
                type: 'review'
            });
        },

        removeReference(index) {
            this.protocol.main_references.splice(index, 1);
        },

        async submitProtocol() {
            this.submitting = true;
            this.successMessage = '';
            this.errorMessage = '';

            // Parse comma-separated fields
            if (this.exampleDrugsText) {
                this.protocol.example_drugs = this.exampleDrugsText.split(',').map(s => s.trim()).filter(s => s);
            }

            if (this.referenceDosesText) {
                this.protocol.scaling.reference_step_doses_mg = this.referenceDosesText.split(',').map(s => parseFloat(s.trim())).filter(n => !isNaN(n));
            }

            try {
                const response = await fetch('/api/protocol-admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.protocol)
                });

                const data = await response.json();

                if (data.success) {
                    this.successMessage = 'Protokol başarıyla eklendi!';
                    this.resetForm();
                    setTimeout(() => {
                        this.successMessage = '';
                    }, 5000);
                } else {
                    this.errorMessage = 'Hata: ' + data.message;
                }
            } catch (error) {
                this.errorMessage = 'Sunucu hatası: ' + error.message;
            } finally {
                this.submitting = false;
            }
        },

        resetForm() {
            this.protocol = {
                protocol_id: '',
                protocol_label: '',
                drug_class: '',
                example_drugs: [],
                route: '',
                main_references: [],
                scaling: {
                    type: 'relative_to_final_dose',
                    reference_final_dose_mg: 1000,
                    reference_step_doses_mg: [],
                    default_step_interval_min: 15,
                    default_number_of_bags: 3
                },
                user_inputs: [],
                outputs: []
            };
            this.exampleDrugsText = '';
            this.referenceDosesText = '';
        }
    };
}
</script>

<?php include __DIR__ . '/../../shared/components/footer.php'; ?>
