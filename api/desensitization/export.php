<?php
/**
 * Desensitization Protocol Export Handler
 * Handles Excel and Word export of protocol tables
 */

// Error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// CORS headers
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method Not Allowed');
}

// Export functionality
if (isset($_POST['export_type']) && isset($_POST['table_data'])) {
    $type = $_POST['export_type'];
    $content = $_POST['table_data'];
    $drugName = isset($_POST['drug_name']) ? $_POST['drug_name'] : 'protokol';
    $timestamp = date('Y-m-d_H-i-s');

    // Sanitize filename
    $drugName = preg_replace('/[^a-zA-Z0-9-_]/', '', $drugName);
    $filename = "{$drugName}_{$timestamp}";

    // Check if mobile device
    $isMobile = isset($_POST['is_mobile']) && $_POST['is_mobile'] === '1';
    $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $isMobile = $isMobile || preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent);

    if ($type === 'excel') {
        // Excel export
        if ($isMobile) {
            header('Content-Type: text/html; charset=utf-8');
            header("Content-Disposition: attachment; filename=\"{$filename}.html\"");
        } else {
            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header("Content-Disposition: attachment; filename=\"{$filename}.xls\"");
        }

        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        echo '<!DOCTYPE html>';
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        echo '<meta name="ProgId" content="Excel.Sheet">';
        echo '<style>';
        echo 'table { border-collapse: collapse; width: 100%; }';
        echo 'th, td { border: 1px solid #000; padding: 8px; text-align: center; }';
        echo 'th { background-color: #4a5568; color: white; font-weight: bold; }';
        echo 'tfoot td { font-weight: bold; text-align: left; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo '<h2>İlaç Desensitizasyon Protokolü</h2>';
        echo '<p><strong>İlaç:</strong> ' . htmlspecialchars($drugName) . '</p>';
        echo '<p><strong>Tarih:</strong> ' . date('d.m.Y H:i') . '</p>';
        echo $content;
        echo '<br><br>';
        echo '<p style="font-size: 10px; color: #666;">Bu protokol eğitim amaçlıdır. Klinik uygulamada güncel kılavuzlara başvurunuz.</p>';
        echo '</body>';
        echo '</html>';
        exit;

    } elseif ($type === 'word') {
        // Word export
        if ($isMobile) {
            header('Content-Type: text/html; charset=utf-8');
            header("Content-Disposition: attachment; filename=\"{$filename}.html\"");
        } else {
            header('Content-Type: application/msword; charset=utf-8');
            header("Content-Disposition: attachment; filename=\"{$filename}.doc\"");
        }

        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        echo '<!DOCTYPE html>';
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-microsoft-com:office:word">';
        echo '<head>';
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        echo '<meta name="ProgId" content="Word.Document">';
        echo '<style>';
        echo 'body { font-family: Arial, sans-serif; font-size: 11pt; }';
        echo 'h2 { color: #2d3748; }';
        echo 'table { border-collapse: collapse; width: 100%; margin: 20px 0; }';
        echo 'th, td { border: 1px solid #000; padding: 8px; text-align: center; }';
        echo 'th { background-color: #4a5568; color: white; font-weight: bold; }';
        echo 'tfoot td { font-weight: bold; text-align: left; }';
        echo '.info { margin: 10px 0; }';
        echo '.warning { font-size: 9pt; color: #666; margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px; }';
        echo '</style>';
        echo '</head>';
        echo '<body>';
        echo '<h2>İlaç Desensitizasyon Protokolü</h2>';
        echo '<div class="info"><strong>İlaç:</strong> ' . htmlspecialchars($drugName) . '</div>';
        echo '<div class="info"><strong>Tarih:</strong> ' . date('d.m.Y H:i') . '</div>';
        echo '<div class="info"><strong>Hazırlayan:</strong> Allergy.tr Desensitizasyon Hesaplayıcı</div>';
        echo $content;
        echo '<div class="warning">';
        echo '<p><strong>Uyarı:</strong> Bu protokol eğitim amaçlıdır. Klinik uygulamada güncel kılavuzlara ve kurumsal protokollere başvurunuz.</p>';
        echo '<p><strong>Referanslar:</strong></p>';
        echo '<ul>';
        echo '<li>Castells MC, et al. Hypersensitivity drug reactions and desensitization protocols. Med Clin North Am. 2020</li>';
        echo '<li>Wong JT, Long A. Desensitization for immediate hypersensitivity: state of the art. Ann Allergy Asthma Immunol. 2018</li>';
        echo '</ul>';
        echo '</div>';
        echo '</body>';
        echo '</html>';
        exit;
    }
}

// If we reach here, invalid request
http_response_code(400);
echo json_encode(array(
    'success' => false,
    'message' => 'Geçersiz istek parametreleri'
));
?>
