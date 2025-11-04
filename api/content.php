<?php

/**
 * Content API Endpoints
 *
 * GET /api/content.php?type=recent
 * GET /api/content.php?type=favorites
 * GET /api/content.php?id=123
 */

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Response.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    $type = $_GET['type'] ?? '';
    $id = $_GET['id'] ?? null;

    switch ($type) {
        case 'recent':
            // Get recent content
            $sql = "SELECT c.*, m.title as module_title, m.icon as module_icon,
                           DATE_FORMAT(c.created_at, '%d.%m.%Y') as created_at
                    FROM content c
                    LEFT JOIN modules m ON c.module_id = m.id
                    WHERE c.is_published = 1
                    ORDER BY c.created_at DESC
                    LIMIT 5";

            $content = Database::query($sql);
            Response::success($content);
            break;

        case 'favorites':
            // Get user favorites (requires auth)
            Response::success(array());
            break;

        case 'modules':
            // Get all active modules
            $sql = "SELECT * FROM modules WHERE is_active = 1 ORDER BY sort_order ASC";
            $modules = Database::query($sql);
            Response::success($modules);
            break;

        default:
            if ($id) {
                // Get specific content by ID
                $content = Database::queryOne('SELECT * FROM content WHERE id = ? AND is_published = 1', array($id));
                if (!$content) {
                    Response::notFound('İçerik bulunamadı');
                }
                Response::success($content);
            } else {
                Response::error('Geçersiz istek', 400);
            }
    }

} catch (Exception $e) {
    Response::error($e->getMessage(), 500);
}
