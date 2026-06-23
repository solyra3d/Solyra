<?php

class SeoController extends Controller
{
    /**
     * Sitemap XML dinâmico
     */
    public function sitemap(): void
    {
        header('Content-Type: application/xml; charset=utf-8');

        $baseUrl = rtrim(setting('site_url', 'https://solyra.com.br'), '/');

        // Páginas estáticas
        $pages = [
            ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
            ['url' => '/catalogo', 'priority' => '0.9', 'changefreq' => 'daily'],
            ['url' => '/sobre', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['url' => '/contato', 'priority' => '0.5', 'changefreq' => 'monthly'],
        ];

        // Categorias
        $categories = Database::fetchAll(
            "SELECT slug, created_at FROM categories WHERE is_active = 1"
        );

        // Produtos
        $products = Database::fetchAll(
            "SELECT slug, updated_at FROM products WHERE is_active = 1 ORDER BY updated_at DESC"
        );

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Páginas estáticas
        foreach ($pages as $page) {
            echo "  <url>\n";
            echo "    <loc>{$baseUrl}{$page['url']}</loc>\n";
            echo "    <changefreq>{$page['changefreq']}</changefreq>\n";
            echo "    <priority>{$page['priority']}</priority>\n";
            echo "  </url>\n";
        }

        // Categorias
        foreach ($categories as $cat) {
            echo "  <url>\n";
            echo "    <loc>{$baseUrl}/catalogo/{$cat['slug']}</loc>\n";
            echo "    <lastmod>" . date('Y-m-d', strtotime($cat['created_at'])) . "</lastmod>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.7</priority>\n";
            echo "  </url>\n";
        }

        // Produtos
        foreach ($products as $prod) {
            echo "  <url>\n";
            echo "    <loc>{$baseUrl}/produto/{$prod['slug']}</loc>\n";
            echo "    <lastmod>" . date('Y-m-d', strtotime($prod['updated_at'])) . "</lastmod>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.8</priority>\n";
            echo "  </url>\n";
        }

        echo '</urlset>';
        exit;
    }

    /**
     * Robots.txt dinâmico
     */
    public function robots(): void
    {
        header('Content-Type: text/plain; charset=utf-8');

        $baseUrl = rtrim(setting('site_url', 'https://solyra.com.br'), '/');

        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /api/\n";
        echo "\n";
        echo "Sitemap: {$baseUrl}/sitemap.xml\n";
        exit;
    }
}
