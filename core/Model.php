<?php
/**
 * SOLYRA - Base Model
 * Model base com CRUD genérico, paginação e busca
 */

class Model
{
    protected string $table = '';
    protected string $primaryKey = 'id';

    /**
     * Buscar por ID
     */
    public function findById(int $id): ?array
    {
        return Database::fetchOne(
            "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ? LIMIT 1",
            [$id]
        );
    }

    /**
     * Buscar por slug
     */
    public function findBySlug(string $slug): ?array
    {
        return Database::fetchOne(
            "SELECT * FROM {$this->table} WHERE slug = ? LIMIT 1",
            [$slug]
        );
    }

    /**
     * Buscar todos (com ordenação)
     */
    public function findAll(string $orderBy = 'id DESC', ?int $limit = null): array
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY {$orderBy}";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return Database::fetchAll($sql);
    }

    /**
     * Buscar com condição WHERE
     */
    public function findWhere(string $where, array $params = [], string $orderBy = 'id DESC'): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$orderBy}";
        return Database::fetchAll($sql, $params);
    }

    /**
     * Buscar ativos
     */
    public function findActive(string $orderBy = 'id DESC', ?int $limit = null): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_active = 1 ORDER BY {$orderBy}";
        
        if ($limit) {
            $sql .= " LIMIT {$limit}";
        }
        
        return Database::fetchAll($sql);
    }

    /**
     * Paginação
     */
    public function paginate(int $page = 1, int $perPage = 12, string $where = '1=1', array $params = [], string $orderBy = 'id DESC'): array
    {
        $offset = ($page - 1) * $perPage;
        $total = Database::count($this->table, $where, $params);
        $totalPages = (int) ceil($total / $perPage);

        $sql = "SELECT * FROM {$this->table} WHERE {$where} ORDER BY {$orderBy} LIMIT {$perPage} OFFSET {$offset}";
        $items = Database::fetchAll($sql, $params);

        return [
            'items' => $items,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages,
        ];
    }

    /**
     * Criar registro
     */
    public function create(array $data): int
    {
        return Database::insert($this->table, $data);
    }

    /**
     * Atualizar registro
     */
    public function update(int $id, array $data): int
    {
        return Database::update($this->table, $data, "{$this->primaryKey} = ?", [$id]);
    }

    /**
     * Deletar registro
     */
    public function delete(int $id): int
    {
        return Database::delete($this->table, "{$this->primaryKey} = ?", [$id]);
    }

    /**
     * Contar registros
     */
    public function count(string $where = '1=1', array $params = []): int
    {
        return Database::count($this->table, $where, $params);
    }

    /**
     * Buscar por texto (LIKE)
     */
    public function search(string $query, array $columns, int $limit = 20): array
    {
        $conditions = array_map(fn($col) => "{$col} LIKE ?", $columns);
        $where = implode(' OR ', $conditions);
        $params = array_fill(0, count($columns), "%{$query}%");

        $sql = "SELECT * FROM {$this->table} WHERE ({$where}) AND is_active = 1 ORDER BY id DESC LIMIT {$limit}";
        return Database::fetchAll($sql, $params);
    }

    /**
     * Gerar slug único
     */
    public function generateSlug(string $text, ?int $excludeId = null): string
    {
        $slug = $this->slugify($text);
        $original = $slug;
        $counter = 1;

        while (true) {
            $sql = "SELECT id FROM {$this->table} WHERE slug = ?";
            $params = [$slug];

            if ($excludeId) {
                $sql .= " AND id != ?";
                $params[] = $excludeId;
            }

            $existing = Database::fetchOne($sql, $params);

            if (!$existing) {
                break;
            }

            $slug = $original . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Converter texto em slug
     */
    private function slugify(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = preg_replace('/[áàâãä]/u', 'a', $text);
        $text = preg_replace('/[éèêë]/u', 'e', $text);
        $text = preg_replace('/[íìîï]/u', 'i', $text);
        $text = preg_replace('/[óòôõö]/u', 'o', $text);
        $text = preg_replace('/[úùûü]/u', 'u', $text);
        $text = preg_replace('/[ç]/u', 'c', $text);
        $text = preg_replace('/[ñ]/u', 'n', $text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        return trim($text, '-');
    }
}
