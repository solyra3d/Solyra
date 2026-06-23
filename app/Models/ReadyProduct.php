<?php

class ReadyProduct extends Model
{
    protected string $table = 'ready_products';

    /**
     * Buscar produtos pronta entrega em destaque
     */
    public function findFeatured(int $limit = 8): array
    {
        return Database::fetchAll(
            "SELECT rp.*, c.name as category_name, c.slug as category_slug
             FROM ready_products rp
             LEFT JOIN categories c ON c.id = rp.category_id
             WHERE rp.is_active = 1 AND rp.is_featured = 1 AND rp.stock_quantity > 0
             ORDER BY rp.created_at DESC
             LIMIT ?",
            [$limit]
        );
    }

    /**
     * Buscar todos ativos com estoque (paginado)
     */
    public function findAvailable(int $page = 1, int $perPage = 12, ?string $search = null): array
    {
        $where = 'rp.is_active = 1 AND rp.stock_quantity > 0';
        $params = [];

        if ($search) {
            $where .= ' AND (rp.name LIKE ? OR rp.short_description LIKE ?)';
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $total = Database::count('ready_products rp', $where, $params);
        $totalPages = (int) ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;

        $items = Database::fetchAll(
            "SELECT rp.*, c.name as category_name, c.slug as category_slug
             FROM ready_products rp
             LEFT JOIN categories c ON c.id = rp.category_id
             WHERE {$where}
             ORDER BY rp.is_featured DESC, rp.created_at DESC
             LIMIT ? OFFSET ?",
            array_merge($params, [$perPage, $offset])
        );

        return [
            'items' => $items,
            'total' => $total,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'has_prev' => $page > 1,
            'has_next' => $page < $totalPages,
        ];
    }

    /**
     * Buscar por slug com imagens
     */
    public function findFullBySlug(string $slug): ?array
    {
        $product = Database::fetchOne(
            "SELECT rp.*, c.name as category_name, c.slug as category_slug
             FROM ready_products rp
             LEFT JOIN categories c ON c.id = rp.category_id
             WHERE rp.slug = ? AND rp.is_active = 1
             LIMIT 1",
            [$slug]
        );

        if (!$product) {
            return null;
        }

        $product['images'] = Database::fetchAll(
            "SELECT * FROM ready_product_images WHERE ready_product_id = ? ORDER BY order_position ASC",
            [$product['id']]
        );

        return $product;
    }

    /**
     * Buscar imagens
     */
    public function getImages(int $productId): array
    {
        return Database::fetchAll(
            "SELECT * FROM ready_product_images WHERE ready_product_id = ? ORDER BY order_position ASC",
            [$productId]
        );
    }
}
