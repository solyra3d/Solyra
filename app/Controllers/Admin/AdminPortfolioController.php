<?php

class AdminPortfolioController extends Controller
{
    protected string $layout = 'admin';
    private Portfolio $model;

    public function __construct()
    {
        $this->model = new Portfolio();
    }

    public function index(): void
    {
        $items = $this->model->findAll('order_position ASC, created_at DESC');
        $this->view('admin/portfolio/index', [
            'items' => $items,
            'pageTitle' => 'Portfólio',
        ]);
    }

    public function create(): void
    {
        $this->view('admin/portfolio/form', [
            'item' => null,
            'pageTitle' => 'Novo Projeto',
        ]);
    }

    public function store(): void
    {
        $this->validateCsrf();

        $data = [
            'title' => $this->input('title'),
            'slug' => $this->model->generateSlug($this->input('title')),
            'description' => $this->input('description'),
            'category' => $this->input('category'),
            'order_position' => (int) $this->input('order_position'),
            'is_active' => $this->input('is_active') ? 1 : 0,
        ];

        if (!empty($_FILES['cover_image']['name'])) {
            $result = Upload::file($_FILES['cover_image'], 'portfolio');
            if ($result['success']) {
                $data['cover_image'] = $result['path'];
            }
        }

        $id = $this->model->create($data);

        if (!empty($_FILES['images']['name'][0])) {
            $this->uploadImages($id);
        }

        Session::flash('success', 'Projeto cadastrado!');
        redirect('/admin/portfolio');
    }

    public function edit(string $id): void
    {
        $item = $this->model->findById((int) $id);
        if (!$item) {
            Session::flash('error', 'Projeto não encontrado.');
            redirect('/admin/portfolio');
        }

        $item['images'] = $this->model->getImages((int) $id);

        $this->view('admin/portfolio/form', [
            'item' => $item,
            'pageTitle' => 'Editar: ' . $item['title'],
        ]);
    }

    public function update(string $id): void
    {
        $this->validateCsrf();

        $item = $this->model->findById((int) $id);
        if (!$item) {
            Session::flash('error', 'Projeto não encontrado.');
            redirect('/admin/portfolio');
        }

        $data = [
            'title' => $this->input('title'),
            'slug' => $this->model->generateSlug($this->input('title'), (int) $id),
            'description' => $this->input('description'),
            'category' => $this->input('category'),
            'order_position' => (int) $this->input('order_position'),
            'is_active' => $this->input('is_active') ? 1 : 0,
        ];

        if (!empty($_FILES['cover_image']['name'])) {
            $result = Upload::file($_FILES['cover_image'], 'portfolio');
            if ($result['success']) {
                $data['cover_image'] = $result['path'];
            }
        }

        $this->model->update((int) $id, $data);

        if (!empty($_FILES['images']['name'][0])) {
            $this->uploadImages((int) $id);
        }

        Session::flash('success', 'Projeto atualizado!');
        redirect('/admin/portfolio');
    }

    public function delete(string $id): void
    {
        $this->validateCsrf();
        $this->model->delete((int) $id);
        Session::flash('success', 'Projeto removido!');
        redirect('/admin/portfolio');
    }

    public function deleteImage(string $id): void
    {
        $this->validateCsrf();
        Database::delete('portfolio_images', 'id = ?', [(int) $id]);
        Session::flash('success', 'Imagem removida!');
        redirect($_SERVER['HTTP_REFERER'] ?? '/admin/portfolio');
    }

    private function uploadImages(int $portfolioId): void
    {
        $files = $_FILES['images'];
        $count = count($files['name']);

        for ($i = 0; $i < $count; $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) continue;

            $tmp = $files['tmp_name'][$i];
            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $filename = 'uploads/portfolio/' . uniqid('img_') . '.' . strtolower($ext);
            $dest = ROOT_PATH . '/public/' . $filename;

            if (!is_dir(dirname($dest))) {
                mkdir(dirname($dest), 0755, true);
            }

            if (move_uploaded_file($tmp, $dest)) {
                Database::insert('portfolio_images', [
                    'portfolio_id' => $portfolioId,
                    'image_path' => $filename,
                    'order_position' => $i,
                ]);
            }
        }
    }
}
