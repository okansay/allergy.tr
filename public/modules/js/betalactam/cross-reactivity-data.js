// Beta-Lactam Cross-Reactivity Data
// Source: FIGURE 1 - Comparison of R1 and R2 structural similarities between beta-lactams

const betalactamDrugs = {
    penicillins: [
        { name: "Flucloxacillin", commonUse: true },
        { name: "Dicloxacillin", commonUse: false },
        { name: "Penicillin G", commonUse: false },
        { name: "Penicillin V", commonUse: true },
        { name: "Piperacillin", commonUse: false },
        { name: "Ampicillin", commonUse: false },
        { name: "Amoxicillin", commonUse: true },
        { name: "Pivmecillinam", commonUse: true }
    ],
    cephalosporins1st: [
        { name: "Cefadroxil", commonUse: true },
        { name: "Cefatrizine", commonUse: false },
        { name: "Cephalexin", commonUse: true },
        { name: "Cefazolin", commonUse: true },
        { name: "Cephalothin", commonUse: false },
        { name: "Cefradine", commonUse: false }
    ],
    cephalosporins2nd: [
        { name: "Cefoxitin", commonUse: false },
        { name: "Cefuroxime", commonUse: true },
        { name: "Cefotiam", commonUse: false },
        { name: "Cefprozil", commonUse: true },
        { name: "Cefaclor", commonUse: true },
        { name: "Cefonicid", commonUse: false },
        { name: "Cefamandole", commonUse: false },
        { name: "Ceforamide", commonUse: false },
        { name: "Loracarbef", commonUse: false }
    ],
    cephalosporins3rd: [
        { name: "Cefoperazone", commonUse: false },
        { name: "Ceftibuten", commonUse: true },
        { name: "Cefixime", commonUse: true },
        { name: "Ceftriaxone", commonUse: true },
        { name: "Cefditoren", commonUse: false },
        { name: "Cefodizime", commonUse: false },
        { name: "Cefotaxime", commonUse: false },
        { name: "Cefpodoxime", commonUse: true },
        { name: "Ceftizoxime", commonUse: false },
        { name: "Cefetamet", commonUse: false },
        { name: "Ceftazidime", commonUse: false }
    ],
    cephalosporins4th: [
        { name: "Cefepime", commonUse: false },
        { name: "Cefpirome", commonUse: false }
    ],
    cephalosporins5th: [
        { name: "Ceftaroline fosamil", commonUse: false },
        { name: "Ceftolozane", commonUse: false },
        { name: "Cefiderocol", commonUse: false }
    ],
    monobactam: [
        { name: "Aztreonam", commonUse: false }
    ]
};

// Cross-reactivity matrix
// Key format: "DrugA|DrugB" -> similarity value
const crossReactivityMatrix = {
    // Flucloxacillin
    "Flucloxacillin|Dicloxacillin": "r1",

    // Dicloxacillin (no additional unique entries beyond Flucloxacillin)

    // Penicillin G
    "Penicillin G|Penicillin V": "r1'",
    "Penicillin G|Piperacillin": "r1'",
    "Penicillin G|Ampicillin": "r1'",
    "Penicillin G|Amoxicillin": "r1'",
    "Penicillin G|Cefadroxil": "r1",
    "Penicillin G|Cefatrizine": "r1",
    "Penicillin G|Cephalexin": "r1",
    "Penicillin G|Cefprozil": "r1",
    "Penicillin G|Cefaclor": "r1",
    "Penicillin G|Cefonicid": "r1",
    "Penicillin G|Cefamandole": "r1",
    "Penicillin G|Ceforamide": "r1",
    "Penicillin G|Loracarbef": "r1",
    "Penicillin G|Cefoperazone": "r1'",

    // Penicillin V
    "Penicillin V|Piperacillin": "r1'",
    "Penicillin V|Ampicillin": "r1'",
    "Penicillin V|Amoxicillin": "r1'",
    "Penicillin V|Cefadroxil": "r1",
    "Penicillin V|Cefatrizine": "r1",
    "Penicillin V|Cephalexin": "r1",
    "Penicillin V|Cefprozil": "r1",
    "Penicillin V|Cefaclor": "r1",
    "Penicillin V|Cefonicid": "r1",
    "Penicillin V|Cefamandole": "r1",
    "Penicillin V|Ceforamide": "r1",
    "Penicillin V|Loracarbef": "r1",
    "Penicillin V|Cefoperazone": "r1'",

    // Piperacillin
    "Piperacillin|Ampicillin": "R1'",
    "Piperacillin|Amoxicillin": "r1'",
    "Piperacillin|Cefadroxil": "r1'",
    "Piperacillin|Cefatrizine": "r1'",
    "Piperacillin|Cephalexin": "R1'",
    "Piperacillin|Cefprozil": "r1'",
    "Piperacillin|Cefaclor": "R1'",
    "Piperacillin|Cefonicid": "r1'",
    "Piperacillin|Cefamandole": "r1'",
    "Piperacillin|Ceforamide": "r1",
    "Piperacillin|Loracarbef": "R1'",
    "Piperacillin|Cefoperazone": "R1''",

    // Ampicillin
    "Ampicillin|Amoxicillin": "r1'",
    "Ampicillin|Cefadroxil": "r1",
    "Ampicillin|Cefatrizine": "r1",
    "Ampicillin|Cephalexin": "R1",
    "Ampicillin|Cefradine": "r1",
    "Ampicillin|Cefprozil": "r1",
    "Ampicillin|Cefaclor": "R1",
    "Ampicillin|Cefonicid": "r1",
    "Ampicillin|Cefamandole": "r1",
    "Ampicillin|Ceforamide": "r1",
    "Ampicillin|Loracarbef": "R1",
    "Ampicillin|Cefoperazone": "r1'",

    // Amoxicillin
    "Amoxicillin|Cefadroxil": "R1",
    "Amoxicillin|Cefatrizine": "R1",
    "Amoxicillin|Cephalexin": "r1",
    "Amoxicillin|Cefradine": "r1",
    "Amoxicillin|Cefprozil": "R1",
    "Amoxicillin|Cefaclor": "r1",
    "Amoxicillin|Cefonicid": "r1",
    "Amoxicillin|Cefamandole": "r1",
    "Amoxicillin|Ceforamide": "r1",
    "Amoxicillin|Loracarbef": "r1",
    "Amoxicillin|Cefoperazone": "R1'",

    // Cefadroxil
    "Cefadroxil|Cefatrizine": "R1",
    "Cefadroxil|Cephalexin": "r1",
    "Cefadroxil|Cefradine": "r1",
    "Cefadroxil|Cefprozil": "R1",
    "Cefadroxil|Cefaclor": "r1",
    "Cefadroxil|Cefonicid": "r1",
    "Cefadroxil|Cefamandole": "r1",
    "Cefadroxil|Ceforamide": "r1",
    "Cefadroxil|Loracarbef": "r1",
    "Cefadroxil|Cefoperazone": "R1'",

    // Cefatrizine
    "Cefatrizine|Cephalexin": "r1",
    "Cefatrizine|Cefradine": "r1",
    "Cefatrizine|Cefotiam": "r2",
    "Cefatrizine|Cefprozil": "R1",
    "Cefatrizine|Cefaclor": "r1",
    "Cefatrizine|Cefonicid": "r1",
    "Cefatrizine|Cefamandole": "r1",
    "Cefatrizine|Ceforamide": "r1r2",
    "Cefatrizine|Loracarbef": "r1",
    "Cefatrizine|Cefoperazone": "R1'",

    // Cephalexin
    "Cephalexin|Cefradine": "r1",
    "Cephalexin|Cefprozil": "r1",
    "Cephalexin|Cefaclor": "R1",
    "Cephalexin|Cefonicid": "r1",
    "Cephalexin|Cefamandole": "r1",
    "Cephalexin|Ceforamide": "r1",
    "Cephalexin|Loracarbef": "R1",
    "Cephalexin|Cefoperazone": "r1'",

    // Cephalothin
    "Cephalothin|Cefoxitin": "R1r2",
    "Cephalothin|Cefuroxime": "r1'r2",
    "Cephalothin|Cefotaxime": "R2",

    // Cefradine
    "Cefradine|Cefprozil": "r1",
    "Cefradine|Cefaclor": "r1",
    "Cefradine|Ceforamide": "r1",

    // Cefoxitin
    "Cefoxitin|Cefuroxime": "r1'R2",
    "Cefoxitin|Cefotaxime": "r2",

    // Cefuroxime
    "Cefuroxime|Ceftibuten": "r1''",
    "Cefuroxime|Cefixime": "R1''",
    "Cefuroxime|Ceftriaxone": "R1''",
    "Cefuroxime|Cefditoren": "R1''",
    "Cefuroxime|Cefodizime": "R1''",
    "Cefuroxime|Cefotaxime": "R1''r2",
    "Cefuroxime|Cefpodoxime": "R1''",
    "Cefuroxime|Ceftizoxime": "R1''",
    "Cefuroxime|Cefetamet": "R1''",
    "Cefuroxime|Ceftazidime": "r1''",
    "Cefuroxime|Cefepime": "R1''",
    "Cefuroxime|Cefpirome": "R1''",
    "Cefuroxime|Ceftaroline fosamil": "R1''",
    "Cefuroxime|Ceftolozane": "r1''",
    "Cefuroxime|Cefiderocol": "r1''",
    "Cefuroxime|Aztreonam": "r1''",

    // Cefotiam
    "Cefotiam|Cefatrizine": "r2",
    "Cefotiam|Cefonicid": "r2",
    "Cefotiam|Cefamandole": "r2",
    "Cefotiam|Ceforamide": "r2",
    "Cefotiam|Cefoperazone": "r2",
    "Cefotiam|Ceftibuten": "R1'",
    "Cefotiam|Cefixime": "R1'",
    "Cefotiam|Ceftriaxone": "R1'",
    "Cefotiam|Cefditoren": "R1'",
    "Cefotiam|Cefodizime": "R1'",
    "Cefotiam|Cefotaxime": "R1'",
    "Cefotiam|Cefpodoxime": "R1'",
    "Cefotiam|Ceftizoxime": "R1'",
    "Cefotiam|Cefetamet": "R1'",
    "Cefotiam|Ceftazidime": "R1'",
    "Cefotiam|Cefepime": "R1'",
    "Cefotiam|Cefpirome": "R1'",
    "Cefotiam|Ceftaroline fosamil": "r1'",
    "Cefotiam|Ceftolozane": "r1'",
    "Cefotiam|Cefiderocol": "R1'",
    "Cefotiam|Aztreonam": "R1'",

    // Cefprozil
    "Cefprozil|Cefaclor": "r1",
    "Cefprozil|Cefonicid": "r1",
    "Cefprozil|Cefamandole": "r1",
    "Cefprozil|Ceforamide": "r1",
    "Cefprozil|Loracarbef": "r1",
    "Cefprozil|Cefoperazone": "R1'",

    // Cefaclor
    "Cefaclor|Cefonicid": "r1",
    "Cefaclor|Cefamandole": "r1",
    "Cefaclor|Ceforamide": "r1",
    "Cefaclor|Loracarbef": "R1",
    "Cefaclor|Cefoperazone": "r1'",

    // Cefonicid
    "Cefonicid|Cefamandole": "R1r2",
    "Cefonicid|Ceforamide": "r1r2",
    "Cefonicid|Loracarbef": "r1",
    "Cefonicid|Cefoperazone": "r1'r2",

    // Cefamandole
    "Cefamandole|Ceforamide": "r1r2",
    "Cefamandole|Loracarbef": "r1",
    "Cefamandole|Cefoperazone": "r1'R2",

    // Ceforamide
    "Ceforamide|Loracarbef": "r1",
    "Ceforamide|Cefoperazone": "r1r2",

    // Loracarbef
    "Loracarbef|Cefoperazone": "r1'",

    // Ceftibuten
    "Ceftibuten|Cefixime": "R1'",
    "Ceftibuten|Ceftriaxone": "R1'",
    "Ceftibuten|Cefditoren": "R1'",
    "Ceftibuten|Cefodizime": "R1'",
    "Ceftibuten|Cefotaxime": "R1'",
    "Ceftibuten|Cefpodoxime": "R1'",
    "Ceftibuten|Ceftizoxime": "R1'",
    "Ceftibuten|Cefetamet": "R1'",
    "Ceftibuten|Ceftazidime": "R1'",
    "Ceftibuten|Cefepime": "R1'",
    "Ceftibuten|Cefpirome": "R1'",
    "Ceftibuten|Ceftaroline fosamil": "r1",
    "Ceftibuten|Ceftolozane": "r1",
    "Ceftibuten|Cefiderocol": "R1'",
    "Ceftibuten|Aztreonam": "R1'",

    // Cefixime
    "Cefixime|Ceftriaxone": "R1'",
    "Cefixime|Cefditoren": "R1'",
    "Cefixime|Cefodizime": "R1'",
    "Cefixime|Cefotaxime": "R1'",
    "Cefixime|Cefpodoxime": "R1'",
    "Cefixime|Ceftizoxime": "R1'",
    "Cefixime|Cefetamet": "R1'",
    "Cefixime|Ceftazidime": "R1'",
    "Cefixime|Cefepime": "R1'",
    "Cefixime|Cefpirome": "R1'",
    "Cefixime|Ceftaroline fosamil": "r1",
    "Cefixime|Ceftolozane": "r1",
    "Cefixime|Cefiderocol": "R1'",
    "Cefixime|Aztreonam": "R1'",

    // Ceftriaxone
    "Ceftriaxone|Cefditoren": "R1",
    "Ceftriaxone|Cefodizime": "R1",
    "Ceftriaxone|Cefotaxime": "R1",
    "Ceftriaxone|Cefpodoxime": "R1",
    "Ceftriaxone|Ceftizoxime": "R1",
    "Ceftriaxone|Cefetamet": "R1",
    "Ceftriaxone|Ceftazidime": "R1'",
    "Ceftriaxone|Cefepime": "R1",
    "Ceftriaxone|Cefpirome": "R1",
    "Ceftriaxone|Ceftaroline fosamil": "R1''",
    "Ceftriaxone|Ceftolozane": "r1",
    "Ceftriaxone|Cefiderocol": "R1'",
    "Ceftriaxone|Aztreonam": "R1'",

    // Cefditoren
    "Cefditoren|Cefodizime": "R1",
    "Cefditoren|Cefotaxime": "R1",
    "Cefditoren|Cefpodoxime": "R1",
    "Cefditoren|Ceftizoxime": "R1",
    "Cefditoren|Cefetamet": "R1",
    "Cefditoren|Ceftazidime": "R1'",
    "Cefditoren|Cefepime": "R1",
    "Cefditoren|Cefpirome": "R1",
    "Cefditoren|Ceftaroline fosamil": "R1''",
    "Cefditoren|Ceftolozane": "r1",
    "Cefditoren|Cefiderocol": "R1'",
    "Cefditoren|Aztreonam": "R1'",

    // Cefodizime
    "Cefodizime|Cefotaxime": "R1",
    "Cefodizime|Cefpodoxime": "R1",
    "Cefodizime|Ceftizoxime": "R1",
    "Cefodizime|Cefetamet": "R1",
    "Cefodizime|Ceftazidime": "R1'",
    "Cefodizime|Cefepime": "R1",
    "Cefodizime|Cefpirome": "R1",
    "Cefodizime|Ceftaroline fosamil": "R1''",
    "Cefodizime|Ceftolozane": "r1",
    "Cefodizime|Cefiderocol": "R1'",
    "Cefodizime|Aztreonam": "R1'",

    // Cefotaxime
    "Cefotaxime|Cefpodoxime": "R1",
    "Cefotaxime|Ceftizoxime": "R1",
    "Cefotaxime|Cefetamet": "R1",
    "Cefotaxime|Ceftazidime": "R1'",
    "Cefotaxime|Cefepime": "R1",
    "Cefotaxime|Cefpirome": "R1",
    "Cefotaxime|Ceftaroline fosamil": "R1''",
    "Cefotaxime|Ceftolozane": "r1",
    "Cefotaxime|Cefiderocol": "R1'",
    "Cefotaxime|Aztreonam": "R1'",

    // Cefpodoxime
    "Cefpodoxime|Ceftizoxime": "R1",
    "Cefpodoxime|Cefetamet": "R1",
    "Cefpodoxime|Ceftazidime": "R1'",
    "Cefpodoxime|Cefepime": "R1",
    "Cefpodoxime|Cefpirome": "R1",
    "Cefpodoxime|Ceftaroline fosamil": "R1''",
    "Cefpodoxime|Ceftolozane": "r1",
    "Cefpodoxime|Cefiderocol": "R1'",
    "Cefpodoxime|Aztreonam": "R1'",

    // Ceftizoxime
    "Ceftizoxime|Cefetamet": "R1",
    "Ceftizoxime|Ceftazidime": "R1'",
    "Ceftizoxime|Cefepime": "R1",
    "Ceftizoxime|Cefpirome": "R1",
    "Ceftizoxime|Ceftaroline fosamil": "R1''",
    "Ceftizoxime|Ceftolozane": "r1",
    "Ceftizoxime|Cefiderocol": "R1'",
    "Ceftizoxime|Aztreonam": "R1'",

    // Cefetamet
    "Cefetamet|Ceftazidime": "R1'",
    "Cefetamet|Cefepime": "R1",
    "Cefetamet|Cefpirome": "R1",
    "Cefetamet|Ceftaroline fosamil": "R1''",
    "Cefetamet|Ceftolozane": "r1",
    "Cefetamet|Cefiderocol": "R1'",
    "Cefetamet|Aztreonam": "R1'",

    // Ceftazidime
    "Ceftazidime|Cefepime": "R1'",
    "Ceftazidime|Cefpirome": "R1'r2",
    "Ceftazidime|Ceftaroline fosamil": "r1",
    "Ceftazidime|Ceftolozane": "R1''",
    "Ceftazidime|Cefiderocol": "R1",
    "Ceftazidime|Aztreonam": "R1",

    // Cefepime
    "Cefepime|Cefpirome": "R1",
    "Cefepime|Ceftaroline fosamil": "R1''",
    "Cefepime|Ceftolozane": "r1",
    "Cefepime|Cefiderocol": "R1'r2",
    "Cefepime|Aztreonam": "R1'",

    // Cefpirome
    "Cefpirome|Ceftaroline fosamil": "R1''",
    "Cefpirome|Ceftolozane": "r1",
    "Cefpirome|Cefiderocol": "R1'",
    "Cefpirome|Aztreonam": "R1'",

    // Ceftaroline fosamil
    "Ceftaroline fosamil|Ceftolozane": "R1'",
    "Ceftaroline fosamil|Cefiderocol": "r1",
    "Ceftaroline fosamil|Aztreonam": "r1",

    // Ceftolozane
    "Ceftolozane|Cefiderocol": "R1''",
    "Ceftolozane|Aztreonam": "R1''",

    // Cefiderocol
    "Cefiderocol|Aztreonam": "R1"
};
