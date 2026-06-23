<?php
/**
 * SOLYRA - Configurações Gerais
 */

return [
    // Nome do site
    'name' => 'SOLYRA',
    'slogan' => 'Soluções para Impressão 3D',
    
    // URLs
    'url' => 'http://solyra',
    'assets_url' => 'http://solyra/assets',
    
    // Upload
    'upload_max_size' => 5242880, // 5MB
    'upload_allowed_types' => ['image/jpeg', 'image/png', 'image/webp'],
    
    // Paginação
    'products_per_page' => 12,
    
    // SEO padrão
    'seo_title' => 'SOLYRA - Soluções Premium para Impressão 3D',
    'seo_description' => 'Impressão 3D sob demanda, brindes personalizados, luminárias decorativas, peças exclusivas e itens colecionáveis. Tecnologia e design premium.',
    
    // Timezone
    'timezone' => 'America/Sao_Paulo',
    
    // Debug (desabilitar em produção)
    'debug' => true,
];
