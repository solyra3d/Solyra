<?php

class AdminReadyProductController extends Controller
{
    protected string $layout = 'admin';
    private ReadyProduct $model;

    public function __construct()
    {
        $this->model = new ReadyProduct();
    }

    public function index(): void
    {
        $page = (int) ($_GET['page'] ?? 1);
        $products = $this->model->paginate($page, 15, '1=1', [], 'created_at DESC');

        $this->view('admin/ready/index', [
            'products' => $products,
            'pageTitle' => 'Pronta Entrega',
        ]);
    }

    public function create(): void
    {
        $categories = (new Category())->findActive('order_position ASC');
        $this->view('admin/ready/form', [
            'product' => null,
            'categories' => $categories,
            'pageTitle' => 'Novo Produto - Pronta Entrega',
        ]);
    }

    public function store(): void
    {
        $this->validateCsrf();

        $data = [
            'name' => $this->input('name'),
            'slug' => $this->model->generateSlug($this->input('name')),
            'short_description' => $this->input('short_description'),
            'description' => $this->input('description'),
            'price' => (float) $this->input('price'),
            'stock_quantity' => (int) $this->input('stock_quantity'),
            'category_id' => $this->input('category_id') ?: null,
            'is_featured' => $this->input('is_featured') ? 1 : 0,
            'is_active' => $this->input('is_active') ? 1 : 0,
        ];

        // Cover image
        if (!empty($_FILES['cover_image']['name'])) {
            $result = Upload::file($_FILES['cover_image'], 'ready');
            if ($result['success']) {
                $data['cover_image'] = $result['path'];
            }
        }

        $id = $this->model->create($data);

        // Multiple images
        if (!empty($_FILES['images']['name'][0])) {
            $this->uploadImages($id);
        }

        Session::flash('success', 'Produto cadastrado com sucesso!');
        redirect('/admin/pronta-entrega');
    }

    public function edit(string $id): void
    {
        $product = $this->model->findById((int) $id);
        if (!$product) {
            Session::flash('error', 'Produto não encontrado.');
            redirect('/admin/pronta-entrega');
        }

        $product['images'] = $this->model->getImages((int) $id);
        $categories = (new Category())->findActive('order_position ASC');

        $this->view('admin/ready/form', [
            'product' => $product,
            'categories' => $categories,
            'pageTitle' => 'Editar: ' . $product['name'],
        ]);
    }

    public function update(string $id): void
    {
        $this->validateCsrf();

        $product = $this->model->findById((int) $id);
        if (!$product) {
            Session::flash('error', 'Produto não encontrado.');
            redirect('/admin/pronta-entrega');
        }

        $data = [
            'name' => $this->input('name'),
            'slug' => $this->model->generateSlug($this->input('name'), (int) $id),
            'short_description' => $this->input('short_description'),
            'description' => $this->input('description'),
            'price' => (float) $this->input('price'),
            'stock_quantity' => (int) $this->input('stock_quantity'),
            'category_id' => $this->input('category_id') ?: null,
            'is_featured' => $this->input('is_featured') ? 1 : 0,
            'is_active' => $this->input('is_active') ? 1 : 0,
        ];

        if (!empty($_FILES['cover_image']['name'])) {
            $result = Upload::file($_FILES['cover_image'], 'ready');
            if ($result['success']) {
                $data['cover_image'] = $result['path'];
            }
        }

        $this->model->update((int) $id, $data);

        if (!empty($_FILES['images']['name'][0])) {
            $this->uploadImages((int) $id);
        }

        Session::flash('success', 'Produto atualizado!');
        redirect('/admin/pronta-entrega');
    }

    public function delete(string $id): void
    {
        $this->validateCsrf();
        $this->model->delete((int) $id);
        Session::flash('success', 'Produto removido!');
        redirect('/admin/pronta-entrega');
    }

    public function deleteImage(string $id): void
    {
        $this->validateCsrf();
        Database::delete('ready_product_images', 'id = ?', [(int) $id]);
        Session::flash('success', 'Imagem removida!');
        redirect($_SERVER['HTTP_REFERER'] ?? '/admin/pronta-entrega');
    }

    private function uploadImages(int $productId): void
    {
        $files = $_FILES['images'];
        $count = count($files['name']);

        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;

            $tmp = $files['tmp_name'][$i];
            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $filename = 'uploads/ready/' . uniqid('img_') . '.' . strtolower($ext);
            $dest = ROOT_PATH . '/public/' . $filename;

            if (!is_dir(dirname($dest))) {
                mkdir(dirname($dest), 0755, true);
            }

            if (move_uploaded_file($tmp, $dest)) {
                Database::insert('ready_product_images', [
                    'ready_product_id' => $productId,
                    'image_path' => $filename,
                    'order_position' => $i,
                ]);
            }
        }
    }
}
