<?php

class Banner extends Model
{
    protected string $table = 'banners';

    /**
     * Buscar banners ativos ordenados
     */
    public function findActiveOrdered(): array
    {
        return Database::fetchAll(
            "SELECT * FROM banners WHERE is_active = 1 ORDER BY order_position ASC"
        );
    }
}
