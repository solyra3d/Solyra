<?php

class AdminCategoryController extends Controller
{
    protected string $layout = 'admin';
    private Category $category;

    public function __construct()
    {
        $this->category = new Category();
    }

    public function index(): void
    {
        $categories = Database::fetchAll(
            "SELECT c.*, (SELECT COUNT(*) FROM products WHERE category_id = c.id) as product_count
             FROM categories c ORDER BY c.order_position ASC"
        );

        $this->view('admin/categories/index', [
            'categories' => $categories,
            'pageTitle' => 'Categorias',
        ]);
    }

    public function create(): void
    {
        $this->view('admin/categories/form', [
            'category' => null,
            'pageTitle' => 'Nova Categoria',
        ]);
    }

    public function store(): void
    {
        $this->validateCsrf();

        $name = $this->input('name');
        $slug = $this->input('slug') ?: $this->category->generateSlug($name);

        $data = [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->input('description'),
            'icon' => $this->input('icon'),
            'order_position' => (int) $this->input('order_position', '0'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        // Upload de imagem
        if (!empty($_FILES['image']['name'])) {
            $result = Upload::file($_FILES['image'], 'categories');
            if ($result['success']) {
                $data['image'] = $result['path'];
            }
        }

        $this->category->create($data);

        Session::flash('success', 'Categoria criada com sucesso!');
        redirect('/admin/categorias');
    }

    public function edit(string $id): void
    {
        $category = $this->category->findById((int) $id);
        if (!$category) {
            Session::flash('error', 'Categoria não encontrada.');
            redirect('/admin/categorias');
        }

        $this->view('admin/categories/form', [
            'category' => $category,
            'pageTitle' => 'Editar: ' . $category['name'],
        ]);
    }

    public function update(string $id): void
    {
        $this->validateCsrf();

        $category = $this->category->findById((int) $id);
        if (!$category) {
            Session::flash('error', 'Categoria não encontrada.');
            redirect('/admin/categorias');
        }

        $name = $this->input('name');
        $slug = $this->input('slug') ?: $this->category->generateSlug($name, (int) $id);

        $data = [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->input('description'),
            'icon' => $this->input('icon'),
            'order_position' => (int) $this->input('order_position', '0'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        // Upload de nova imagem
        if (!empty($_FILES['image']['name'])) {
            $result = Upload::file($_FILES['image'], 'categories');
            if ($result['success']) {
                // Deletar imagem anterior
                if ($category['image']) {
                    Upload::deleteFile($category['image']);
                }
                $data['image'] = $result['path'];
            }
        }

        $this->category->update((int) $id, $data);

        Session::flash('success', 'Categoria atualizada com sucesso!');
        redirect('/admin/categorias/editar/' . $id);
    }

    public function delete(string $id): void
    {
        $this->validateCsrf();

        $category = $this->category->findById((int) $id);
        if (!$category) {
            Session::flash('error', 'Categoria não encontrada.');
            redirect('/admin/categorias');
        }

        // Verificar se há produtos vinculados
        $productCount = Database::count('products', 'category_id = ?', [(int) $id]);
        if ($productCount > 0) {
            Session::flash('error', "Não é possível excluir. Existem {$productCount} produtos nesta categoria.");
            redirect('/admin/categorias');
            return;
        }

        // Deletar imagem
        if ($category['image']) {
            Upload::deleteFile($category['image']);
        }

        $this->category->delete((int) $id);

        Session::flash('success', 'Categoria excluída com sucesso!');
        redirect('/admin/categorias');
    }
}
