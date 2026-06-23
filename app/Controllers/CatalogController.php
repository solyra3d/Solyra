<?php

class CatalogController extends Controller
{
    private Product $product;
    private Category $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
    }

    /**
     * Listagem completa do catálogo (padrão: Luminárias)
     */
    public function index(): void
    {
        $page = max(1, (int) $this->query('page', '1'));
        $search = $this->query('q', '');
        $showAll = !empty($_GET['all']);
        $categories = $this->category->findActiveOrdered();

        // Padrão: mostrar Luminárias se não for busca nem "Todos"
        if (!$search && !$showAll) {
            // Buscar categoria Luminárias
            $luminariasCat = null;
            foreach ($categories as $cat) {
                if (stripos($cat['slug'], 'luminaria') !== false || stripos($cat['name'], 'luminária') !== false) {
                    $luminariasCat = $cat;
                    break;
                }
            }

            if ($luminariasCat) {
                $products = $this->product->findByCategory((int)$luminariasCat['id'], $page, 12);
                $currentCategory = $luminariasCat;
            } else {
                $products = $this->product->findAllWithCover($page, 12, null);
                $currentCategory = null;
            }
        } else {
            $products = $this->product->findAllWithCover($page, 12, $search ?: null);
            $currentCategory = null;
        }

        $data = [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $currentCategory ?? null,
            'search' => $search,
            'seo' => [
                'title' => 'Catálogo - SOLYRA | Brindes, Luminárias e Decoração',
                'description' => 'Explore nosso catálogo completo de brindes personalizados, luminárias decorativas, peças 3D e itens colecionáveis.',
            ],
        ];

        $this->view('catalog/index', $data);
    }

    /**
     * Listagem por categoria
     */
    public function category(string $slug): void
    {
        $category = $this->category->findBySlugWithCount($slug);

        if (!$category) {
            http_response_code(404);
            include ROOT_PATH . '/app/Views/errors/404.php';
            exit;
        }

        $page = max(1, (int) $this->query('page', '1'));
        $categories = $this->category->findActiveOrdered();

        $products = $this->product->findByCategory((int)$category['id'], $page, 12);

        $data = [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $category,
            'search' => '',
            'seo' => [
                'title' => $category['name'] . ' - Catálogo SOLYRA',
                'description' => $category['description'] ?? 'Produtos da categoria ' . $category['name'],
            ],
        ];

        $this->view('catalog/index', $data);
    }
}
