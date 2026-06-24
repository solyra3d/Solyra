<?php

class AdminProductController extends Controller
{
    protected string $layout = 'admin';
    private Product $product;
    private Category $category;

    public function __construct()
    {
        $this->product = new Product();
        $this->category = new Category();
    }

    /**
     * Hub de Categorias — exibe cards com resumo por categoria
     */
    public function index(): void
    {
        $categories = Database::fetchAll(
            "SELECT c.*,
                    (SELECT COUNT(*) FROM products WHERE category_id = c.id) as total_products,
                    (SELECT COUNT(*) FROM products WHERE category_id = c.id AND is_active = 1) as active_products,
                    (SELECT COUNT(*) FROM products WHERE category_id = c.id AND is_featured = 1) as featured_products
             FROM categories c
             WHERE c.is_active = 1
             ORDER BY c.order_position ASC, c.name ASC"
        );

        $this->view('admin/products/index', [
            'categories' => $categories,
            'pageTitle' => 'Produtos',
        ]);
    }

    /**
     * Página de produtos por categoria com filtros e estatísticas
     */
    public function category(string $id): void
    {
        $cat = $this->category->findById((int) $id);
        if (!$cat) {
            Session::flash('error', 'Categoria não encontrada.');
            redirect('/admin/produtos');
        }

        $search = $this->query('q', '');
        $filter = $this->query('filtro', 'todos');

        // Estatísticas
        $stats = Database::fetchOne(
            "SELECT
                COUNT(*) as total,
                SUM(is_active = 1) as ativos,
                SUM(is_featured = 1) as destaques
             FROM products WHERE category_id = ?",
            [(int) $id]
        );

        // Construir WHERE
        $where = 'p.category_id = ?';
        $params = [(int) $id];

        if ($search) {
            $where .= ' AND p.name LIKE ?';
            $params[] = "%{$search}%";
        }

        if ($filter === 'ativos') {
            $where .= ' AND p.is_active = 1';
        } elseif ($filter === 'inativos') {
            $where .= ' AND p.is_active = 0';
        } elseif ($filter === 'destaques') {
            $where .= ' AND p.is_featured = 1';
        }

        // Paginação
        $page = max(1, (int) $this->query('page', '1'));
        $perPage = 20;
        $total = Database::count('products p', $where, $params);
        $totalPages = (int) ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;

        $products = Database::fetchAll(
            "SELECT p.*
             FROM products p
             WHERE {$where}
             ORDER BY p.created_at DESC
             LIMIT {$perPage} OFFSET {$offset}",
            $params
        );

        $this->view('admin/products/category', [
            'category' => $cat,
            'products' => $products,
            'stats' => $stats,
            'search' => $search,
            'filter' => $filter,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => $totalPages,
                'total' => $total,
            ],
            'pageTitle' => 'Produtos > ' . $cat['name'],
        ]);
    }

    public function create(): void
    {
        $categoryId = $this->query('categoria', '');

        $this->view('admin/products/form', [
            'product' => null,
            'categories' => $this->category->findAll('order_position ASC'),
            'images' => [],
            'preselectedCategory' => $categoryId,
            'pageTitle' => 'Novo Produto',
        ]);
    }

    public function store(): void
    {
        $this->validateCsrf();

        $name = $this->input('name');
        $slug = $this->input('slug') ?: $this->product->generateSlug($name);
        $categoryId = (int) $this->input('category_id');

        $data = [
            'name' => $name,
            'slug' => $slug,
            'category_id' => $categoryId,
            'short_description' => $this->input('short_description'),
            'description' => $this->input('description'),
            'price_from' => $this->input('price_from') ? (float) $this->input('price_from') : null,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_new' => isset($_POST['is_new']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'seo_title' => $this->input('seo_title'),
            'seo_description' => $this->input('seo_description'),
        ];

        $productId = $this->product->create($data);

        // Upload de vídeo
        if (!empty($_FILES['video']['name'])) {
            $videoResult = Upload::video($_FILES['video'], 'products/videos');
            if ($videoResult['success']) {
                $this->product->update($productId, ['video_path' => $videoResult['path']]);
            }
        }

        // Upload de imagens
        if (!empty($_FILES['images']['name'][0])) {
            $results = Upload::multiple($_FILES['images'], 'products');
            $isFirst = true;
            $order = 0;

            foreach ($results as $result) {
                if ($result['success']) {
                    Database::insert('product_images', [
                        'product_id' => $productId,
                        'image_path' => $result['path'],
                        'is_cover' => $isFirst ? 1 : 0,
                        'order_position' => $order++,
                    ]);
                    $isFirst = false;
                }
            }
        }

        Session::flash('success', 'Produto criado com sucesso!');
        redirect('/admin/produtos/categoria/' . $categoryId);
    }

    public function edit(string $id): void
    {
        $product = $this->product->findById((int) $id);
        if (!$product) {
            Session::flash('error', 'Produto não encontrado.');
            redirect('/admin/produtos');
        }

        $images = $this->product->getImages((int) $id);

        $this->view('admin/products/form', [
            'product' => $product,
            'categories' => $this->category->findAll('order_position ASC'),
            'images' => $images,
            'preselectedCategory' => '',
            'pageTitle' => 'Editar: ' . $product['name'],
        ]);
    }

    public function update(string $id): void
    {
        $this->validateCsrf();

        $product = $this->product->findById((int) $id);
        if (!$product) {
            Session::flash('error', 'Produto não encontrado.');
            redirect('/admin/produtos');
        }

        $name = $this->input('name');
        $slug = $this->input('slug') ?: $this->product->generateSlug($name, (int) $id);
        $categoryId = (int) $this->input('category_id');

        $data = [
            'name' => $name,
            'slug' => $slug,
            'category_id' => $categoryId,
            'short_description' => $this->input('short_description'),
            'description' => $this->input('description'),
            'price_from' => $this->input('price_from') ? (float) $this->input('price_from') : null,
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_new' => isset($_POST['is_new']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'seo_title' => $this->input('seo_title'),
            'seo_description' => $this->input('seo_description'),
        ];

        // Upload de novo vídeo
        if (!empty($_FILES['video']['name'])) {
            if (!empty($product['video_path'])) {
                Upload::deleteFile($product['video_path']);
            }
            $videoResult = Upload::video($_FILES['video'], 'products/videos');
            if ($videoResult['success']) {
                $data['video_path'] = $videoResult['path'];
            }
        }

        $this->product->update((int) $id, $data);

        // Upload de novas imagens
        if (!empty($_FILES['images']['name'][0])) {
            $existingCount = Database::count('product_images', 'product_id = ?', [(int) $id]);
            $hasCover = Database::count('product_images', 'product_id = ? AND is_cover = 1', [(int) $id]) > 0;
            $results = Upload::multiple($_FILES['images'], 'products');
            $order = $existingCount;

            foreach ($results as $result) {
                if ($result['success']) {
                    Database::insert('product_images', [
                        'product_id' => (int) $id,
                        'image_path' => $result['path'],
                        'is_cover' => (!$hasCover && $existingCount === 0) ? 1 : 0,
                        'order_position' => $order++,
                    ]);
                    $hasCover = true;
                    $existingCount++;
                }
            }
        }

        Session::flash('success', 'Produto atualizado com sucesso!');
        redirect('/admin/produtos/editar/' . $id);
    }

    public function delete(string $id): void
    {
        $this->validateCsrf();

        $product = $this->product->findById((int) $id);
        $categoryId = $product['category_id'] ?? null;

        // Deletar vídeo e imagens do disco
        if (!empty($product['video_path'])) {
            Upload::deleteFile($product['video_path']);
        }
        $images = $this->product->getImages((int) $id);
        foreach ($images as $img) {
            Upload::deleteFile($img['image_path']);
        }

        $this->product->delete((int) $id);

        Session::flash('success', 'Produto excluído com sucesso!');
        if ($categoryId) {
            redirect('/admin/produtos/categoria/' . $categoryId);
        } else {
            redirect('/admin/produtos');
        }
    }

    public function toggle(string $id): void
    {
        $this->validateCsrf();

        $product = $this->product->findById((int) $id);
        if ($product) {
            $this->product->update((int) $id, [
                'is_active' => $product['is_active'] ? 0 : 1,
            ]);
            Session::flash('success', 'Status atualizado!');
            if ($product['category_id']) {
                redirect('/admin/produtos/categoria/' . $product['category_id']);
            }
        }

        redirect('/admin/produtos');
    }

    public function deleteImage(string $id): void
    {
        $this->validateCsrf();

        $image = Database::fetchOne("SELECT * FROM product_images WHERE id = ?", [(int) $id]);
        if ($image) {
            Upload::deleteFile($image['image_path']);
            Database::delete('product_images', 'id = ?', [(int) $id]);
        }

        Session::flash('success', 'Imagem removida!');
        redirect($_SERVER['HTTP_REFERER'] ?? '/admin/produtos');
    }

    public function deleteVideo(string $id): void
    {
        $this->validateCsrf();

        $product = $this->product->findById((int) $id);
        if ($product && !empty($product['video_path'])) {
            Upload::deleteFile($product['video_path']);
            $this->product->update((int) $id, ['video_path' => null]);
        }

        Session::flash('success', 'Vídeo removido!');
        redirect($_SERVER['HTTP_REFERER'] ?? '/admin/produtos');
    }
}
