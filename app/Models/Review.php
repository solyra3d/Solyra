<?php

class Review extends Model
{
    protected string $table = 'reviews';

    /**
     * Buscar avaliações ativas
     */
    public function findActiveOrdered(int $limit = 10): array
    {
        return Database::fetchAll(
            "SELECT * FROM reviews WHERE is_active = 1 ORDER BY created_at DESC LIMIT ?",
            [$limit]
        );
    }
}
