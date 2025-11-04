<?php

namespace App\Core;

/**
 * API Response Helper
 */
class Response
{
    /**
     * Send JSON response
     */
    public static function json(mixed $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Send success response
     */
    public static function success(mixed $data = null, string $message = 'İşlem başarılı', int $statusCode = 200): void
    {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Send error response
     */
    public static function error(string $message = 'Bir hata oluştu', int $statusCode = 400, mixed $errors = null): void
    {
        self::json([
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Send unauthorized response
     */
    public static function unauthorized(string $message = 'Yetkisiz erişim'): void
    {
        self::error($message, 401);
    }

    /**
     * Send forbidden response
     */
    public static function forbidden(string $message = 'Bu işlem için yetkiniz yok'): void
    {
        self::error($message, 403);
    }

    /**
     * Send not found response
     */
    public static function notFound(string $message = 'Kaynak bulunamadı'): void
    {
        self::error($message, 404);
    }

    /**
     * Send validation error response
     */
    public static function validationError(array $errors, string $message = 'Doğrulama hatası'): void
    {
        self::error($message, 422, $errors);
    }
}
