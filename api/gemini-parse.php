<?php
/**
 * Gemini 2.5 Pro - Report Parser
 * AI Destek 1: Akıllı Veri Girişi (NLP)
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
$reportText = $input['reportText'] ?? '';

if (empty($reportText)) {
    http_response_code(400);
    echo json_encode(['error' => 'Rapor metni boş olamaz']);
    exit;
}

// Gemini API Configuration
$apiKey = 'AIzaSyBq7YzYwfMnGTiGkbGfhoZ-mWWJ2DJg57U';
$apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=' . $apiKey;

// Sistem Prompt: NLP Data Extraction
$systemPrompt = "Sen, moleküler alerji diyagnostiği konusunda uzman bir veri çıkarma (data extraction) botusun. Görevin, verilen laboratuvar raporu metnini okumak ve sadece pozitif veya sınırda olan moleküler komponentleri tanımlamaktır.

ÖNEMLI KURALLAR:
1. Sadece Class 1 ve üzeri VEYA 0.35 kU/L ve üzeri değerleri pozitif kabul et.
2. Sadece komponent kodlarını (örn: Bet v 1, Phl p 5, Der p 2) döndür.
3. Çıktı formatı: Düz metin, her satırda bir komponent kodu, başka açıklama ekleme.
4. Eğer hiç pozitif komponent bulamazsan, 'HİÇ POZİTİF BULUNAMADI' yaz.

ÖRNEKLERİ İYİ İNCELE:

ÖRNEK RAPOR 1:
ImmunoCAP Results:
- rBet v 1 (Birch): 15.2 kU/L (Class 3)
- rPhl p 5 (Timothy): 3.8 kU/L (Class 2)
- rDer p 1: 0.1 kU/L (Class 0)
- rFel d 1 (Cat): < 0.10 kU/L (Negative)

DOĞRU ÇIKTI:
Bet v 1
Phl p 5

ÖRNEK RAPOR 2:
Molecular Allergy Test:
Bet v 2: Positive (18 kU/L)
Ole e 1: 2.5 (Class 1)
Der p 10: Negative
Phl p 7: 1.2 kU/L

DOĞRU ÇIKTI:
Bet v 2
Ole e 1
Phl p 7";

$userPrompt = "Aşağıdaki laboratuvar raporu metnini tara ve pozitif/sınırda olan tüm alerjen komponentlerini (örn: Bet v 1, Phl p 7, Der p 23) listele. Sadece komponent kodlarını döndür, her satırda bir tane.

RAPOR METNİ:
" . $reportText;

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
        'temperature' => 0.1,
        'topK' => 20,
        'topP' => 0.8,
        'maxOutputTokens' => 1024
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

$aiResponse = trim($result['candidates'][0]['content']['parts'][0]['text']);

// Parse AI Response
if (stripos($aiResponse, 'HİÇ POZİTİF BULUNAMADI') !== false ||
    stripos($aiResponse, 'NO POSITIVE') !== false ||
    empty($aiResponse)) {
    echo json_encode(['components' => []]);
    exit;
}

// Extract component codes (line by line)
$lines = explode("\n", $aiResponse);
$components = [];

foreach ($lines as $line) {
    $line = trim($line);

    // Remove bullet points, dashes, numbers
    $line = preg_replace('/^[\-\*\•\d\.\)]+\s*/', '', $line);

    // Match pattern: Xxx x N (allergen component format)
    if (preg_match('/^[A-Z][a-z]{1,3}\s[a-z]\s\d+(\.\d+)?$/i', $line)) {
        $components[] = $line;
    }
}

// Remove duplicates
$components = array_unique($components);
$components = array_values($components);

echo json_encode([
    'components' => $components,
    'raw_ai_response' => $aiResponse
]);
