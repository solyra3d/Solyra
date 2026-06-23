<?php

class SectionCard
{
    /**
     * Obter cards ativos de uma seção (ordenados)
     */
    public static function getBySection(string $section): array
    {
        return Database::fetchAll(
            "SELECT * FROM section_cards WHERE section = ? AND is_active = 1 ORDER BY order_position ASC",
            [$section]
        );
    }

    /**
     * Obter todos os cards de uma seção (incluindo inativos, para admin)
     */
    public static function getAllBySection(string $section): array
    {
        return Database::fetchAll(
            "SELECT * FROM section_cards WHERE section = ? ORDER BY order_position ASC",
            [$section]
        );
    }

    /**
     * Obter card por ID
     */
    public static function find(int $id): ?array
    {
        return Database::fetchOne("SELECT * FROM section_cards WHERE id = ?", [$id]);
    }

    /**
     * Criar novo card
     */
    public static function create(array $data): int
    {
        return Database::insert('section_cards', [
            'section' => $data['section'],
            'icon' => $data['icon'] ?? '',
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'order_position' => $data['order_position'] ?? 0,
            'is_active' => $data['is_active'] ?? 1,
        ]);
    }

    /**
     * Atualizar card
     */
    public static function update(int $id, array $data): void
    {
        Database::update('section_cards', [
            'icon' => $data['icon'] ?? '',
            'title' => $data['title'],
            'description' => $data['description'] ?? '',
            'order_position' => $data['order_position'] ?? 0,
            'is_active' => $data['is_active'] ?? 1,
        ], 'id = ?', [$id]);
    }

    /**
     * Excluir card
     */
    public static function delete(int $id): void
    {
        Database::delete('section_cards', 'id = ?', [$id]);
    }

    /**
     * Obter o label amigável de uma seção
     */
    public static function getSectionLabel(string $section): string
    {
        $labels = [
            'home_process' => 'Como Funciona (Home)',
            'home_differentials' => 'Diferenciais (Home)',
            'about_features' => 'Features (Sobre)',
        ];
        return $labels[$section] ?? $section;
    }
}
