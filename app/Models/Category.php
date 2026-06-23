<?php

class Category extends Model
{
    protected string $table = 'categories';

    /**
     * Buscar categorias ativas ordenadas
     */
    public function findActiveOrdered(): array
    {
        return Database::fetchAll(
            "SELECT c.*, (SELECT COUNT(*) FROM products WHERE category_id = c.id AND is_active = 1) as product_count
             FROM categories c
             WHERE c.is_active = 1
             ORDER BY c.order_position ASC"
        );
    }

    /**
     * Buscar categoria por slug com contagem de produtos
     */
    public function findBySlugWithCount(string $slug): ?array
    {
        return Database::fetchOne(
            "SELECT c.*, (SELECT COUNT(*) FROM products WHERE category_id = c.id AND is_active = 1) as product_count
             FROM categories c
             WHERE c.slug = ? AND c.is_active = 1
             LIMIT 1",
            [$slug]
        );
    }
}
