<?php
namespace Utils;

class Validator {
    /**
     * Nettoie une chaîne de caractères contre les failles XSS.
     */
    public static function sanitizeString(?string $value): string {
        if ($value === null) {
            return '';
        }
        return trim(htmlspecialchars(strip_tags($value), ENT_QUOTES, 'UTF-8'));
    }

    /**
     * Valide et nettoie une adresse email.
     */
    public static function sanitizeEmail(?string $email): string|false {
        if (empty($email)) {
            return false;
        }
        $sanitizedEmail = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        return filter_var($sanitizedEmail, FILTER_VALIDATE_EMAIL) ? $sanitizedEmail : false;
    }

    /**
     * Valide et nettoie une URL.
     */
    public static function sanitizeUrl(?string $url): ?string {
        if (empty($url)) {
            return null;
        }
        $sanitizedUrl = filter_var(trim($url), FILTER_SANITIZE_URL);
        return filter_var($sanitizedUrl, FILTER_VALIDATE_URL) ? $sanitizedUrl : null;
    }
}