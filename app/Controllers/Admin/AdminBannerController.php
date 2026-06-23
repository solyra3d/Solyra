<?php

class AdminBannerController extends Controller
{
    protected string $layout = 'admin';
    private Banner $banner;

    public function __construct()
    {
        $this->banner = new Banner();
    }

    public function index(): void
    {
        $banners = $this->banner->findAll('order_position ASC');

        $this->view('admin/banners/index', [
            'banners' => $banners,
            'pageTitle' => 'Banners',
        ]);
    }

    public function create(): void
    {
        $this->view('admin/banners/form', [
            'banner' => null,
            'pageTitle' => 'Novo Banner',
        ]);
    }

    public function store(): void
    {
        $this->validateCsrf();

        $data = [
            'title' => $this->input('title'),
            'subtitle' => $this->input('subtitle'),
            'button_text' => $this->input('button_text') ?: 'Saiba Mais',
            'button_link' => $this->input('button_link'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'order_position' => (int) $this->input('order_position', '0'),
        ];

        // Upload de imagem (obrigatório para banners)
        if (!empty($_FILES['image_path']['name'])) {
            $result = Upload::file($_FILES['image_path'], 'banners');
            if ($result['success']) {
                $data['image_path'] = $result['path'];
            } else {
                Session::flash('error', 'Erro no upload: ' . $result['error']);
                redirect('/admin/banners/criar');
                return;
            }
        } else {
            Session::flash('error', 'A imagem do banner é obrigatória.');
            redirect('/admin/banners/criar');
            return;
        }

        $this->banner->create($data);

        Session::flash('success', 'Banner criado com sucesso!');
        redirect('/admin/banners');
    }

    public function edit(string $id): void
    {
        $banner = $this->banner->findById((int) $id);
        if (!$banner) {
            Session::flash('error', 'Banner não encontrado.');
            redirect('/admin/banners');
        }

        $this->view('admin/banners/form', [
            'banner' => $banner,
            'pageTitle' => 'Editar: ' . $banner['title'],
        ]);
    }

    public function update(string $id): void
    {
        $this->validateCsrf();

        $banner = $this->banner->findById((int) $id);
        if (!$banner) {
            Session::flash('error', 'Banner não encontrado.');
            redirect('/admin/banners');
        }

        $data = [
            'title' => $this->input('title'),
            'subtitle' => $this->input('subtitle'),
            'button_text' => $this->input('button_text') ?: 'Saiba Mais',
            'button_link' => $this->input('button_link'),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'order_position' => (int) $this->input('order_position', '0'),
        ];

        // Upload de nova imagem
        if (!empty($_FILES['image_path']['name'])) {
            $result = Upload::file($_FILES['image_path'], 'banners');
            if ($result['success']) {
                // Deletar imagem anterior
                if ($banner['image_path']) {
                    Upload::deleteFile($banner['image_path']);
                }
                $data['image_path'] = $result['path'];
            }
        }

        $this->banner->update((int) $id, $data);

        Session::flash('success', 'Banner atualizado com sucesso!');
        redirect('/admin/banners/editar/' . $id);
    }

    public function delete(string $id): void
    {
        $this->validateCsrf();

        $banner = $this->banner->findById((int) $id);
        if (!$banner) {
            Session::flash('error', 'Banner não encontrado.');
            redirect('/admin/banners');
        }

        // Deletar imagem
        if ($banner['image_path']) {
            Upload::deleteFile($banner['image_path']);
        }

        $this->banner->delete((int) $id);

        Session::flash('success', 'Banner excluído com sucesso!');
        redirect('/admin/banners');
    }
}
