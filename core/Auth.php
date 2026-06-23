<?php
/**
 * SOLYRA - Auth
 * Sistema de autenticação para área administrativa
 */

class Auth
{
    /**
     * Tentar login
     */
    public static function attempt(string $email, string $password): bool
    {
        $user = Database::fetchOne(
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$email]
        );

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Login bem-sucedido - regenerar sessão
        Session::regenerate();
        Session::set('user_id', $user['id']);
        Session::set('user_name', $user['name']);
        Session::set('user_email', $user['email']);
        Session::set('user_role', $user['role']);

        return true;
    }

    /**
     * Verificar se está autenticado
     */
    public static function check(): bool
    {
        return Session::has('user_id');
    }

    /**
     * Obter usuário logado
     */
    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }

        return [
            'id' => Session::get('user_id'),
            'name' => Session::get('user_name'),
            'email' => Session::get('user_email'),
            'role' => Session::get('user_role'),
        ];
    }

    /**
     * Obter ID do usuário logado
     */
    public static function id(): ?int
    {
        return Session::get('user_id');
    }

    /**
     * Logout
     */
    public static function logout(): void
    {
        Session::destroy();
    }

    /**
     * Criar hash de senha
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    /**
     * Verificar se é admin
     */
    public static function isAdmin(): bool
    {
        return self::check() && Session::get('user_role') === 'admin';
    }
}
