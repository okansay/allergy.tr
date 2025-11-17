<?php
/**
 * Gemini 2.5 Pro - Results Interpreter
 * AI Destek 2 & 3: Nuanslı Raporlama + Gri Alan Analizi
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$selectedComponents = $input['selectedComponents'] ?? [];
$ruleEngineResults = $input['ruleEngineResults'] ?? [];

if (empty($selectedComponents) || empty($ruleEngineResults)) {
    http_response_code(400);
    echo json_encode(['error' => 'Komponent ve sonuç verileri gerekli']);
    exit;
}

// Pozitif komponentleri filtrele
$positiveComponents = array_keys(array_filter($selectedComponents, function($value) {
    return $value === true;
}));

if (empty($positiveComponents)) {
    echo json_encode(['interpretation' => '<p>Hiç pozitif komponent seçilmedi.</p>']);
    exit;
}

// Gemini API Configuration
$apiKey = 'AIzaSyBq7YzYwfMnGTiGkbGfhoZ-mWWJ2DJg57U';
$apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=' . $apiKey;

// Sistem Prompt: Klinik Yorum + Gri Alan Analizi
$systemPrompt = "Sen, EAACI 2024 Molecular Allergology Pocket Guide kılavuzuna hakim, uzman bir alergolog ve immünologsun. Bir meslektaşına hastanın moleküler alerji profili hakkında kısa ve profesyonel bir epikriz (klinik özet) yazıyorsun.

ÖNEMLİ KURALLAR:
1. Teknik analiz sonuçlarını akıcı bir tıbbi metne dönüştür.
2. ASLA yeni bir tanı koyma veya analiz dışı yorum yapma.
3. AIT (immünoterapi) önerilerini net bir şekilde belirt.
4. Panalerjen pozitifliklerini ve çapraz reaksiyon risklerini açıkla.
5. Eksik test edilen komponentleri tespit et ve ek test önerileri sun.
6. HTML formatında yaz (başlıklar için <h4>, paragraflar için <p>, listeler için <ul>/<li>).
7. Medikal terminolojiyi kullan ama anlaşılır ol.
8. Kısa ve öz yaz (maksimum 500 kelime).

RAPOR YAPISI (bu başlıkları kullan):
1. <h4>Genel Değerlendirme ve AIT Uygunluğu</h4>
2. <h4>Detaylı Bulgular ve Riskler</h4>
3. <h4>Önerilen Ek Testler (Gri Alan Analizi)</h4>";

$positiveList = implode(', ', $positiveComponents);
$technicalAnalysis = json_encode($ruleEngineResults, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

$userPrompt = "Lütfen aşağıdaki verilere dayanarak bir klinik özet yaz:

POZİTİF TESTLER (" . count($positiveComponents) . " adet):
" . $positiveList . "

TEKNİK ANALİZ (Kural Motoru Çıktısı):
" . $technicalAnalysis . "

Yukarıdaki rapor yapısına göre HTML formatında bir epikriz hazırla. Özellikle 'Önerilen Ek Testler' bölümünde, hangi primer belirteçlerin test edilmediğini veya hangi risk profillerinin netleştirilmesi gerektiğini belirt.";

// Gemini API Request Payload
$payload = [
    'contents' => [
        [
            'parts' => [
                ['text' => $systemPrompt . "\n\n" . $userPrompt]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.4,
        'topK' => 40,
        'topP' => 0.9,
        'maxOutputTokens' => 2048
    ]
];

// cURL Request to Gemini API
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    http_response_code(500);
    echo json_encode(['error' => 'API bağlantı hatası: ' . $curlError]);
    exit;
}

if ($httpCode !== 200) {
    http_response_code($httpCode);
    echo json_encode(['error' => 'Gemini API hatası (HTTP ' . $httpCode . ')', 'details' => $response]);
    exit;
}

$result = json_decode($response, true);

if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Gemini API yanıtı beklenmedik formatta', 'raw' => $result]);
    exit;
}

$aiInterpretation = trim($result['candidates'][0]['content']['parts'][0]['text']);

// Clean up markdown artifacts if present
$aiInterpretation = preg_replace('/```html\n/', '', $aiInterpretation);
$aiInterpretation = preg_replace('/\n```$/', '', $aiInterpretation);
$aiInterpretation = trim($aiInterpretation);

echo json_encode([
    'interpretation' => $aiInterpretation
]);
