<?php

namespace App\Core;

/**
 * Authentication & Session Management
 */
class Auth
{
    private static ?array $currentUser = null;

    /**
     * Start session
     */
    public static function initSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $config = require __DIR__ . '/../config/app.php';
            $session = $config['session'];

            session_set_cookie_params([
                'lifetime' => $session['lifetime'],
                'path' => '/',
                'domain' => '',
                'secure' => $session['secure'],
                'httponly' => $session['httponly'],
                'samesite' => $session['samesite']
            ]);

            session_name($session['cookie_name']);
            session_start();
        }
    }

    /**
     * Register new user
     */
    public static function register(array $data): array
    {
        // Validate
        if (empty($data['email']) || empty($data['password']) || empty($data['full_name'])) {
            throw new \Exception('Email, şifre ve ad soyad gerekli');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Geçerli bir email adresi girin');
        }

        if (strlen($data['password']) < 6) {
            throw new \Exception('Şifre en az 6 karakter olmalı');
        }

        // Check if email exists
        $existing = Database::queryOne('SELECT id FROM users WHERE email = ?', [$data['email']]);
        if ($existing) {
            throw new \Exception('Bu email adresi zaten kullanılıyor');
        }

        // Hash password
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        // Insert user
        $sql = "INSERT INTO users (email, password, full_name, title, specialty, hospital, phone)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        Database::execute($sql, [
            $data['email'],
            $hashedPassword,
            $data['full_name'],
            $data['title'] ?? null,
            $data['specialty'] ?? 'Alerji & İmmünoloji',
            $data['hospital'] ?? null,
            $data['phone'] ?? null
        ]);

        $userId = Database::lastInsertId();

        // Get created user
        return Database::queryOne('SELECT id, email, full_name, title, specialty, hospital, phone, created_at FROM users WHERE id = ?', [$userId]);
    }

    /**
     * Login user
     */
    public static function login(string $email, string $password, bool $remember = false): array
    {
        if (empty($email) || empty($password)) {
            throw new \Exception('Email ve şifre gerekli');
        }

        // Get user
        $user = Database::queryOne('SELECT * FROM users WHERE email = ?', [$email]);

        if (!$user) {
            throw new \Exception('Email veya şifre hatalı');
        }

        // Verify password
        if (!password_verify($password, $user['password'])) {
            throw new \Exception('Email veya şifre hatalı');
        }

        // Check if active
        if (!$user['is_active']) {
            throw new \Exception('Hesabınız aktif değil');
        }

        // Update last login
        Database::execute('UPDATE users SET last_login_at = NOW() WHERE id = ?', [$user['id']]);

        // Create session
        self::initSession();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];

        // Create session token (for API usage if needed)
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+2 hours'));

        Database::execute(
            'INSERT INTO user_sessions (user_id, token, ip_address, user_agent, expires_at) VALUES (?, ?, ?, ?, ?)',
            [
                $user['id'],
                $token,
                $_SERVER['REMOTE_ADDR'] ?? null,
                $_SERVER['HTTP_USER_AGENT'] ?? null,
                $expiresAt
            ]
        );

        // Log activity
        self::logActivity($user['id'], 'login', null, 'Kullanıcı giriş yaptı');

        // Return user data (without password)
        unset($user['password']);
        $user['token'] = $token;

        return $user;
    }

    /**
     * Logout user
     */
    public static function logout(): void
    {
        self::initSession();

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];

            // Remove all sessions
            Database::execute('DELETE FROM user_sessions WHERE user_id = ?', [$userId]);

            // Log activity
            self::logActivity($userId, 'logout', null, 'Kullanıcı çıkış yaptı');
        }

        session_destroy();
    }

    /**
     * Get current logged in user
     */
    public static function user(): ?array
    {
        if (self::$currentUser !== null) {
            return self::$currentUser;
        }

        self::initSession();

        if (!isset($_SESSION['user_id'])) {
            return null;
        }

        $user = Database::queryOne(
            'SELECT id, email, full_name, title, specialty, hospital, phone, profile_image, created_at FROM users WHERE id = ? AND is_active = 1',
            [$_SESSION['user_id']]
        );

        self::$currentUser = $user ?: null;
        return self::$currentUser;
    }

    /**
     * Check if user is logged in
     */
    public static function check(): bool
    {
        return self::user() !== null;
    }

    /**
     * Require authentication (throw exception if not logged in)
     */
    public static function require(): void
    {
        if (!self::check()) {
            Response::unauthorized('Bu işlem için giriş yapmalısınız');
        }
    }

    /**
     * Verify token (for API requests)
     */
    public static function verifyToken(string $token): ?array
    {
        $session = Database::queryOne(
            'SELECT * FROM user_sessions WHERE token = ? AND expires_at > NOW()',
            [$token]
        );

        if (!$session) {
            return null;
        }

        return Database::queryOne(
            'SELECT id, email, full_name, title, specialty, hospital, phone, profile_image FROM users WHERE id = ? AND is_active = 1',
            [$session['user_id']]
        );
    }

    /**
     * Log user activity
     */
    public static function logActivity(int $userId, string $activityType, ?string $moduleName = null, ?string $description = null): void
    {
        Database::execute(
            'INSERT INTO user_activities (user_id, activity_type, module_name, description, ip_address) VALUES (?, ?, ?, ?, ?)',
            [
                $userId,
                $activityType,
                $moduleName,
                $description,
                $_SERVER['REMOTE_ADDR'] ?? null
            ]
        );
    }
}
