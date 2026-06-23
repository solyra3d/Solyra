<?php
/**
 * SOLYRA - SEO Helper
 * Meta tags dinâmicas, Open Graph, Twitter Cards, JSON-LD
 */

/**
 * Gerar meta tags completas
 */
function seoMeta(array $options = []): string
{
    $defaults = [
        'title' => setting('seo_title', 'SOLYRA'),
        'description' => setting('seo_description', ''),
        'image' => '',
        'url' => getCurrentUrl(),
        'type' => 'website',
        'siteName' => 'SOLYRA',
    ];

    $seo = array_merge($defaults, $options);
    $html = '';

    // Meta básico
    $html .= '<title>' . e($seo['title']) . '</title>' . "\n";
    $html .= '<meta name="description" content="' . e($seo['description']) . '">' . "\n";
    $html .= '<link rel="canonical" href="' . e($seo['url']) . '">' . "\n";

    // Open Graph
    $html .= '<meta property="og:title" content="' . e($seo['title']) . '">' . "\n";
    $html .= '<meta property="og:description" content="' . e($seo['description']) . '">' . "\n";
    $html .= '<meta property="og:type" content="' . e($seo['type']) . '">' . "\n";
    $html .= '<meta property="og:url" content="' . e($seo['url']) . '">' . "\n";
    $html .= '<meta property="og:site_name" content="' . e($seo['siteName']) . '">' . "\n";
    $html .= '<meta property="og:locale" content="pt_BR">' . "\n";
    
    if (!empty($seo['image'])) {
        $html .= '<meta property="og:image" content="' . e($seo['image']) . '">' . "\n";
    }

    // Twitter Cards
    $html .= '<meta name="twitter:card" content="summary_large_image">' . "\n";
    $html .= '<meta name="twitter:title" content="' . e($seo['title']) . '">' . "\n";
    $html .= '<meta name="twitter:description" content="' . e($seo['description']) . '">' . "\n";
    
    if (!empty($seo['image'])) {
        $html .= '<meta name="twitter:image" content="' . e($seo['image']) . '">' . "\n";
    }

    return $html;
}

/**
 * JSON-LD Schema Organization
 */
function schemaOrganization(): string
{
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => 'SOLYRA',
        'description' => setting('seo_description', ''),
        'url' => baseUrl(),
        'logo' => baseUrl(setting('logo', 'assets/images/logo/logo.png')),
        'contactPoint' => [
            '@type' => 'ContactPoint',
            'telephone' => setting('phone', ''),
            'contactType' => 'customer service',
            'availableLanguage' => 'Portuguese',
        ],
        'sameAs' => array_filter([
            setting('instagram', ''),
            setting('facebook', ''),
            setting('tiktok', ''),
        ]),
    ];

    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * JSON-LD Schema Product
 */
function schemaProduct(array $product, array $images = []): string
{
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $product['name'],
        'description' => $product['description'] ?? $product['short_description'] ?? '',
        'url' => baseUrl('produto/' . $product['slug']),
        'brand' => [
            '@type' => 'Brand',
            'name' => 'SOLYRA',
        ],
    ];

    if (!empty($images)) {
        $schema['image'] = array_map(fn($img) => baseUrl($img['image_path']), $images);
    }

    if (!empty($product['price_from']) && $product['price_from'] > 0) {
        $schema['offers'] = [
            '@type' => 'Offer',
            'priceCurrency' => 'BRL',
            'price' => $product['price_from'],
            'availability' => 'https://schema.org/InStock',
        ];
    }

    return '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
}

/**
 * Obter URL atual completa
 */
function getCurrentUrl(): string
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return $protocol . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . ($_SERVER['REQUEST_URI'] ?? '/');
}
