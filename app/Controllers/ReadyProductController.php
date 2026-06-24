<?php

class ReadyProductController extends Controller
{
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index(): void
    {
        $page   = max(1, (int) ($_GET['page'] ?? 1));
        $search = trim($_GET['q'] ?? '');

        $products   = $this->product->findReadyDelivery($page, 12, $search ?: null);
        $categories = (new Category())->findActive('order_position ASC');

        $this->view('ready/index', [
            'products'   => $products,
            'categories' => $categories,
            'search'     => $search,
            'seo' => [
                'title'       => 'Pronta Entrega - SOLYRA',
                'description' => 'Produtos de impressão 3D prontos para envio imediato. Luminárias, brindes e peças decorativas disponíveis.',
            ],
        ]);
    }

    public function show(string $slug): void
    {
        $product = $this->product->findFullBySlug($slug);

        if (!$product || !$product['is_ready_delivery'] || $product['stock_quantity'] <= 0) {
            http_response_code(404);
            include ROOT_PATH . '/app/Views/errors/404.php';
            return;
        }

        $this->view('ready/show', [
            'product' => $product,
            'seo' => [
                'title'       => $product['name'] . ' - Pronta Entrega | SOLYRA',
                'description' => $product['short_description'] ?? $product['name'],
                'image'       => !empty($product['images']) ? baseUrl($product['images'][0]['image_path']) : '',
            ],
        ]);
    }
}
