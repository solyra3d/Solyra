<?php
/**
 * SOLYRA - Session Manager
 * Gerenciamento seguro de sessões
 */

class Session
{
    /**
     * Iniciar sessão com configurações seguras
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', '1');
            ini_set('session.cookie_secure', '0'); // Mudar para 1 em produção HTTPS
            ini_set('session.use_strict_mode', '1');
            ini_set('session.cookie_samesite', 'Lax');
            session_start();
        }
    }

    /**
     * Definir valor na sessão
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Obter valor da sessão
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Verificar se existe na sessão
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remover valor da sessão
     */
    public static function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Definir flash message
     */
    public static function flash(string $key, string $message): void
    {
        $_SESSION['_flash'][$key] = $message;
    }

    /**
     * Obter e remover flash message
     */
    public static function getFlash(string $key): ?string
    {
        $message = $_SESSION['_flash'][$key] ?? null;
        unset($_SESSION['_flash'][$key]);
        return $message;
    }

    /**
     * Verificar se existe flash message
     */
    public static function hasFlash(string $key): bool
    {
        return isset($_SESSION['_flash'][$key]);
    }

    /**
     * Regenerar ID da sessão (após login)
     */
    public static function regenerate(): void
    {
        session_regenerate_id(true);
    }

    /**
     * Destruir sessão completamente
     */
    public static function destroy(): void
    {
        $_SESSION = [];
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        session_destroy();
    }

    /**
     * Gerar CSRF Token
     */
    public static function generateCsrfToken(): string
    {
        if (!self::has('_csrf_token')) {
            self::set('_csrf_token', bin2hex(random_bytes(32)));
        }
        return self::get('_csrf_token');
    }

    /**
     * Validar CSRF Token
     */
    public static function validateCsrfToken(?string $token): bool
    {
        if (!$token || !self::has('_csrf_token')) {
            return false;
        }
        return hash_equals(self::get('_csrf_token'), $token);
    }
}
