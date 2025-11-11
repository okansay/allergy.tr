<?php
/**
 * Admin API for adding new desensitization protocols
 */

header('Content-Type: application/json');

$dataFile = __DIR__ . '/../modules/data/drug-desensitization-protocols.json';

// Handle POST request to add new protocol
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
        exit;
    }

    // Read existing data
    if (!file_exists($dataFile)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Data file not found']);
        exit;
    }

    $data = json_decode(file_get_contents($dataFile), true);

    if (!$data) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to parse data file']);
        exit;
    }

    // Validate required fields
    $required = ['protocol_id', 'protocol_label', 'drug_class', 'route'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
            exit;
        }
    }

    // Check for duplicate protocol_id
    foreach ($data['protocols'] as $protocol) {
        if ($protocol['protocol_id'] === $input['protocol_id']) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Protocol ID already exists']);
            exit;
        }
    }

    // Add new protocol
    $data['protocols'][] = $input;

    // Write back to file
    $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents($dataFile, $jsonData) === false) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Failed to write to data file']);
        exit;
    }

    echo json_encode(['success' => true, 'message' => 'Protocol added successfully']);
    exit;
}

// Handle GET request to list protocols
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!file_exists($dataFile)) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Data file not found']);
        exit;
    }

    $data = json_decode(file_get_contents($dataFile), true);
    echo json_encode(['success' => true, 'data' => $data]);
    exit;
}

http_response_code(405);
echo json_encode(['success' => false, 'message' => 'Method not allowed']);
