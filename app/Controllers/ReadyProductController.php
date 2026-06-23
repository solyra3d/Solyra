<?php

class ReadyProductController extends Controller
{
    private ReadyProduct $model;

    public function __construct()
    {
        $this->model = new ReadyProduct();
    }

    /**
     * Listagem de produtos pronta entrega
     */
    public function index(): void
    {
        $page = (int) ($_GET['page'] ?? 1);
        $search = trim($_GET['q'] ?? '');

        $products = $this->model->findAvailable($page, 12, $search ?: null);
        $categories = (new Category())->findActive('order_position ASC');

        $this->view('ready/index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'seo' => [
                'title' => 'Pronta Entrega - SOLYRA',
                'description' => 'Produtos de impressão 3D prontos para envio imediato. Luminárias, brindes e peças decorativas disponíveis.',
            ],
        ]);
    }

    /**
     * Detalhe do produto pronta entrega
     */
    public function show(string $slug): void
    {
        $product = $this->model->findFullBySlug($slug);

        if (!$product) {
            http_response_code(404);
            include ROOT_PATH . '/app/Views/errors/404.php';
            return;
        }

        $this->view('ready/show', [
            'product' => $product,
            'seo' => [
                'title' => $product['name'] . ' - Pronta Entrega | SOLYRA',
                'description' => $product['short_description'] ?? $product['name'],
            ],
        ]);
    }
}
