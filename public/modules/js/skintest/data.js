// Drug Skin Test Concentrations Data
// Based on ENDA/EAACI Drug Allergy Interest Group Position Paper
// Allergy 2013; 68: 702-712

const skinTestData = {
    // Beta-lactam Antibiotics
    betalactams: [
        {
            id: 'ppll',
            name: 'Penicilloyl-poly-l-lysine (PPL)',
            searchTerms: ['penicilloyl', 'ppl', 'poly-l-lysine'],
            category: 'Beta-laktam Antibiyotikler',
            spt: '5 × 10⁻⁵ mM',
            idt: '5 × 10⁻⁵ mM',
            patch: 'Uygulanmaz',
            notes: 'Penisilin alerjisi tanısında temel determinant'
        },
        {
            id: 'mdm',
            name: 'Minor Determinant Mixture (MDM)',
            searchTerms: ['minor', 'determinant', 'mdm'],
            category: 'Beta-laktam Antibiyotikler',
            spt: '2 × 10⁻² mM',
            idt: '2 × 10⁻² mM',
            patch: 'Uygulanmaz',
            notes: 'Penisilin alerjisi tanısında minör determinant karışımı'
        },
        {
            id: 'benzylpenicillin',
            name: 'Benzylpenicillin (Penisilin G)',
            searchTerms: ['benzylpenicillin', 'penicillin', 'penisilin', 'benzil'],
            category: 'Beta-laktam Antibiyotikler',
            spt: '10,000 IU/ml',
            idt: '10,000 IU/ml',
            patch: '%5',
            notes: 'Doğal penisilin'
        },
        {
            id: 'amoxicillin',
            name: 'Amoxicillin (Amoksisilin)',
            searchTerms: ['amoxicillin', 'amoksisilin', 'amox'],
            category: 'Beta-laktam Antibiyotikler',
            spt: '20 mg/ml',
            idt: '20 mg/ml',
            patch: '%5',
            notes: 'En sık kullanılan aminopenisilin. Penisilin alerjisinde en önemli determinant'
        },
        {
            id: 'ampicillin',
            name: 'Ampicillin (Ampisilin)',
            searchTerms: ['ampicillin', 'ampisilin', 'amp'],
            category: 'Beta-laktam Antibiyotikler',
            spt: '20 mg/ml',
            idt: '20 mg/ml',
            patch: '%5',
            notes: 'Aminopenisilin grubu'
        },
        {
            id: 'cephalosporins',
            name: 'Sefalosporinler (Genel)',
            searchTerms: ['cephalosporin', 'sefalosporin', 'cef'],
            category: 'Beta-laktam Antibiyotikler',
            spt: '2 mg/ml',
            idt: '2 mg/ml',
            patch: '%5',
            notes: 'Tüm sefalosporinler için genel konsantrasyon. Bazı çalışmalar 20 mg/ml\'nin de güvenli olabileceğini önermektedir (cefuroxime, ceftriaxone, cefotaxime, ceftazidime, cefazolin, cephalexin, cefaclor, cefatrizine için - ancak cefepime hariç)'
        }
    ],

    // Perioperative Drugs - Anesthetics
    anesthetics: [
        {
            id: 'thiopental',
            name: 'Thiopental (Tiyopental)',
            searchTerms: ['thiopental', 'tiyopental'],
            category: 'Anestezik Ajanlar',
            undilutedConc: '25 mg/ml',
            spt: '25 mg/ml (Dilüe edilmemiş)',
            idt: '2.5 mg/ml (1/10 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'İndüksiyon anestezisi'
        },
        {
            id: 'propofol',
            name: 'Propofol',
            searchTerms: ['propofol'],
            category: 'Anestezik Ajanlar',
            undilutedConc: '10 mg/ml',
            spt: '10 mg/ml (Dilüe edilmemiş)',
            idt: '1 mg/ml (1/10 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'İndüksiyon ve idame anestezisi'
        },
        {
            id: 'ketamine',
            name: 'Ketamine (Ketamin)',
            searchTerms: ['ketamine', 'ketamin'],
            category: 'Anestezik Ajanlar',
            undilutedConc: '10 mg/ml',
            spt: '10 mg/ml (Dilüe edilmemiş)',
            idt: '1 mg/ml (1/10 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'Disosiyatif anestezik'
        },
        {
            id: 'etomidate',
            name: 'Etomidate',
            searchTerms: ['etomidate', 'etomidat'],
            category: 'Anestezik Ajanlar',
            undilutedConc: '2 mg/ml',
            spt: '2 mg/ml (Dilüe edilmemiş)',
            idt: '0.2 mg/ml (1/10 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'İndüksiyon anestezisi'
        },
        {
            id: 'midazolam',
            name: 'Midazolam',
            searchTerms: ['midazolam'],
            category: 'Anestezik Ajanlar',
            undilutedConc: '5 mg/ml',
            spt: '5 mg/ml (Dilüe edilmemiş)',
            idt: '0.5 mg/ml (1/10 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'Benzodiyazepin, premedikasyon ve sedasyon'
        }
    ],

    // Perioperative Drugs - Opioids
    opioids: [
        {
            id: 'fentanyl',
            name: 'Fentanyl',
            searchTerms: ['fentanyl'],
            category: 'Opioidler',
            undilutedConc: '0.05 mg/ml',
            spt: '0.05 mg/ml (Dilüe edilmemiş)',
            idt: '0.005 mg/ml (1/10 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'Güçlü sentetik opioid. Histamin salınımı yapabilir'
        },
        {
            id: 'alfentanil',
            name: 'Alfentanil',
            searchTerms: ['alfentanil'],
            category: 'Opioidler',
            undilutedConc: '0.5 mg/ml',
            spt: '0.5 mg/ml (Dilüe edilmemiş)',
            idt: '0.05 mg/ml (1/10 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'Fentanyl türevi'
        },
        {
            id: 'sufentanil',
            name: 'Sufentanil',
            searchTerms: ['sufentanil'],
            category: 'Opioidler',
            undilutedConc: '0.005 mg/ml',
            spt: '0.005 mg/ml (Dilüe edilmemiş)',
            idt: '0.0005 mg/ml (1/10 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'Güçlü fentanyl türevi'
        },
        {
            id: 'remifentanil',
            name: 'Remifentanil',
            searchTerms: ['remifentanil'],
            category: 'Opioidler',
            undilutedConc: '0.05 mg/ml',
            spt: '0.05 mg/ml (Dilüe edilmemiş)',
            idt: '0.005 mg/ml (1/10 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'Kısa etkili fentanyl türevi'
        },
        {
            id: 'morphine',
            name: 'Morphine (Morfin)',
            searchTerms: ['morphine', 'morfin'],
            category: 'Opioidler',
            undilutedConc: '10 mg/ml',
            spt: '1 mg/ml (1/10 dilüsyon)',
            idt: '0.01 mg/ml (1/1000 dilüsyon)',
            patch: '%5 petrolatum',
            notes: 'Doğal opioid. Nonspesifik histamin salınımı yapar'
        }
    ],

    // Neuromuscular Blocking Agents
    neuromuscularBlockers: [
        {
            id: 'atracurium',
            name: 'Atracurium (Atrakuryum)',
            searchTerms: ['atracurium', 'atrakuryum'],
            category: 'Nöromüsküler Blokerler',
            undilutedConc: '10 mg/ml',
            spt: '1 mg/ml (1/10 dilüsyon)',
            idt: '0.01 mg/ml (1/1000 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'Histamin salınımı yapabilir. Çapraz reaksiyon riski %60-70'
        },
        {
            id: 'cisatracurium',
            name: 'Cis-atracurium',
            searchTerms: ['cisatracurium', 'cis-atracurium'],
            category: 'Nöromüsküler Blokerler',
            undilutedConc: '2 mg/ml',
            spt: '2 mg/ml (Dilüe edilmemiş)',
            idt: '0.02 mg/ml (1/100 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'Atracurium izomeri'
        },
        {
            id: 'mivacurium',
            name: 'Mivacurium (Mivakuryum)',
            searchTerms: ['mivacurium', 'mivakuryum'],
            category: 'Nöromüsküler Blokerler',
            undilutedConc: '2 mg/ml',
            spt: '0.2 mg/ml (1/10 dilüsyon)',
            idt: '0.01 mg/ml (1/200 dilüsyon)',
            notes: 'Önerilen IDT konsantrasyonu güncellenmiştir (1/200)'
        },
        {
            id: 'rocuronium',
            name: 'Rocuronium (Rokuronyum)',
            searchTerms: ['rocuronium', 'rokuronyum'],
            category: 'Nöromüsküler Blokerler',
            undilutedConc: '10 mg/ml',
            spt: '10 mg/ml (Dilüe edilmemiş)',
            idt: '0.05 mg/ml (1/200 dilüsyon)',
            patch: 'Uygulanmaz',
            notes: 'Sık kullanılan nöromüsküler bloker'
        },
        {
            id: 'vecuronium',
            name: 'Vecuronium (Vekuronyum)',
            searchTerms: ['vecuronium', 'vekuronyum'],
            category: 'Nöromüsküler Blokerler',
            undilutedConc: '4 mg/ml',
            spt: '4 mg/ml (Dilüe edilmemiş)',
            idt: '0.04 mg/ml (1/100 dilüsyon)',
            notes: 'Önerilen IDT konsantrasyonu güncellenmiştir (1/100)'
        },
        {
            id: 'pancuronium',
            name: 'Pancuronium (Pankuronyum)',
            searchTerms: ['pancuronium', 'pankuronyum'],
            category: 'Nöromüsküler Blokerler',
            undilutedConc: '2 mg/ml',
            spt: '2 mg/ml (Dilüe edilmemiş)',
            idt: '0.04 mg/ml (1/50 dilüsyon)',
            notes: 'Önerilen IDT konsantrasyonu güncellenmiştir (1/50)'
        },
        {
            id: 'suxamethonium',
            name: 'Suxamethonium (Sukzametonyum)',
            searchTerms: ['suxamethonium', 'sukzametonyum', 'succinylcholine'],
            category: 'Nöromüsküler Blokerler',
            undilutedConc: '50 mg/ml',
            spt: '10 mg/ml (1/5 dilüsyon)',
            idt: '0.5 mg/ml (1/100 dilüsyon)',
            notes: 'Depolarize edici nöromüsküler bloker. Önerilen IDT konsantrasyonu güncellenmiştir (1/100)'
        }
    ],

    // Anticoagulants
    anticoagulants: [
        {
            id: 'heparin',
            name: 'Heparin (Unfraktione)',
            searchTerms: ['heparin', 'unfraktione', 'ufh'],
            category: 'Antikoagülanlar',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'HIT (Heparin-induced thrombocytopenia) şüphesinde test yapılmamalı'
        },
        {
            id: 'nadroparin',
            name: 'Nadroparin',
            searchTerms: ['nadroparin'],
            category: 'Antikoagülanlar',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Düşük molekül ağırlıklı heparin (LMWH)'
        },
        {
            id: 'dalteparin',
            name: 'Dalteparin',
            searchTerms: ['dalteparin'],
            category: 'Antikoagülanlar',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Düşük molekül ağırlıklı heparin (LMWH)'
        },
        {
            id: 'enoxaparin',
            name: 'Enoxaparin (Enoksaparin)',
            searchTerms: ['enoxaparin', 'enoksaparin'],
            category: 'Antikoagülanlar',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Düşük molekül ağırlıklı heparin (LMWH)'
        },
        {
            id: 'fondaparinux',
            name: 'Fondaparinux',
            searchTerms: ['fondaparinux'],
            category: 'Antikoagülanlar',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Sentetik pentasakkarit, heparinoid'
        }
    ],

    // Platinum Salts
    platinumSalts: [
        {
            id: 'carboplatin',
            name: 'Carboplatin (Karboplatin)',
            searchTerms: ['carboplatin', 'karboplatin'],
            category: 'Platin Tuzları',
            spt: '10 mg/ml',
            idt: '1 mg/ml',
            patch: 'Uygulanmaz',
            notes: 'Kemoterapötik ajan'
        },
        {
            id: 'oxaliplatin',
            name: 'Oxaliplatin (Oksaliplatin)',
            searchTerms: ['oxaliplatin', 'oksaliplatin'],
            category: 'Platin Tuzları',
            spt: '1 mg/ml',
            idt: '0.1 mg/ml',
            patch: 'Uygulanmaz',
            notes: 'Kemoterapötik ajan'
        },
        {
            id: 'cisplatin',
            name: 'Cisplatin (Sisplatin)',
            searchTerms: ['cisplatin', 'sisplatin'],
            category: 'Platin Tuzları',
            spt: '1 mg/ml',
            idt: '0.1 mg/ml',
            patch: 'Uygulanmaz',
            notes: 'Kemoterapötik ajan'
        }
    ],

    // NSAIDs
    nsaids: [
        {
            id: 'metamizole',
            name: 'Metamizole (Metamizol, Dipyrone)',
            searchTerms: ['metamizole', 'metamizol', 'dipyrone', 'novalgin'],
            category: 'NSAİİ - Pirazolon Grubu',
            spt: 'Toz',
            idt: '0.1 mg/ml',
            patch: '%10',
            notes: 'Pirazolon türevi. IgE aracılı reaksiyonlar görülebilir'
        },
        {
            id: 'paracetamol',
            name: 'Paracetamol (Asetaminofen)',
            searchTerms: ['paracetamol', 'acetaminophen', 'asetaminofen'],
            category: 'NSAİİ - Pirazolon Grubu',
            spt: 'Toz',
            idt: '0.1 mg/ml',
            patch: '%10',
            notes: 'Analjezik ve antipiretik'
        },
        {
            id: 'aspirin',
            name: 'Aspirin (Asetilsalisilik Asit)',
            searchTerms: ['aspirin', 'asa', 'acetylsalicylic', 'asetilsalisilik'],
            category: 'NSAİİ - Diğer',
            spt: 'Toz',
            idt: '0.1 mg/ml',
            patch: '%10',
            notes: 'IgE aracılı reaksiyonlar nadirdir, çoğu COX-1 inhibisyonu ilişkili'
        },
        {
            id: 'ibuprofen',
            name: 'Ibuprofen',
            searchTerms: ['ibuprofen'],
            category: 'NSAİİ - Diğer',
            spt: 'Toz',
            idt: '0.1 mg/ml',
            patch: '%10',
            notes: 'Propionic acid türevi'
        },
        {
            id: 'naproxen',
            name: 'Naproxen',
            searchTerms: ['naproxen', 'naproksen'],
            category: 'NSAİİ - Diğer',
            spt: 'Toz',
            idt: '0.1 mg/ml',
            patch: '%10',
            notes: 'Propionic acid türevi'
        },
        {
            id: 'diclofenac',
            name: 'Diclofenac (Diklofenak)',
            searchTerms: ['diclofenac', 'diklofenak'],
            category: 'NSAİİ - Diğer',
            spt: 'Toz',
            idt: '0.1 mg/ml',
            patch: '%10',
            notes: 'Acetic acid türevi'
        },
        {
            id: 'celecoxib',
            name: 'Celecoxib',
            searchTerms: ['celecoxib'],
            category: 'NSAİİ - COX-2 İnhibitörleri',
            spt: 'Toz',
            idt: '0.1 mg/ml',
            patch: '%10',
            notes: 'Selektif COX-2 inhibitörü. Dilüe edilmemiş irrite edici olabilir'
        },
        {
            id: 'etoricoxib',
            name: 'Etoricoxib',
            searchTerms: ['etoricoxib'],
            category: 'NSAİİ - COX-2 İnhibitörleri',
            spt: 'Toz',
            idt: '0.1 mg/ml',
            patch: '%10',
            notes: 'Selektif COX-2 inhibitörü'
        }
    ],

    // Biologicals
    biologicals: [
        {
            id: 'adalimumab',
            name: 'Adalimumab',
            searchTerms: ['adalimumab', 'humira'],
            category: 'Biyolojik Ajanlar',
            spt: '50 mg/ml',
            idt: '50 mg/ml',
            patch: 'Dilüe edilmemiş',
            notes: 'TNF-α antagonisti'
        },
        {
            id: 'etanercept',
            name: 'Etanercept',
            searchTerms: ['etanercept', 'enbrel'],
            category: 'Biyolojik Ajanlar',
            spt: '25 mg/ml',
            idt: '5 mg/ml',
            patch: 'Uygulanmaz',
            notes: 'TNF-α antagonisti'
        },
        {
            id: 'infliximab',
            name: 'Infliximab',
            searchTerms: ['infliximab', 'remicade'],
            category: 'Biyolojik Ajanlar',
            spt: '10 mg/ml',
            idt: '10 mg/ml',
            patch: 'Uygulanmaz',
            notes: 'TNF-α antagonisti'
        },
        {
            id: 'omalizumab',
            name: 'Omalizumab',
            searchTerms: ['omalizumab', 'xolair'],
            category: 'Biyolojik Ajanlar',
            spt: '1.25 µg/ml',
            idt: '1.25 µg/ml',
            patch: 'Uygulanmaz',
            notes: 'Anti-IgE monoklonal antikor'
        }
    ],

    // Local Anesthetics
    localAnesthetics: [
        {
            id: 'lidocaine',
            name: 'Lidocaine (Lidokain)',
            searchTerms: ['lidocaine', 'lidokain', 'xylocaine'],
            category: 'Lokal Anestezikler',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Amid grubu. Vazokonstrüktör içermeyen preparat kullanın'
        },
        {
            id: 'bupivacaine',
            name: 'Bupivacaine (Bupivakain)',
            searchTerms: ['bupivacaine', 'bupivakain', 'marcaine'],
            category: 'Lokal Anestezikler',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Amid grubu. Vazokonstrüktör içermeyen preparat kullanın'
        },
        {
            id: 'mepivacaine',
            name: 'Mepivacaine (Mepivakain)',
            searchTerms: ['mepivacaine', 'mepivakain', 'carbocaine'],
            category: 'Lokal Anestezikler',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Amid grubu. Vazokonstrüktör içermeyen preparat kullanın'
        },
        {
            id: 'prilocaine',
            name: 'Prilocaine (Prilokain)',
            searchTerms: ['prilocaine', 'prilokain', 'citanest'],
            category: 'Lokal Anestezikler',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Amid grubu. Vazokonstrüktör içermeyen preparat kullanın'
        },
        {
            id: 'procaine',
            name: 'Procaine (Prokain)',
            searchTerms: ['procaine', 'prokain', 'novocaine'],
            category: 'Lokal Anestezikler',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Ester grubu. Esterler arası çapraz reaksiyon olabilir'
        }
    ],

    // Contrast Media
    contrastMedia: [
        {
            id: 'ioversol',
            name: 'Ioversol',
            searchTerms: ['ioversol', 'optiray'],
            category: 'Kontrast Medya',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Non-iyonik düşük osmolar kontrast medya'
        },
        {
            id: 'iohexol',
            name: 'Iohexol',
            searchTerms: ['iohexol', 'omnipaque'],
            category: 'Kontrast Medya',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Non-iyonik düşük osmolar kontrast medya'
        },
        {
            id: 'iopromide',
            name: 'Iopromide',
            searchTerms: ['iopromide', 'ultravist'],
            category: 'Kontrast Medya',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Non-iyonik düşük osmolar kontrast medya'
        },
        {
            id: 'gadolinium',
            name: 'Gadolinium Chelates',
            searchTerms: ['gadolinium', 'gadovist', 'dotarem'],
            category: 'Kontrast Medya - MR',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Uygulanmaz',
            notes: 'MR kontrast ajanları. Dilüe edilmemiş IDT yalancı pozitif verebilir'
        }
    ],

    // Proton Pump Inhibitors
    ppi: [
        {
            id: 'omeprazole',
            name: 'Omeprazole',
            searchTerms: ['omeprazole', 'omeprazol'],
            category: 'Proton Pompa İnhibitörleri',
            spt: 'Dilüe edilmemiş',
            idt: '40 mg/ml',
            patch: '%10',
            notes: 'IV preparat kullanın'
        },
        {
            id: 'pantoprazole',
            name: 'Pantoprazole',
            searchTerms: ['pantoprazole', 'pantoprazol'],
            category: 'Proton Pompa İnhibitörleri',
            spt: 'Dilüe edilmemiş',
            idt: '40 mg/ml',
            patch: '%10',
            notes: 'IV preparat kullanın'
        },
        {
            id: 'esomeprazole',
            name: 'Esomeprazole',
            searchTerms: ['esomeprazole', 'esomeprazol'],
            category: 'Proton Pompa İnhibitörleri',
            spt: 'Dilüe edilmemiş',
            idt: '40 mg/ml',
            patch: '%10',
            notes: 'IV preparat kullanın'
        },
        {
            id: 'lansoprazole',
            name: 'Lansoprazole',
            searchTerms: ['lansoprazole', 'lansoprazol'],
            category: 'Proton Pompa İnhibitörleri',
            spt: 'Toz',
            idt: 'IV preparat yok',
            patch: '%10',
            notes: 'IV preparat olmadığı için SPT toz ile yapılır'
        }
    ],

    // Anticonvulsants
    anticonvulsants: [
        {
            id: 'carbamazepine',
            name: 'Carbamazepine (Karbamazepin)',
            searchTerms: ['carbamazepine', 'karbamazepin', 'tegretol'],
            category: 'Antikonvülzanlar',
            spt: 'Uygulanmaz',
            idt: 'Uygulanmaz',
            patch: '%10 (Şiddetli reaksiyonlarda %1 ile başlayın)',
            notes: 'Yama testi en yüksek duyarlılık. Şiddetli reaksiyonlarda alevlenme riski'
        },
        {
            id: 'phenytoin',
            name: 'Phenytoin (Fenitoin)',
            searchTerms: ['phenytoin', 'fenitoin', 'dilantin'],
            category: 'Antikonvülzanlar',
            spt: 'Uygulanmaz',
            idt: 'Uygulanmaz',
            patch: '%10 (Şiddetli reaksiyonlarda %1 ile başlayın)',
            notes: 'Yama testi kullanılır. DRESS, SJS/TEN riski'
        },
        {
            id: 'lamotrigine',
            name: 'Lamotrigine (Lamotrijin)',
            searchTerms: ['lamotrigine', 'lamotrijin', 'lamictal'],
            category: 'Antikonvülzanlar',
            spt: 'Uygulanmaz',
            idt: 'Uygulanmaz',
            patch: '%10 (Şiddetli reaksiyonlarda %1 ile başlayın)',
            notes: 'Yama testinin duyarlılığı düşüktür. SJS/TEN riski'
        },
        {
            id: 'phenobarbital',
            name: 'Phenobarbital (Fenobarbital)',
            searchTerms: ['phenobarbital', 'fenobarbital', 'luminal'],
            category: 'Antikonvülzanlar',
            spt: 'Uygulanmaz',
            idt: 'Uygulanmaz',
            patch: '%10 (Şiddetli reaksiyonlarda %1 ile başlayın)',
            notes: 'Yama testinin duyarlılığı düşük'
        }
    ],

    // Other drugs
    others: [
        {
            id: 'chlorhexidine',
            name: 'Chlorhexidine (Klorheksidin)',
            searchTerms: ['chlorhexidine', 'klorheksidin'],
            category: 'Antiseptikler',
            spt: '5 mg/ml',
            idt: '0.002 mg/ml',
            patch: '%1',
            notes: 'Perioperatif reaksiyonlarda test paneline dahil edilmeli'
        },
        {
            id: 'patent-blue',
            name: 'Patent Blue',
            searchTerms: ['patent blue', 'isosulfan'],
            category: 'Boyalar',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Uygulanmaz',
            notes: 'Sentinel lenf nodu haritalamada kullanılır'
        },
        {
            id: 'methylene-blue',
            name: 'Methylene Blue',
            searchTerms: ['methylene blue', 'metilen mavisi'],
            category: 'Boyalar',
            spt: '1/100 dilüsyon',
            idt: '1/100 dilüsyon',
            patch: 'Uygulanmaz',
            notes: 'Cerrahi işaretlemede kullanılır'
        },
        {
            id: 'fluorescein',
            name: 'Fluorescein',
            searchTerms: ['fluorescein', 'floresein'],
            category: 'Boyalar',
            spt: 'Dilüe edilmemiş',
            idt: '1/10 dilüsyon',
            patch: 'Dilüe edilmemiş',
            notes: 'Oftalmolojik muayenede kullanılır'
        }
    ]
};

// Flatten all drugs into a single searchable array
const allDrugs = [];
Object.keys(skinTestData).forEach(category => {
    allDrugs.push(...skinTestData[category]);
});

// Export data
if (typeof module !== 'undefined' && module.exports) {
    module.exports = { skinTestData, allDrugs };
}
