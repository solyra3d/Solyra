<?php

class Gallery
{
    /**
     * Obter fotos ativas (para site público)
     */
    public static function getActive(): array
    {
        return Database::fetchAll(
            "SELECT * FROM gallery WHERE is_active = 1 ORDER BY order_position ASC"
        );
    }

    /**
     * Obter todas as fotos (para admin)
     */
    public static function getAll(): array
    {
        return Database::fetchAll(
            "SELECT * FROM gallery ORDER BY order_position ASC"
        );
    }

    /**
     * Obter foto por ID
     */
    public static function find(int $id): ?array
    {
        return Database::fetchOne("SELECT * FROM gallery WHERE id = ?", [$id]);
    }

    /**
     * Criar nova foto
     */
    public static function create(array $data): int
    {
        $maxPos = Database::fetchOne("SELECT MAX(order_position) as max_pos FROM gallery");
        $nextPos = ($maxPos['max_pos'] ?? 0) + 1;

        return Database::insert('gallery', [
            'image_path' => $data['image_path'],
            'caption' => $data['caption'] ?? '',
            'order_position' => $nextPos,
            'is_active' => 1,
        ]);
    }

    /**
     * Atualizar caption
     */
    public static function updateCaption(int $id, string $caption): void
    {
        Database::update('gallery', ['caption' => $caption], 'id = ?', [$id]);
    }

    /**
     * Excluir foto
     */
    public static function delete(int $id): void
    {
        Database::delete('gallery', 'id = ?', [$id]);
    }

    /**
     * Total de fotos
     */
    public static function count(): int
    {
        return Database::count('gallery');
    }
}
