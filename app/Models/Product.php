<?php

class Product extends Model
{
    protected string $table = 'products';

    /**
     * Buscar produtos em destaque
     */
    public function findFeatured(int $limit = 8): array
    {
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug,
                    (SELECT image_path FROM product_images WHERE product_id = p.id AND is_cover = 1 LIMIT 1) as cover_image
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1 AND p.is_featured = 1
             ORDER BY p.created_at DESC
             LIMIT ?",
            [$limit]
        );
    }

    /**
     * Buscar produtos novos
     */
    public function findNew(int $limit = 8): array
    {
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug,
                    (SELECT image_path FROM product_images WHERE product_id = p.id AND is_cover = 1 LIMIT 1) as cover_image
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.is_active = 1 AND p.is_new = 1
             ORDER BY p.created_at DESC
             LIMIT ?",
            [$limit]
        );
    }

    /**
     * Buscar por categoria (com paginação)
     */
    public function findByCategory(int $categoryId, int $page = 1, int $perPage = 12): array
    {
        $offset = ($page - 1) * $perPage;
        $total = Database::count('products', 'category_id = ? AND is_active = 1', [$categoryId]);
        $totalPages = (int) ceil($total / $perPage);

        $items = Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug,
                    (SELECT image_path FROM product_images WHERE product_id = p.id AND is_cover = 1 LIMIT 1) as cover_image
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.category_id = ? AND p.is_active = 1
             ORDER BY p.created_at DESC
             LIMIT ? OFFSET ?",
            [$categoryId, $perPage, $offset]
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
     * Buscar todos com cover (paginado)
     */
    public function findAllWithCover(int $page = 1, int $perPage = 12, ?string $search = null): array
    {
        $where = 'p.is_active = 1';
        $params = [];

        if ($search) {
            $where .= ' AND (p.name LIKE ? OR p.short_description LIKE ?)';
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $countWhere = str_replace('p.', '', $where);
        $total = Database::count('products p', $where, $params);
        $totalPages = (int) ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;

        $items = Database::fetchAll(
            "SELECT p.*, c.name as category_name, c.slug as category_slug,
                    (SELECT image_path FROM product_images WHERE product_id = p.id AND is_cover = 1 LIMIT 1) as cover_image
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE {$where}
             ORDER BY p.created_at DESC
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
     * Buscar produto completo por slug (com imagens)
     */
    public function findFullBySlug(string $slug): ?array
    {
        $product = Database::fetchOne(
            "SELECT p.*, c.name as category_name, c.slug as category_slug
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.slug = ? AND p.is_active = 1
             LIMIT 1",
            [$slug]
        );

        if (!$product) {
            return null;
        }

        // Buscar imagens
        $product['images'] = Database::fetchAll(
            "SELECT * FROM product_images WHERE product_id = ? ORDER BY is_cover DESC, order_position ASC",
            [$product['id']]
        );

        return $product;
    }

    /**
     * Buscar produtos relacionados
     */
    public function findRelated(int $productId, int $categoryId, int $limit = 4): array
    {
        return Database::fetchAll(
            "SELECT p.*, c.name as category_name,
                    (SELECT image_path FROM product_images WHERE product_id = p.id AND is_cover = 1 LIMIT 1) as cover_image
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE p.category_id = ? AND p.id != ? AND p.is_active = 1
             ORDER BY RAND()
             LIMIT ?",
            [$categoryId, $productId, $limit]
        );
    }

    /**
     * Buscar imagens de um produto
     */
    public function getImages(int $productId): array
    {
        return Database::fetchAll(
            "SELECT * FROM product_images WHERE product_id = ? ORDER BY is_cover DESC, order_position ASC",
            [$productId]
        );
    }
}
