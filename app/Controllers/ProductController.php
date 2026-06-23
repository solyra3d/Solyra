<?php

class ProductController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    /**
     * Exibir página do produto
     */
    public function show(string $slug): void
    {
        $product = $this->product->findFullBySlug($slug);

        if (!$product) {
            http_response_code(404);
            include ROOT_PATH . '/app/Views/errors/404.php';
            exit;
        }

        // Produtos relacionados
        $related = $this->product->findRelated(
            (int)$product['id'],
            (int)$product['category_id'],
            4
        );

        $data = [
            'product' => $product,
            'related' => $related,
            'seo' => [
                'title' => ($product['seo_title'] ?: $product['name']) . ' - SOLYRA',
                'description' => $product['seo_description'] ?: truncate(strip_tags($product['description'] ?? $product['short_description'] ?? ''), 160),
                'image' => !empty($product['images']) ? baseUrl($product['images'][0]['image_path']) : '',
                'type' => 'product',
            ],
        ];

        $this->view('product/show', $data);
    }
}
