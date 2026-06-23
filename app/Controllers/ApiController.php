<?php

class ApiController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    /**
     * Busca de produtos (AJAX)
     */
    public function searchProducts(): void
    {
        $q = $this->query('q', '');
        
        if (strlen($q) < 2) {
            $this->json(['results' => [], 'total' => 0]);
            return;
        }

        $results = Database::fetchAll(
            "SELECT p.id, p.name, p.slug, p.short_description, p.price_from,
                    (SELECT image_path FROM product_images WHERE product_id = p.id AND is_cover = 1 LIMIT 1) as cover
             FROM products p
             WHERE p.is_active = 1 AND (p.name LIKE ? OR p.short_description LIKE ?)
             ORDER BY p.name ASC
             LIMIT 10",
            ["%{$q}%", "%{$q}%"]
        );

        // Formatar resultados
        $formatted = array_map(function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'slug' => $item['slug'],
                'description' => $item['short_description'],
                'price_from' => $item['price_from'],
                'cover' => $item['cover'] ? baseUrl($item['cover']) : null,
                'url' => baseUrl('produto/' . $item['slug']),
            ];
        }, $results);

        $this->json(['results' => $formatted, 'total' => count($formatted)]);
    }

    /**
     * Filtrar produtos por categoria (AJAX)
     */
    public function filterProducts(): void
    {
        $categoryId = (int) $this->query('category', '0');
        $sort = $this->query('sort', 'newest');
        $page = max(1, (int) $this->query('page', '1'));
        $perPage = 12;

        $where = 'p.is_active = 1';
        $params = [];

        if ($categoryId > 0) {
            $where .= ' AND p.category_id = ?';
            $params[] = $categoryId;
        }

        $orderBy = match ($sort) {
            'name_asc' => 'p.name ASC',
            'name_desc' => 'p.name DESC',
            'price_asc' => 'p.price_from ASC',
            'price_desc' => 'p.price_from DESC',
            default => 'p.created_at DESC',
        };

        $offset = ($page - 1) * $perPage;

        $total = Database::fetchOne(
            "SELECT COUNT(*) as total FROM products p WHERE {$where}",
            $params
        )['total'];

        $products = Database::fetchAll(
            "SELECT p.*, c.name as category_name,
                    (SELECT image_path FROM product_images WHERE product_id = p.id AND is_cover = 1 LIMIT 1) as cover
             FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             WHERE {$where}
             ORDER BY {$orderBy}
             LIMIT {$perPage} OFFSET {$offset}",
            $params
        );

        $formatted = array_map(function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'slug' => $item['slug'],
                'description' => $item['short_description'],
                'price_from' => $item['price_from'],
                'category' => $item['category_name'],
                'is_new' => (bool) $item['is_new'],
                'is_featured' => (bool) $item['is_featured'],
                'cover' => $item['cover'] ? baseUrl($item['cover']) : null,
                'url' => baseUrl('produto/' . $item['slug']),
            ];
        }, $products);

        $this->json([
            'products' => $formatted,
            'total' => (int) $total,
            'current_page' => $page,
            'total_pages' => ceil($total / $perPage),
            'per_page' => $perPage,
        ]);
    }
}
