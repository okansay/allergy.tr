<?php

/**
 * API Response Helper
 * Compatible with PHP 5.6+ and Hostinger shared hosting
 */
class Response
{
    /**
     * Send JSON response
     */
    public static function json($data, $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Send success response
     */
    public static function success($data = null, $message = 'İşlem başarılı', $statusCode = 200)
    {
        self::json(array(
            'success' => true,
            'message' => $message,
            'data' => $data
        ), $statusCode);
    }

    /**
     * Send error response
     */
    public static function error($message = 'Bir hata oluştu', $statusCode = 400, $errors = null)
    {
        self::json(array(
            'success' => false,
            'message' => $message,
            'errors' => $errors
        ), $statusCode);
    }

    /**
     * Send unauthorized response
     */
    public static function unauthorized($message = 'Yetkisiz erişim')
    {
        self::error($message, 401);
    }

    /**
     * Send forbidden response
     */
    public static function forbidden($message = 'Bu işlem için yetkiniz yok')
    {
        self::error($message, 403);
    }

    /**
     * Send not found response
     */
    public static function notFound($message = 'Kaynak bulunamadı')
    {
        self::error($message, 404);
    }

    /**
     * Send validation error response
     */
    public static function validationError($errors, $message = 'Doğrulama hatası')
    {
        self::error($message, 422, $errors);
    }
}
