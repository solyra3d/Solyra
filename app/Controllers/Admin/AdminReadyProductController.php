<?php

class AdminReadyProductController extends Controller
{
    protected string $layout = 'admin';
    private Product $product;

    public function __construct()
    {
        $this->product = new Product();
    }

    public function index(): void
    {
        $search = $this->query('q', '');
        $page   = max(1, (int) $this->query('page', '1'));

        $where  = 'p.is_ready_delivery = 1';
        $params = [];

        if ($search) {
            $where .= ' AND p.name LIKE ?';
            $params[] = "%{$search}%";
        }

        $perPage = 20;
        $total = Database::count('products p', $where, $params);
        $totalPages = (int) ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;

        $products = Database::fetchAll(
            "SELECT p.*,
                    c.name as category_name,
                    (SELECT image_path FROM product_images WHERE product_id = p.id AND is_cover = 1 LIMIT 1) as cover_image
             FROM products p
             LEFT JOIN categories c ON c.id = p.category_id
             WHERE {$where}
             ORDER BY p.stock_quantity ASC, p.name ASC
             LIMIT {$perPage} OFFSET {$offset}",
            $params
        );

        $this->view('admin/ready/index', [
            'products'   => $products,
            'pagination' => [
                'current_page' => $page,
                'total_pages'  => $totalPages,
                'total'        => $total,
            ],
            'search'    => $search,
            'pageTitle' => 'Pronta Entrega',
        ]);
    }
}
