<?php

/**
 * Authentication API Endpoints
 *
 * POST /api/auth.php?action=register
 * POST /api/auth.php?action=login
 * POST /api/auth.php?action=logout
 * GET  /api/auth.php?action=me
 */

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Response.php';
require_once __DIR__ . '/core/Auth.php';

use App\Core\Auth;
use App\Core\Response;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

try {
    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'register':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                Response::error('Method not allowed', 405);
            }

            $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;

            $user = Auth::register($data);
            Response::success($user, 'Kayıt başarılı! Giriş yapabilirsiniz.', 201);
            break;

        case 'login':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                Response::error('Method not allowed', 405);
            }

            $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;

            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';
            $remember = $data['remember'] ?? false;

            $user = Auth::login($email, $password, $remember);
            Response::success($user, 'Giriş başarılı');
            break;

        case 'logout':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                Response::error('Method not allowed', 405);
            }

            Auth::logout();
            Response::success(null, 'Çıkış başarılı');
            break;

        case 'me':
            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                Response::error('Method not allowed', 405);
            }

            // Check token header or session
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
            if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
                $token = $matches[1];
                $user = Auth::verifyToken($token);
                if (!$user) {
                    Response::unauthorized('Geçersiz token');
                }
            } else {
                $user = Auth::user();
                if (!$user) {
                    Response::unauthorized('Giriş yapmalısınız');
                }
            }

            Response::success($user);
            break;

        default:
            Response::error('Geçersiz işlem', 400);
    }

} catch (Exception $e) {
    Response::error($e->getMessage(), 400);
}
