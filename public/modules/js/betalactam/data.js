// Beta-Lactam Cross-Reactivity Data
// Reference: Comparison of R1 and R2 structural similarities between beta-lactams

const betalactamData = {
    drugs: [
        // Penicillins
        { id: 'flucloxacillin', name: 'Flucloxacillin', group: 'Penicillins', commonlyUsed: true },
        { id: 'dicloxacillin', name: 'Dicloxacillin', group: 'Penicillins', commonlyUsed: false },
        { id: 'penicillin-g', name: 'Penicillin G', group: 'Penicillins', commonlyUsed: false },
        { id: 'penicillin-v', name: 'Penicillin V', group: 'Penicillins', commonlyUsed: true },
        { id: 'piperacillin', name: 'Piperacillin', group: 'Penicillins', commonlyUsed: false },
        { id: 'ampicillin', name: 'Ampicillin', group: 'Penicillins', commonlyUsed: false },
        { id: 'amoxicillin', name: 'Amoxicillin', group: 'Penicillins', commonlyUsed: true },
        { id: 'pivmecillinam', name: 'Pivmecillinam', group: 'Penicillins', commonlyUsed: true },

        // Cephalosporins 1st generation
        { id: 'cefadroxil', name: 'Cefadroxil', group: 'Cephalosporins (1st Gen)', commonlyUsed: true },
        { id: 'cefatrizine', name: 'Cefatrizine', group: 'Cephalosporins (1st Gen)', commonlyUsed: false },
        { id: 'cephalexin', name: 'Cephalexin', group: 'Cephalosporins (1st Gen)', commonlyUsed: true },
        { id: 'cefazolin', name: 'Cefazolin', group: 'Cephalosporins (1st Gen)', commonlyUsed: true },
        { id: 'cephalothin', name: 'Cephalothin', group: 'Cephalosporins (1st Gen)', commonlyUsed: false },
        { id: 'cefradine', name: 'Cefradine', group: 'Cephalosporins (1st Gen)', commonlyUsed: false },

        // Cephalosporins 2nd generation
        { id: 'cefoxitin', name: 'Cefoxitin', group: 'Cephalosporins (2nd Gen)', commonlyUsed: false },
        { id: 'cefuroxime', name: 'Cefuroxime', group: 'Cephalosporins (2nd Gen)', commonlyUsed: true },
        { id: 'cefotiam', name: 'Cefotiam', group: 'Cephalosporins (2nd Gen)', commonlyUsed: false },
        { id: 'cefprozil', name: 'Cefprozil', group: 'Cephalosporins (2nd Gen)', commonlyUsed: true },
        { id: 'cefaclor', name: 'Cefaclor', group: 'Cephalosporins (2nd Gen)', commonlyUsed: true },
        { id: 'cefonicid', name: 'Cefonicid', group: 'Cephalosporins (2nd Gen)', commonlyUsed: false },
        { id: 'cefamandole', name: 'Cefamandole', group: 'Cephalosporins (2nd Gen)', commonlyUsed: false },
        { id: 'ceforamide', name: 'Ceforamide', group: 'Cephalosporins (2nd Gen)', commonlyUsed: false },
        { id: 'loracarbef', name: 'Loracarbef', group: 'Cephalosporins (2nd Gen)', commonlyUsed: false },

        // Cephalosporins 3rd generation
        { id: 'cefoperazone', name: 'Cefoperazone', group: 'Cephalosporins (3rd Gen)', commonlyUsed: false },
        { id: 'ceftibuten', name: 'Ceftibuten', group: 'Cephalosporins (3rd Gen)', commonlyUsed: true },
        { id: 'cefixime', name: 'Cefixime', group: 'Cephalosporins (3rd Gen)', commonlyUsed: true },
        { id: 'ceftriaxone', name: 'Ceftriaxone', group: 'Cephalosporins (3rd Gen)', commonlyUsed: true },
        { id: 'cefditoren', name: 'Cefditoren', group: 'Cephalosporins (3rd Gen)', commonlyUsed: false },
        { id: 'cefodizime', name: 'Cefodizime', group: 'Cephalosporins (3rd Gen)', commonlyUsed: false },
        { id: 'cefotaxime', name: 'Cefotaxime', group: 'Cephalosporins (3rd Gen)', commonlyUsed: false },
        { id: 'cefpodoxime', name: 'Cefpodoxime', group: 'Cephalosporins (3rd Gen)', commonlyUsed: true },
        { id: 'ceftizoxime', name: 'Ceftizoxime', group: 'Cephalosporins (3rd Gen)', commonlyUsed: false },
        { id: 'cefetamet', name: 'Cefetamet', group: 'Cephalosporins (3rd Gen)', commonlyUsed: false },
        { id: 'ceftazidime', name: 'Ceftazidime', group: 'Cephalosporins (3rd Gen)', commonlyUsed: false },

        // Cephalosporins 4th generation
        { id: 'cefepime', name: 'Cefepime', group: 'Cephalosporins (4th Gen)', commonlyUsed: false },
        { id: 'cefpirome', name: 'Cefpirome', group: 'Cephalosporins (4th Gen)', commonlyUsed: false },

        // Cephalosporins 5th generation
        { id: 'ceftaroline', name: 'Ceftaroline fosamil', group: 'Cephalosporins (5th Gen)', commonlyUsed: false },
        { id: 'ceftolozane', name: 'Ceftolozane', group: 'Cephalosporins (5th Gen)', commonlyUsed: false },
        { id: 'cefiderocol', name: 'Cefiderocol', group: 'Cephalosporins (5th Gen)', commonlyUsed: false },

        // Monobactam
        { id: 'aztreonam', name: 'Aztreonam', group: 'Monobactam', commonlyUsed: false }
    ],

    // Cross-reactivity matrix (only non-empty relationships are stored)
    crossReactivity: {
        'flucloxacillin': {
            'dicloxacillin': 'r1'
        },
        'dicloxacillin': {
            'flucloxacillin': 'r1'
        },
        'penicillin-g': {
            'penicillin-v': "r1'", 'piperacillin': "r1'", 'ampicillin': "r1'", 'amoxicillin': "r1'",
            'cefadroxil': 'r1', 'cefatrizine': 'r1', 'cephalexin': 'r1',
            'cefprozil': 'r1', 'cefaclor': 'r1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1', 'loracarbef': 'r1',
            'cefoperazone': "r1'"
        },
        'penicillin-v': {
            'penicillin-g': "r1'", 'piperacillin': "r1'", 'ampicillin': "r1'", 'amoxicillin': "r1'",
            'cefadroxil': 'r1', 'cefatrizine': 'r1', 'cephalexin': 'r1',
            'cefprozil': 'r1', 'cefaclor': 'r1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1', 'loracarbef': 'r1',
            'cefoperazone': "r1'"
        },
        'piperacillin': {
            'penicillin-g': "r1'", 'penicillin-v': "r1'", 'ampicillin': "R1'", 'amoxicillin': "r1'",
            'cefadroxil': "r1'", 'cefatrizine': "r1'", 'cephalexin': "R1'",
            'cefprozil': "r1'", 'cefaclor': "R1'", 'cefonicid': "r1'", 'cefamandole': "r1'", 'ceforamide': 'r1', 'loracarbef': "R1'",
            'cefoperazone': "R1''"
        },
        'ampicillin': {
            'penicillin-g': "r1'", 'penicillin-v': "r1'", 'piperacillin': "R1'", 'amoxicillin': "r1'",
            'cefadroxil': 'r1', 'cefatrizine': 'r1', 'cephalexin': 'R1', 'cefradine': 'r1',
            'cefprozil': 'r1', 'cefaclor': 'R1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1', 'loracarbef': 'R1',
            'cefoperazone': "r1'"
        },
        'amoxicillin': {
            'penicillin-g': "r1'", 'penicillin-v': "r1'", 'piperacillin': "r1'", 'ampicillin': "r1'",
            'cefadroxil': 'R1', 'cefatrizine': 'R1', 'cephalexin': 'r1', 'cefradine': 'r1',
            'cefprozil': 'R1', 'cefaclor': 'r1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1', 'loracarbef': 'r1',
            'cefoperazone': "R1'"
        },
        'cefadroxil': {
            'penicillin-g': 'r1', 'penicillin-v': 'r1', 'piperacillin': "r1'", 'ampicillin': 'r1', 'amoxicillin': 'R1',
            'cefatrizine': 'R1', 'cephalexin': 'r1', 'cefradine': 'r1',
            'cefprozil': 'R1', 'cefaclor': 'r1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1', 'loracarbef': 'r1',
            'cefoperazone': "R1'"
        },
        'cefatrizine': {
            'penicillin-g': 'r1', 'penicillin-v': 'r1', 'piperacillin': "r1'", 'ampicillin': 'r1', 'amoxicillin': 'R1',
            'cefadroxil': 'R1', 'cephalexin': 'r1', 'cefradine': 'r1',
            'cefotiam': 'r2',
            'cefprozil': 'R1', 'cefaclor': 'r1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1r2', 'loracarbef': 'r1',
            'cefoperazone': "R1'"
        },
        'cephalexin': {
            'penicillin-g': 'r1', 'penicillin-v': 'r1', 'piperacillin': "R1'", 'ampicillin': 'R1', 'amoxicillin': 'r1',
            'cefadroxil': 'r1', 'cefatrizine': 'r1', 'cefradine': 'r1',
            'cefprozil': 'r1', 'cefaclor': 'R1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1', 'loracarbef': 'R1',
            'cefoperazone': "r1'"
        },
        'cephalothin': {
            'cefoxitin': 'R1r2', 'cefuroxime': "r1'r2",
            'cefotaxime': 'R2'
        },
        'cefradine': {
            'ampicillin': 'r1', 'amoxicillin': 'r1',
            'cefadroxil': 'r1', 'cefatrizine': 'r1', 'cephalexin': 'r1',
            'cefprozil': 'r1', 'cefaclor': 'r1', 'loracarbef': 'r1'
        },
        'cefoxitin': {
            'cephalothin': 'R1r2',
            'cefuroxime': "r1'R2",
            'cefotaxime': 'r2'
        },
        'cefuroxime': {
            'cephalothin': "r1'r2", 'cefoxitin': "r1'R2",
            'cefixime': "r1''", 'ceftriaxone': "R1''", 'cefditoren': "R1''", 'cefodizime': "R1''", 'cefotaxime': "R1''r2",
            'cefpodoxime': "R1''", 'ceftizoxime': "R1''", 'cefetamet': "R1''", 'ceftazidime': "r1''",
            'cefepime': "R1''", 'cefpirome': "R1''",
            'ceftaroline': "R1''", 'ceftolozane': "r1''", 'cefiderocol': "r1''"
        },
        'cefotiam': {
            'cefatrizine': 'r2',
            'cefonicid': 'r2', 'cefamandole': 'r2', 'ceforamide': 'r2',
            'cefoperazone': 'r2',
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': "R1'", 'cefditoren': "R1'", 'cefodizime': "R1'",
            'cefotaxime': "R1'", 'cefpodoxime': "R1'", 'ceftizoxime': "R1'", 'cefetamet': "R1'", 'ceftazidime': "R1'",
            'cefepime': "R1'", 'cefpirome': "R1'",
            'ceftaroline': "r1'", 'ceftolozane': "r1'", 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'cefprozil': {
            'penicillin-g': 'r1', 'penicillin-v': 'r1', 'piperacillin': "r1'", 'ampicillin': 'r1', 'amoxicillin': 'R1',
            'cefadroxil': 'R1', 'cefatrizine': 'R1', 'cephalexin': 'r1', 'cefradine': 'r1',
            'cefaclor': 'r1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1', 'loracarbef': 'r1',
            'cefoperazone': "R1'"
        },
        'cefaclor': {
            'penicillin-g': 'r1', 'penicillin-v': 'r1', 'piperacillin': "R1'", 'ampicillin': 'R1', 'amoxicillin': 'r1',
            'cefadroxil': 'r1', 'cefatrizine': 'r1', 'cephalexin': 'R1', 'cefradine': 'r1',
            'cefprozil': 'r1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1', 'loracarbef': 'R1',
            'cefoperazone': "r1'"
        },
        'cefonicid': {
            'penicillin-g': 'r1', 'penicillin-v': 'r1', 'piperacillin': "r1'", 'ampicillin': 'r1', 'amoxicillin': 'r1',
            'cefadroxil': 'r1', 'cefatrizine': 'r1', 'cephalexin': 'r1',
            'cefotiam': 'r2',
            'cefprozil': 'r1', 'cefaclor': 'r1', 'cefamandole': 'R1r2', 'ceforamide': 'r1r2', 'loracarbef': 'r1',
            'cefoperazone': "r1'r2"
        },
        'cefamandole': {
            'penicillin-g': 'r1', 'penicillin-v': 'r1', 'piperacillin': "r1'", 'ampicillin': 'r1', 'amoxicillin': 'r1',
            'cefadroxil': 'r1', 'cefatrizine': 'r1', 'cephalexin': 'r1',
            'cefotiam': 'r2',
            'cefprozil': 'r1', 'cefaclor': 'r1', 'cefonicid': 'R1r2', 'ceforamide': 'r1r2', 'loracarbef': 'r1',
            'cefoperazone': "r1'R2"
        },
        'ceforamide': {
            'penicillin-g': 'r1', 'penicillin-v': 'r1', 'piperacillin': 'r1', 'ampicillin': 'r1', 'amoxicillin': 'r1',
            'cefadroxil': 'r1', 'cefatrizine': 'r1r2', 'cephalexin': 'r1',
            'cefotiam': 'r2',
            'cefprozil': 'r1', 'cefaclor': 'r1', 'cefonicid': 'r1r2', 'cefamandole': 'r1r2', 'loracarbef': 'r1',
            'cefoperazone': 'r1r2'
        },
        'loracarbef': {
            'penicillin-g': 'r1', 'penicillin-v': 'r1', 'piperacillin': "R1'", 'ampicillin': 'R1', 'amoxicillin': 'r1',
            'cefadroxil': 'r1', 'cefatrizine': 'r1', 'cephalexin': 'R1', 'cefradine': 'r1',
            'cefprozil': 'r1', 'cefaclor': 'R1', 'cefonicid': 'r1', 'cefamandole': 'r1', 'ceforamide': 'r1',
            'cefoperazone': "r1'"
        },
        'cefoperazone': {
            'penicillin-g': "r1'", 'penicillin-v': "r1'", 'piperacillin': "R1''", 'ampicillin': "r1'", 'amoxicillin': "R1'",
            'cefadroxil': "R1'", 'cefatrizine': "R1'", 'cephalexin': "r1'",
            'cefotiam': 'r2',
            'cefprozil': "R1'", 'cefaclor': "r1'", 'cefonicid': "r1'r2", 'cefamandole': "r1'R2", 'ceforamide': 'r1r2', 'loracarbef': "r1'"
        },
        'ceftibuten': {
            'cefotiam': "R1'",
            'cefixime': "R1'", 'ceftriaxone': "R1'", 'cefditoren': "R1'", 'cefodizime': "R1'", 'cefotaxime': "R1'",
            'cefpodoxime': "R1'", 'ceftizoxime': "R1'", 'cefetamet': "R1'", 'ceftazidime': "R1'",
            'cefepime': "R1'", 'cefpirome': "R1'",
            'ceftaroline': 'r1', 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'cefixime': {
            'cefuroxime': "r1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'ceftriaxone': "R1'", 'cefditoren': "R1'", 'cefodizime': "R1'", 'cefotaxime': "R1'",
            'cefpodoxime': "R1'", 'ceftizoxime': "R1'", 'cefetamet': "R1'", 'ceftazidime': "R1'",
            'cefepime': "R1'", 'cefpirome': "R1'",
            'ceftaroline': 'r1', 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'ceftriaxone': {
            'cefuroxime': "R1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'cefditoren': 'R1', 'cefodizime': 'R1', 'cefotaxime': 'R1',
            'cefpodoxime': 'R1', 'ceftizoxime': 'R1', 'cefetamet': 'R1', 'ceftazidime': "R1'",
            'cefepime': 'R1', 'cefpirome': 'R1',
            'ceftaroline': "R1''", 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'cefditoren': {
            'cefuroxime': "R1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': 'R1', 'cefodizime': 'R1', 'cefotaxime': 'R1',
            'cefpodoxime': 'R1', 'ceftizoxime': 'R1', 'cefetamet': 'R1', 'ceftazidime': "R1'",
            'cefepime': 'R1', 'cefpirome': 'R1',
            'ceftaroline': "R1''", 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'cefodizime': {
            'cefuroxime': "R1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': 'R1', 'cefditoren': 'R1', 'cefotaxime': 'R1',
            'cefpodoxime': 'R1', 'ceftizoxime': 'R1', 'cefetamet': 'R1', 'ceftazidime': "R1'",
            'cefepime': 'R1', 'cefpirome': 'R1',
            'ceftaroline': "R1''", 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'cefotaxime': {
            'cephalothin': 'R2', 'cefoxitin': 'r2', 'cefuroxime': "R1''r2", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': 'R1', 'cefditoren': 'R1', 'cefodizime': 'R1',
            'cefpodoxime': 'R1', 'ceftizoxime': 'R1', 'cefetamet': 'R1', 'ceftazidime': "R1'",
            'cefepime': 'R1', 'cefpirome': 'R1',
            'ceftaroline': "R1''", 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'cefpodoxime': {
            'cefuroxime': "R1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': 'R1', 'cefditoren': 'R1', 'cefodizime': 'R1', 'cefotaxime': 'R1',
            'ceftizoxime': 'R1', 'cefetamet': 'R1', 'ceftazidime': "R1'",
            'cefepime': 'R1', 'cefpirome': 'R1',
            'ceftaroline': "R1''", 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'ceftizoxime': {
            'cefuroxime': "R1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': 'R1', 'cefditoren': 'R1', 'cefodizime': 'R1', 'cefotaxime': 'R1',
            'cefpodoxime': 'R1', 'cefetamet': 'R1', 'ceftazidime': "R1'",
            'cefepime': 'R1', 'cefpirome': 'R1',
            'ceftaroline': "R1''", 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'cefetamet': {
            'cefuroxime': "R1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': 'R1', 'cefditoren': 'R1', 'cefodizime': 'R1', 'cefotaxime': 'R1',
            'cefpodoxime': 'R1', 'ceftizoxime': 'R1', 'ceftazidime': "R1'",
            'cefepime': 'R1', 'cefpirome': 'R1',
            'ceftaroline': "R1''", 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'ceftazidime': {
            'cefuroxime': "r1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': "R1'", 'cefditoren': "R1'", 'cefodizime': "R1'", 'cefotaxime': "R1'",
            'cefpodoxime': "R1'", 'ceftizoxime': "R1'", 'cefetamet': "R1'",
            'cefepime': "R1'", 'cefpirome': "R1'r2",
            'ceftaroline': 'r1', 'ceftolozane': "R1''", 'cefiderocol': 'R1', 'aztreonam': 'R1'
        },
        'cefepime': {
            'cefuroxime': "R1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': 'R1', 'cefditoren': 'R1', 'cefodizime': 'R1', 'cefotaxime': 'R1',
            'cefpodoxime': 'R1', 'ceftizoxime': 'R1', 'cefetamet': 'R1', 'ceftazidime': "R1'",
            'cefpirome': 'R1',
            'ceftaroline': "R1''", 'ceftolozane': 'r1', 'cefiderocol': "R1'r2", 'aztreonam': "R1'"
        },
        'cefpirome': {
            'cefuroxime': "R1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': 'R1', 'cefditoren': 'R1', 'cefodizime': 'R1', 'cefotaxime': 'R1',
            'cefpodoxime': 'R1', 'ceftizoxime': 'R1', 'cefetamet': 'R1', 'ceftazidime': "R1'r2",
            'cefepime': 'R1',
            'ceftaroline': "R1''", 'ceftolozane': 'r1', 'cefiderocol': "R1'", 'aztreonam': "R1'"
        },
        'ceftaroline': {
            'cefuroxime': "R1''", 'cefotiam': "r1'",
            'ceftibuten': 'r1', 'cefixime': 'r1', 'ceftriaxone': "R1''", 'cefditoren': "R1''", 'cefodizime': "R1''", 'cefotaxime': "R1''",
            'cefpodoxime': "R1''", 'ceftizoxime': "R1''", 'cefetamet': "R1''", 'ceftazidime': 'r1',
            'cefepime': "R1''", 'cefpirome': "R1''",
            'ceftolozane': "R1'", 'cefiderocol': 'r1', 'aztreonam': 'r1'
        },
        'ceftolozane': {
            'cefuroxime': "r1''", 'cefotiam': "r1'",
            'ceftibuten': 'r1', 'cefixime': 'r1', 'ceftriaxone': 'r1', 'cefditoren': 'r1', 'cefodizime': 'r1', 'cefotaxime': 'r1',
            'cefpodoxime': 'r1', 'ceftizoxime': 'r1', 'cefetamet': 'r1', 'ceftazidime': "R1''",
            'cefepime': 'r1', 'cefpirome': 'r1',
            'ceftaroline': "R1'", 'cefiderocol': "R1''", 'aztreonam': "R1''"
        },
        'cefiderocol': {
            'cefuroxime': "r1''", 'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': "R1'", 'cefditoren': "R1'", 'cefodizime': "R1'", 'cefotaxime': "R1'",
            'cefpodoxime': "R1'", 'ceftizoxime': "R1'", 'cefetamet': "R1'", 'ceftazidime': 'R1',
            'cefepime': "R1'r2", 'cefpirome': "R1'",
            'ceftaroline': 'r1', 'ceftolozane': "R1''", 'aztreonam': 'R1'
        },
        'aztreonam': {
            'cefotiam': "R1'",
            'ceftibuten': "R1'", 'cefixime': "R1'", 'ceftriaxone': "R1'", 'cefditoren': "R1'", 'cefodizime': "R1'", 'cefotaxime': "R1'",
            'cefpodoxime': "R1'", 'ceftizoxime': "R1'", 'cefetamet': "R1'", 'ceftazidime': 'R1',
            'cefepime': "R1'", 'cefpirome': "R1'",
            'ceftaroline': 'r1', 'ceftolozane': "R1''", 'cefiderocol': 'R1'
        }
    },

    // Similarity level descriptions with color gradients by risk level
    similarityLevels: {
        // YÜKSEK RİSK - ÖZDEŞ (Çok Koyu Kırmızı - Neredeyse Siyah)
        'R1': {
            label: 'Özdeş R1 Yapısı (R1)',
            description: 'İki ilaç özdeş R1 yan zincir yapısına sahiptir',
            risk: 'Yüksek çapraz reaksiyon riski',
            color: '#7F1D1D',  // Çok koyu bordo-kırmızı (Tailwind red-900)
            bgColor: '#FFCCCC'
        },
        'R2': {
            label: 'Özdeş R2 Yapısı (R2)',
            description: 'İki ilaç özdeş R2 yan zincir yapısına sahiptir',
            risk: 'Yüksek çapraz reaksiyon riski',
            color: '#7F1D1D',  // Çok koyu bordo-kırmızı
            bgColor: '#FFE0B2'
        },

        // YÜKSEK RİSK - KISMI ÖZDEŞ (Koyu Kırmızı)
        "R1'": {
            label: "R1 Kısmi Özdeş (Halka) (R1')",
            description: 'R1 yan zincirinin sadece halka kısmı özdeştir',
            risk: 'Yüksek çapraz reaksiyon riski',
            color: '#B91C1C',  // Koyu kırmızı (Tailwind red-700)
            bgColor: '#FFD4B3'
        },
        "R1''": {
            label: "R1 Kısmi Özdeş (Dal) (R1'')",
            description: 'R1 yan zincirinin sadece dal kısmı özdeştir',
            risk: 'Yüksek çapraz reaksiyon riski',
            color: '#B91C1C',  // Koyu kırmızı
            bgColor: '#FFD4B3'
        },

        // YÜKSEK RİSK - KARMA (R1 özdeş + r2 benzer veya tersi) - Orta Kırmızı
        'R1r2': {
            label: 'R1 Özdeş + r2 Benzer (R1r2)',
            description: 'R1 özdeş, R2 benzer yapıdadır',
            risk: 'Yüksek çapraz reaksiyon riski',
            color: '#DC2626',  // Orta kırmızı (Tailwind red-600)
            bgColor: '#FFE5CC'
        },
        'r1R2': {
            label: 'r1 Benzer + R2 Özdeş (r1R2)',
            description: 'R1 benzer, R2 özdeş yapıdadır',
            risk: 'Yüksek çapraz reaksiyon riski',
            color: '#DC2626',  // Orta kırmızı
            bgColor: '#FFE5CC'
        },
        "R1'r2": {
            label: "R1' Kısmi Özdeş + r2 Benzer (R1'r2)",
            description: 'R1 kısmen özdeş, R2 benzer yapıdadır',
            risk: 'Yüksek çapraz reaksiyon riski',
            color: '#F87171',  // Açık kırmızı (Tailwind red-400)
            bgColor: '#FFEEDD'
        },

        // ORTA RİSK - BENZER (Çok Koyu Kahverengi-Amber)
        'r1': {
            label: 'Benzer R1 Yapısı (r1)',
            description: 'İki ilaç benzer R1 yan zincir yapısına sahiptir',
            risk: 'Orta çapraz reaksiyon riski',
            color: '#78350F',  // Çok koyu amber (Tailwind amber-900)
            bgColor: '#FEF3C7'
        },
        'r2': {
            label: 'Benzer R2 Yapısı (r2)',
            description: 'İki ilaç benzer R2 yan zincir yapısına sahiptir',
            risk: 'Orta çapraz reaksiyon riski',
            color: '#78350F',  // Çok koyu amber
            bgColor: '#FEF3C7'
        },

        // ORTA RİSK - KISMI BENZER (Koyu Turuncu)
        "r1'": {
            label: "R1 Kısmi Benzer (Halka) (r1')",
            description: 'R1 yan zincirinin sadece halka kısmı benzerdir',
            risk: 'Orta çapraz reaksiyon riski',
            color: '#C2410C',  // Koyu turuncu (Tailwind orange-700)
            bgColor: '#FEF9C3'
        },
        "r1''": {
            label: "R1 Kısmi Benzer (Dal) (r1'')",
            description: 'R1 yan zincirinin sadece dal kısmı benzerdir',
            risk: 'Orta çapraz reaksiyon riski',
            color: '#C2410C',  // Koyu turuncu
            bgColor: '#FEF9C3'
        },

        // ORTA RİSK - KARMA BENZER (Orta Sarı-Turuncu)
        'r1r2': {
            label: 'r1 Benzer + r2 Benzer (r1r2)',
            description: 'Hem R1 hem R2 benzer yapıdadır',
            risk: 'Orta çapraz reaksiyon riski',
            color: '#F59E0B',  // Orta amber (Tailwind amber-500)
            bgColor: '#FFFBEB'
        },
        "r1'r2": {
            label: "r1' Kısmi Benzer + r2 Benzer (r1'r2)",
            description: 'R1 kısmen benzer, R2 benzer yapıdadır',
            risk: 'Orta çapraz reaksiyon riski',
            color: '#FBBF24',  // Açık sarı (Tailwind amber-400)
            bgColor: '#FFFBEB'
        },
        "r1'R2": {
            label: "r1' Kısmi Benzer + R2 Özdeş (r1'R2)",
            description: 'R1 kısmen benzer, R2 özdeş yapıdadır',
            risk: 'Orta-Yüksek çapraz reaksiyon riski',
            color: '#D97706',  // Orta-koyu amber (Tailwind amber-600)
            bgColor: '#FEF3C7'
        },

        // DÜŞÜK RİSK - BENZERLİK YOK
        '': {
            label: 'Yapısal Benzerlik Yok',
            description: 'İki ilaç arasında R1 veya R2 yapısal benzerliği bulunmamaktadır',
            risk: 'Düşük çapraz reaksiyon riski',
            color: '#059669',  // Yeşil
            bgColor: '#D1FAE5'
        }
    }
};
