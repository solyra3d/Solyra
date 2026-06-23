<?php

class Portfolio extends Model
{
    protected string $table = 'portfolio';

    /**
     * Buscar portfólios ativos com imagens
     */
    public function findActiveWithImages(int $limit = 12): array
    {
        $items = Database::fetchAll(
            "SELECT * FROM portfolio WHERE is_active = 1 ORDER BY order_position ASC, created_at DESC LIMIT ?",
            [$limit]
        );

        foreach ($items as &$item) {
            $item['images'] = Database::fetchAll(
                "SELECT * FROM portfolio_images WHERE portfolio_id = ? ORDER BY order_position ASC",
                [$item['id']]
            );
        }

        return $items;
    }

    /**
     * Buscar por slug com imagens
     */
    public function findFullBySlug(string $slug): ?array
    {
        $item = Database::fetchOne(
            "SELECT * FROM portfolio WHERE slug = ? AND is_active = 1 LIMIT 1",
            [$slug]
        );

        if (!$item) {
            return null;
        }

        $item['images'] = Database::fetchAll(
            "SELECT * FROM portfolio_images WHERE portfolio_id = ? ORDER BY order_position ASC",
            [$item['id']]
        );

        return $item;
    }

    /**
     * Buscar imagens
     */
    public function getImages(int $portfolioId): array
    {
        return Database::fetchAll(
            "SELECT * FROM portfolio_images WHERE portfolio_id = ? ORDER BY order_position ASC",
            [$portfolioId]
        );
    }
}
