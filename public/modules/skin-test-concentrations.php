<div x-data="{
    searchQuery: '',
    selectedDrugId: null,
    selectedCategory: '',

    normalizeText(text) {
        return text.toLowerCase()
            .replace(/ı/g, 'i').replace(/İ/g, 'i')
            .replace(/ğ/g, 'g').replace(/Ğ/g, 'g')
            .replace(/ü/g, 'u').replace(/Ü/g, 'u')
            .replace(/ş/g, 's').replace(/Ş/g, 's')
            .replace(/ö/g, 'o').replace(/Ö/g, 'o')
            .replace(/ç/g, 'c').replace(/Ç/g, 'c');
    },

    // TÜM 88 İLAÇ
    allDrugs: [
        // Beta-laktamlar (10)
        { id: 'ppll', name: 'Penicilloyl-poly-l-lysine (PPL)', category: 'Beta-laktam Antibiyotikler', spt: '5 × 10⁻⁵ mM', idt: '5 × 10⁻⁵ mM', patch: 'Uygulanmaz', searchTerms: ['penicilloyl', 'ppl', 'poly-l-lysine'], notes: 'Penisilin alerjisi tanısında temel determinant' },
        { id: 'mdm', name: 'Minor Determinant Mixture (MDM)', category: 'Beta-laktam Antibiyotikler', spt: '2 × 10⁻² mM', idt: '2 × 10⁻² mM', patch: 'Uygulanmaz', searchTerms: ['minor', 'determinant', 'mdm'], notes: 'Penisilin alerjisi tanısında minör determinant karışımı' },
        { id: 'benzylpenicillin', name: 'Benzylpenicillin (Penisilin G)', category: 'Beta-laktam Antibiyotikler', spt: '10,000 IU/ml', idt: '10,000 IU/ml', patch: '%5', searchTerms: ['benzylpenicillin', 'penicillin', 'penisilin', 'benzil'], notes: 'Doğal penisilin' },
        { id: 'amoxicillin', name: 'Amoxicillin (Amoksisilin)', category: 'Beta-laktam Antibiyotikler', spt: '20 mg/ml', idt: '20 mg/ml', patch: '%5', searchTerms: ['amoxicillin', 'amoksisilin', 'amox'], notes: 'En sık kullanılan aminopenisilin' },
        { id: 'ampicillin', name: 'Ampicillin (Ampisilin)', category: 'Beta-laktam Antibiyotikler', spt: '20 mg/ml', idt: '20 mg/ml', patch: '%5', searchTerms: ['ampicillin', 'ampisilin', 'amp'], notes: 'Aminopenisilin grubu' },
        { id: 'cephalosporins', name: 'Sefalosporinler (Genel)', category: 'Beta-laktam Antibiyotikler', spt: '20 mg/ml', idt: '20 mg/ml', patch: '%5', searchTerms: ['cephalosporin', 'sefalosporin', 'cef'], notes: 'Çoğu sefalosporin için 20 mg/ml' },
        { id: 'cefepime', name: 'Cefepime', category: 'Beta-laktam Antibiyotikler', spt: '2 mg/ml', idt: '2 mg/ml', patch: '%5', searchTerms: ['cefepime', 'sefepim'], notes: '4. kuşak sefalosporin. 20 mg/ml irritan olabilir' },
        { id: 'aztreonam', name: 'Aztreonam', category: 'Beta-laktam Antibiyotikler', spt: '20 mg/ml', idt: '20 mg/ml', patch: '%5', searchTerms: ['aztreonam'], notes: 'Monobaktam' },
        { id: 'imipenem', name: 'Imipenem/Cilastatin', category: 'Beta-laktam Antibiyotikler', spt: '1 mg/ml', idt: '1 mg/ml', patch: '%5', searchTerms: ['imipenem', 'cilastatin'], notes: 'Karbapenem grubu' },
        { id: 'meropenem', name: 'Meropenem', category: 'Beta-laktam Antibiyotikler', spt: '1 mg/ml', idt: '1 mg/ml', patch: '%5', searchTerms: ['meropenem'], notes: 'Karbapenem grubu' },

        // Fluorokinolonlar (4)
        { id: 'ciprofloxacin', name: 'Ciprofloxacin (Siprofloksasin)', category: 'Fluorokinolonlar', spt: '0.025 mg/ml', idt: '0.005 mg/ml', patch: 'Uygulanmaz', searchTerms: ['ciprofloxacin', 'siprofloksasin', 'cipro'], notes: 'MRGPRX2 aracılı non-IgE reaksiyonlar sıktır' },
        { id: 'levofloxacin', name: 'Levofloxacin (Levofloksasin)', category: 'Fluorokinolonlar', spt: '0.025 mg/ml', idt: '0.005 mg/ml', patch: 'Uygulanmaz', searchTerms: ['levofloxacin', 'levofloksasin', 'levo', 'tavanic'], notes: 'Yaygın kullanılan fluorokinolon' },
        { id: 'moxifloxacin', name: 'Moxifloxacin (Moksifloksasin)', category: 'Fluorokinolonlar', spt: '0.025 mg/ml', idt: '0.005 mg/ml', patch: 'Uygulanmaz', searchTerms: ['moxifloxacin', 'moksifloksasin', 'moxi', 'avelox'], notes: 'MRGPRX2 aracılı direkt mast hücre aktivasyonu' },
        { id: 'ofloxacin', name: 'Ofloxacin', category: 'Fluorokinolonlar', spt: '0.025 mg/ml', idt: '0.005 mg/ml', patch: 'Uygulanmaz', searchTerms: ['ofloxacin', 'ofloksasin'], notes: 'Fluorokinolon grubu' },

        // Diğer Antibiyotikler (5)
        { id: 'vancomycin', name: 'Vancomycin (Vankomisin)', category: 'Antibiyotikler - Glikopeptid', spt: '50 mg/ml', idt: '5 mg/ml', patch: '%10', searchTerms: ['vancomycin', 'vankomisin', 'vanko'], notes: 'Red Man Sendromu riski yüksek' },
        { id: 'teicoplanin', name: 'Teicoplanin', category: 'Antibiyotikler - Glikopeptid', spt: '25 mg/ml', idt: '2.5 mg/ml', patch: '%10', searchTerms: ['teicoplanin', 'teikoplanin'], notes: 'Vankomisin alternatifi' },
        { id: 'clarithromycin', name: 'Clarithromycin (Klaritromisin)', category: 'Antibiyotikler - Makrolid', spt: '50 mg/ml', idt: '5 mg/ml', patch: '%10', searchTerms: ['clarithromycin', 'klaritromisin', 'biaxin'], notes: 'Makrolid grubu' },
        { id: 'azithromycin', name: 'Azithromycin (Azitromisin)', category: 'Antibiyotikler - Makrolid', spt: '50 mg/ml', idt: '5 mg/ml', patch: '%10', searchTerms: ['azithromycin', 'azitromisin', 'zithromax'], notes: 'Makrolid grubu' },
        { id: 'metronidazole', name: 'Metronidazole (Metronidazol)', category: 'Antibiyotikler - Nitroimidazol', spt: '5 mg/ml', idt: '0.05 mg/ml', patch: '%10', searchTerms: ['metronidazole', 'metronidazol', 'flagyl'], notes: 'Nitroimidazol grubu' },

        // Anestezikler (5)
        { id: 'thiopental', name: 'Thiopental (Tiyopental)', category: 'Anestezik Ajanlar', spt: '25 mg/ml', idt: '2.5 mg/ml', patch: 'Uygulanmaz', searchTerms: ['thiopental', 'tiyopental'], notes: 'İndüksiyon anestezisi', undilutedConc: '25 mg/ml' },
        { id: 'propofol', name: 'Propofol', category: 'Anestezik Ajanlar', spt: '10 mg/ml', idt: '1 mg/ml', patch: 'Uygulanmaz', searchTerms: ['propofol'], notes: 'İndüksiyon ve idame anestezisi', undilutedConc: '10 mg/ml' },
        { id: 'ketamine', name: 'Ketamine (Ketamin)', category: 'Anestezik Ajanlar', spt: '10 mg/ml', idt: '1 mg/ml', patch: 'Uygulanmaz', searchTerms: ['ketamine', 'ketamin'], notes: 'Disosiyatif anestezik', undilutedConc: '10 mg/ml' },
        { id: 'etomidate', name: 'Etomidate', category: 'Anestezik Ajanlar', spt: '2 mg/ml', idt: '0.2 mg/ml', patch: 'Uygulanmaz', searchTerms: ['etomidate', 'etomidat'], notes: 'İndüksiyon anestezisi', undilutedConc: '2 mg/ml' },
        { id: 'midazolam', name: 'Midazolam', category: 'Anestezik Ajanlar', spt: '5 mg/ml', idt: '0.5 mg/ml', patch: 'Uygulanmaz', searchTerms: ['midazolam'], notes: 'Benzodiyazepin', undilutedConc: '5 mg/ml' },

        // Opioidler (5)
        { id: 'fentanyl', name: 'Fentanyl', category: 'Opioidler', spt: '0.05 mg/ml', idt: '0.005 mg/ml', patch: 'Uygulanmaz', searchTerms: ['fentanyl'], notes: 'Güçlü sentetik opioid', undilutedConc: '0.05 mg/ml' },
        { id: 'alfentanil', name: 'Alfentanil', category: 'Opioidler', spt: '0.5 mg/ml', idt: '0.05 mg/ml', patch: 'Uygulanmaz', searchTerms: ['alfentanil'], notes: 'Fentanyl türevi', undilutedConc: '0.5 mg/ml' },
        { id: 'sufentanil', name: 'Sufentanil', category: 'Opioidler', spt: '0.005 mg/ml', idt: '0.0005 mg/ml', patch: 'Uygulanmaz', searchTerms: ['sufentanil'], notes: 'Güçlü fentanyl türevi', undilutedConc: '0.005 mg/ml' },
        { id: 'remifentanil', name: 'Remifentanil', category: 'Opioidler', spt: '0.05 mg/ml', idt: '0.005 mg/ml', patch: 'Uygulanmaz', searchTerms: ['remifentanil'], notes: 'Kısa etkili', undilutedConc: '0.05 mg/ml' },
        { id: 'morphine', name: 'Morphine (Morfin)', category: 'Opioidler', spt: '1 mg/ml', idt: '0.01 mg/ml', patch: '%5 petrolatum', searchTerms: ['morphine', 'morfin'], notes: 'Doğal opioid, histamin salınımı', undilutedConc: '10 mg/ml' },

        // Nöromüsküler Blokerler (7)
        { id: 'atracurium', name: 'Atracurium (Atrakuryum)', category: 'Nöromüsküler Blokerler', spt: '1 mg/ml', idt: '0.01 mg/ml', patch: 'Uygulanmaz', searchTerms: ['atracurium', 'atrakuryum'], notes: 'Histamin salınımı, çapraz reaksiyon %60-70', undilutedConc: '10 mg/ml' },
        { id: 'cisatracurium', name: 'Cis-atracurium', category: 'Nöromüsküler Blokerler', spt: '2 mg/ml', idt: '0.02 mg/ml', patch: 'Uygulanmaz', searchTerms: ['cisatracurium', 'cis-atracurium'], notes: 'Atracurium izomeri', undilutedConc: '2 mg/ml' },
        { id: 'mivacurium', name: 'Mivacurium (Mivakuryum)', category: 'Nöromüsküler Blokerler', spt: '0.2 mg/ml', idt: '0.01 mg/ml', patch: 'Uygulanmaz', searchTerms: ['mivacurium', 'mivakuryum'], notes: 'IDT 1/200', undilutedConc: '2 mg/ml' },
        { id: 'rocuronium', name: 'Rocuronium (Rokuronyum)', category: 'Nöromüsküler Blokerler', spt: '10 mg/ml', idt: '0.05 mg/ml', patch: 'Uygulanmaz', searchTerms: ['rocuronium', 'rokuronyum'], notes: 'Sık kullanılan NM bloker', undilutedConc: '10 mg/ml' },
        { id: 'vecuronium', name: 'Vecuronium (Vekuronyum)', category: 'Nöromüsküler Blokerler', spt: '4 mg/ml', idt: '0.04 mg/ml', patch: 'Uygulanmaz', searchTerms: ['vecuronium', 'vekuronyum'], notes: 'IDT 1/100', undilutedConc: '4 mg/ml' },
        { id: 'pancuronium', name: 'Pancuronium (Pankuronyum)', category: 'Nöromüsküler Blokerler', spt: '2 mg/ml', idt: '0.04 mg/ml', patch: 'Uygulanmaz', searchTerms: ['pancuronium', 'pankuronyum'], notes: 'IDT 1/50', undilutedConc: '2 mg/ml' },
        { id: 'suxamethonium', name: 'Suxamethonium (Sukzametonyum)', category: 'Nöromüsküler Blokerler', spt: '10 mg/ml', idt: '0.5 mg/ml', patch: 'Uygulanmaz', searchTerms: ['suxamethonium', 'sukzametonyum', 'succinylcholine'], notes: 'Depolarize edici', undilutedConc: '50 mg/ml' },

        // Antikoagülanlar (5)
        { id: 'heparin', name: 'Heparin (Unfraktione)', category: 'Antikoagülanlar', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['heparin', 'unfraktione', 'ufh'], notes: 'HIT şüphesinde test yapılmamalı' },
        { id: 'nadroparin', name: 'Nadroparin', category: 'Antikoagülanlar', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['nadroparin'], notes: 'LMWH' },
        { id: 'dalteparin', name: 'Dalteparin', category: 'Antikoagülanlar', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['dalteparin'], notes: 'LMWH' },
        { id: 'enoxaparin', name: 'Enoxaparin (Enoksaparin)', category: 'Antikoagülanlar', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['enoxaparin', 'enoksaparin'], notes: 'LMWH' },
        { id: 'fondaparinux', name: 'Fondaparinux', category: 'Antikoagülanlar', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['fondaparinux'], notes: 'Sentetik pentasakkarit' },

        // Platin Tuzları (3)
        { id: 'carboplatin', name: 'Carboplatin (Karboplatin)', category: 'Platin Tuzları', spt: '10 mg/ml', idt: '1 mg/ml', patch: 'Uygulanmaz', searchTerms: ['carboplatin', 'karboplatin'], notes: 'Kemoterapötik ajan' },
        { id: 'oxaliplatin', name: 'Oxaliplatin (Oksaliplatin)', category: 'Platin Tuzları', spt: '1 mg/ml', idt: '0.1 mg/ml', patch: 'Uygulanmaz', searchTerms: ['oxaliplatin', 'oksaliplatin'], notes: 'Kemoterapötik ajan' },
        { id: 'cisplatin', name: 'Cisplatin (Sisplatin)', category: 'Platin Tuzları', spt: '1 mg/ml', idt: '0.1 mg/ml', patch: 'Uygulanmaz', searchTerms: ['cisplatin', 'sisplatin'], notes: 'Kemoterapötik ajan' },

        // Taksanlar (2)
        { id: 'paclitaxel', name: 'Paclitaxel', category: 'Kemoterapötikler - Taksan', spt: '6 mg/ml', idt: '0.001 → 1 mg/ml (kademeli)', patch: 'Uygulanmaz', searchTerms: ['paclitaxel', 'taxol'], notes: 'Seri artan IDT önerilir' },
        { id: 'docetaxel', name: 'Docetaxel', category: 'Kemoterapötikler - Taksan', spt: 'Dilüe edilmemiş', idt: '0.001 → 1 mg/ml (kademeli)', patch: 'Uygulanmaz', searchTerms: ['docetaxel', 'taxotere'], notes: 'Seri artan IDT' },

        // NSAİİ (8)
        { id: 'metamizole', name: 'Metamizole (Metamizol, Dipyrone)', category: 'NSAİİ', spt: 'Toz', idt: '0.1 mg/ml', patch: '%10', searchTerms: ['metamizole', 'metamizol', 'dipyrone', 'novalgin'], notes: 'Pirazolon türevi' },
        { id: 'paracetamol', name: 'Paracetamol (Asetaminofen)', category: 'NSAİİ', spt: 'Toz', idt: '0.1 mg/ml', patch: '%10', searchTerms: ['paracetamol', 'acetaminophen', 'asetaminofen'], notes: 'Analjezik ve antipiretik' },
        { id: 'aspirin', name: 'Aspirin (ASA)', category: 'NSAİİ', spt: 'Toz', idt: '0.1 mg/ml', patch: '%10', searchTerms: ['aspirin', 'asa', 'acetylsalicylic', 'asetilsalisilik'], notes: 'IgE aracılı reaksiyonlar nadir' },
        { id: 'ibuprofen', name: 'Ibuprofen', category: 'NSAİİ', spt: 'Toz', idt: '0.1 mg/ml', patch: '%10', searchTerms: ['ibuprofen'], notes: 'Propionic acid türevi' },
        { id: 'naproxen', name: 'Naproxen', category: 'NSAİİ', spt: 'Toz', idt: '0.1 mg/ml', patch: '%10', searchTerms: ['naproxen', 'naproksen'], notes: 'Propionic acid türevi' },
        { id: 'diclofenac', name: 'Diclofenac (Diklofenak)', category: 'NSAİİ', spt: 'Toz', idt: '0.1 mg/ml', patch: '%10', searchTerms: ['diclofenac', 'diklofenak'], notes: 'Acetic acid türevi' },
        { id: 'celecoxib', name: 'Celecoxib', category: 'NSAİİ', spt: 'Toz', idt: '0.1 mg/ml', patch: '%10', searchTerms: ['celecoxib'], notes: 'Selektif COX-2 inhibitörü' },
        { id: 'etoricoxib', name: 'Etoricoxib', category: 'NSAİİ', spt: 'Toz', idt: '0.1 mg/ml', patch: '%10', searchTerms: ['etoricoxib'], notes: 'Selektif COX-2 inhibitörü' },

        // Biyolojik Ajanlar (4)
        { id: 'adalimumab', name: 'Adalimumab', category: 'Biyolojik Ajanlar', spt: '50 mg/ml', idt: '50 mg/ml', patch: 'Dilüe edilmemiş', searchTerms: ['adalimumab', 'humira'], notes: 'TNF-α antagonisti' },
        { id: 'etanercept', name: 'Etanercept', category: 'Biyolojik Ajanlar', spt: '25 mg/ml', idt: '5 mg/ml', patch: 'Uygulanmaz', searchTerms: ['etanercept', 'enbrel'], notes: 'TNF-α antagonisti' },
        { id: 'infliximab', name: 'Infliximab', category: 'Biyolojik Ajanlar', spt: '10 mg/ml', idt: '10 mg/ml', patch: 'Uygulanmaz', searchTerms: ['infliximab', 'remicade'], notes: 'TNF-α antagonisti' },
        { id: 'omalizumab', name: 'Omalizumab', category: 'Biyolojik Ajanlar', spt: '1.25 µg/ml', idt: '1.25 µg/ml', patch: 'Uygulanmaz', searchTerms: ['omalizumab', 'xolair'], notes: 'Anti-IgE monoklonal antikor' },

        // Lokal Anestezikler (5)
        { id: 'lidocaine', name: 'Lidocaine (Lidokain)', category: 'Lokal Anestezikler', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['lidocaine', 'lidokain', 'xylocaine'], notes: 'Amid grubu' },
        { id: 'bupivacaine', name: 'Bupivacaine (Bupivakain)', category: 'Lokal Anestezikler', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['bupivacaine', 'bupivakain', 'marcaine'], notes: 'Amid grubu' },
        { id: 'mepivacaine', name: 'Mepivacaine (Mepivakain)', category: 'Lokal Anestezikler', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['mepivacaine', 'mepivakain', 'carbocaine'], notes: 'Amid grubu' },
        { id: 'prilocaine', name: 'Prilocaine (Prilokain)', category: 'Lokal Anestezikler', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['prilocaine', 'prilokain', 'citanest'], notes: 'Amid grubu' },
        { id: 'procaine', name: 'Procaine (Prokain)', category: 'Lokal Anestezikler', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['procaine', 'prokain', 'novocaine'], notes: 'Ester grubu' },

        // Kontrast Medya (4)
        { id: 'ioversol', name: 'Ioversol', category: 'Kontrast Medya', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['ioversol', 'optiray'], notes: 'Non-iyonik kontrast' },
        { id: 'iohexol', name: 'Iohexol', category: 'Kontrast Medya', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['iohexol', 'omnipaque'], notes: 'Non-iyonik kontrast' },
        { id: 'iopromide', name: 'Iopromide', category: 'Kontrast Medya', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['iopromide', 'ultravist'], notes: 'Non-iyonik kontrast' },
        { id: 'gadolinium', name: 'Gadolinium Chelates', category: 'Kontrast Medya - MR', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Uygulanmaz', searchTerms: ['gadolinium', 'gadovist', 'dotarem'], notes: 'MR kontrast ajanları' },

        // PPI (4)
        { id: 'omeprazole', name: 'Omeprazole', category: 'Proton Pompa İnhibitörleri', spt: 'Dilüe edilmemiş', idt: '40 mg/ml', patch: '%10', searchTerms: ['omeprazole', 'omeprazol'], notes: 'IV preparat kullanın' },
        { id: 'pantoprazole', name: 'Pantoprazole', category: 'Proton Pompa İnhibitörleri', spt: 'Dilüe edilmemiş', idt: '40 mg/ml', patch: '%10', searchTerms: ['pantoprazole', 'pantoprazol'], notes: 'IV preparat kullanın' },
        { id: 'esomeprazole', name: 'Esomeprazole', category: 'Proton Pompa İnhibitörleri', spt: 'Dilüe edilmemiş', idt: '40 mg/ml', patch: '%10', searchTerms: ['esomeprazole', 'esomeprazol'], notes: 'IV preparat kullanın' },
        { id: 'lansoprazole', name: 'Lansoprazole', category: 'Proton Pompa İnhibitörleri', spt: 'Toz', idt: 'IV preparat yok', patch: '%10', searchTerms: ['lansoprazole', 'lansoprazol'], notes: 'IV preparat yok' },

        // Antikonvülzanlar (4)
        { id: 'carbamazepine', name: 'Carbamazepine (Karbamazepin)', category: 'Antikonvülzanlar', spt: 'Uygulanmaz', idt: 'Uygulanmaz', patch: '%10 (Şiddetlide %1)', searchTerms: ['carbamazepine', 'karbamazepin', 'tegretol'], notes: 'Yama testi en yüksek duyarlılık' },
        { id: 'phenytoin', name: 'Phenytoin (Fenitoin)', category: 'Antikonvülzanlar', spt: 'Uygulanmaz', idt: 'Uygulanmaz', patch: '%10 (Şiddetlide %1)', searchTerms: ['phenytoin', 'fenitoin', 'dilantin'], notes: 'DRESS, SJS/TEN riski' },
        { id: 'lamotrigine', name: 'Lamotrigine (Lamotrijin)', category: 'Antikonvülzanlar', spt: 'Uygulanmaz', idt: 'Uygulanmaz', patch: '%10 (Şiddetlide %1)', searchTerms: ['lamotrigine', 'lamotrijin', 'lamictal'], notes: 'SJS/TEN riski' },
        { id: 'phenobarbital', name: 'Phenobarbital (Fenobarbital)', category: 'Antikonvülzanlar', spt: 'Uygulanmaz', idt: 'Uygulanmaz', patch: '%10 (Şiddetlide %1)', searchTerms: ['phenobarbital', 'fenobarbital', 'luminal'], notes: 'Yama testinin duyarlılığı düşük' },

        // Diğer (4)
        { id: 'chlorhexidine', name: 'Chlorhexidine (Klorheksidin)', category: 'Antiseptikler', spt: '5 mg/ml', idt: '0.002 mg/ml', patch: '%1', searchTerms: ['chlorhexidine', 'klorheksidin'], notes: 'Perioperatif reaksiyonlarda test paneline dahil edilmeli' },
        { id: 'patent-blue', name: 'Patent Blue', category: 'Boyalar', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Uygulanmaz', searchTerms: ['patent blue', 'isosulfan'], notes: 'Sentinel lenf nodu haritalama' },
        { id: 'methylene-blue', name: 'Methylene Blue', category: 'Boyalar', spt: '1/100 dilüsyon', idt: '1/100 dilüsyon', patch: 'Uygulanmaz', searchTerms: ['methylene blue', 'metilen mavisi'], notes: 'Cerrahi işaretleme' },
        { id: 'fluorescein', name: 'Fluorescein', category: 'Boyalar', spt: 'Dilüe edilmemiş', idt: '1/10 dilüsyon', patch: 'Dilüe edilmemiş', searchTerms: ['fluorescein', 'floresein'], notes: 'Oftalmolojik muayene' }
    ],

    get categories() {
        const cats = [...new Set(this.allDrugs.map(d => d.category))];
        return cats.sort((a, b) => a.localeCompare(b, 'tr'));
    },

    get drugsByCategory() {
        const grouped = {};
        this.categories.forEach(cat => {
            grouped[cat] = this.allDrugs
                .filter(d => d.category === cat)
                .sort((a, b) => a.name.localeCompare(b, 'tr'));
        });
        return grouped;
    },

    get filteredDrugs() {
        if (this.selectedCategory) {
            return this.drugsByCategory[this.selectedCategory] || [];
        }

        if (!this.searchQuery || this.searchQuery.length < 3) return [];

        const query = this.normalizeText(this.searchQuery);
        return this.allDrugs.filter(drug => {
            const nameMatch = this.normalizeText(drug.name).includes(query);
            const categoryMatch = this.normalizeText(drug.category).includes(query);
            const termsMatch = drug.searchTerms.some(term =>
                this.normalizeText(term).includes(query)
            );
            return nameMatch || categoryMatch || termsMatch;
        });
    },

    get selectedDrug() {
        return this.allDrugs.find(d => d.id === this.selectedDrugId);
    },

    selectDrug(drugId) {
        this.selectedDrugId = drugId;
        this.searchQuery = '';
        this.selectedCategory = '';
    },

    filterByCategory(category) {
        this.selectedCategory = category;
        this.searchQuery = '';
        this.selectedDrugId = null;
    },

    clearFilters() {
        this.searchQuery = '';
        this.selectedCategory = '';
        this.selectedDrugId = null;
    }
}" class="space-y-6 pb-20">

    <!-- Header -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <div class="flex items-center gap-4">
            <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-3xl">science</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">İlaç Deri Testi Konsantrasyonları</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-1">ENDA/EAACI kılavuzuna göre test konsantrasyonları</p>
                <p class="text-xs text-slate-500 dark:text-slate-500 mt-1">
                    <span x-text="allDrugs.length"></span> ilaç •
                    <span x-text="categories.length"></span> kategori
                </p>
            </div>
        </div>
    </div>

    <!-- Dropdown + Search -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <!-- Dropdown -->
        <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Listeden Seçin</label>
            <select
                x-model="selectedDrugId"
                @change="if (selectedDrugId) { searchQuery = ''; selectedCategory = ''; }"
                class="w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white">
                <option value="">İlaç seçin...</option>
                <template x-for="category in categories" :key="category">
                    <optgroup :label="category">
                        <template x-for="drug in drugsByCategory[category]" :key="drug.id">
                            <option :value="drug.id" x-text="drug.name"></option>
                        </template>
                    </optgroup>
                </template>
            </select>
        </div>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white dark:bg-slate-800/50 text-slate-500 dark:text-slate-400">VEYA</span>
            </div>
        </div>

        <!-- Search -->
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">İlaç Arayın</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input
                    type="text"
                    x-model="searchQuery"
                    @input="selectedCategory = ''; selectedDrugId = null;"
                    placeholder="İlaç adı yazın (en az 3 harf)..."
                    class="w-full pl-12 pr-12 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white"
                />
                <button
                    x-show="searchQuery.length > 0"
                    @click="searchQuery = ''"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <p class="mt-2 text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">lightbulb</span>
                Türkçe ve İngilizce isimlere göre arama yapabilirsiniz
            </p>
        </div>
    </div>

    <!-- Category Buttons -->
    <div class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Kategorilere Göre Gözat</h2>
        <div class="flex flex-wrap gap-2">
            <template x-for="category in categories" :key="category">
                <button
                    @click="filterByCategory(category)"
                    :class="selectedCategory === category ? 'bg-primary text-white border-primary' : 'bg-slate-50 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-600 hover:border-primary hover:bg-primary/10'"
                    class="px-4 py-2 rounded-lg border transition-colors text-sm font-medium">
                    <span x-text="category"></span>
                    <span class="ml-2 opacity-75" x-text="'(' + drugsByCategory[category].length + ')'"></span>
                </button>
            </template>
        </div>
        <button
            x-show="selectedCategory || searchQuery"
            @click="clearFilters()"
            class="mt-4 text-sm text-primary hover:underline">
            Filtreleri temizle
        </button>
    </div>

    <!-- Search/Category Results -->
    <div x-show="filteredDrugs.length > 0 && !selectedDrug" class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">
            <span x-text="filteredDrugs.length"></span> ilaç bulundu
        </h3>
        <div class="space-y-2 max-h-96 overflow-y-auto">
            <template x-for="drug in filteredDrugs" :key="drug.id">
                <button
                    @click="selectDrug(drug.id)"
                    class="w-full text-left p-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-primary hover:bg-primary/5 transition-colors group">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="font-semibold text-slate-900 dark:text-white group-hover:text-primary" x-text="drug.name"></div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1" x-text="drug.category"></div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400 group-hover:text-primary">chevron_right</span>
                    </div>
                </button>
            </template>
        </div>
    </div>

    <!-- Drug Details -->
    <div x-show="selectedDrug" class="bg-white dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800 rounded-xl p-6">
        <div class="border-b border-slate-200 dark:border-slate-700 pb-4 mb-6">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white" x-text="selectedDrug?.name"></h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-1" x-text="selectedDrug?.category"></p>
                </div>
                <button
                    @click="selectedDrugId = null"
                    class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-950/30 dark:to-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">vaccines</span>
                    <h3 class="font-bold text-blue-900 dark:text-blue-100">SPT</h3>
                </div>
                <p class="text-xs text-blue-700 dark:text-blue-300 mb-2">Skin Prick Test</p>
                <div class="bg-white dark:bg-blue-950/50 rounded-lg p-3">
                    <p class="text-sm font-mono font-semibold text-blue-900 dark:text-blue-100" x-text="selectedDrug?.spt || 'Belirtilmemiş'"></p>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-950/30 dark:to-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">medication</span>
                    <h3 class="font-bold text-green-900 dark:text-green-100">IDT</h3>
                </div>
                <p class="text-xs text-green-700 dark:text-green-300 mb-2">Intradermal Test</p>
                <div class="bg-white dark:bg-green-950/50 rounded-lg p-3">
                    <p class="text-sm font-mono font-semibold text-green-900 dark:text-green-100" x-text="selectedDrug?.idt || 'Belirtilmemiş'"></p>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-950/30 dark:to-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-3">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">healing</span>
                    <h3 class="font-bold text-purple-900 dark:text-purple-100">Yama Testi</h3>
                </div>
                <p class="text-xs text-purple-700 dark:text-purple-300 mb-2">Patch Test</p>
                <div class="bg-white dark:bg-purple-950/50 rounded-lg p-3">
                    <p class="text-sm font-mono font-semibold text-purple-900 dark:text-purple-100" x-text="selectedDrug?.patch || 'Uygulanmaz'"></p>
                </div>
            </div>
        </div>

        <div x-show="selectedDrug?.undilutedConc" class="mb-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Dilüe Edilmemiş Konsantrasyon</h4>
            <p class="text-sm font-mono text-slate-900 dark:text-white" x-text="selectedDrug?.undilutedConc"></p>
        </div>

        <div x-show="selectedDrug?.notes" class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4">
            <div class="flex items-start gap-2">
                <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 flex-shrink-0">info</span>
                <div class="flex-1">
                    <h4 class="text-sm font-semibold text-amber-900 dark:text-amber-100 mb-1">Önemli Notlar</h4>
                    <p class="text-sm text-amber-900 dark:text-amber-100" x-text="selectedDrug?.notes"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Reference -->
    <div class="bg-slate-50 dark:bg-slate-800/30 border border-slate-200 dark:border-slate-700 rounded-xl p-6">
        <h3 class="font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined">article</span>
            Referans
        </h3>
        <div class="text-sm text-slate-600 dark:text-slate-400 space-y-2">
            <p><strong>Kaynak:</strong> Brockow K, et al. Skin test concentrations for systemically administered drugs – an ENDA/EAACI Drug Allergy Interest Group position paper. Allergy. 2013;68(6):702-712.</p>
            <p><strong>DOI:</strong> <a href="https://doi.org/10.1111/all.12142" target="_blank" rel="noopener" class="text-primary hover:underline">10.1111/all.12142</a></p>
            <p class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                <strong class="text-amber-600 dark:text-amber-400">⚠️ Önemli Uyarı:</strong>
                Bu bilgiler eğitim amaçlıdır. Deri testleri uzman klinisyenler tarafından yapılmalıdır.
            </p>
        </div>
    </div>

</div>
