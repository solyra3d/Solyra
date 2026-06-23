<?php

class PageContent
{
    /**
     * Cache estático para evitar queries repetidas
     */
    private static ?array $cache = null;

    /**
     * Carregar todo o conteúdo em cache
     */
    private static function loadCache(): void
    {
        if (self::$cache === null) {
            $rows = Database::fetchAll("SELECT page, section, content_key, content_value FROM page_contents");
            self::$cache = [];
            foreach ($rows as $row) {
                self::$cache[$row['page']][$row['section']][$row['content_key']] = $row['content_value'] ?? '';
            }
        }
    }

    /**
     * Obter valor de um conteúdo específico
     */
    public static function get(string $page, string $section, string $key, string $default = ''): string
    {
        self::loadCache();
        return self::$cache[$page][$section][$key] ?? $default;
    }

    /**
     * Obter todos os conteúdos de uma seção
     */
    public static function getSection(string $page, string $section): array
    {
        self::loadCache();
        return self::$cache[$page][$section] ?? [];
    }

    /**
     * Obter todos os conteúdos de uma página (para admin)
     */
    public static function getPage(string $page): array
    {
        return Database::fetchAll(
            "SELECT * FROM page_contents WHERE page = ? ORDER BY section, content_key",
            [$page]
        );
    }

    /**
     * Atualizar seção inteira (upsert)
     */
    public static function updateSection(string $page, string $section, array $data): void
    {
        foreach ($data as $key => $value) {
            $existing = Database::fetchOne(
                "SELECT id FROM page_contents WHERE page = ? AND section = ? AND content_key = ?",
                [$page, $section, $key]
            );

            if ($existing) {
                Database::update('page_contents', [
                    'content_value' => $value
                ], 'id = ?', [$existing['id']]);
            } else {
                Database::insert('page_contents', [
                    'page' => $page,
                    'section' => $section,
                    'content_key' => $key,
                    'content_value' => $value,
                    'content_type' => 'text'
                ]);
            }
        }
        // Limpar cache
        self::$cache = null;
    }

    /**
     * Limpar cache (útil após updates)
     */
    public static function clearCache(): void
    {
        self::$cache = null;
    }
}
