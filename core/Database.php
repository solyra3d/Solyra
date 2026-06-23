<?php
/**
 * SOLYRA - Database
 * Conexão PDO Singleton com prepared statements
 */

class Database
{
    private static ?PDO $instance = null;
    private static array $config = [];

    /**
     * Inicializar configuração
     */
    public static function init(array $config): void
    {
        self::$config = $config;
    }

    /**
     * Obter instância PDO (Singleton)
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                self::$config['host'],
                self::$config['port'],
                self::$config['database']
            );

            try {
                self::$instance = new PDO($dsn, self::$config['username'], self::$config['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
                ]);
            } catch (PDOException $e) {
                die('Erro de conexão com o banco de dados.');
            }
        }

        return self::$instance;
    }

    /**
     * Executar query com prepared statement
     */
    public static function query(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Buscar um registro
     */
    public static function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = self::query($sql, $params);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Buscar todos os registros
     */
    public static function fetchAll(string $sql, array $params = []): array
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetchAll();
    }

    /**
     * Inserir registro e retornar ID
     */
    public static function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        self::query($sql, array_values($data));

        return (int) self::getInstance()->lastInsertId();
    }

    /**
     * Atualizar registro
     */
    public static function update(string $table, array $data, string $where, array $whereParams = []): int
    {
        $set = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
        $params = array_merge(array_values($data), $whereParams);

        $stmt = self::query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Deletar registro
     */
    public static function delete(string $table, string $where, array $params = []): int
    {
        $sql = "DELETE FROM {$table} WHERE {$where}";
        $stmt = self::query($sql, $params);
        return $stmt->rowCount();
    }

    /**
     * Contar registros
     */
    public static function count(string $table, string $where = '1=1', array $params = []): int
    {
        $sql = "SELECT COUNT(*) as total FROM {$table} WHERE {$where}";
        $result = self::fetchOne($sql, $params);
        return (int) ($result['total'] ?? 0);
    }
}
