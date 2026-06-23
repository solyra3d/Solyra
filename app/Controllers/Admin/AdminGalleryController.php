<?php

class AdminGalleryController extends Controller
{
    protected string $layout = 'admin';

    /**
     * Listar galeria
     */
    public function index(): void
    {
        $photos = Gallery::getAll();

        $this->view('admin/gallery/index', [
            'photos' => $photos,
            'pageTitle' => 'Galeria',
        ]);
    }

    /**
     * Upload de foto(s)
     */
    public function store(): void
    {
        $this->validateCsrf();

        $uploaded = 0;

        // Upload múltiplo
        if (isset($_FILES['photos']) && is_array($_FILES['photos']['name'])) {
            $count = count($_FILES['photos']['name']);
            for ($i = 0; $i < $count; $i++) {
                if ($_FILES['photos']['error'][$i] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $_FILES['photos']['name'][$i],
                        'type' => $_FILES['photos']['type'][$i],
                        'tmp_name' => $_FILES['photos']['tmp_name'][$i],
                        'error' => $_FILES['photos']['error'][$i],
                        'size' => $_FILES['photos']['size'][$i],
                    ];

                    $result = Upload::file($file, 'gallery');
                    if ($result['success']) {
                        $caption = $_POST['captions'][$i] ?? '';
                        Gallery::create([
                            'image_path' => $result['path'],
                            'caption' => $caption,
                        ]);
                        $uploaded++;
                    }
                }
            }
        }

        if ($uploaded > 0) {
            Session::flash('success', $uploaded . ' foto(s) adicionada(s) com sucesso!');
        } else {
            Session::flash('error', 'Nenhuma foto foi enviada. Verifique o formato.');
        }

        redirect(baseUrl('admin/galeria'));
    }

    /**
     * Excluir foto
     */
    public function delete(string $id): void
    {
        $this->validateCsrf();

        $photo = Gallery::find((int) $id);
        if ($photo) {
            // Remover arquivo físico
            $filePath = ROOT_PATH . '/public/' . $photo['image_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            Gallery::delete((int) $id);
            Session::flash('success', 'Foto removida!');
        } else {
            Session::flash('error', 'Foto não encontrada.');
        }

        redirect(baseUrl('admin/galeria'));
    }
}
